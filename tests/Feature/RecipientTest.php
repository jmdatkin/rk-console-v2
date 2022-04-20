<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipientTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function can_create_new_recipient() {
        $response = $this->post('/recipients/store', [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@hotmail.com',
            'phoneHome' => '718-555-5555',
            'phoneCell' => '917-777-7777',
            'numMeals' => 23,
            'notes' => 'Hi'
        ]);
    }
}