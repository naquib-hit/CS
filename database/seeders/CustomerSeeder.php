<?php

namespace Database\Seeders;

use App\Models\Customer as Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{

    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Customer::factory()
                    ->count(12)
                    ->create();
    }
}
