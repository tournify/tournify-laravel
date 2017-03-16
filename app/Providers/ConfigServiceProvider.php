<?php
/**
 * Created by PhpStorm.
 * User: markustenghamn
 * Date: 22/11/15
 * Time: 22:08
 */

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Laravelrus\LocalizedCarbon\LocalizedCarbon;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config([
            'config/services.php',
        ]);
    }
}