<?php

namespace Database\Seeders\TransitionSeeders;

use Database\Seeders\BaseSeeder;

class MenuEntitiesTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->isCalledOnce()) {
            return;
        }



        $this->setCalledOnce();
    }
}
