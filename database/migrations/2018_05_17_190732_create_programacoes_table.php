<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacoes', function (Blueprint $table) {
            $table->increments('id');

            $table->char('ativo', 1)->default('S');
            $table->integer('order')->nullable();
            $table->integer('order_home')->nullable();
            $table->char('home', 1)->default('N');
            $table->char('banner', 1)->default('N');
            $table->string('name', 240);
            $table->string('sub_title', 240)->nullable();
            // $table->integer('categorias')->nullable();
            $table->text('data')->nullable();
            $table->text('horario')->nullable();
            $table->integer('local')->nullable();
            $table->text('texto_evento')->nullable();
            $table->text('servico')->nullable();
            $table->text('ingressos')->nullable();
            $table->string('link_ingresso', 240)->nullable();
            $table->string('title_banner', 240);
            $table->integer('banner_principal')->nullable();
            $table->string('legenda_banner', 240);
            $table->integer('imagem_principal')->nullable();
            $table->string('legenda_imagem', 240);
            $table->timestamp('data_inicial')->nullable();
            $table->timestamp('data_final')->nullable();

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
        Schema::dropIfExists('programacoes');
    }
}
