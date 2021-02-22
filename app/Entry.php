<?php

/**
* Description:
* Model (based on MVC architecture) for entry (submittion made by user)
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - form() | reference to application's form definition (Object-Relational Mapper)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
    * Description:
    * reference to application's form definition (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    *
    * Example of usage:
    *
    */
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

}
