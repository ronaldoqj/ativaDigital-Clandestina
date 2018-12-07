<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casas', function (Blueprint $table) {
            $table->increments('id');

            $table->char('ativo', 1)->default('S');
            $table->integer('order')->nullable();
            $table->integer('order_home')->nullable();
            $table->char('home', 1)->default('N');
            $table->char('banner', 1)->default('N');
            $table->string('name', 240);
            $table->string('sub_title', 240)->nullable();
            // $table->integer('categorias')->nullable();
            $table->text('diashorarios')->nullable();
            $table->text('diashorarios2')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('endereco', 240)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('cidade', 240)->nullable();
            $table->char('uf', 2)->nullable();
            $table->text('localizacao')->nullable();
            $table->string('responsavel', 240)->nullable();
            $table->string('telefone_responsavel', 20)->nullable();
            $table->string('celular_responsavel', 20)->nullable();
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
        Schema::dropIfExists('casas');
    }
}
