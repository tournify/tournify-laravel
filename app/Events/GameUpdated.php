<?php
/**
 * Created by PhpStorm.
 * User: markustenghamn
 * Date: 27/12/15
 * Time: 01:00
 */

namespace App\Events;

use App\Events\Event;
use App\Game;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function broadcastOn()
    {
        return ['main'];
    }
}
