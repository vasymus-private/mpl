<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->text("description")->nullable();
            $table->unsignedBigInteger("ordering")->nullable();
            $table->unsignedBigInteger("group_id");
            $table->boolean("is_active")->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('group_id', 'services_groups_group_id_services_groups_id')->references('id')->on('services_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
