<?php

use Domain\Orders\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelledAndCancelledDescriptionAndCancelledDateColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('cancelled')->default(Order::DEFAULT_CANCELLED);
            $table->string('cancelled_description')->nullable();
            $table->timestamp('cancelled_date')->nullable();
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
            $table->dropColumn(['cancelled', 'cancelled_description', 'cancelled_date']);
        });
    }
}
