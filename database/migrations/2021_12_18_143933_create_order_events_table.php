<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\H;

class CreateOrderEventsTable extends Migration
{
    protected static string $table = 'order_events';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::$table, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedTinyInteger('type')->index();
            $table->json('payload')->default(json_encode([]));
            $table->timestamp('created_at')->nullable();
        });

        Schema::table(static::$table, function(Blueprint $table) {
            $table->foreign('order_id', H::foreignIndexName(static::$table, 'order_id', 'orders', 'id'))->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::$table);
    }
}
