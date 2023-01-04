<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductUnit as ProductUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            //'product_code'  => $this->faker->regexify('[A-Za-z0-9]{16}'),
            'product_name'      => $this->faker->unique()->randomElement(['woowtime', 'woowaccess']),
            'product_price'     => $this->faker->numberBetween('200000', '800000'),
            'product_unit_id'   => $this->faker->randomElement(collect(ProductUnit::cursor())->pluck('id'))
        ];
    }
}
