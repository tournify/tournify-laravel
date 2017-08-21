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

    //Social


    public function redirectToGithub(Request $request)
    {
        if ($request->get('session') == 'en') {
            $request->session()->flash('redirect', 'Back to tournify.io');
        }
        if (Lang::getLocale() == 'en') {
            return redirect('http://turnering.io/auth/github?session=en');
        }
        $github = Socialite::with('github');
        return $github->redirect();
    }

    public function handleGithubCallback(Request $request)
    {
        if (is_numeric($request->get('u'))) {
            $user = User::where('id', $request->get('u'))->first();
            if (Hash::check("%tournify" . $user->id . "a" . $user->token, $request->get('h'))) {
                $this->auth->login($user);
                return redirect('/');
            }
        }
        $github = Socialite::with('github')->user();
        $user = $this->registerOrFind($github, 'github');
        if (is_null($user)) {
            return redirect('/login')->withErrors([
                'email' => 'An account with this email already exists, please login.',
            ]);
        }
        if (session('redirect') == "Back to tournify.io") {
            $hash = Hash::make("%tournify" . $user->id . "a" . $user->token);
            return redirect('http://tournify.io/auth/github/callback?u=' . $user->id . '&h=' . $hash);
        }
        $this->auth->login($user);
        return redirect('/');
    }

    public function redirectToFacebook(Request $request)
    {
        if ($request->get('session') == 'en') {
            $request->session()->flash('redirect', 'Back to tournify.io');
        }
        if (Lang::getLocale() == 'en') {
            return redirect('http://turnering.io/auth/github?session=en');
        }
        return Socialite::with('facebook')->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        if (is_numeric($request->get('u'))) {
            $user = User::where('id', $request->get('u'))->first();
            if (Hash::check("%tournify" . $user->id . "a" . $user->token, $request->get('h'))) {
                $this->auth->login($user);
                return redirect('/');
            }
        }
        $facebook = Socialite::with('facebook')->user();
        $user = $this->registerOrFind($facebook, 'facebook');
        if (is_null($user)) {
            return redirect('/login')->withErrors([
                'email' => 'An account with this email already exists, please login.',
            ]);
        }
        if (session('redirect') == "Back to tournify.io") {
            $hash = Hash::make("%tournify" . $user->id . "a" . $user->token);
            return redirect('http://tournify.io/auth/github/callback?u=' . $user->id . '&h=' . $hash);
        }
        $this->auth->login($user);
        return redirect('/');
    }

    public function redirectToTwitter(Request $request)
    {
        if ($request->get('session') == 'en') {
            $request->session()->flash('redirect', 'Back to tournify.io');
        }
        if (Lang::getLocale() == 'en') {
            return redirect('http://turnering.io/auth/github?session=en');
        }
        return Socialite::with('twitter')->redirect();
    }

    public function handleTwitterCallback(Request $request)
    {
        if (is_numeric($request->get('u'))) {
            $user = User::where('id', $request->get('u'))->first();
            if (Hash::check("%tournify" . $user->id . "a" . $user->token, $request->get('h'))) {
                $this->auth->login($user);
                return redirect('/');
            }
        }
        $twitter = Socialite::with('twitter')->user();
        $user = $this->registerOrFind($twitter, 'twitter');
        if (is_null($user)) {
            return redirect('/login')->withErrors([
                'email' => 'An account with this email already exists, please login.',
            ]);
        }
        if (session('redirect') == "Back to tournify.io") {
            $hash = Hash::make("%tournify" . $user->id . "a" . $user->token);
            return redirect('http://tournify.io/auth/github/callback?u=' . $user->id . '&h=' . $hash);
        }
        $this->auth->login($user);
        return redirect('/');
    }

    public function redirectToGoogle(Request $request)
    {
        if ($request->get('session') == 'en') {
            $request->session()->flash('redirect', 'Back to tournify.io');
        }
        if (Lang::getLocale() == 'en') {
            return redirect('http://turnering.io/auth/github?session=en');
        }
        return Socialite::with('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        if (is_numeric($request->get('u'))) {
            $user = User::where('id', $request->get('u'))->first();
            if (Hash::check("%tournify" . $user->id . "a" . $user->token, $request->get('h'))) {
                $this->auth->login($user);
                return redirect('/');
            }
        }
        $google = Socialite::with('google')->user();
        $user = $this->registerOrFind($google, 'google');
        if (is_null($user)) {
            return redirect('/login')->withErrors([
                'email' => 'An account with this email already exists, please login.',
            ]);
        }
        if (session('redirect') == "Back to tournify.io") {
            $hash = Hash::make("%tournify" . $user->id . "a" . $user->token);
            return redirect('http://tournify.io/auth/github/callback?u=' . $user->id . '&h=' . $hash);
        }
        $this->auth->login($user);
        return redirect('/');
    }

    public function redirectToInstagram(Request $request)
    {
        if ($request->get('session') == 'en') {
            $request->session()->flash('redirect', 'Back to tournify.io');
        }
        if (Lang::getLocale() == 'en') {
            return redirect('http://turnering.io/auth/github?session=en');
        }
        return Socialite::with('instagram')->redirect();
    }

    public function handleInstagramCallback(Request $request)
    {
        if (is_numeric($request->get('u'))) {
            $user = User::where('id', $request->get('u'))->first();
            if (Hash::check("%tournify" . $user->id . "a" . $user->token, $request->get('h'))) {
                $this->auth->login($user);
                return redirect('/');
            }
        }
        $instagram = Socialite::with('instagram')->user();
        $user = $this->registerOrFind($instagram, 'instagram');
        if (is_null($user)) {
            return redirect('/login')->withErrors([
                'email' => 'An account with this email already exists, please login.',
            ]);
        }
        if (session('redirect') == "Back to tournify.io") {
            $hash = Hash::make("%tournify" . $user->id . "a" . $user->token);
            return redirect('http://tournify.io/auth/github/callback?u=' . $user->id . '&h=' . $hash);
        }
        $this->auth->login($user);
        return redirect('/');
    }

    private function registerOrFind($provider, $providername)
    {
        if (Lang::getLocale() == 'sv') {
            $faker = Faker::create('sv_SE');
        } else {
            $faker = Faker::create();
        }

        $theuser = User::where(['provider_id' => $provider->id, 'provider' => $providername])->first();
        if ($theuser) {
            $user = $theuser;
        } else {
            $checkuser = USER::where('email', $provider->email)->first();
            if ($checkuser) {
                return NULL;
            }
            $user = User::create([
                'name' => $provider->name,
                'email' => $provider->email,
                'password' => bcrypt($faker->password(20, 30)),
                'provider' => $providername,
                'provider_id' => $provider->id,
                'token' => $provider->token,
                'avatar' => $provider->avatar
            ]);
            event(new UserRegistered($user));
        }
        return $user;
    }
}
