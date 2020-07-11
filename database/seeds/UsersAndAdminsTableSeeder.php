<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
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
         User::query()->truncate();

         Admin::query()->forceCreate([
             'name' => 'admin',
             'email' => 'test@test.test',
             'password' => Hash::make('secret'),
             'status' => Admin::SUPER_ADMIN,
         ]);
    }
}
