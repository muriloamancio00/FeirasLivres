<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->unsignedBigInteger('fair_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('stand_id')->nullable();
            $table->string('path');
            $table->foreign('fair_id')->references('id')->on('fairs');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('stand_id')->references('id')->on('stands');
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
        Schema::dropIfExists('photos');
    }
}
