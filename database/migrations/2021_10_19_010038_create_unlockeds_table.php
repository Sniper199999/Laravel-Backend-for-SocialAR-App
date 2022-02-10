<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnlockedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unlockeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('media_id');
            $table->integer('friend_id');
            $table->tinyInteger('media_unlocked');
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
        Schema::dropIfExists('unlockeds');
    }
}
