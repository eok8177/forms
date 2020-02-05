<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormEmail extends Model
{
    CONST TYPES = [
        'user_submit' => 'Inform User when form submited',
        'user_accept' => 'Inform User when form accepted',
        'user_reject' => 'Inform User when form rejected',
        'admin_submit' => 'Inform Admin when form submitted',
        'manager_submit' => 'Inform Managers when form must be approved',
     ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = $this->replaceMacro($value);
    }

    public function replaceMacro($string)
    {

        $find = [
            '{form_title}'
        ];

        $replace = [
            $this->form->title
        ];

        return str_replace($find,$replace,$string);
    }

    public function clientMessageFields()
    {
        preg_match_all("/\[([^\]]*)\]/", $this->message, $matches);

        $items = [];

        foreach ($matches[0] as $item) {
            preg_match("/\w+/", $item, $match);
            $items[$item] = $match[0];
        }
        return $items;

    }
}
