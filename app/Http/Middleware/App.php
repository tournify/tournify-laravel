<?php
namespace App\Http\Middleware;

use Closure, Illuminate\Support\Facades\Session, Illuminate\Support\Facades\Auth;

class App
{

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['en', 'sv'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (strpos($request->root(),'turnering') !== false)
        {
            Session::put('locale', 'sv');
        } else {
            Session::put('locale', 'en');
        }

        app()->setLocale(Session::get('locale'));

        return $next($request);
    }

}
