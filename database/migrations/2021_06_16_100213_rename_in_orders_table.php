<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('comment_manager', 'comment_admin');
            $table->dropForeign('orders_manager_id_users_id');
            $table->renameColumn('manager_id', 'admin_id');
            $table->foreign('admin_id', 'orders_admin_id_users_id')->references('id')->on('users');
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
            $table->renameColumn('comment_admin', 'comment_manager');
            $table->dropForeign('orders_admin_id_users_id');
            $table->renameColumn('admin_id', 'manager_id');
            $table->foreign('manager_id', 'orders_manager_id_users_id')->references('id')->on('users');
        });
    }
}
