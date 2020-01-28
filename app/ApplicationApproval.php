<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationApproval extends Model
{
    const STATUS = [
        '0' => 'submited',
        '1' => 'accepted',
       '-1' => 'rejected'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}
