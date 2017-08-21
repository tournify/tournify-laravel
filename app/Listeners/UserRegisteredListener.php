<?php
/**
 * Created by PhpStorm.
 * User: markustenghamn
 * Date: 27/12/15
 * Time: 00:51
 */

namespace App\Listeners;

use App\Events\SomeEvent;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maknz\Slack;

class UserRegisteredListener
{
    public function __construct()
    {
        //
    }

    public function handle(UserRegistered $event)
    {

    }
}