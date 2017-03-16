<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cocur\Slugify\Slugify;
use Faker\Factory as Faker;
use App\User;
use App\Comment;
use Carbon\Carbon;

class Post extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'title_en', 'content_en', 'creator', 'keywords', 'description'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['slug', 'slug_en'];

    public function setTitleAttribute($value)
    {
        $slug = Slugify::create();
        $this->attributes['title'] = strtolower($value);
        $this->attributes['slug'] = $this->uniqueTitleSlug($slug->slugify($value));
    }

    public function setTitleEnAttribute($value)
    {
        $slug = Slugify::create();
        $this->attributes['title_en'] = strtolower($value);
        $this->attributes['slug_en'] = $this->uniqueTitleSlug($slug->slugify($value));
    }

    public function getTitleAttribute($value) {
        return ucwords($value);
    }

    public function getTitleEnAttribute($value) {
        return ucwords($value);
    }


    public function comments() {

        return $this->hasMany('App\Comment');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    private function uniqueTitleSlug($name)
    {
        $slug = Slugify::create();
        $res = $slug->slugify($name);
        $tour = Post::where('slug', $res)->first();
        if (is_null($tour)) {
            return $res;
        }
        $faker = Faker::create();
        $res2 = $name."-".$faker->numberBetween();
        return $this->uniqueTitleSlug($res2);
    }
}
