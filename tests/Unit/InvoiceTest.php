<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use JMac\Testing\Traits\AdditionalAssertions;

class InvoiceTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function insert_invoice_test()
    {
        $this->assertActionUsesFormRequest(\App\Http\Controllers\InvoiceController::class, 'store', \App\Http\Requests\StoreInvoiceRequest::class);
    }



    /** @test */
    public function insert_invoice_and_products()
    {

        $items = [
            [
                'name'  => 'Lisensi Woowtime',
                'value' => 3,
                'total' => 10
            ],
            [
                'name'  => 'woowtime',
                'value' => 2,
                'total' => 1
            ]
        ];

        $collect = collect($items)->reduce(function ($summary, $curr) {
            [$curr['value']] = [
                'quantity'      => $curr['total'],
                'total_price'   => (\App\Models\Product::find($curr['value']))->product_price * $curr['total']
            ];
        }, []);

        print_r($collect);
        $this->assertTrue(true);
    }
}