<?php

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()->comment("Product variations slug could be nullable");
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable()->comment("Product variations category_id could be nullable");
            $table->unsignedBigInteger('ordering')->nullable()->default(Product::DEFAULT_ORDERING);
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->double('coefficient')->nullable();
            $table->string('coefficient_description')->nullable();
            $table->boolean('coefficient_description_show')->default(false);
            $table->string('price_name')->default('Цена');
            $table->text('admin_comment')->nullable();
            $table->double('price_purchase')->nullable();
            $table->integer('price_purchase_currency_id')->nullable();
            $table->string('unit')->nullable();
            $table->double('price_retail')->nullable();
            $table->integer('price_retail_currency_id')->nullable();
            $table->unsignedBigInteger('availability_status_id')->default(Product::DEFAULT_AVAILABILITY_STATUS_ID);
            $table->text('preview')->nullable();
            $table->text('description')->nullable();
            $table->string('ch_desc_trade_mark')->nullable();
            $table->string('ch_desc_country_name')->nullable();
            $table->string('ch_desc_unit')->nullable();
            $table->string('ch_desc_packing')->nullable();
            $table->string('ch_desc_light_reflection')->nullable();
            $table->string('ch_desc_material_consumption')->nullable();
            $table->string('ch_desc_apply_instrument')->nullable();
            $table->string('ch_desc_placement_temperature_moisture')->nullable();
            $table->string('ch_desc_drying_time')->nullable();
            $table->string('ch_desc_special_characteristics')->nullable();
            $table->unsignedTinyInteger('ch_compatibility_wood_usual_rate')->nullable();
            $table->unsignedTinyInteger('ch_compatibility_wood_exotic_rate')->nullable();
            $table->unsignedTinyInteger('ch_compatibility_wood_cork_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_parquet_piece_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_parquet_massive_board_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_parquet_board_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_parquet_art_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_parquet_laminate_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_placement_living_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_placement_office_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_placement_restaurant_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_placement_child_and_medical_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_placement_gym_rate')->nullable();
            $table->unsignedTinyInteger('ch_suitability_placement_industrial_zone_rate')->nullable();
            $table->unsignedTinyInteger('ch_exploitation_abrasion_resistance_rate')->nullable();
            $table->unsignedTinyInteger('ch_exploitation_surface_firmness_rate')->nullable();
            $table->unsignedTinyInteger('ch_exploitation_elasticity_rate')->nullable();
            $table->unsignedTinyInteger('ch_exploitation_sustain_uv_rays_rate')->nullable();
            $table->unsignedTinyInteger('ch_exploitation_sustain_chemicals_rate')->nullable();
            $table->string('ch_exploitation_after_apply_wood_color')->nullable();
            $table->string('ch_exploitation_env_friendliness')->nullable();
            $table->string('ch_storage_term')->nullable();
            $table->string('ch_storage_conditions')->nullable();

            $table->string("accessory_name")->default(Product::DEFAULT_ACCESSORY_NAME);
            $table->string("similar_name")->default(Product::DEFAULT_SIMILAR_NAME);
            $table->string("related_name")->default(Product::DEFAULT_RELATED_NAME);
            $table->string("work_name")->default(Product::DEFAULT_WORK_NAME);

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger("_old_id")->nullable()->comment("Temporary for transfering data from old database");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
