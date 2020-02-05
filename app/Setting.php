<?php

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


    public static function updateSettings($data)
    {
        foreach ($data as $key => $item) {
            $item_settings = Setting::where('key', $key)->first();
            $item_settings->value = $item;
            $item_settings->save();
        }
        return true;
    }

}
