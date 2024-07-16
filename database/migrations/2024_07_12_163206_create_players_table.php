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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('player_id');
            $table->unsignedInteger('team_id')->nullable();
            $table->foreign('team_id')->references('team_id')->on('teams')->nullOnDelete();
            $table->string('lastname');
            $table->string('photo')->nullable();
            $table->string('position');
            $table->enum('status', ['starting', 'bench', 'nc'])->nullable();
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
        Schema::dropIfExists('players');
    }
};
