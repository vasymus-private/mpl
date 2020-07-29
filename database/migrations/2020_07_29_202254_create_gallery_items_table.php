<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique()->nullable();
            $table->text("description")->nullable();
            $table->unsignedBigInteger("ordering")->nullable();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->foreign('parent_id', 'gallery_items_parent_id_gallery_items_id')->references('id')->on('gallery_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery_items');
    }
}
