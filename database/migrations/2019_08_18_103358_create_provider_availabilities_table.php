<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //         id int [pk]
        //          provider_id int [ref: > providers.id]
        //          weekday int
        //          start_datetime datetime
        //          end_datetime datetime
        Schema::create('provider_availabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->unsigned();
            $table->integer('weekday');
            $table->timestamp('start_datetime')->nullable();
            $table->timestamp('end_datetime')->nullable();
        });

        Schema::table('provider_availabilities', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_availabilities');
    }
}
