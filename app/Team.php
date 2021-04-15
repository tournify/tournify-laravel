<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];


    public function tournaments()
    {
        return $this->belongsToMany('App\Tournament');
    }

    public function games()
    {
        return $this->belongsToMany('App\Games');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    public function scores() {
        return $this->hasMany('App\Score');
    }
}
