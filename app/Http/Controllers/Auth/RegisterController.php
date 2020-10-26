<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\ApiCall;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/redirect-to';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users|emailcheck',
            'password' => 'required|string|min:4|confirmed',
            'g-recaptcha-response' => 'required|recaptcha',
            'agree' => 'required'
        ], $this->messages());
    }

    protected function messages()
    {
        return [
           'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
           'g-recaptcha-response.required' => 'Please complete the captcha',
           'email.emailcheck' => 'Not valid email address',
       ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            // 'login' => $data['login'],
            'email' => $data['email'],
            // 'social_id' => $data['social_id'],
            // 'avatar' => $data['avatar'],
            'password' => bcrypt($data['password']),
        ]);

        // pass data into MARS
        $api = new ApiCall;
		$data = $api->newUser($user);
		
        return $user;
    }
}
