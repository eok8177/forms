<?php

/**
* Description:
* Model (based on MVC architecture) for applications (entries)
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - user() | reference to application user's details (Object-Relational Mapper)
* - form() | reference to application form's details (Object-Relational Mapper)
* - approvs() | reference to application's approval history (Object-Relational Mapper)
* - getEmailAttribute() | get applicaiton's email - user's email or first control of type='email' in the application (Laravel Accessor)
* - getFieldsAttribute() | get a list of fields ['type', 'label', 'value'] (Laravel Accessor)
* - _getFileName($fileNameFullPath) | remove invalid symbols from filename
* - getAdditionalFieldAttribute() | reference to the additional field's detail in the format: ['type', 'label', 'value'] (Laravel Accessor)
* - checkFiles() | Check uploaded files for empty ones
* - getHasAlertAttribute() | are there any alert for this application? (Laravel Accessor)
* - updateConfig($fieldName, $value) | Save uploaded files paths into applications.config
* - createEntry() | create new entry
* - deleteEntry() | delete entry
* - adminSubmitEmail() | send email to the admin
* - userSubmitEmail() | send email to the user
* - userAcceptEmail() | send email to the user once the application is accepted
* - userRejectEmail() | send email to the user once the application is rejected
* - managerSubmitEmail() | send email to the manager once the application is submitted
* - sendEmail($type) | prepare and send particular email based on email template details stored in form_emails.type=$type
* - emailValidate($email) | check if email is valid
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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


    /**
    * Description:
    * reference to application user's details (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object|list of objects
    *
    * Example of usage:
    * see method getEmailAttribute()
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }


    /**
    * Description:
    * reference to application form's details (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object|list of objects
    *
    * Example of usage:
    * see method getAdditionalFieldAttribute()
    */
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id')->withDefault();
    }


    /**
    * Description:
    * reference to application's approval history (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object | list of objects
    *
    * Example of usage:
    * see method createEntry()
    */
    public function approvs()
    {
        return $this->hasMany(ApplicationApproval::class);
    }


    /**
    * Description:
    * get applicaiton's email - user's email or first control of type='email' in the application (Laravel Accessor)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * string
    *
    * Example of usage:
    * TOADD
    */
    public function getEmailAttribute()
    {
        $email = $this->user->email;
        if (!$email) {
            $email = array_shift($this->parseAppConfig($this->config)['emails']);
        }
        return $email;
    }


    /**
    * Description:
    * get a list of fields ['type', 'label', 'value'] (Laravel Accessor)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * false|array
    *
    * Example of usage:
    * see resources/views/admin/form/email.blade.php
    */
    public function getFieldsAttribute()
    {
        if (!$this->config) return false;

        return $this->parseAppConfig($this->config)['fields'];
    }


    /**
    * Description:
    * remove invalid symbols from filename
    *
    * List of parameters:
    * $fileNameFllPath : string
    *
    * Return:
    * - string
    *
    * Example of usage:
    * see method getAdditionalFieldAttribute()
    */
    private function _getFileName($fileNameFullPath)
    {
        return preg_replace('/\w+\/\d+\/\d+\//i', "", $fileNameFullPath);
    }


    /**
    * Description:
    * reference to the additional field's detail in the format: ['type', 'label', 'value'] (Laravel Accessor)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * false|array
    *
    * Example of usage:
    * see resources/views/admin/response.blade.php
    */
    public function getAdditionalFieldAttribute()
    {
        $field = $this->form->additional_field;
        if (!$field) return false;

        $fields = $this->parseAppConfig($this->config)['fields'];
        if (!array_key_exists($field, $fields)) return false;

        $value = implode(' ', (array) $fields[$field]['value']);
        $value = trim($value);

        if ($fields[$field]['type'] == 'file' && $value) {
            return '<a href="/'.$value.'" target="_blank">'.$this->_getFileName($value).'</a>';
        }
        return $value;
    }


    /** 
    * Description:
    * Check uploaded files for empty ones
    *
    * List of parameters:
    * false|array
    *
    * Return:
    * error: json
    *
    * Example of usage:
    * see method Http\Controller\Api\FormController.postForm()
    */
    public function checkFiles()
    {
        if (!$this->config) return false;
        $error = false;

        $files = $this->parseFiles($this->config);
        foreach ($files as $fieldName => $field) {
            if ($field['value'] && Storage::disk('public')->exists($field['value'])) {
                if (Storage::disk('public')->size($field['value']) == 0) {
                    $error[] = [
                        'fieldName' => $fieldName,
                        'value' => $field['value'],
                        'alias' => $field['alias'],
                        'label' => $field['label'],
                        'section' => $field['section'],
                    ];
                }
            }

            if (!$field['value'] || is_array($field['value'])) {
                if ($field['required']) {
                    $error[] = [
                        'fieldName' => $fieldName,
                        'value' => $field['value'],
                        'alias' => $field['alias'],
                        'label' => $field['label'],
                        'section' => $field['section'],
                    ];
                }
            }
        }
        echo 'checkFiles.error=';
        print_r($error);die();
        $this->alert = $error ? json_encode($error) : NULL;
        $this->save();

        return $this->alert;
    }


    /**
    * Description:
    * are there any alert for this application? (Laravel Accessor)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * false|string
    *
    * Example of usage:
    * see resources/views/manager/responses.blade.php
    */
    public function getHasAlertAttribute()
    {
        if (!$this->alert) return false;

        $msg = false;
        foreach (json_decode($this->alert) as $alert) {
            $msg .= ' '.$alert->section.' - '.$alert->label.';';
        }
        return $msg;
    }


    /** 
    * Description:
    * Save uploaded files paths into applications.config
    *
    * List of parameters:
    * - $fileName : string
    * - $value: string
    * 
    * Return: 
    * true
    *
    * Example of usage:
    * see method Http\Controller\Api\FormController.uploadFile()
    */
    public function updateConfig($fieldName, $value)
    {
        $config = json_decode($this->config, true);

        $toUpdate = false;
        foreach ($config['sections'] as $idSection => $section) {
            if ($section['isDynamic']) {

                foreach ($section['instances'] as $idInst => $instance) {
                    foreach ($instance as $sectionID => $section) {
                        if (array_key_exists('controls', $section)) {
                            foreach ($section['controls'] as $idControl => $control) {
                                if ($control['fieldName'] == $fieldName) {
                                    $config['sections'][$idSection]['instances'][$idInst][$sectionID]['controls'][$idControl]['value'] = $value;
                                    $toUpdate = true;
                                }
                            }
                        }
                    }
                }

            } else {

                if (array_key_exists('rows', $section)) {
                    foreach ($section['rows'] as $idRow => $row) {
                        if (array_key_exists('controls', $row)) {
                            foreach ($row['controls'] as $idControl => $control) {
                                if ($control['fieldName'] == $fieldName) {
                                    $config['sections'][$idSection]['rows'][$idRow]['controls'][$idControl]['value'] = $value;
                                    $toUpdate = true;
                                }
                            }
                        }
                    }
                }

            }
        }
        if ($toUpdate) {
            $this->config = json_encode($config);
            $this->updated_at = date('Y-m-d H:i:s');
            $this->save();
            return true;
        }
    }

    /**
    * Descriptioin:
    * create new entry
    * 
    * List of parameters:
    * - none
    *
    * Return:
    * true
    * 
    * Example of usage:
    * see method Http\Controller\Api\FormController.postForm()
    */
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


    /**
    * Description:
    * Delete entry
    *
    * List of parameters:
    * - none
    *
    * Return:
    * true 
    *
    * Examples of usage:
    * see method Http\Controller\Admin\ResponseController.destroy()
    */
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


    /**
    * Description:
    * send email to the admin
    *
    * List of parameters:
    * - none
    *
    * Return:
    * true
    *
    * Example of usage:
    * see method Http/Controllers/Admin/ResponseController.status()
    */
    public function adminSubmitEmail()
    {
        // TODO check info what sending
        return $this->sendEmail('admin_submit');
    }


    /**
    * Description:
    * send email to the user
    *
    * List of parameters:
    * - none
    *
    * Return:
    * true
    *
    * Example of usage:
    * see method Http/Controllers/Api/FormController.postForm()
    */
    public function userSubmitEmail()
    {
        return $this->sendEmail('user_submit');
    }


    /**
    * Description:
    * send email to the user once the application is accepted
    *
    * List of parameters:
    * - none
    *
    * Return:
    * true
    *
    * Example of usage:
    * see method Http/Controllers/Admin/ResponseController.status()
    */
    public function userAcceptEmail()
    {
        return $this->sendEmail('user_accept');
    }


    /**
    * Description:
    * send email to the user once the application is rejected
    *
    * List of parameters:
    * - none
    *
    * Return:
    *
    * Example of usage:
    * see method Http/Controllers/Admin/ResponseController.status()
    */
    public function userRejectEmail()
    {
        return $this->sendEmail('user_reject');
    }


    /**
    * Description:
    * send email to the manager once the application is submitted
    *
    * List of parameters:
    * - none
    *
    * Return:
    * true
    *
    * Example of usage:
    * ses Http/Controllers/Manager/ResponseController.status()
    */
    public function managerSubmitEmail()
    {
        return $this->sendEmail('manager_submit');
    }


    /**
    * Description:
    * prepare and send particular email based on email template details stored in form_emails.type=$type
    *
    * List of parameters:
    * $type | string
    *
    * Return:
    * true
    *
    * Example of usage:
    * see method managerSubmitEmail()
    */
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

        $from_name = $email->from_name ? $email->from_name : 'RWAV';

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
    * Description:
    * Search applications
    *
    * List of parameters:
    * - $request : Request
    * - $order : string  - ASC|DESC
    *
    * Return:
    * $apps : object
    * $filter | array used filters
    *
    * Example of usage:
    * see method app/Http/Controllers/Admin/ResponseController.index()
    * see method app/Http/Controllers/Manager/ResponseController.index()
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


    /**
    * Description:
    * check if email is valid
    *
    * List of parameters:
    * $email : string
    *
    * Return:
    * boolean
    *
    * Example of usage:
    * see method sendEmail()
    */
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
