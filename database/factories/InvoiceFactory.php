<?php

namespace Database\Factories;

use App\Models\{ Sales, Customer };
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
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
            'invoice_no'        => $this->faker->unique->regexify('[A-Za-z0-9]{10}'),
            'sales_id'          => $this->faker->randomElement(collect(Sales::cursor())->pluck('id')),
            'start_date'        => $this->faker->dateTimeBetween('-3 months', '-2 days'),
            'expiration_date'   => $this->faker->dateTimeBetween('now', '+1 months'),
            'customer_id'       => $this->faker->randomElement(collect(Customer::cursor())->pluck('id')),
        ];
    }
}
