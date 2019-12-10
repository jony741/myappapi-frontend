<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id int [ref: - users.id]
        // occ_id int [ref: > occasions.id]
        // title varchar
        // full_name varchar
        // description varchar
        // phone_number varchar
        // thumbnail longtext
        // header longtext
        // capacity int
        // location_id int [ref: - locations.id]
        // accepted bool
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('cat_id')->unsigned();
            $table->string('title');
            $table->string('full_name');
            $table->longtext('description')->nullable();
            $table->string('phone_number');
            $table->longtext('thumbnail');
            $table->longtext('header');
            // $table->bigInteger('location_id')->unsigned();
            // $table->integer('providers_availability_id');
            $table->boolean('accepted');
            $table->timestamps();
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
