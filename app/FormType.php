<?php

/**
* Description:
* Model (based on MVC architecture) for type of form definitions
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - forms() | reference to all forms with this form type (Object-Relational Mapper)
* - getColorAttribute($value) | Get color of Form Type
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
    * Description:
    * reference to all forms with this form type (Object-Relational Mapper)
    *
    * Return:
    * object | list of objects
    *
    * Example of usage:
    * see resources/views/admin/formtype/index.blade.php
    */
    public function forms()
    {
        return $this->hasMany(Form::class, 'form_type_id', 'id');
    }


    /**
    * Description:
    * Get color of Form Type
    *
    * Return:
    * string color
    *
    * Example of usage:
    * app/Http/Controllers/Admin/FormTypeController.edit()
    * resources/views/admin/response.blade.php ...
    */
    public function getColorAttribute($value)
    {
        return $value ? $value : '#000';
    }

}
