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
use Maknz\Slack;

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
//        $t = $event->tournament;
//        $client = new \Maknz\Slack\Client('https://hooks.slack.com/services/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');
//        $options = $t->options()->get();
//        $teams = 0;
//        $groups = 0;
//        $meets = 0;
//        foreach($options as $o) {
//            if ($o->key == "teamcount") {
//                $teams = $o->value;
//            } else if ($o->key == "groupcount") {
//                $groups = $o->value;
//            } else if ($o->key == "meetcount") {
//                $meets = $o->value;
//            }
//        }
//        $group = "grupper";
//        if ($groups == 1) {
//            $group = "grupp";
//        }
//        $meet = "möten";
//        if ($meets == 1) {
//            $meet = "möte";
//        }
//        $client->send('Turneringen "'.$t->name.'" har skapats med '.$teams.' lag, '.$groups.' '.$group.' och '.$meets.' '.$meet.' per lag!');
    }
}