<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->increments('id');
            $table->char('ativo', 1)->default('S');
            $table->integer('order')->nullable();
            $table->integer('order_home')->nullable();
            $table->char('home', 1)->default('N');
            $table->char('banner', 1)->default('N');
            $table->string('pelicula', 20)->default('padrao');
            $table->string('name', 240);
            $table->string('sub_title', 240)->nullable();
            $table->text('texto')->nullable();
            $table->text('texto2')->nullable();
            $table->string('title_banner', 240);
            $table->integer('banner_principal')->nullable();
            $table->string('legenda_banner', 240);
            $table->integer('imagem_principal')->nullable();
            $table->string('legenda_imagem', 240);
            $table->string('facebook', 240)->nullable();
            $table->string('site', 240)->nullable();
            $table->string('twitter', 240)->nullable();
            $table->string('instagram', 240)->nullable();
            $table->string('whatsapp', 240)->nullable();
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
        Schema::dropIfExists('noticias');
    }
}
