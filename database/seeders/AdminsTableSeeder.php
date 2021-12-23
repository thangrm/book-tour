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
            'password' => '$2y$10$wGMS4RHD/NON/p.KQerk.Os6bO6qYEHfZui1vG2yihieKrCpfuUGG', // password: ngaodu123
        ]);
    }
}
