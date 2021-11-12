<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('api/part/add',[
            'name' => 'd',
            'description' => 'sfsfs',
            'maker' => 'd',
            'country' => 'd',
            'quantity' => '1321',
            'sellingPrice' => '2343',
            'orginalPrice' => '0988',
            'category_id' => '1',
            'car_id' => '1'
        ]);

        // $response= $this->post('api/category/add' , [
        //     'name' => 'sfds' ,
        // ]);

        // $response = $this->post('api/car/add' , [
        //     'maker' => 'audi',
        //     'name' => 'r8' ,
        //     'model' => '2011',
        //     'country' => 'germany'
        // ]);
        $response->assertStatus(200);
    }
}
