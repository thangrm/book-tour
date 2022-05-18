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
                'name' => 'Hội An, Quảng nam',
                'slug' => 'hoian-quangnam',
                'image' => 'tmp/jcJuIAKDNE',
                'status' => 1
            ],
            [
                'name' => 'Bà Nà Hill, Đà Nẵng',
                'slug' => 'ba-na-hill-danang',
                'image' => 'tmp/ERWwKKxKgH',
                'status' => 1
            ],
            [
                'name' => 'Mũi né, Bình Thuận',
                'slug' => 'muine-binhthuan',
                'image' => 'tmp/wiSVcOWLRF',
                'status' => 1
            ],
            [
                'name' => 'Hạ Long, Quảng Ning',
                'slug' => 'halong-quangning',
                'image' => 'tmp/IhUukIvvAb',
                'status' => 2
            ],
        ]);
    }
}
