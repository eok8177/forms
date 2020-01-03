<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
	const STATUS_ALL = 'All Statuses';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

}
