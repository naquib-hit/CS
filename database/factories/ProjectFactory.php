<?php

namespace Database\Factories;

use App\Models\Project;
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
            'customer_id'  => $this->faker->randomElement(Project::cursor()->get()->pluck('id'))
        ];
    }
}
