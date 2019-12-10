<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifiedConfirmationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confirmations', function (Blueprint $table) {
            $table->string('batch_id',36)->index();
            $table->integer('user_id')->index()->nullable();
            $table->string('name')->comment('Operation Name');
            $table->string('actionable_type')->nullable();
            $table->integer('actionable_id')->nullable();
            $table->string('target_type')->nullable();
            $table->integer('target_id')->nullable();
            $table->string('model_type')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('fields')->nullable();
            $table->string('status')->nullable();
            $table->text('exception')->nullable();
            $table->json('original')->nullable();
            $table->json('changes')->nullable();
            $table->dropColumn('resource_id');
            $table->dropColumn('type');
            $table->dropColumn('data');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirmation', function (Blueprint $table) {
            //
        });
    }
}
