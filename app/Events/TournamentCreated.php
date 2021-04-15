<?php

namespace App\Events;

use App\Events\Event;
use App\Tournament;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;

class TournamentCreated extends Event implements ShouldBroadcast, ShouldQueue
{
    use SerializesModels;

    public $tournament;

    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    public function broadcastOn()
    {
        return ['main'];
    }
}
