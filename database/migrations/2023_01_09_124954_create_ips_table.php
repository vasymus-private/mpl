<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ips', function (Blueprint $table) {
            $table->string('ip')->primary();
            $table->string('country_a2')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_img')->nullable();
            $table->string('city')->nullable();
            $table->text('meta')->nullable()->default(json_encode([]));
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ips');
    }
};
