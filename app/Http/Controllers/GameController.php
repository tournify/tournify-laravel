<?php

namespace App\Http\Controllers;

use App\Game;
use App\Score;
use App\Team;
use App\Tournament;
use App\Group;
use App\TournamentOption;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function view($tournament, $slug) {
        $t = Tournament::where(['slug' => $tournament])->first();
        $game = Game::where(['slug' => $slug])->first();
        return view('game.view')->with(['game' => $game, 'tournament' => $t]);
    }
}
