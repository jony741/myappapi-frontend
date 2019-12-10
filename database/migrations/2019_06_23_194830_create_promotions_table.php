<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         id int [pk]
//          promotion_type varchar
//          title varchar
//          description longtext
//          price float
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('promotion_type');
            $table->string('title');
            $table->longtext('description');
            $table->float('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
