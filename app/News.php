<?php

/**
* Description:
* Model (based on MVC architecture) for news definitions
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - front() | get active records
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
    * Description:
    * get active records
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object | list of objects
    *
    * Example of usage:
    * resources/views/user/parts/informBlock.blade.php
    */
    public static function front()
    {
        return News::where('show', 1)->orderBy('order', 'asc')->get();
    }
}
