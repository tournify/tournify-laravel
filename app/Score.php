<?php
/**
 * Created by PhpStorm.
 * User: markustenghamn
 * Date: 21/11/15
 * Time: 14:57
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $table = 'scores';

    protected $fillable = array('id', 'game_id', 'team_id', 'score');

    public function getScoreAttribute($value) {
        return $value + 0;
    }

    public function game()
    {
        return $this->hasOne('App\Game');
    }

    public function team()
    {

        return $this->BelongsTo('App\Team');
    }
}