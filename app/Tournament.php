<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tournaments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'private', 'keywords', 'description', 'type'];

    public function getFromTimeAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function groups() {

        return $this->hasMany('App\Group');
    }

    public function options() {

        return $this->hasMany('App\TournamentOption');
    }
}
