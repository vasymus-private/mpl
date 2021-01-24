<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User\User;
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
        User::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Admin::query()->forceCreate([
            'id' => Admin::ID_CENTRAL_ADMIN,
            'name' => 'admin',
            'email' => 'test@test.test',
            'password' => Hash::make('secret'),
            'status' => Admin::SUPER_ADMIN,
        ]);
    }
}
