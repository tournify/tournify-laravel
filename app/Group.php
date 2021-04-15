<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    public function tournament()
    {
        return $this->hasOne('App\Tournament');
    }

    public function games() {
        return $this->belongsToMany('App\Game');
    }

    public function teams() {
        return $this->belongsToMany('App\Team');
    }
}
