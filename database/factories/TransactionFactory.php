<?php

namespace Database\Factories;

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
            'transaction_code' => Str::random(16),
            'sales_name'       => $this->faker->name(),
            'start_date'       => $this->faker->dateTimeBetween('-3 months', '-2 days'),

        ];
    }
}
