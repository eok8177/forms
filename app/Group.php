<?php

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
