<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //             id int [pk]
        //              provider_id int [ref: > providers.id]
        //              client_id int [ref: > users.id]
        //              event_id int [ref: > events.id]
        //              description longtext
        //              status varchar [note: "from status Enum"]
        //              created_at timestamp
        //              updated_at timestamp
        //              status_changed_at timestamp
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->longText('description');
            $table->integer('status');
            $table->timestamp('status_changed_at')->nullable();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
