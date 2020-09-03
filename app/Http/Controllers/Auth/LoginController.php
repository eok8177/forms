<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // Dual login via login or email
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)
        ? 'email'
        : 'login';

        return [
            $field => $request->get('email'),
            'password' => $request->password,
        ];
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if (auth()->user()->role == 'admin') {
            return '/admin/responses';
        }
        if (auth()->user()->role == 'manager') {
            return '/admin/responses';
        }
        if (auth()->user()->role == 'user') {
            return '/user';
        }
        return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
     protected function authenticated(Request $request, $user)
     {
        if ($user->role == 'user') {
            $count = $user->draftApps()->count();
            if ($count > 0) {
                $message = '<strong>Welcome back '.$user->first_name.'!</strong> You have '.$count.' item/s for attention.';
                $request->session()->flash('success', $message);
            }
        }
        return redirect()->intended($this->redirectPath());
     }


    /**
     * Handle Social login request
     *
     * @return response
     */
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
    /**
     * Obtain the user information from Social Logged in.
     * @param $social
     * @return Response
     */

    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();
        // dd($userSocial);
        if($user){
            Auth::login($user);
            if ($user->role == 'admin') return redirect('/admin/dashboard');
            return redirect('/');
        }else{
            return view('auth.register',[
                'first_name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'social_id' => $userSocial->getId(),
                'avatar' => $userSocial->getAvatar(),
            ]);
        }
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $urlBase = url()->to('/');
        $redirect = session()->get('redirectTo', false);
        $urlPrevious = $redirect ? $urlBase.$redirect : url()->previous();

        // Set the previous url that we came from to redirect to after successful login but only if is internal
        if(($urlPrevious != $urlBase . '/login') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)) {
            if(str_replace($urlBase, '', $urlPrevious) != '/')
                session()->put('url.intended', $urlPrevious);
        }

        return view('auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->super_admin_to = NULL;
        auth()->user()->save();

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }
}
