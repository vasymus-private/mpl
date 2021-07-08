<?php

namespace Database\Seeders;

use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Orders\Models\Pivots\OrderProduct;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::query()->truncate();
        OrderProduct::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $seeds = $this->getSeeds();

        foreach ($seeds as $seed) {
            $orderSeed = collect($seed)->except(['orderProductsSeeds'])->all();
            $orderProductsSeeds = $seed['orderProductsSeeds'];

            Order::query()->insert($orderSeed);
            OrderProduct::query()->insert($orderProductsSeeds);
        }
    }

    /**
     * @return array[]
     */
    protected function getSeeds(): array
    {
        $seeds = [];
        $faker = Factory::create();
        $orderStatusesIds = OrderStatus::query()->pluck('id')->toArray();
        $adminIds = [Admin::ID_CENTRAL_ADMIN, Admin::ID_HELEN_ADMIN, Admin::ID_NASTYA_ADMIN];
        $importanceIds = OrderImportance::query()->pluck('id')->toArray();
        $billStatusesIds = BillStatus::query()->pluck('id')->toArray();
        $paymentMethodsIds = PaymentMethod::query()->pluck('id')->toArray();

        $products1 = Product::query()->doesntHaveVariations()->get()->all();
        $products2 = Product::query()->variations()->get()->all();
        $products = array_merge($products1, $products2);

        foreach (range(1, 50) as $id) {
            $orderProductsSeeds = [];

            $createdAt = $faker->dateTimeBetween('-1 weeks', 'now');
            $updatedAt = clone $createdAt;
            $updatedAt->add(new \DateInterval('PT20M'));

            $seedItem = [
                'id' => $id,
                'order_status_id' => Arr::random($orderStatusesIds),
                'user_id' => UsersAndAdminsTableSeeder::TEST_USER_ID,
                'admin_id' => Arr::random($adminIds),
                'importance_id' => Arr::random($importanceIds),
                'customer_bill_status_id' => Arr::random($billStatusesIds),
                'comment_user' => $faker->address,
                'comment_admin' => $faker->title,
                'payment_method_id' => Arr::random($paymentMethodsIds),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];

            foreach (range(1, rand(2, 3)) as $item) {
                /** @var \Domain\Products\Models\Product\Product $product */
                $product = Arr::random($products);

                $orderProductsSeeds[] = [
                    'order_id' => $id,
                    'product_id' => $product->id,
                    'count' => rand(1, 5),
                    'price_purchase' => $product->price_purchase ?? 0.0,
                    'price_purchase_currency_id' => $product->price_purchase_currency_id,
                    'price_retail' => $product->price_retail ?? 0.0,
                    'price_retail_currency_id' => $product->price_retail_currency_id,
                ];
            }
            $seedItem['orderProductsSeeds'] = $orderProductsSeeds;
            $seeds[] = $seedItem;
        }

        return $seeds;
    }
}
