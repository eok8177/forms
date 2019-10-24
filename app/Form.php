<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Search forms
     */
    static function search($search, $order = 'ASC')
    {
        $forms = Form::Where('title','LIKE', '%'.$search.'%');
        return $forms;
    }

}
