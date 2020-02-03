<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

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
                                // TODO isDynamic fields
                                if ($control['type'] == 'address') {
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $fields[$control['fieldName']][$control['label'.$i]] = $control['value'.$i];
                                        }
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


    public function sendClientEmail()
    {
        if (!$this->form->email) return false;
        if (!$this->email) return false;

        $view = 'email.client';
        $email = [];

        $find = false;
        $replace = false;
        $fields = $this->fields;
        $msgMacros = $this->form->email->clientMessageFields();
        foreach ($msgMacros as $key => $item) {
            if (@$fields[$item]['value']) {
                $find[] = $key;
                $replace[] = $fields[$item]['value'];
            }
        }

        $clientMsg = str_replace($find, $replace, $this->form->email->client_message);

        $email['to'] = $this->email;
        $email['subject'] = $this->form->email->subject;
        $email['from_name'] = $this->form->email->from_name;
        $email['from_email'] = $this->form->email->from_email;
        $email['reply_to'] = $this->form->email->reply_to;


        Mail::send($view, ['msg' => $clientMsg], function ($mail) use ($email) {
          $mail->from($email['from_email'], $email['from_name'])
                ->to($email['to'])
                ->subject($email['subject']);
          if ($email['reply_to']) $mail->cc($email['reply_to']);
        });

        return true;
    }


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

}
