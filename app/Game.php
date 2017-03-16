<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cocur\Slugify\Slugify;
use Faker\Factory as Faker;

class Game extends Model
{

    protected $table = 'games';

    protected $fillable = array('id', 'tournament_id', 'name', 'slug', 'keywords', 'description', 'type');

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
        $this->attributes['slug'] = $this->uniqueNameSlug($value);
    }

    public function tournament()
    {
        return $this->BelongsTo('App\Tournament');
    }

    public function teams() {

        return $this->belongsToMany('App\Team');
    }

    public function scores() {
        return $this->hasMany('App\Score');
    }

    private function uniqueNameSlug($name)
    {
        $slug = Slugify::create();
        $res = $slug->slugify($name);
        $tour = Game::where('slug', $res)->first();
        if (is_null($tour)) {
            return $res;
        }
        $faker = Faker::create();
        $res2 = $name."-".$faker->numberBetween();
        return $this->uniqueNameSlug($res2);
    }
}
