<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

use App\Jobs\SendEmail;
use App\ApiCall;
use App\FormConfig;
use App\Setting;

class Application extends Model
{
    use SoftDeletes;
    use FormConfig;

    const STATUS_ALL = 'All Statuses';
    const STATUS_SUBMITTED = 'Submitted';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id')->withDefault();
    }

    public function approvs()
    {
        return $this->hasMany(ApplicationApproval::class);
    }

    public function getEmailAttribute()
    {
        $email = $this->user->email;
        if (!$email) {
            $email = array_shift($this->parseAppConfig($this->config)['emails']);
        }
        return $email;
    }

    public function getFieldsAttribute()
    {
        if (!$this->config) return false;

        return $this->parseAppConfig($this->config)['fields'];
    }

    public function getAdditionalFieldAttribute()
    {
        $field = $this->form->additional_field;
        if (!$field) return false;

        $fields = $this->parseAppConfig($this->config)['fields'];
        if (!array_key_exists($field, $fields)) return false;

        $value = implode(' ', (array) $fields[$field]['value']);
        $value = trim($value);

        if ($fields[$field]['type'] == 'file') {
            return '<a href="/'.$value.'" target="_blank">file</a>';
        }
        return $value;
    }


    /*
    * Save uploaded files path to config
    */
    public function updateConfig($fieldName, $value)
    {
        $config = json_decode($this->config, true);

        foreach ($config['sections'] as $idSection => $section) {
            if (array_key_exists('rows', $section)) {
                foreach ($section['rows'] as $idRow => $row) {
                    if (array_key_exists('controls', $row)) {
                        foreach ($row['controls'] as $idControl => $control) {
                            if ($control['fieldName'] == $fieldName) {
                                $config['sections'][$idSection]['rows'][$idRow]['controls'][$idControl]['value'] = $value;
                            }
                        }
                    }
                }
            }
        }
        $this->config = json_encode($config);
        $this->save();
        return true;
    }

    public function createEntry()
    {
        $data = $this->parseApp($this->config);

        $responseStatusID = 2; // submitted == $this->status == 'submitted' && $app->to_be_approved == 0
        $responseStatusID = ($this->status == 'submitted' && $this->to_be_approved != 1) ? 6 : $responseStatusID; // 6 (= 2 + 4) - for those which are Submitted and do not require Acceptance
        $responseStatusID = ($this->status == 'accepted') ? 4 : $responseStatusID; // Accepted
        $responseStatusID = ($this->status == 'rejected') ? 8 : $responseStatusID; // Rejected
        
        // TODO * 32 - Deleted from Portal
        $msg = [
            'active_user_id' => ($responseStatusID == 2 || $responseStatusID == 6) ? $this->user_id : auth()->user()->id,
            'user_id' => $this->user_id,
            'form_id' => $this->form_id,
            'entry_id' => $this->id,
            'response_status_id' => $responseStatusID,
            'response_details' => $this->form->name,
			'form_response' => json_encode($data)
        ];
        
        // if rejected or accepted - notes field is mandatory
        if ($this->status == 'accepted' || $this->status == 'rejected') {
            $msg['processed_comments'] = isset($this->approvs()->latest()->first()->notes) ? $this->approvs()->latest()->first()->notes : 'no reason specified';
        }

        $api = new ApiCall;
        $res = $api->newResponse($msg);

        return true;
    }

    public function deleteEntry()
    {
        $responseStatusID = 32;
        $msg = [
            'active_user_id' => Auth::user()->id,
            'user_id' => $this->user_id,
            'form_id' => $this->form_id,
            'entry_id' => $this->entry_id,
            'response_status_id' => $responseStatusID,
            'response_details' => $this->form->name,
            'form_response' => '',
        ];

        $api = new ApiCall;
        $res = $api->newResponse($msg);
        return true;
    }

    private function newEntry($fieldId, $label, $value)
    {
        $entry = new Entry;
        $entry->entry_id = $this->entry_id;
        $entry->form_id = $this->form_id;
        $entry->field_id = $fieldId;
        $entry->user_id = $this->user_id;
        $entry->name = $label;
        $entry->value = $value;
        $entry->save();
        return $entry;
    }

    // TODO check info what sending
    public function adminSubmitEmail()
    {
        return $this->sendEmail('admin_submit');
    }

    public function userSubmitEmail()
    {
        return $this->sendEmail('user_submit');
    }

    public function userAcceptEmail()
    {
        return $this->sendEmail('user_accept');
    }

    public function userRejectEmail()
    {
        return $this->sendEmail('user_reject');
    }

    public function managerSubmitEmail()
    {
        return $this->sendEmail('manager_submit');
    }

    private function sendEmail($type)
    {
        // email sends only loggedIn users with active email template in form Settings
        // get template from `form_emails` table
        $email = $this->form->email($type);
        if (!$email) return false;
        if ($email->active != 1) return false;

        // from Template or Settings
        $from_settings = Setting::where('key', 'from_email')->first();
        $from_email = $email->from_email ? $email->from_email : $from_settings->value;

        $from_name = $email->from_name ? $email->from_name : 'RVAW';

        // to `user.email`
        $to_email = $this->user->email;

        // parse $email->send_to
        $send_to = [];
        if ($email->send_to) {
            $sendtoArrayy = explode(',', preg_replace('/\s+/', '', $email->send_to));
            foreach ($sendtoArrayy as $send_to_item) {
                if ($this->emailValidate($send_to_item)) $send_to[] = $send_to_item;
            }
        }

        if ($type == 'admin_submit') {
            if ($send_to) {
                $to_email = $send_to;
            } else {
                // admin_submit
                $to_email = Setting::where('key', 'feedback_email')->first()->value;
            }
        }
        if ($type == 'manager_submit') {
            if ($send_to) {
                $to_email = $send_to;
            } else {
                // managers
                $to_email = [];
                $groups = $this->form->groups;
                foreach ($groups as $group) {
                    foreach ($group->managers as $manager) {
                        $to_email[] = $manager->email;
                    }
                }

            }
        }

        // replase macros in message
        $find = false;
        $replace = false;
        $fields = $this->fields;
        $msgMacros = $email->messageFields();
        foreach ($msgMacros as $key => $item) {
            if (@$fields[$item]['value']) {
                $find[] = $key;
                $replace[] = $fields[$item]['value'];
            }
        }

        $message = str_replace($find, $replace, $email->message);

        // $view = 'email.client';
        $data = [];

        $data['from_email'] = $from_email;
        $data['from_name'] = $from_name;
        $data['to'] = $to_email;
        $data['subject'] = $email->subject;
        $data['message'] = $message;

        SendEmail::dispatch($data);

        return true;
    }


    /**
     * Search
     * return Two objects
     */
    static function search($request = false, $order = 'DESC')
    {
        $user = Auth::user();

        $filter['user'] = $user;
        $filter['form_id'] = $request->input('id', 0);
        $filter['status'] = $request->input('status', Application::STATUS_SUBMITTED);
        $filter['from'] = $request->input('from', false);
        $filter['to'] = $request->input('to', false);
        $filter['search'] = $request->input('search', false);

        $apps = Application::Where('status', '!=', 'deleted')->with('user', 'form');

        if ($user->role == 'manager') {
            $groupIds = $user->groups->pluck('id')->toArray();
            $forms = Form::whereHas('groups', function($q) use ($groupIds) {
                $q->whereIn('group_id', $groupIds);
            })->pluck('id')->toArray();
            $apps->whereIn('form_id', $forms);
            $apps->where('to_be_approved', 1);
        }

        $selectAppsList = $apps->distinct()->pluck('form_id')->toArray();
        $filter['selectAppsList'] = [0 =>'All Forms'] + Form::whereIn('id',$selectAppsList)->pluck('title', 'id')->all();

        if (!array_key_exists($filter['form_id'], $filter['selectAppsList'])) {
            $filter['form_id'] = 0;
        }

        if ($filter['search']) {
            $search = $filter['search'];
            $searchValues = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

            $apps->where(function ($q) use ($search, $searchValues) {
                foreach ($searchValues as $item) {
                    $q->orWhereHas('user', function ($query) use ($item) {
                        $query->Where('first_name','LIKE', '%'.$item.'%')
                            ->orWhere('last_name','LIKE', '%'.$item.'%');
                    });
                }
                $q->orWhereHas('form', function ($q) use ($search) {
                    $q->where('name','LIKE', '%'.$search.'%');
                });
                $q->orWhere('additional_field_value','LIKE', '%'.$search.'%');
            });
        }

        if ($filter['status'] != Application::STATUS_ALL) {
            $apps->where('status', $filter['status']);
        }

        if ($filter['from']) {
            $apps->where('created_at', '>=', $filter['from']);
        }

        if ($filter['to']) {
            $apps->where('created_at', '<=', $filter['to']);
        }

        if ($filter['form_id'] > 0) {
            $apps->where('form_id', $filter['form_id']);
        }

        return [
            $apps->orderBy('id', $order),
            $filter
        ];
    }


    private function emailValidate($email)
    {
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);

        return $validator->isValid($email, $multipleValidations);
    }

}
