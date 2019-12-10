<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id int [pk]
        // title varchar
        // occ_id int [ref: > occasions.id]
        // budget bigint
        // planner_option int [ref: > planner_option.id]
        // event_start datetime
        // event_end datetime
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('occ_id')->unsigned();
            $table->bigInteger('budget');
            $table->integer('planner_option_id')->unsigned();
            $table->timestamp('event_start')->nullable();
            $table->timestamp('event_end')->nullable();
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('occ_id')->references('id')->on('occasions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('planner_option_id')->references('id')->on('planner_options')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
