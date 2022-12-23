<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    /**
     * Test Insert Product
     * 
     * @return void
     */
    public function test_insert_product()
    {
        $random = bin2hex(random_bytes(4));

        $this->visit('products/create');
        // SUBMIT
        $this->submitForm('save', [
            'product_code'  => $random,
            'product_name'  => $valid['product_name'],
            'product_price' => $valid['product_price']
        ]);
        // CHECK DB
        $this->seeInDatabase('products', [
            'product_code'  => $random,
            'product_name'  => $valid['product_name'],
            'product_price' => $valid['product_price']
        ]);
    }
}
