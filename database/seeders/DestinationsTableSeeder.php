<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;

class DestinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Destination::factory()->count(100)->create();
        DB::table('destinations')->insert([
            [
                'name' => 'Sapa, Laocai',
                'slug' => 'sapa-laocai',
                'image' => 'tmp/iPXjUBSJCb',
                'status' => 1
            ],
            [
                'name' => 'Hoian, Quangnam',
                'slug' => 'hoian-quangnam',
                'image' => 'tmp/jcJuIAKDNE',
                'status' => 1
            ],
            [
                'name' => 'Ba Na Hill, Danang',
                'slug' => 'ba-na-hill-danang',
                'image' => 'tmp/ERWwKKxKgH',
                'status' => 1
            ],
            [
                'name' => 'Muine, Binhthuan',
                'slug' => 'muine-binhthuan',
                'image' => 'tmp/wiSVcOWLRF',
                'status' => 1
            ],
            [
                'name' => 'Halong, Quangning',
                'slug' => 'halong-quangning',
                'image' => 'tmp/IhUukIvvAb',
                'status' => 2
            ],
        ]);
    }
}
