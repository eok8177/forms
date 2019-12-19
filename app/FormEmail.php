<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
