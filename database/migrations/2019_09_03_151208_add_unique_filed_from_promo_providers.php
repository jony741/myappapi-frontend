<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueFiledFromPromoProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promo_providers', function (Blueprint $table) {
            $table->unique(['promotion_id', 'provider_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promo_providers', function (Blueprint $table) {
            //tableName_fieldsSeperatedByUnderscore_unique
            $table->dropUnique('promo_providers_promotion_id_provider_id_unique');
        });
    }
}
