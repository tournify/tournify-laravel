<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTeamsPlayers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('teams_players');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('teams_players', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('player_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
