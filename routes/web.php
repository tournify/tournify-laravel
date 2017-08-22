<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Register routes
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Logout route

Route::get('auth/github', 'Auth\AuthController@redirectToGithub');
Route::get('auth/github/callback', 'Auth\AuthController@handleGithubCallback');

Route::get('auth/instagram', 'Auth\AuthController@redirectToInstagram');
Route::get('auth/instagram/callback', 'Auth\AuthController@handleInstagramCallback');

Route::get('auth/facebook', 'Auth\AuthController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleFacebookCallback');

Route::get('auth/google', 'Auth\AuthController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\AuthController@handleGoogleCallback');

Route::get('auth/twitter', 'Auth\AuthController@redirectToTwitter');
Route::get('auth/twitter/callback', 'Auth\AuthController@handleTwitterCallback');

Route::get('/tournament/create', ['uses' =>'TournamentController@getCreate']);
Route::post('/tournament/make', ['uses' =>'TournamentController@postMake']);
Route::post('/tournament/save', ['uses' =>'TournamentController@postSave']);
Route::get('/tournament/{slug}', ['uses' =>'TournamentController@view']);
Route::get('/tournament/{slug}/stats', ['uses' =>'TournamentController@stats']);
Route::get('/tournament/{slug}/teams', ['uses' =>'TournamentController@teams']);

Route::get('/tournament/{tournament}/{slug}', ['uses' =>'GameController@view']);

Route::get('/blog/create', ['uses' =>'BlogController@getCreate']);

Route::get('/blog/{slug}', ['uses' =>'BlogController@view']);

Route::post('/subscribe', ['uses' =>'UserController@subscribe']);

Route::get('/subscribe', function () {
    return view('errors.404');
});

Route::get('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);

Route::resource('blog', 'BlogController');
Route::resource('profile', 'UserController');
Route::resource('tournament', 'TournamentController');
Route::resource('login', 'Auth\LoginController');


Route::get('/terms-of-service', function () {
    return view('legal.terms');
});

Route::get('/privacy-policy', function () {
    return view('legal.privacy');
});

Route::get('/', function () {
    return view('welcome')->with(array('tournaments' => \App\Tournament::orderBy('created_at','desc')->take(5)->get()));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
