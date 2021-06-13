<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('type_id')->default(1);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('ordering')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chars');
    }
}
