<?php

/**
* Description:
* Model (based on MVC architecture) for application approvals
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - none
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationApproval extends Model
{
    const STATUS = [
        '0' => 'submitted',
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
