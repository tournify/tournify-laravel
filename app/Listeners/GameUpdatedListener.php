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
use Maknz\Slack;

class GameUpdatedListener
{
    public function __construct()
    {
        //
    }

    public function handle(GameUpdated $event)
    {
        $g = $event->game;
        $client = new \Maknz\Slack\Client('https://hooks.slack.com/services/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');
        $t = $g->tournament()->first();
        $scores = $g->scores()->get();
        $message2 = "";
        $i=0;
        foreach ($scores as $s) {
            $team = $s->team()->first();
            if (isset($team->name)) {
                $message2 .= $team->name . ' - ' . $s->score . "\n";
            } else {
                $message2 .= $s->score . "\n";
            }
            $i++;
        }
        $client->send('Matchen "'.$g->name.'" i turneringen "'.$t->name.'" har uppdaterats!'."\n".$message2);
    }
}