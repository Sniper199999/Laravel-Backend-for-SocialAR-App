<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('caption');
            $table->string('image_path');
            $table->integer('width');
            $table->integer('height');
            $table->point('position')->nullable();
            $table->string('anchor_id')->nullable();
            $table->string('anchor_name')->nullable();
            $table->smallInteger('compass_direction');
            $table->integer('total_comments');
            $table->integer('total_likes');
            $table->string('ref_img')->nullable();
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
        Schema::dropIfExists('media');
    }
}
