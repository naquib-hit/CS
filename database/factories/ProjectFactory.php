<?php

namespace Database\Factories;

use App\Models\{ Customer, User };
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
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
            'project_name' => $this->faker->unique->word(),
            'customer_id'  => $this->faker->randomElement(Customer::cursor()->pluck('id')->toArray()),
            'created_by'   => User::find(1)->fullname
        ];
    }
}
