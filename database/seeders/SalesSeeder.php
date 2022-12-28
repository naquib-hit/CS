<?php

namespace Database\Seeders;

use App\Models\Sales;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Sales::factory()->count(18)->create();
    }
}
