<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Hashids;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout','loginAsUser','backToRealAccount']);
    }

    public function showLoginForm()
    {
        return view('auth.index');
    }

    protected function validateLogin(Request $request)
    {
        // If user provided mobile number as username
        if (isMobile($request->login) && $this->validate($request, ['login' => 'required', 'password' => 'required|string|min:6'])) {
            return true;
        }
        // If user provided email as username
        elseif (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $this->validate($request, [
                'login' => 'required|string',
                'password' => 'required|string|min:6'
            ]);
        }
        else {
            return false;
        }
    }

    public function username()
    {
        // If user provided mobile number as username
        if (isMobile(request('login')))
            return 'mobile';

        // If user provided email as username
        if (filter_var(request('login'), FILTER_VALIDATE_EMAIL))
            return 'email';

        return 'email';
    }

    protected function credentials(Request $request)
    {
        $request->merge([$this->username() => $request->login]);
        return $request->only($this->username(), 'password');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        // Replace it with translation strings
        $message = 'Mobile or Password is incorrect.';
        if ($this->username() == 'email')
            $message = 'Email or Password is incorrect';
        throw ValidationException::withMessages([
            $this->username() => [$message],
//            $this->username() => [trans('auth.failed_' . $this->username())],
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('admin'))
            return redirect()->intended(route('admin.home'));
        if ($user->hasRole('support'))
            return redirect()->intended(route('admin.home'));
        // return redirect()->intended(route('dashboard.home'));
        // return;
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('dashboard.home');
    }

    public function loginAsUser(Request $request,$userHashId){
        // return 'aaa';
        $adminId = \Auth::user()->id;
        $id = Hashids::connection('general')->decode($userHashId);
        if ($this->guard()->loginUsingId($id)) {
            // return 'aaa';
            \Session::put('force-login', true);
            \Session::put('logged-admin-id', $adminId);
            return $this->sendLoginResponse($request);
        }
    }

    public function backToRealAccount(Request $request){
        // return 'aaa';
        if(\Session::has('force-login')){
            if ($this->guard()->loginUsingId(\Session::get('logged-admin-id'))) {
                \Session::forget('force-login');
                \Session::forget('logged-admin-id');
                return $this->sendLoginResponse($request);
            }
        }
    }
}
