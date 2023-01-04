<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{ Product as Product, ProductUnit as ProductUnit };

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
        Product::factory()->count(2)
                        ->create();
    }
}
