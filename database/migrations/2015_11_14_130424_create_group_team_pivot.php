<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTeamPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('groups_teams');
        Schema::create('group_team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('group_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_team');
        Schema::create('groups_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('group_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
