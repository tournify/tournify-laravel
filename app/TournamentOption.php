<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentOption extends Model
{

    protected $table = 'tournaments_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value', 'tournament_id'];

    public function tournament()
    {
        return $this->hasOne('App\Tournament');
    }
}
