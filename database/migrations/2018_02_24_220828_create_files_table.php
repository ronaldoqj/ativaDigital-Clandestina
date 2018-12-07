<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');

            $table->string('path', 100)->nullable();
            $table->string('name', 140)->nullable();
            $table->string('namefile', 140)->nullable();
            $table->string('namefilefull', 240)->nullable();
            $table->string('description', 240)->nullable();
            $table->string('mimetype', 100)->nullable();
            $table->string('extension', 6)->nullable();
            $table->string('size', 240)->nullable();
            $table->string('paththumb', 100)->nullable();
            $table->string('namefilethumb', 140)->nullable();
            $table->string('namefilefullthumb', 240)->nullable();
            $table->string('mimetypethumb', 100)->nullable();
            $table->string('extensionthumb', 6)->nullable();
            $table->string('sizethumb', 240)->nullable();
            $table->string('alternative_text', 140)->nullable();


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
        Schema::dropIfExists('files');
    }
}
