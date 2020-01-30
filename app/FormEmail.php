<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormEmail extends Model
{
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
}
