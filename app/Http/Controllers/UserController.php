<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Application;
use App\ApiCall;
use App\Setting;
use App\Faq;
use App\Form;

use Mail;

class UserController extends Controller
{
    public function redirectTo(Request $request)
    {
        $user =Auth::user();
        $user->last_logged_in = date("Y-m-d H:i:s");
        $user->save();
        if ($user->role == 'admin') {
            return redirect('/admin/responses');
        } elseif ($user->role == 'manager') {
            return redirect('/admin/responses');
        } elseif ($user->role == 'user') {
            $redirectTo = $request->session()->get('redirectTo', '/user');
            if (!$user->email_verified_at) {
                return redirect('/user');
            }
            $request->session()->forget('redirectTo');
            return redirect($redirectTo);
        }
    }

    public function index(Request $request)
    {
        $user =Auth::user();

        $api = new ApiCall;
        $data = $api->getDashboard($user);

        $order = $request->get('order', 'date');
        $dir = $request->get('dir', 'desc');

        $apps = Application::where('user_id', $user->id)
            ->join('forms', 'forms.id', '=', 'applications.form_id')
            ->join('form_types', 'form_types.id', '=', 'forms.form_type_id')
            ->select('applications.*')
            ->where(function($q) {
                $q->orWhere('status', 'rejected');
                $q->orWhere('status', 'draft');
            });

        $submitted = Application::where('user_id', $user->id)
            ->join('forms', 'forms.id', '=', 'applications.form_id')
            ->join('form_types', 'form_types.id', '=', 'forms.form_type_id')
            ->select('applications.*')
            ->where(function($q) {
                $q->orWhere('status', 'accepted');
                $q->orWhere(function($q) {
                    $q->where('status', 'submitted');
                });
            });

        if ($order == 'type') {
            $apps->orderBy('forms.form_types.name', $dir);
            $submitted->orderBy('forms.form_types.name', $dir);
        }
        if ($order == 'status') {
            $apps->orderBy('applications.status', $dir);
            $submitted->orderBy('applications.status', $dir);
        }
        if ($order == 'date') {
            $apps->orderBy('applications.updated_at', $dir);
            $submitted->orderBy('applications.updated_at', $dir);
        }

        return view('user.index', [
            'user' => $user,
            'apps' => $apps->get(),
            'submitted' => $submitted->get(),
            'dataMars' => $data,
            'host' => $request->getHost()
        ]);
    }
	
	// public function security()
	// {
	// 	return view('user.security', ['user' => Auth::user()]);
	// }

    public function edit()
    {
        return view('user.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => Rule::unique('users')->ignore($user->id),
        ]);

        $data = $request->all();

        // Password
        if ($data['old_password']) {
            if (!Hash::check($data['old_password'], $user->password)) {
                return redirect()->route('user.edit')->with('danger', 'Wrong old password');
            }
            if (!$data['password']) {
                return redirect()->route('user.edit')->with('danger', 'Password must be setup');
            }
            $data['password'] = bcrypt($data['password']);
            unset($data['old_password']);
            unset($data['re_password']);
        } else {
            unset($data['old_password']);
            unset($data['password']);
            unset($data['re_password']);
        }

        $user->update($data);

        $api = new ApiCall;
        $data = $api->updateUser($user);
	
        return redirect()->route('user.edit')->with('success', 'User updated');
    }
	
	// public function update_security(Request $request)
	// {
	// 	$user = Auth::user();
	// 	$data = $request->all();
	// 	// Password
	// 	if ($data['old_password']) {
	// 		if (!Hash::check($data['old_password'], $user->password)) {
	// 			return redirect()->route('user.security')->with('danger', 'Wrong old password');
	// 		}
	// 		if (!$data['password']) {
	// 			return redirect()->route('user.security')->with('danger', 'Password must be setup');
	// 		}
	// 		$data['password'] = bcrypt($data['password']);
	// 		unset($data['old_password']);
	// 		unset($data['re_password']);
	// 	} else {
	// 		unset($data['old_password']);
	// 		unset($data['password']);
	// 		unset($data['re_password']);
	// 	}
	// 	$user->update($data);
	// 	return redirect()->route('user.security')->with('success', 'Security settings have been updated');
	// }

    public function form(Application $app)
    {
        return view('user.form', [
            'app' => $app,
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }

    public function formView(Application $app)
    {
        return view('user.form_view', [
            'app' => $app,
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }

    public function destroy(Application $app)
    {
        $app->status = 'deleted';
        $app->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function archive(Request $request)
    {
        $user = Auth::user();

        $apps = Application::where('user_id', $user->id)
            ->where(function($q) {
                $q->orWhere('status', 'accepted');
                $q->orWhere(function($q) {
                    $q->where('status', 'submitted');
                    // $q->where('to_be_approved', 0);
                });
            })
            ->get();

        return view('user.archive', [
            'user' => $user,
            'apps' => $apps,
        ]);
    }

    public function faq()
    {
        return view('user.faq', [
            'user' => $user = Auth::user(),
            'faqs' => Faq::where('show', 1)->orderBy('order','asc')->get(),
        ]);
    }

    protected function draftSaved(Form $form)
    {
        $msg = 'You draft "'.$form->name.'" updated.';
        return redirect()->route('user.index')->with('success', $msg);
    }

    public function contact()
    {
        return view('user.contact', [
            'user' => $user = Auth::user()
        ]);
    }

    public function contactSend(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        $msg = "<h1>".$request->get('first_name')."</h1> <h2>".$request->get('last_name')."</h2><p>".$request->get('email',false)."<p>".$request->get('message');

        $data = [];

        $to_admin = Setting::where('key', 'admin_email')->first();

        $data['to'] = $to_admin ? $to_admin->value : 'sergey.markov@gmail.com';

        $data['subject'] = 'Contact';
        $data['from_name'] = $request->get('first_name',false)." ".$request->get('last_name',false);
        $data['from_email'] = $request->get('email',env('MAIL_FROM'));
        $data['message'] = $msg;
        $data['view'] = 'contact';


        Mail::send('email.'.$data['view'], ['msg' => $data['message']], function ($m) use ($data) {
          $m->from($data['from_email'], $data['from_name']);
          $m->to($data['to'])->subject($data['subject']);
        });

        return redirect()->route('user.contact')->with('success', 'Thank You');

    }

}
