<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveChPrefixedColumnsInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['ch_desc_trade_mark']);
            $table->dropColumn(['ch_desc_country_name']);
            $table->dropColumn(['ch_desc_unit']);
            $table->dropColumn(['ch_desc_packing']);
            $table->dropColumn(['ch_desc_light_reflection']);
            $table->dropColumn(['ch_desc_material_consumption']);
            $table->dropColumn(['ch_desc_apply_instrument']);
            $table->dropColumn(['ch_desc_placement_temperature_moisture']);
            $table->dropColumn(['ch_desc_drying_time']);
            $table->dropColumn(['ch_desc_special_characteristics']);
            $table->dropColumn(['ch_compatibility_wood_usual_rate']);
            $table->dropColumn(['ch_compatibility_wood_exotic_rate']);
            $table->dropColumn(['ch_compatibility_wood_cork_rate']);
            $table->dropColumn(['ch_suitability_parquet_piece_rate']);
            $table->dropColumn(['ch_suitability_parquet_massive_board_rate']);
            $table->dropColumn(['ch_suitability_parquet_board_rate']);
            $table->dropColumn(['ch_suitability_parquet_art_rate']);
            $table->dropColumn(['ch_suitability_parquet_laminate_rate']);
            $table->dropColumn(['ch_suitability_placement_living_rate']);
            $table->dropColumn(['ch_suitability_placement_office_rate']);
            $table->dropColumn(['ch_suitability_placement_restaurant_rate']);
            $table->dropColumn(['ch_suitability_placement_child_and_medical_rate']);
            $table->dropColumn(['ch_suitability_placement_gym_rate']);
            $table->dropColumn(['ch_suitability_placement_industrial_zone_rate']);
            $table->dropColumn(['ch_exploitation_abrasion_resistance_rate']);
            $table->dropColumn(['ch_exploitation_surface_firmness_rate']);
            $table->dropColumn(['ch_exploitation_elasticity_rate']);
            $table->dropColumn(['ch_exploitation_sustain_uv_rays_rate']);
            $table->dropColumn(['ch_exploitation_sustain_chemicals_rate']);
            $table->dropColumn(['ch_exploitation_after_apply_wood_color']);
            $table->dropColumn(['ch_exploitation_env_friendliness']);
            $table->dropColumn(['ch_storage_term']);
            $table->dropColumn(['ch_storage_conditions']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
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
        });
    }
}
