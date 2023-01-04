<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $_units = [
           'Pieces',
           'Devices',
           'Month',
           'Day',
           'Week'
        ];   
        return [
            //
            'unit_name' => $this->faker->unique()->randomElement($_units)
        ];
    }
}
