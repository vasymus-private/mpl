<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        dump(DB::connection()->getPdo(), DB::connection()->getConfig());
        $this->assertTrue(true);
    }
}
