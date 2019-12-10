<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameOccIdFromProviderOccs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_occs', function (Blueprint $table) {
            $table->dropForeign('provider_occs_occ_id_foreign');
            $table->renameColumn('occ_id', 'occasion_id');

            $table->foreign('occasion_id')->references('id')->on('occasions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_occs', function (Blueprint $table) {
            $table->dropForeign('provider_occs_occasion_id_foreign');
            $table->renameColumn('occasion_id', 'occ_id');

            $table->foreign('occ_id')->references('id')->on('occasions')->onDelete('cascade');
        });
    }
}
