<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'product1',
                'unit_price' => 100
            ],
            [
                'id' => 2,
                'name' => 'product2',
                'unit_price' => 200
            ]
        ]);

        DB::table('offers')->insert([
            [
                'id' => 1,
                'name' => 'offer1',
                'quantity' => 2,
                'price' => 150,
                'product_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'offer2',
                'quantity' => 3,
                'price' => 250,
                'product_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'offer3',
                'quantity' => 5,
                'price' => 420,
                'product_id' => 1
            ]
        ]);
    }
}
