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
* - none
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

    public function empty()
    {
        $forms = $this->belongsToMany(Form::class);
        $users = $this->belongsToMany(User::class);

        return ($forms->count() == 0 && $users->count() == 0) ? true : false;
    }

    public function managers()
    {
        return $this->belongsToMany(User::class)->where('role', 'manager');
    }


}
