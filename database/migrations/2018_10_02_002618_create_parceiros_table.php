<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parceiros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->nullable();
            $table->char('ativo', 1)->default('S');
            $table->string('name', 240);
            $table->text('text')->nullable();
            $table->integer('image_logo')->nullable();
            $table->integer('image_background')->nullable();
            $table->string('site', 240)->nullable();
            $table->string('facebook', 240)->nullable();
            $table->string('instagram', 240)->nullable();
            $table->string('twitter', 240)->nullable();
            $table->string('youtube', 240)->nullable();
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
        Schema::dropIfExists('parceiros');
    }
}
