<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id int [pk]
        // provider_id int [ref: > providers.id]
        // promotion_id int [ref: > promotions.id]
        // payment_method varchar
        // expirey_date datetime
        Schema::create('promo_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->unsigned();
            $table->integer('promotion_id')->unsigned();
            $table->string('payment_method');
            $table->timestamp('expirey_date');
            $table->timestamps();
        });

        Schema::table('promo_providers', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_providers');
    }
}
