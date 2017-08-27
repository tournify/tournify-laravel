<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Events\UserRegistered;
use Laravel\Socialite\Facades\Socialite;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @param  Authenticator $auth
     * @return void
     */

    protected $redirectTo = '/';

    protected $loginPath = '/login';

    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function postIndex(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $this->incrementLoginAttempts($request);

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        }

        if ($this->auth->attempt($request->only('email', 'password'))) {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'email' => 'The credentials you entered did not match our records. Try again?',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        event(new UserRegistered($user));
        return $user;
    }
}
