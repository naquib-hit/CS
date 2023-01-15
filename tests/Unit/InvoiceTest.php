<?php

namespace Tests\Unit;

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
        // $this->visit(route('invoices.create'))
        //     ->type('INV-0011', 'invoic_no')
        //     ->type('CV Ardianto Hasanah', 'invoice_customer_text')
        //     ->type('8', 'invoice_customer')
        //     ->type('2023-01-14', 'invoice_date')
        //     ->type('2023-01-31', 'invoice_due')
        //     ->type('', 'invoice_discount')
        //     ->select('percent', 'tax_type')
        //     ->type('woowtime', 'invoice_items[0][name]')
        //     ->type('2', 'invoice_items[0][value]')
        //     ->type('1', 'invoice_items[0][total]')
        //     ->type('aliquam', 'invoice_tax[0][name]')
        //     ->type('2', 'invoice_tax[0][value]');

        $this->assertTrue(true);
    }
}

// _token: 
// b8vezIGJJkEB83qfsxjXOfiI7RtoC3rbaR9L1BAS
// invoice_no: 
// INV-0010
// invoice_customer_text: 
// CV Ardianto Hasanah
// invoice_customer: 
// 8
// invoice_date: 
// 2023-01-14
// invoice_due: 
// 2023-01-31
// invoice_discount: 
// tax_type: 
// percent
// invoice_items[0][name]: 
// woowtime
// invoice_items[0][value]: 
// 2
// invoice_items[0][total]: 
// 1
// invoice_tax[0][name]: 
// aliquam
// invoice_tax[0][value]: 
// 2
// invoice_notes: