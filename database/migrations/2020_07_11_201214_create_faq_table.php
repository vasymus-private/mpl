<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("slug")->unique()->nullable();
            $table->text("question");
            $table->text("answer")->nullable();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->boolean("is_active")->default(0);
            $table->string("user_email")->nullable();
            $table->string("user_name")->nullable();
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
        Schema::dropIfExists('faq');
    }
}
