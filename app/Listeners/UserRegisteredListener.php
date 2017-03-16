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
        $u = $event->user;
        $client = new \Maknz\Slack\Client('https://hooks.slack.com/services/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');
        $client->send('En ny användare som heter "'.$u->name.'" med e-post "'.$u->email.'" har registrerat sig!');
    }
}