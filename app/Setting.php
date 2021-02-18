<?php

/**
* Description:
* Model (based on MVC architecture) for application settings
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - updateSettings($data) | update settings
* - colors() | get list of available colors from settings
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
    * Description:
    * Update settings
    *
    * List of parameters:
    * - $data : object
    *
    * Return:
    * true
    *
    * Examples of usage:
    * see method Http/Controllers/Admin/SettingController.update()
    */
    public static function updateSettings($data)
    {
        foreach ($data as $key => $item) {
            $item_settings = Setting::where('key', $key)->first();
            $item_settings->value = $item;
            $item_settings->save();
        }
        return true;
    }


    /**
    * Description:
    * get list of available colors from settings
    *
    * List of parameters:
    * - none
    *
    * Return:
    * comma separated #rgb values
    *
    * Examples of usage:
    * see method Http/Controllers/Admin/FormTypeController.create()
    */
    public static function colors()
    {
        $colors = Setting::where('key', 'form_type_colors')->first();
        if (!$colors) return '#000';

        return explode(',', preg_replace('/\s+/', '', $colors->value));
    }

}
