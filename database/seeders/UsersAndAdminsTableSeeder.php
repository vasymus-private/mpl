<?php

namespace Database\Seeders;

use Domain\Users\Models\Admin;
use Domain\Users\Models\BaseUser\BaseUser;
use Domain\Users\Models\User\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersAndAdminsTableSeeder extends Seeder
{
    public const TEST_USER_ID = 10;

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

        $this->seedAdmins();
        $this->seedUsers();
    }

    protected function seedAdmins()
    {
        Admin::query()->forceCreate([
            'id' => Admin::ID_CENTRAL_ADMIN,
            'name' => 'Саша',
            'email' => 'test@test.test',
            'password' => Hash::make('secret'),
            'status' => Admin::SUPER_ADMIN,
            'admin_color' => '#ffff99',
        ]);

        Admin::query()->forceCreate([
            'id' => Admin::ID_HELEN_ADMIN,
            'name' => 'Лена',
            'email' => 'lena@test.test',
            'password' => Hash::make('secret'),
            'status' => Admin::ADMIN_THRESHOLD,
            'admin_color' => '#ffb3ff',
        ]);

        Admin::query()->forceCreate([
            'id' => Admin::ID_NASTYA_ADMIN,
            'name' => 'Настя',
            'email' => 'nastya@test.test',
            'password' => Hash::make('secret'),
            'status' => Admin::ADMIN_THRESHOLD,
            'admin_color' => '#b3ffb3',
        ]);
    }

    protected function seedUsers()
    {
        User::query()->forceCreate([
            'id' => static::TEST_USER_ID,
            'name' => 'Иванов Иван',
            'email' => 'user@test.test',
            'password' => Hash::make('secret'),
            'phone' => "777-888-999",
        ]);
    }
}
