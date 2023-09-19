<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFairsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fairs_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('fair_id');
            $table->unsignedBigInteger('category_id');
            $table->primary(['fair_id', 'category_id']);
            $table->foreign('fair_id')->references('id')->on('fairs');
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('fairs_categories');
    }
}
