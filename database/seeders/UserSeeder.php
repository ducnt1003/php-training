<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        User::create([
            'name' => 'SuperAdmin',
            'email' =>'SuperAdmin@sample.com',
            'password' => bcrypt('123123'),
            'role_id' => '1'
        ]);
        User::create([
            'name' => 'Admin',
            'email' =>'Admin@sample.com',
            'password' => bcrypt('123123'),
            'role_id' => '2'
        ]);
        User::create([
            'name' => 'User',
            'email' =>'User@sample.com',
            'password' => bcrypt('123123'),
            'role_id' => '3'
        ]);
    }
}
