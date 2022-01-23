<?php

namespace Database\Seeders;

class DatabaseTestingSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeoTableSeeder::class);
        $this->call(UsersAndAdminsTableSeeder::class);
        $this->call(AvailabilityStatusesTableSeeder::class);
        $this->call(BillStatusesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(OrderImportancesTableSeeder::class);
        $this->call(OrderStatusesTableSeeder::class);
        $this->call(CharTypesTableSeeder::class);
    }
}
