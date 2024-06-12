<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'fullname' => 'admin1',
            'email' => 'admin1@gmail.com',
            'username' => 'adminusername',
            'tel' => '1234567890',
            'role' => 'admin',
            'password' => bcrypt('password')

        ]);
        DB::table('users')->insert([
            'fullname' => 'admin2',
            'email' => 'admin2@gmail.com',
            'username' => 'adminusername',
            'tel' => '1234567890',
            'role' => 'admin',
            'password' => bcrypt('password')

        ]);
        DB::table('users')->insert([
            'fullname' => 'admin3',
            'email' => 'admin3@gmail.com',
            'username' => 'adminusername',
            'tel' => '1234567890',
            'role' => 'admin',
            'password' => bcrypt('password')

        ]);
    }
}
