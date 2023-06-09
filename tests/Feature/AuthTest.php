<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\helpers\TestHelper;
use Tests\TestCase;

class AuthTest extends TestCase
{   
    protected $seed = true;
    use RefreshDatabase;
    public function testLogin_endpoint_with_seeder_credentials()
    {

        $body = [
            'email' => 'teste@teste.com',
            'password' => '123456'
        ];

        $response = $this->postJson('/api/auth/login', $body);

        $response->assertStatus(200)->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function testLogout_endpoint(){

        $token = TestHelper::getJwtToken();

        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->postJson('api/auth/logout', [], $headers);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully logged out'
        ]);
    }
}
