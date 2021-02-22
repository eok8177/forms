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
* - getNameAttribute() | get user's first name and last name (Laravel Accessor)
* - hasAnyRole($roles) | Are there any role assign for this user?
* - groups() | reference to list of groups current user belongs (Object-Relational Mapper)
* - generateRandomString($length = 8) | generate random string
* - draftApps() | get draft applications for particular user
* - sendNewPasswordEmail() | send new password via email
* - sendPasswordResetNotification($token) | send the password reset notification
* - sendEmailVerificationNotification() | send the email verification notification
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


    /**
    * Description:
    * get user's first name and last name (Laravel Accessor)
    *
    * Return:
    * string
    *
    * Example of usage:
    * see method Http/Controllers/FrontendController.success()
    */
    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }


    /**
    * Description:
    * Are there any role assign for this user?
    *
    * List of parameters:
    * - none
    *
    * Return:
    * boolean
    *
    * Example of usage:
    * see method Http/Middleware/CheckRole.handle()
    */
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


    /**
    * Description:
    * reference to list of groups current user belongs (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    *
    * Example of usage:
    *
    */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }


    /**
    * Description:
    * generate random string
    *
    * List of parameters:
    * - $length: integer (default 8)
    *
    * Return:
    * string
    *
    * Example of usage:
    * see sendNewPasswordEmail()
    */
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

    /**
    * Description:
    * send new password via email
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object
    *
    * Example of usage:
    * navigate to <baseUrl>/password/reset
    */
    public function sendNewPasswordEmail()
    {
        $password = $this->generateRandomString();
        $this->password = bcrypt($password);
        $this->save();
        return $this->notify(new NewPassword($password));
    }


    /**
    * Description:
    * send the password reset notification
    *
    * List of parameters:
    * $token : string
    *
    * Return:
    * - void
    *
    * Example of usage:
    * used by laravel internally
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token, $this));
    }


    /**
    * Description:
    * send the email verification notification
    *
    * List of parameters:
    * - none
    *
    * Return:
    * - void
    *
    * Example of usage:
    * used by laravel internally
    */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerify($this));
    }
}
