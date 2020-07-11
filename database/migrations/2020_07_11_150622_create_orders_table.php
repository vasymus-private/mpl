<?php

use App\Models\BillStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->double('price_retail');
            $table->unsignedBigInteger('order_status_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('importance_id')->nullable();
            $table->unsignedBigInteger('customer_bill_status_id')->default(BillStatus::DEFAULT_ID);
            $table->text('customer_bill_description')->nullable();
            $table->unsignedBigInteger('provider_bill_status_id')->default(BillStatus::DEFAULT_ID);
            $table->text('provider_bill_description')->nullable();
            $table->text('comment_user')->nullable();
            $table->text('comment_manager')->nullable();
            $table->string('ps_status')->nullable();
            $table->text('ps_description')->nullable();
            $table->double('ps_amount')->nullable();
            $table->timestamp('ps_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
