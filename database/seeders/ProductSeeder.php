<?php

namespace Database\Seeders;

use App\Models\Product as Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::factory()->count(2)->create();
    }
}
