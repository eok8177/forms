<?php

/**
* Description:
* Model (based on MVC architecture) for email templates defined for each form definition
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - form() | reference to "parent" form definition details (Object-Relational Mapper)
* - setSubjectAttribute($value) | set email's subject (Laravel Accessor)
* - replaceMacro($string) | macros replacement for $string
* - messageFields() | get email body fields to be replaced
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormEmail extends Model
{
    CONST TYPES = [
        'user_submit' => 'Inform User when form is submitted',
        'user_accept' => 'Inform User when form is accepted',
        'user_reject' => 'Inform User when form is rejected',
        'admin_submit' => 'Inform Admin when form is submitted',
        'manager_submit' => 'Inform Managers when form must be approved',
     ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
    * Description:
    * reference to "parent" form definition details (Object-Relational Mapper)
    *
    * Return:
    * object
    *
    * Example of usage:
    * TOADD
    */
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }


    /**
    * Description:
    * set email's subject (Laravel Accessor)
    *
    * Return:
    * void
    *
    * Example of usage:
    * see method Http/Controllers/Api/EmailController.feedback()
    */
    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = $this->replaceMacro($value);
    }


    /**
    * Description:
    * macros replacement for $string
    *
    * List of parameters:
    * $string | string
    *
    * Return:
    * string
    *
    * Example of usage:
    * see setSubjectAttribute()
    */
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


    /**
    * Description:
    * get email body fields to be replaced
    *
    * List of parameters:
    * - none
    *
    * Return:
    * array
    *
    * Example of usage:
    * see method Application.sendEmail()
    */
    public function messageFields()
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
