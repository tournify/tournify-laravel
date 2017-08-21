<?php
/**
 * Created by PhpStorm.
 * User: markustenghamn
 * Date: 26/12/15
 * Time: 20:03
 */

namespace App\Listeners;

use App\Events\TournamentCreated;
use App\TournamentOption;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TournamentCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TournamentCreated  $event
     * @return void
     */
    public function handle(TournamentCreated $event)
    {

    }
}