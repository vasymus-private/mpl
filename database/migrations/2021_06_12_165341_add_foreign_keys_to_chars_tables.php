<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCharsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('char_categories', function (Blueprint $table) {
            $table->foreign('product_id', 'char_categories_product_id_products_id')->references('id')->on('products');
        });
        Schema::table('chars', function (Blueprint $table) {
            $table->foreign('product_id', 'chars_product_id_products_id')->references('id')->on('products');
            $table->foreign('category_id', 'chars_category_id_char_categories_id')->references('id')->on('char_categories');
            $table->foreign('type_id', 'chars_type_id_chart_types_id')->references('id')->on('char_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('char_categories', function (Blueprint $table) {
            $table->dropForeign('char_categories_product_id_products_id');
        });
        Schema::table('chars', function (Blueprint $table) {
            $table->dropForeign('chars_product_id_products_id');
            $table->dropForeign('chars_category_id_char_categories_id');
            $table->dropForeign('chars_type_id_chart_types_id');
        });
    }
}
