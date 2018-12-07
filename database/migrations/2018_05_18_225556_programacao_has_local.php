<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProgramacaoHasLocal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('programacao_has_local', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('order')->nullable();
          $table->integer('id_programacao');
          $table->integer('id_local');
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
        Schema::dropIfExists('programacao_has_local');
    }
}
