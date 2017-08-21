<?php

namespace App\Http\Controllers;

use Event;
use App\Events\TournamentCreated;
use App\Events\GameUpdated;
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

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $sort_key1;
    public $sort_key2;
    public $sort_key3;
    public $sort_key4;
    public $sort_asc;

    public function index()
    {
        $tournaments = Tournament::orderBy('created_at', 'DESC')->limit(20)->get();
        return view('tournament')->with(['tournaments' => $tournaments]);
    }

    public function getMake()
    {
        return redirect('/tournament');
    }

    public function postSave(Request $request)
    {
        $res = array("response" => "saved");
        $game = 0;
        if ($request->ajax()) {
            $arr = $request->all();
            foreach ($arr as $k => $v) {
                if ($k != "game-id" && $k != "_token") {
                    $team = Team::where(['id' => $k])->first();
                    $game = Game::where(['id' => $arr['game-id']])->first();
                    Score::where(['team_id' => $team->id, 'game_id' => $game->id])->delete();
                    $score = Score::create(['score' => $v, 'team_id' => $team->id, 'game_id' => $game->id]);
                    $score->save();
                    $res['score'][] = $score->id;
                }
            }
            event(new GameUpdated($game));
        } else {
            $res["response"] = "error";
        }
        return json_encode($res);
    }

    public function view($slug)
    {
        $tournament = Tournament::where(['slug' => $slug])->first();
        $options = $tournament->options()->get();
        $type = 0;
        foreach ($options as $o) {
            if ($o->key == "type") {
                $type = $o->value;
            }
        }
        if ($type == 1) {
            return view('tournament.elimination.view')->with('tournament', $tournament);
        } else {
            return view('tournament.view')->with('tournament', $tournament);
        }
    }

    public function teams($slug)
    {
        $tournament = Tournament::where(['slug' => $slug])->first();
        return view('tournament.teams')->with('tournament', $tournament);
    }


    public function stats($slug)
    {
        $tournament = Tournament::where(['slug' => $slug])->first();
        $groups = $tournament->groups()->get();
        $stats = array();
        $i = 0;
        foreach ($groups as $g) {
            $teams = $g->teams()->get();
            foreach ($teams as $t) {
                $stats[$i]["groupid"] = $g->id;
                $stats[$i]["group"] = $g->name;
                $stats[$i]["teamid"] = $t->id;
                $stats[$i]["team"] = $t->name;
                $stats[$i]["played"] = 0;
                $stats[$i]["win"] = 0;
                $stats[$i]["loss"] = 0;
                $stats[$i]["tied"] = 0;
                $stats[$i]["scoredon"] = 0;
                $stats[$i]["scoredagainst"] = 0;
                $games = $g->games()->whereHas('teams', function ($q) use ($t) {
                    $q->where('team_id', $t->id);
                })->get();
                foreach ($games as $ga) {
                    $scores = $ga->scores;
                    $teamscore = 0;
                    $opponentscore = 0;
                    foreach ($scores as $s) {
                        if ($s->team->id == $t->id) {
                            $stats[$i]["scoredon"] += $s->score;
                            $teamscore = $s->score;
                        } else {
                            $stats[$i]["scoredagainst"] += $s->score;
                            if ($opponentscore < $s->score) {
                                $opponentscore = $s->score;
                            }
                        }
                    }
                    if (count($scores) > 0) {
                        if ($teamscore > $opponentscore) {
                            $stats[$i]["win"] += 1;
                        } else if ($teamscore == $opponentscore) {
                            $stats[$i]["tied"] += 1;
                        } else {
                            $stats[$i]["loss"] += 1;
                        }
                        $stats[$i]["played"] += 1;
                    }
                }
                $options = $tournament->options()->get();
                $win = 3;
                $loss = 0;
                $tie = 1;
                foreach ($options as $o) {
                    if ($o->key == 'winpoints') {
                        $win = $o->value;
                    } else if ($o->key == 'tiepoints') {
                        $tie = $o->value;
                    } else if ($o->key == 'losspoints') {
                        $loss = $o->value;
                    }
                }
                $stats[$i]["points"] = $stats[$i]["win"] * $win;
                $stats[$i]["points"] += $stats[$i]["loss"] * $loss;
                $stats[$i]["points"] += $stats[$i]["tied"] * $tie;

                $stats[$i]["diff"] = $stats[$i]["scoredon"] - $stats[$i]["scoredagainst"];
                $i++;
            }
        }

        $stats = $this->array_sort_by_column($stats, 'groupid', 'points', 'diff', 'scoredon');
        return view('tournament.stats')->with(array('tournament' => $tournament, 'stats' => $stats));
    }

