<?php

namespace Database\Seeders;

use Domain\Users\Models\Admin;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersAndAdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BaseUser::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Admin::query()->forceCreate([
            'id' => Admin::ID_CENTRAL_ADMIN,
            'name' => 'Саша',
            'email' => 'test@test.test',
            'password' => Hash::make('secret'),
            'status' => Admin::SUPER_ADMIN,
        ]);

        Admin::query()->forceCreate([
            'id' => Admin::ID_HELEN_ADMIN,
            'name' => 'Лена',
            'email' => 'lena@test.test',
            'password' => Hash::make('secret'),
            'status' => Admin::ADMIN_THRESHOLD,
        ]);

        Admin::query()->forceCreate([
            'id' => Admin::ID_NASTYA_ADMIN,
            'name' => 'Настя',
            'email' => 'nastya@test.test',
            'password' => Hash::make('secret'),
            'status' => Admin::ADMIN_THRESHOLD,
        ]);
    }
}
