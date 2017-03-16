<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTournamentsGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('tournaments_groups');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('tournaments_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('tournament_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
