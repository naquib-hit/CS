<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /** @test */    
    public function test_querying_report()
    {
        $resp = $this->get('/reports/generate?selected_by=product&periode_from=2023-02-05&periode_to=2023-02-07&file_type=pdf');
        $resp->assertStatus(302);
        $resp->dump();
    }
}
