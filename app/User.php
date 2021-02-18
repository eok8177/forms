<?php

/**
* Description:
* Model (based on MVC architecture) for users
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - draftApps() | get draft applications for particular user
*/

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Notifications\NewPassword;
use App\Notifications\PasswordReset;
use App\Notifications\EmailVerify;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->role == $role) return true;
            }
        } else {
            if ($this->role == $roles) return true;
        }
        return false;
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    private function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
    * Description:
    * get draft applications for particular user
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object
    *
    * Examples of usage:
    * see method app/Http/Controllers/Auth/LoginController.authenticated()
    */
    public function draftApps()
    {
        $apps = Application::where('user_id', $this->id)
            ->where(function($q) {
                $q->orWhere('status', 'rejected');
                $q->orWhere('status', 'draft');
        })->get();
        return $apps;
    }


    // Notifications

    public function sendNewPasswordEmail()
    {
        $password = $this->generateRandomString();
        $this->password = bcrypt($password);
        $this->save();
        return $this->notify(new NewPassword($password));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token, $this));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerify($this));
    }
}
