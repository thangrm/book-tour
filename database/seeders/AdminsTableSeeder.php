<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => '$2y$10$uWxSHi3.B/7iMbJ0hnFnPOBKkkxA4E7sAzckZM1cITRcIsynt0jNS', // password: thangloi123
        ]);
    }
}
