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
            ['name' => 'Tour trọn gói', 'status' => 1],
            ['name' => 'Tour gia đình', 'status' => 1],
            ['name' => 'Tour xuyên việt', 'status' => 1],
            ['name' => 'Biển', 'status' => 1],
            ['name' => 'Thiên nhiên vùng núi', 'status' => 1],
        ]);
    }
}
