<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSessionUuidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_session_uuids', function (Blueprint $table) {
            $table->char("session_uuid", 30);
            $table->unsignedBigInteger("user_id");
            $table->boolean("via_credentials")->default(false);
            $table->timestamps();

            $table->primary("session_uuid");
        });

        Schema::table('user_session_uuids', function (Blueprint $table) {
            $table->foreign('user_id', 'user_session_uuids_user_id_users_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_session_uuids');
    }
}
