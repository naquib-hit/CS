<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesFactory extends Factory
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
            'sales_code'    => Str::random(8),
            'sales_name'    => $this->faker->unique()->name(),
            'sales_email'   => $this->faker->unique()->safeEmail()
        ];
    }
}
