<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Jobs\SendEmail;

class Application extends Model
{
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
            $email = array_shift($this->parseConfig($this->config)['emails']);
        }
        return $email;
    }

    public function getFieldsAttribute()
    {
        if (!$this->config) return false;

        return $this->parseConfig($this->config)['fields'];
    }


    private function parseConfig($config)
    {
        $fields = [];
        $emails = [];

        $config = json_decode($config, true);

        foreach ($config['sections'] as $section) {
            if (array_key_exists('rows', $section)) {

                if ($section['isDynamic']) {
                    foreach ($section['instances'] as $idInst => $instance) {
                        foreach ($instance as $section) {
                            foreach ($section['controls'] as $control) {
                                $fields[$idInst.'_'.$control['fieldName']]['type'] = $control['type'];

                                if (array_key_exists('isEmail', $control) && $control['isEmail']) {
                                    $fields[$idInst.'_'.$control['fieldName']]['type'] = 'email';
                                    $emails[$control['label']] = $control['value'];
                                }
                                if ($control['type'] == 'address') {
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $fields[$idInst.'_'.$control['fieldName']][$control['label'.$i]] = $control['value'.$i];
                                        }
                                    }
                                } else {
                                    $fields[$idInst.'_'.$control['fieldName']]['label'] = $control['label'];
                                    $fields[$idInst.'_'.$control['fieldName']]['value'] = $control['value'];
                                }
                            }
                        }

                    }
                } else {
                    foreach ($section['rows'] as $row) {
                        if (array_key_exists('controls', $row)) {
                            foreach ($row['controls'] as $control) {

                                $fields[$control['fieldName']]['type'] = $control['type'];

                                if (array_key_exists('isEmail', $control) && $control['isEmail']) {
                                    $fields[$control['fieldName']]['type'] = 'email';
                                    $emails[$control['label']] = $control['value'];
                                }
                                if ($control['type'] == 'address') {
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $fields[$control['fieldName']][$control['label'.$i]] = $control['value'.$i];
                                        }
                                    }
                                    if ($control['mapIt']) {
                                        $fields[$control['fieldName']]['lat'] = $control['lat'];
                                        $fields[$control['fieldName']]['lng'] = $control['lng'];
                                        $fields[$control['fieldName']]['address'] = $control['address'];
                                    }
                                } else {
                                    $fields[$control['fieldName']]['label'] = $control['label'];
                                    $fields[$control['fieldName']]['value'] = $control['value'];
                                }
                            }
                        }
                    }
                }
            }
        }
        return [
            'fields' => $fields,
            'emails' => $emails
        ];
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

        foreach ($this->fields as $fieldId => $field) {
            if ($field['type'] == 'address') {
                foreach ($field as $key => $value) {
                    if ($key != 'type') {
                        $this->newEntry($fieldId, $key, $value);
                    }
                }
            } elseif ($field['type'] != 'html') {
                if ($field['value'] !== NULL) 
                    $this->newEntry($fieldId, $field['label'], $field['value']);
            }
        }
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
        return true;
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

        echo "start: $type ".date('i:s')."\n";
        SendEmail::dispatch($data)->delay(now()->addMinutes(2));;
        echo "end: $type ".date('i:s')."\n";

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

        $apps = Application::Where('status', '!=', 'deleted')->with('user');

        if ($filter['search']) {
            $searchValues = preg_split('/\s+/', $filter['search'], -1, PREG_SPLIT_NO_EMPTY);
            foreach ($searchValues as $search) {
                $apps->WhereHas('user', function ($query) use ($search) {
                    $query->Where('first_name','LIKE', '%'.$search.'%')
                        ->orWhere('last_name','LIKE', '%'.$search.'%');
                });
            }
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
        }

        return [
            $apps->orderBy('id', $order),
            $filter
        ];
    }

}
