<?php

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

    public static function front()
    {
        return News::where('show', 1)->orderBy('order', 'asc')->get();
    }
}
