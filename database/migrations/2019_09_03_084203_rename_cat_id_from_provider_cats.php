<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCatIdFromProviderCats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_cats', function (Blueprint $table) {
            $table->dropForeign('provider_cats_cat_id_foreign');
            $table->renameColumn('cat_id', 'category_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_cats', function (Blueprint $table) {
            $table->dropForeign('provider_cats_category_id_foreign');
            $table->renameColumn('category_id', 'cat_id');

            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
