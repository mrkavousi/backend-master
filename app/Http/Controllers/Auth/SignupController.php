<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserCreated;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class SignupController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Signup Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;
    use \Illuminate\Foundation\Auth\RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
        // If user provided mobile number as username
        if (isMobile($data['login'])) {
            return Validator::make($data, [
                'mobile' => 'required|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }
        // If user provided email as username
        elseif (filter_var($data['login'], FILTER_VALIDATE_EMAIL)) {
            return Validator::make($data, [
                'email' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }
        else {
            return false;
        }
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $request->merge([$this->username() => $request->login]);
        $validator = $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request)));
        $this->guard()->login($user);

        return $this->signedup($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        $user = User::create([
            $this->username() => $request->login,
            'password' => bcrypt($request->password),
            'status' => 0,
        ]);

        event(new UserCreated($user));

        return $user;
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
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

    protected function signedup(Request $request, $user)
    {
        //
    }
}
