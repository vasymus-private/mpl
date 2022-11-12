<?php

namespace Database\Seeders;

use Domain\Common\Models\Currency;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Product\Product;

class SpecialProductsTableSeeder extends BaseSeeder
{
    protected const PRICE = 1000;
    protected const CURRENCY_ID = Currency::ID_RUB;
    protected const NAME = 'Доставка';
    protected const ORDERING = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedDeliveryProduct();
    }

    public function seedDeliveryProduct()
    {
        $delivery = Product::query()->where(sprintf('%s.uuid', Product::TABLE), Product::DELIVERY_PRODUCT_UUID)->first();
        if (! $delivery) {
            $delivery = new Product();
        }

        $delivery->uuid = Product::DELIVERY_PRODUCT_UUID;
        $delivery->name = static::NAME;

        $delivery->price_retail = static::PRICE;
        $delivery->price_retail_currency_id = static::CURRENCY_ID;

        $delivery->price_purchase = static::PRICE;
        $delivery->price_purchase_currency_id = static::CURRENCY_ID;

        $delivery->is_public_viewable = false;
        $delivery->is_active = true;
        $delivery->is_with_variations = false;
        $delivery->availability_status_id = AvailabilityStatus::ID_AVAILABLE_IN_STOCK;
        $delivery->ordering = static::ORDERING;

        $delivery->save();
    }
}
