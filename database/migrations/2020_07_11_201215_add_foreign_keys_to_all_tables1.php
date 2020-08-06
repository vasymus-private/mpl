<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAllTables1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_product', function (Blueprint $table) {
            $table->foreign('product_1_id', 'product_product_product_1_id_products_id')->references('id')->on('products');
            $table->foreign('product_2_id', 'product_product_product_2_id_products_id')->references('id')->on('products');
        });

        Schema::table('product_user', function (Blueprint $table) {
            $table->foreign('product_id', 'product_user_product_id_products_id')->references('id')->on('products');
            $table->foreign('user_id', 'product_user_user_id_users_id')->references('id')->on('users');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id', 'products_category_id_categories_id')->references('id')->on('categories');
            $table->foreign('parent_id', 'products_parent_id_products_id')->references('id')->on('products');
            $table->foreign('brand_id', 'products_brand_id_brands_id')->references('id')->on('brands');
            $table->foreign("availability_status_id", "prs_av_status_id_av_statuses_id")->references("id")->on("availability_statuses");
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id', 'categories_parent_id_categories_id')->references('id')->on('categories');
        });

        Schema::table('order_product', function (Blueprint $table) {
            $table->foreign('order_id', 'order_product_order_id_orders_id')->references('id')->on('orders');
            $table->foreign('product_id', 'order_product_product_id_products_id')->references('id')->on('products');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id', 'orders_user_id_users_id')->references('id')->on('users');
            $table->foreign('manager_id', 'orders_manager_id_users_id')->references('id')->on('users');
            $table->foreign('importance_id', 'orders_importance_id_order_importances_id')->references('id')->on('order_importances');
            $table->foreign('customer_bill_status_id', 'orders_customer_bill_status_id_bill_statuses_id')->references('id')->on('bill_statuses');
            $table->foreign('provider_bill_status_id', 'orders_provider_bill_status_id_bill_statuses_id')->references('id')->on('bill_statuses');
            $table->foreign('order_status_id', 'orders_order_status_id_order_statuses_id')->references('id')->on('order_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_product', function (Blueprint $table) {
            $table->dropForeign('product_product_product_1_id_products_id');
            $table->dropForeign('product_product_product_2_id_products_id');
        });

        Schema::table('product_user', function (Blueprint $table) {
            $table->dropForeign('product_user_product_id_products_id');
            $table->dropForeign('product_user_user_id_users_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_category_id_categories_id');
            $table->dropForeign('products_parent_id_products_id');
            $table->dropForeign('products_brand_id_brands_id');
            $table->dropForeign("prs_av_status_id_av_statuses_id");
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('categories_parent_id_categories_id');
        });

        Schema::table('order_product', function (Blueprint $table) {
            $table->dropForeign('order_product_order_id_orders_id');
            $table->dropForeign('order_product_product_id_products_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_user_id_users_id');
            $table->dropForeign('orders_manager_id_users_id');
            $table->dropForeign('orders_importance_id_order_importances_id');
            $table->dropForeign('orders_customer_bill_status_id_bill_statuses_id');
            $table->dropForeign('orders_provider_bill_status_id_bill_statuses_id');
            $table->dropForeign('orders_order_status_id_order_statuses_id');
        });
    }
}
