<?php

namespace Kjdion84\Laraback\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Kjdion84\Laraback\Traits\ValidateAjax;

class AuthController extends Controller
{
    use ValidateAjax;

    public function __construct()
    {
        $this->middleware('guest')->only(['loginForm', 'login', 'passwordEmailForm', 'passwordEmail', 'passwordResetForm', 'passwordReset']);
        $this->middleware('auth')->only(['profileForm', 'profile', 'passwordChangeForm', 'passwordChange', 'logout']);
        $this->middleware('GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:5,1')->only(['login', 'passwordEmail', 'passwordReset']);
    }

    // show login form
    public function loginForm()
    {
        return view('laraback::auth.login');
    }

    // login
    public function login()
    {
        $this->validateAjax(request(), [
            'email' => 'required|email',
            'password' => 'required',
        ], true);

        if (auth()->guard()->attempt(request()->only(['email', 'password']), request()->has('remember'))) {
            request()->session()->regenerate();

            activity('Logged In');

            return response()->json(['redirect' => request()->session()->pull('url.intended', route('index'))]);
        }
        else {
            return response()->json(['message' => trans('auth.failed')], 422);
        }
    }

    // show password reset link email form
    public function passwordEmailForm()
    {
        return view('laraback::auth.password.email');
    }

    // email password reset link
    public function passwordEmail()
    {
        $this->validateAjax(request(), [
            'email' => 'required|email',
            'g-recaptcha-response' => 'sometimes|recaptcha',
        ]);

        if (($user = app(config('auth.providers.users.model'))->where('email', request()->input('email'))->first())) {
            $token = Password::getRepository()->create($user);

            Mail::send(['text' => 'laraback::emails.password'], ['token' => $token], function (Message $message) use ($user) {
                $message->subject(config('app.name') . ' Password Reset Link');
                $message->to($user->email);
            });

            flash('success', 'Password reset link emailed!');

            return response()->json(['reload_page' => true]);
        }
        else {
            return response()->json(['message' => trans('auth.failed')], 422);
        }
    }

    // show password reset form
    public function passwordResetForm($token)
    {
        return view('laraback::auth.password.reset', compact('token'));
    }

    // reset password
    public function passwordReset()
    {
        $this->validateAjax(request(), [
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'g-recaptcha-response' => 'sometimes|recaptcha',
        ]);

        $response = Password::broker()->reset(request()->except('_token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
            auth()->guard()->login($user);
        });

        if ($response == Password::PASSWORD_RESET) {
            activity('Reset Password');
            flash('success', 'Password reset!');

            return response()->json(['redirect' => route('index')]);
        }
        else {
            return response()->json(['message' => trans($response)], 422);
        }
    }

    // show profile edit form
    public function profileForm()
    {
        return view('laraback::auth.profile');
    }

    // edit profile
    public function profile()
    {
        $this->validateAjax(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ]);

        auth()->user()->update(request()->all());

        activity('Edited Profile', request()->all());
        flash('success', 'Profile edited!');

        return response()->json(['reload_page' => true]);
    }

    // show password change form
    public function passwordChangeForm()
    {
        return view('laraback::auth.password.change');
    }

    // change password
    public function passwordChange()
    {
        $this->validateAjax(request(), [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if (Hash::check(request()->input('current_password'), auth()->user()->password)) {
            auth()->user()->update(['password' => Hash::make(request()->input('password'))]);

            activity('Changed Password');
            flash('success', 'Password changed!');

            return response()->json(['reload_page' => true]);
        }
        else {
            return response()->json(['message' => trans('auth.failed')], 422);
        }
    }

    // logout
    public function logout()
    {
        activity('Logged Out');

        auth()->guard()->logout();
        request()->session()->invalidate();

        return redirect()->route('index');
    }
}