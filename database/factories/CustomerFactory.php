<?php

namespace Database\Factories;

use App\Models\Customer as Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{

    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            //'customer_code'     => $this->faker->regexify('[A-Za-z0-9]{16}'),
            'customer_name'     => $this->faker->unique()->company(),
            'customer_address'  => $this->faker->unique()->address(),
            'customer_email'    => $this->faker->unique()->safeEmail(),
            'customer_phone'    => $this->faker->unique()->phoneNumber()
        ];
    }
}
