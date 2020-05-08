<?php

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
