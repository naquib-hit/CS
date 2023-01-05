<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceProductFactory extends Factory
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
            'invoice_id'  => $this->faker->randomElement(collect(Invoice::cursor())->pluck('id')),
            'product_id'  => $this->faker->randomElement(collect(Product::cursor())->pluck('id'))
        ];
    }
}
