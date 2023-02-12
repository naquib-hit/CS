<?php

namespace Tests\Unit;

use App\Models\{ Product, Invoice };
use Illuminate\Foundation\Testing\{ RefreshDatabase, WithoutMiddleware };
use Tests\TestCase;
use JMac\Testing\Traits\AdditionalAssertions;

class InvoiceTest extends TestCase
{
    use AdditionalAssertions;

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
    public function test_insert_invoice()
    {
        $params = [
                'invoice_project_text'      => 'blanditiis',
                'invoice_project'           => 1,
                'invoice_date'              => '2023-02-12',
                'invoice_due'               => '2023-02-20',
                'invoice_currency'          => 'IDR',
                'invoice_items'             => 
                [
                    [
                        'name'      => 'woowtime',
                        'value'     => 1,
                        'price'     => 700000,
                        'total'     => 3
                    ]
                ],
                'invoice_tax'               => 
                [
                    [
                        'name'  => 'PPN',
                        'value' => 1
                    ]
                ],
                'invoice_notes'             => '<p><br></p>',
                'invoice_discount'          => NULL, 
                'discount_unit'             => 'percent'
        ];

        $resp = $this->post(route('invoices.store'), $params);

        $invoice = Invoice::createInvoice($params);
        $invoice->get()->dd();
        //$resp->assertStatus(302);
    }      



}

/*

invoice_project_text=> 
blanditiis
invoice_project=> 
1
invoice_date=> 
2023-02-12
invoice_due=> 
2023-02-20
invoice_currency=> 
IDR
invoice_items[0][name]=> 
woowtime
invoice_items[0][value]=> 
1
invoice_items[0][price]=> 
700000
invoice_items[0][total]=> 
3
invoice_tax[0][name]=> 
PPN
invoice_tax[0][value]=> 
1
invoice_notes=> 
<p><br></p>
invoice_discount=> 
discount_unit=> 
percent

*/