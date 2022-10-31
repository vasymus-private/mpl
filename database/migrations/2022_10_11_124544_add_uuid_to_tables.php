<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('blacklist', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('chars', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('char_categories', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('faq', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('informational_prices', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('blacklist', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('chars', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('char_categories', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('faq', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('informational_prices', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
}
