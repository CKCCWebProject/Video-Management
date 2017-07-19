<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQNAsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_n_a_s', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('question', 2000);
            $table->string('answer', 2000);
            $table->string('category', 100);
            $table->integer('frequency');
            $table->text('keyword');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('q_n_a_s');
    }
}
