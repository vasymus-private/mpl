<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\H;

class AddBusyColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('busy_by_id')->nullable();
            $table->timestamp('busy_at')->nullable();

            $table->foreign('user_id', H::foreignIndexName('orders', 'busy_by_id', 'users', 'id'))->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(H::foreignIndexName('orders', 'busy_by_id', 'users', 'id'));
            $table->dropColumn(['busy_by_id', 'busy_at']);
        });
    }
}
