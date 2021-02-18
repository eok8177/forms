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
* - none
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

    public function forms()
    {
        return $this->hasMany(Form::class, 'form_type_id', 'id');
    }

    public function getColorAttribute($value)
    {
        return $value ? $value : '#000';
    }

}
