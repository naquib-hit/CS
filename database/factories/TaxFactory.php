<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
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
            'tax_name' => $this->faker->unique()->word(),
            'tax_amount' => $this->faker->numberBetween(1, 20)
        ];
    }
}