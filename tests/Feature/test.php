<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class test extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/api/car/add',[
            'name' => 'd',
            'maker' => 'd',
            'country' => 'd',
            'model' => '3'
        ]);

        $response->assertStatus(200);
    }
}
