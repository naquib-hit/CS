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



}