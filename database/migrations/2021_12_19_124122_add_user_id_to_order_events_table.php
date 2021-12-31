<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\H;

class AddUserIdToOrderEventsTable extends Migration
{
    protected static string $table = 'order_events';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(static::$table, function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('order_id');
            $table->foreign('user_id', H::foreignIndexName(static::$table, 'user_id', 'users', 'id'))->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(static::$table, function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
