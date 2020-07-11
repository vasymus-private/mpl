<?php

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
            $table->string('slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_with_variations')->default(false);
            $table->unsignedBigInteger('category_id');
            $table->integer('ordering')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->double('coefficient')->nullable();
            $table->string('coefficient_description')->nullable();
            $table->string('price_name')->default('Цена');
            $table->text('admin_comment')->nullable();
            $table->double('price_purchase')->nullable();
            $table->integer('price_purchase_currency_id')->nullable();
            $table->string('unit')->nullable();
            $table->double('price_retail')->nullable();
            $table->integer('price_retail_currency_id')->nullable();
            $table->boolean('is_in_stock')->default(false);
            $table->boolean('is_available')->default(false);
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
            $table->tinyInteger('ch_compatibility_wood_usual_rate')->default(0);
            $table->tinyInteger('ch_compatibility_wood_exotic_rate')->default(0);
            $table->tinyInteger('ch_compatibility_wood_cork_rate')->default(0);
            $table->tinyInteger('ch_suitability_parquet_piece_rate')->nullable();
            $table->tinyInteger('ch_suitability_parquet_massive_board_rate')->default(0);
            $table->tinyInteger('ch_suitability_parquet_board_rate')->default(0);
            $table->tinyInteger('ch_suitability_parquet_art_rate')->default(0);
            $table->tinyInteger('ch_suitability_parquet_laminate_rate')->default(0);
            $table->tinyInteger('ch_suitability_placement_living_rate')->default(0);
            $table->tinyInteger('ch_suitability_placement_office_rate')->default(0);
            $table->tinyInteger('ch_suitability_placement_restaurant_rate')->default(0);
            $table->tinyInteger('ch_suitability_placement_child_and_medical_rate')->default(0);
            $table->tinyInteger('ch_suitability_placement_gym_rate')->default(0);
            $table->tinyInteger('ch_suitability_placement_industrial_zone_rate')->default(0);
            $table->tinyInteger('ch_exploitation_abrasion_resistance_rate')->default(0);
            $table->tinyInteger('ch_exploitation_surface_firmness_rate')->default(0);
            $table->tinyInteger('ch_exploitation_elasticity_rate')->default(0);
            $table->tinyInteger('ch_exploitation_sustain_uv_rays_rate')->default(0);
            $table->tinyInteger('ch_exploitation_sustain_chemicals_rate')->default(0);
            $table->string('ch_exploitation_after_apply_wood_color')->nullable();
            $table->string('ch_exploitation_env_friendliness')->nullable();
            $table->string('ch_storage_term')->nullable();
            $table->string('ch_storage_conditions')->nullable();
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
        Schema::dropIfExists('products');
    }
}
