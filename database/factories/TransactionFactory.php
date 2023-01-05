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
            'invoice_no'       => $this->faker->unique()->regexify('[A-Za-z0-9]{16}'),
            'sales_name'       => $this->faker->name(),
            'start_date'       => $this->faker->dateTimeBetween('-3 months', '-2 days'),
            'expiration_date'  => $this->faker->dateTimeBetween('now', '+1 months'),
            'customer'         => $this->faker->randomElement(collect(Customer::cursor())->pluck('customer_name')),
            //'product_id'        => $this->faker->randomElement(collect(Product::cursor())->pluck('id')),
        ];
    }
}
