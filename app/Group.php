<?php

/**
* Description:
* Model (based on MVC architecture) for group definitions
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - empty() | is this group used for any form or user?
* - managers() | reference to users-managers (Object-Relational Mapper)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
    * Description:
    * is this group used for any form or user?
    *
    * List of parameters:
    * - none
    *
    * Return:
    * boolean
    *
    * Example of usage:
    * see resources/views/admin/groupe/index.blade.php
    */
    public function empty()
    {
        $forms = $this->belongsToMany(Form::class);
        $users = $this->belongsToMany(User::class);

        return ($forms->count() == 0 && $users->count() == 0) ? true : false;
    }


    /**
    * Description:
    * reference to users-managers (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * oject | list of objects
    *
    * Example of usage:
    * see method Http/Controllers/Admin/GroupController.store()
    */
    public function managers()
    {
        return $this->belongsToMany(User::class)->where('role', 'manager');
    }


}
