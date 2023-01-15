<?php

namespace Tests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
//use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $baseUrl = 'http://localhost:8000';

    /**
     * @param mixed $baseUrl
     */
    public function __construct($baseUrl) {
    	$this->baseUrl = $baseUrl;
    }
}
