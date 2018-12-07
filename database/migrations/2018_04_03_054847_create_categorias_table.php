<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->char('ativo', 1)->default('S');
            $table->string('color', 40)->nullable();
            $table->string('name', 140);
            $table->text('description')->nullable();
            $table->string('path', 100)->nullable();
            $table->string('namefile', 140)->nullable();
            $table->string('namefileOriginal', 140)->nullable();
            $table->string('namefilefull', 240)->nullable();
            $table->string('mimetype', 100)->nullable();
            $table->string('extension', 6)->nullable();
            $table->string('size', 240)->nullable();
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
        Schema::dropIfExists('categorias');
    }
}
