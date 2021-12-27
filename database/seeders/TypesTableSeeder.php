<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tour_types')->insert([
            ['name' => 'City-Break', 'status' => 1],
            ['name' => 'Wildlife', 'status' => 1],
            ['name' => 'Cultural', 'status' => 1],
            ['name' => 'Ecotourism', 'status' => 1],
            ['name' => 'Sun and Beaches', 'status' => 1],
        ]);
    }
}
