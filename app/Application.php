<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Jobs\SendEmail;
use App\ApiCall;
use App\FormConfig;

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
        return $this->belongsTo(Form::class, 'form_id');
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
        $fields = $this->parseAppConfig($this->config)['fields'];

        return $field ? $fields[$field]['value'] : false;
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
        $entry_id = 1;
        $last = Entry::latest()->first();
        if ($last) {
            $entry_id = $last->entry_id + 1;
        }
        $this->entry_id = $entry_id;
        $this->save();

        $data = [];

        foreach ($this->fields as $fieldId => $field) {
            if ($field['type'] == 'address') {
                foreach ($field as $key => $value) {
                    if ($key != 'type') {
                        $entry = $this->newEntry($fieldId, $key, $value);
                        $data[$entry->id] = [
                            'name' => $entry->name,
                            'value' => $entry->value,
                        ];
                    }
                }
            } elseif ($field['type'] != 'html') {
                if ($field['value'] !== NULL) 
                    $entry = $this->newEntry($fieldId, $field['label'], $field['value']);
                    $data[strval(preg_replace("/[^0-9]/", '', $fieldId))] = $entry->value;
            }
        }

        $responseStatusID = 2; // submitted == $this->status == 'submitted' && $app->to_be_approved == 0
        $responseStatusID = ($this->status == 'submitted' && $this->to_be_approved != 1) ? 6 : $responseStatusID; // 6 (= 2 + 4) - for those which are Submitted and do not require Acceptance
        $responseStatusID = ($this->status == 'accepted') ? 4 : $responseStatusID; // Accepted
        $responseStatusID = ($this->status == 'rejected') ? 8 : $responseStatusID; // Rejected
        // TODO * 32 - Deleted from Portal
        $msg = [
            'user_id' => $this->user_id,
            'form_id' => $this->form_id,
            'entry_id' => $entry_id,
            'response_status_id' => $responseStatusID,
            'response_details' => $this->form->name,
            'form_response' => json_encode($data),
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

    public function managersSubmitEmail()
    {
        return $this->sendEmail('manager_submit');
    }

    private function sendEmail($type)
    {
        $email = $this->form->email($type);
        if (!$email) return false;
        if (!$email->send_to) return false;
        if (!$email->from_email) return false;

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

        $view = 'email.client';
        $data = [];

        $data['to'] = $email->send_to ? $email->send_to : $this->email;
        $data['subject'] = $email->subject;
        $data['from_name'] = $email->from_name;
        $data['from_email'] = $email->from_email;
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
            });
        }

        if ($filter['form_id'] > 0) {
            $apps->where('form_id', $filter['form_id']);
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

        if ($user->role == 'manager') {
            $groupIds = $user->groups->pluck('id')->toArray();
            $forms = Form::whereHas('groups', function($q) use ($groupIds) {
                $q->whereIn('group_id', $groupIds);
            })->pluck('id')->toArray();
            $apps->whereIn('form_id', $forms);
            $apps->where('to_be_approved', 1);
        }

        return [
            $apps->orderBy('id', $order),
            $filter
        ];
    }

}
