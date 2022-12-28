<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Http\Controllers\CustomerController;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use AdditionalAssertions;
/**
 * Test update validation
 * 
 * @return void
 */

 /** @test */
 public function check_valiation_update()
 {
    $this->assertActionUsesFormRequest(CustomerController::class, 'update', UpdateCustomerRequest::class);
 }

}


