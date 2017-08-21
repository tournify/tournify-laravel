<?php
/**
 * Created by PhpStorm.
 * User: markustenghamn
 * Date: 27/12/15
 * Time: 01:02
 */

namespace App\Listeners;

use App\Events\GameUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GameUpdatedListener
{
    public function __construct()
    {
        //
    }

    public function handle(GameUpdated $event)
    {

    }
}