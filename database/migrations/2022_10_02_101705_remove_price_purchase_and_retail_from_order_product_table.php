<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePricePurchaseAndRetailFromOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropForeign('order_product_price_purchase_currency_id_foreign');
            $table->dropForeign('order_product_price_retail_currency_id_foreign');
            $table->dropColumn(['price_purchase', 'price_purchase_currency_id', 'price_retail', 'price_retail_currency_id']);
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
            $table->unsignedBigInteger('price_purchase_currency_id')->nullable();
            $table->unsignedBigInteger('price_retail_currency_id')->nullable();
            $table->double('price_purchase');
            $table->double('price_retail');

            $table->foreign('price_purchase_currency_id')->references('id')->on('currencies');
            $table->foreign('price_retail_currency_id')->references('id')->on('currencies');
        });
    }
}
