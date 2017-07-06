<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongPlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_playlists', function (Blueprint $table) {
            $table->integer('sp_id');
            $table->timestamps();
            $table->string('sp_name');
            $table->integer('u_id');
            $table->integer('f_id');
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
        Schema::dropIfExists('song_playlists');
    }
}
