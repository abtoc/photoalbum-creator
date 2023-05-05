<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;

class UploadTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = \App\Models\User::find(1);
        $this->actingAs($user);

        $response = $this->get('/api-token');
        $token = $response->original['api_token'];

        $response = $this->post('/api/photos/upload', [
            'Authorization' => 'Bearer '.$token, 
        ]);
        var_dump($response);

        $response->assertStatus(201);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
