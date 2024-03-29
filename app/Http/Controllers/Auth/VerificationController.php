<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

use App\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    // auth by verification link
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        auth()->login($user);

        if ($request->user()->hasVerifiedEmail()) {
            //already verified
            return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect($this->redirectPath());
    }
}
