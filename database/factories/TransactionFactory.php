<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\{Sales, Product, Customer};
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'transaction_code'  => Str::random(16),
            'sales_id'          => Sales::factory(),
            'start_date'        => $this->faker->dateTimeBetween('-3 months', '-2 days'),
            'expiration_date'   => $this->faker->dateTimeBetween('now', '+1 months'),
            'customer_id'       => Customer::factory(),
            'product_id'        => Product::factory()
        ];
    }
}
