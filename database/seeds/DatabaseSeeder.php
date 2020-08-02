<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearMedia::class);

        $this->call(SeoTableSeeder::class);

        $this->call(UsersAndAdminsTableSeeder::class);
        $this->call(ServicesGroupsTableSeeder::class);
        $this->call(CommonImagesAndArticlesAndServicesTablesSeeder::class);


        $this->call(BillStatusesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(ManufacturersTableSeeder::class);
        $this->call(OrderImportancesTableSeeder::class);
        $this->call(OrderStatusesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(FAQTableSeeder::class);
        $this->call(ProductsInfoPricesSeoTablesSeeder::class);
        $this->call(GalleryItemsTableSeeder::class);
    }
}
