<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Files extends Migration
{

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign('images_file_id_foreign');
        });

        Schema::drop('images');
        Schema::drop('files');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mimetype');
            $table->string('name');
            $table->string('path');
            $table->unique('path');
            $table->integer('size');
            $table->timestamps();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('width');
            $table->integer('height');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');

            $table->index('file_id');
            $table->timestamps();
        });
    }
}
