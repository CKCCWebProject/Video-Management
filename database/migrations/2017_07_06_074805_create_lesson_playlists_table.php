<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonPlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_playlists', function (Blueprint $table) {
            $table->increments('l_id');
            $table->timestamps();
            $table->string('l_name');
            $table->integer('u_id');
            $table->integer('f_id');
            $table->string('record');
            $table->boolean('if_public');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LessonPlaylists');
    }
}