//

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postMake(Request $request)
    {
        //TODO if two teams have the same name we should append a 2 or something
        $input = $request->all();
        if (Lang::getLocale() == 'sv') {
            $faker = Faker::create('sv_SE');
        } else {
            $faker = Faker::create();
        }
        if ($input['teamcount'] > 20) {
            $input['teamcount'] = 20;
        }
        if ($input['meetcount'] > 5) {
            $input['meetcount'] = 5;
        }
        $t = new Tournament();

        if (strlen($input['tourname']) > 1) {
            $t->name = $input['tourname'];
        } else {
            if (Lang::getLocale() == 'sv') {
                $t->name = "Turnering " . $faker->lastName;
            } else {
                $t->name = "Tournament " . $faker->lastName;
            }

        }
        $t->slug = $this->uniqueTournamentSlug($t->name);
        if (Auth::user()) {
            $user = Auth::user();
            $user->tournaments()->save($t);
        } else {
            $t->save();
        }

        //Set tournament type //0 = group, 1 = elimination
        $t->options()->save(TournamentOption::create(['key' => 'type', 'value' => $input['tourtype']]));

        //Set point defaults if none are submitted
        $t->options()->save(TournamentOption::create(['key' => 'winpoints', 'value' => $input['winpoints']]));
        $t->options()->save(TournamentOption::create(['key' => 'tiepoints', 'value' => $input['tiepoints']]));
        $t->options()->save(TournamentOption::create(['key' => 'losspoints', 'value' => $input['losspoints']]));

        //Tournament options
        $t->options()->save(TournamentOption::create(['key' => 'teamcount', 'value' => $input['teamcount']]));
        $t->options()->save(TournamentOption::create(['key' => 'groupcount', 'value' => $input['groupcount']]));
        $t->options()->save(TournamentOption::create(['key' => 'meetcount', 'value' => $input['meetcount']]));
        $t->options()->save(TournamentOption::create(['key' => 'elimcount', 'value' => $input['elimcount']]));

        $groupsarr = array();
        for ($i = 1; $i <= $input['groupcount']; $i++) {
            $slug = $this->uniqueGroupSlug(trans('messages.group') . ' ' . $i);
            $group = Group::create(['name' => trans('messages.group') . ' ' . $i, 'slug' => $slug]);
            $t->groups()->save($group);
            $groupsarr[] = $group;
        }
        $teamsarr = $input['team'];
        if (!isset($teamsarr) || $teamsarr == null) {
            $teamsarr = array();
        }
        while (count($teamsarr) < $input['teamcount']) {
            $teamsarr[] = trans('messages.team') . " " . (count($teamsarr) + 1);
        }
        $tc = 0;
        foreach ($groupsarr as $g) {
            if ($tc >= $input['teamcount']) {
                break;
            }
            $l = 0;
            while ($l < ($input['teamcount'] / $input['groupcount'])) {
                if (trim($teamsarr[$tc]) == "") {
                    $teamsarr[$tc] = trans('messages.team') . " " . ($tc + 1);
                }
                $slug = $this->uniqueTeamSlug($teamsarr[$tc]);
                $g->teams()->save(Team::create(['name' => $teamsarr[$tc], 'slug' => $slug]));
                $l++;
                $tc++;
            }
        }

        if ($input['tourtype'] == 1) {
            $this->generateEliminationGames($t);
        } else {
            $this->generateGames($t);
        }

        event(new TournamentCreated($t));

        return redirect('/tournament/' . $t->slug);
    }

    public function postCreate(Request $request)
    {
        $input = $request->all();
        if (Lang::getLocale() == 'sv') {
            $faker = Faker::create('sv_SE');
        } else {
            $faker = Faker::create();
        }

        if (isset($input['tourname']) && strlen($input['tourname']) < 1) {
            if (Lang::getLocale() == 'sv') {
                $input['tourname'] = "Turnering " . $faker->lastName;
            } else {
                $input['tourname'] = "Tournament " . $faker->lastName;
            }
        }
        if (isset($input['tourname'])) {
            return view('tournament/create')->with('data', array('tourname' => $input['tourname']));
        } else {
            return view('tournament/create')->with('data', array('tourname' => ""));
        }
    }

    public function create()
    {
        $input = array();
        if (Lang::getLocale() == 'sv') {
            $faker = Faker::create('sv_SE');
        } else {
            $faker = Faker::create();
        }

        if (isset($input['tourname']) && strlen($input['tourname']) < 1) {
            if (Lang::getLocale() == 'sv') {
                $input['tourname'] = "Turnering " . $faker->lastName;
            } else {
                $input['tourname'] = "Tournament " . $faker->lastName;
            }
        }
        if (isset($input['tourname'])) {
            return view('tournament/create')->with('data', array('tourname' => $input['tourname']));
        } else {
            return view('tournament/create')->with('data', array('tourname' => ""));
        }
    }

    private function uniqueTournamentSlug($name)
    {
        $slug = Slugify::create();
        $res = $slug->slugify($name);
        $tour = Tournament::where('slug', $res)->first();
        if (is_null($tour)) {
            return $res;
        }
        $faker = Faker::create();
        $res2 = $name . "-" . $faker->numberBetween();
        return $this->uniqueTournamentSlug($res2);
    }

    private function uniqueGroupSlug($name)
    {
        $slug = Slugify::create();
        $res = $slug->slugify($name);
        $tour = Group::where('slug', $res)->first();
        if (is_null($tour)) {
            return $res;
        }
        $faker = Faker::create();
        $res2 = $name . "-" . $faker->numberBetween();
        return $this->uniqueGroupSlug($res2);
    }

    private function uniqueTeamSlug($name)
    {
        $slug = Slugify::create();
        $res = $slug->slugify($name);
        $tour = Team::where('slug', $res)->first();
        if (is_null($tour)) {
            return $res;
        }
        $faker = Faker::create();
        $res2 = $name . "-" . $faker->numberBetween();
        return $this->uniqueTeamSlug($res2);
    }

    private function generateGames($t)
    {
        // $t is tournament object
        $meetoption = $t->options()->where(['key' => 'meetcount'])->get()->first();
        $meetcount = $meetoption->value;
        $groups = $t->groups()->get();
        $gamecount = 1;
        foreach ($groups as $g) {
            $teams = $g->teams()->get();
            $teamarr = array();
            foreach ($teams as $tt) {
                $teamarr[] = $tt;
            }
            $series = $this->seriesGen($teamarr, $meetcount);
            foreach ($series as $s) {
                foreach ($s as $n) {
                    foreach ($n as $tea) {
                        if (isset($tea['away']) && isset($tea['home']) && is_object($tea['away']) && is_object($tea['home'])) {
                            $game = Game::create(['name' => trans('messages.game') . ' ' . $gamecount, 'tournament_id' => $t->id]);
                            $game->teams()->save($tea['home']);
                            $game->teams()->save($tea['away']);
                            $g->games()->save($game);
                            $gamecount++;
                        }
                    }
                }
            }
        }
    }

    private function seriesGen($teams, $meets)
    {

        $round = array();
        if (count($teams) % 2 != 0) {
            array_push($teams, 0);
        }
        for ($z = 0; $z < $meets; $z++) {
            $tempteams = $teams;
            $away = array_splice($tempteams, (count($tempteams) / 2));
            $home = $tempteams;
            for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
                for ($j = 0; $j < count($home); $j++) {
                    $round[$z][$i][$j]["home"] = $home[$j];
                    $round[$z][$i][$j]["away"] = $away[$j];
                }
                if (count($home) + count($away) - 1 > 2) {
                    $splice = array_splice($home, 1, 1);
                    $shift = array_shift($splice);
                    array_unshift($away, $shift);
                    $pop = array_pop($away);
                    array_push($home, $pop);
                }
            }
        }
        return $round;
    }

    private function tableSort($a, $b)
    {
        $key1 = $this->sort_key1;
        $key2 = $this->sort_key2;
        $key3 = $this->sort_key3;
        $key4 = $this->sort_key4;
        $asc = $this->sort_asc;
        $num = 1;
        if ($asc == 'desc') {
            $num = -1;
        }
        $key_a_1 = $a[$key1];
        $key_b_1 = $b[$key1];
        $key_a_2 = $a[$key2];
        $key_b_2 = $b[$key2];
        $key_a_3 = $a[$key3];
        $key_b_3 = $b[$key3];
        $key_a_4 = $a[$key4];
        $key_b_4 = $b[$key4];

        if ($key_a_1 > $key_b_1) {
            return (-1 * $num);
        } else if ($key_a_1 < $key_b_1) {
            return (1 * $num);
        } else {
            if ($key_a_2 < $key_b_2) {
                return (-1 * $num);
            } else if ($key_a_2 > $key_b_2) {
                return (1 * $num);
            } else {
                if ($key_a_3 < $key_b_3) {
                    return (-1 * $num);
                } else if ($key_a_3 > $key_b_3) {
                    return (1 * $num);
                } else {
                    if ($key_a_4 < $key_b_4) {
                        return (-1 * $num);
                    } else if ($key_a_4 > $key_b_4) {
                        return (1 * $num);
                    } else {
                        return 0;
                    }
                }
            }
        }
    }

    private function array_sort_by_column($arr, $col1, $col2, $col3, $col4, $asc = 'desc')
    {
        $this->sort_key1 = $col1;
        $this->sort_key2 = $col2;
        $this->sort_key3 = $col3;
        $this->sort_key4 = $col4;
        $this->sort_asc = $asc;
        usort($arr, array($this, "tableSort"));
        return $arr;
    }

    private function generateEliminationGames($t)
    {
        $meetcount = 1;
        $groups = $t->groups()->get();
        $gamecount = 1;
        foreach ($groups as $g) {
            foreach (array_chunk($g->teams->all(), 2) as $teammatch) {
                $game = Game::create(['name' => trans('messages.game') . ' ' . $gamecount, 'tournament_id' => $t->id]);
                if (isset($teammatch[0])) {
                    $game->teams()->save($teammatch[0]);
                }
                if (isset($teammatch[1])) {
                    $game->teams()->save($teammatch[1]);
                }
                $g->games()->save($game);
                $gamecount++;
            }
        }

    }
}
