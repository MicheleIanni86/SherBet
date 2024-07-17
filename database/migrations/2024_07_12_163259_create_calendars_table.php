<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->char('season', 4);
            $table->unsignedInteger('match_id')->unique();
            $table->dateTime('match_date');
            $table->char('match_status', 5);
            $table->unsignedTinyInteger('match_elapsed')->nullable();
            $table->char('round', 2);
            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('away_team_id');
            $table->unsignedTinyInteger('home_goals')->nullable();
            $table->unsignedTinyInteger('away_goals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
};
