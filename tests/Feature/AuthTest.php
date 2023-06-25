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
    public function test_request_to_login_endpoint_with_seeder_credentials_should_return_token()
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

    public function test_request_to_login_endpoint_with_wrong_credentials_should_return_401()
    {
        $body = [
            'email' => 'teste@teste.com',
            'password' => '1234567'
        ];

        $response = $this->postJson('/api/auth/login', $body);
        $response->assertStatus(401);
    }

    public function test_request_to_logout_endpoint_should_return_200(){

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
