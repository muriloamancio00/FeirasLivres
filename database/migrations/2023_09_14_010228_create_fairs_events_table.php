<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFairsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fairs_events', function (Blueprint $table) {
            $table->unsignedBigInteger('fair_id');
            $table->unsignedBigInteger('event_id');
            $table->date('data');
            $table->integer('status');
            $table->string('horarioInicio')->nullable();
            $table->string('horarioFim')->nullable();
            $table->primary(['fair_id', 'event_id']);
            $table->foreign('fair_id')->references('id')->on('fairs');
            $table->foreign('event_id')->references('id')->on('events');
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
        Schema::dropIfExists('fairs_events');
    }
}
