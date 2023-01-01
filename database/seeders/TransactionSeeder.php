<?php

namespace Database\Seeders;

use App\Models\{Sales, Product, Customer, Transaction};
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Transaction::factory()->count(100)
                        ->create();
    }
}
