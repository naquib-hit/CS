<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductUnitFactory extends Factory
{

    protected $_units = [
        ''
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            //
            'unit_name' => $this->faker->unique()->randomElements()
        ];
    }
}
