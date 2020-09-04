<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nev');
            $table->integer('auto')->unsigned();
            $table->integer('tipus')->unsigned();
            $table->integer('partner')->unsigned()->nullable();
            $table->longText('leiras')->nullable();
            $table->timestamps();

            $table->foreign('auto')->references('id')->on('cars');
            $table->foreign('tipus')->references('id')->on('doctypes');
            $table->foreign('partner')->references('id')->on('partners');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
