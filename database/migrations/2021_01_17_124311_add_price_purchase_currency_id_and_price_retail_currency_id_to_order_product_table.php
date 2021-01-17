<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricePurchaseCurrencyIdAndPriceRetailCurrencyIdToOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->unsignedBigInteger('price_purchase_currency_id')->nullable();
            $table->unsignedBigInteger('price_retail_currency_id')->nullable();

            $table->foreign('price_purchase_currency_id')->references('id')->on('currencies');
            $table->foreign('price_retail_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropForeign(["price_purchase_currency_id"]);
            $table->dropForeign(["price_retail_currency_id"]);
            $table->dropColumn(["price_purchase_currency_id", "price_retail_currency_id"]);
        });
    }
}
