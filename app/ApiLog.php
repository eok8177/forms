<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    const UPDATED_AT = null; //and updated by default null set

    static function failled()
    {
        $logs = ApiLog::where('response','LIKE', '%"response_status":"0"%')->get();

        return $logs;
    }

}
