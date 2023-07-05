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
    public function test_request_to_login_endpoint_with_valid_credentials_should_return_token(){
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

    public function test_request_to_login_endpoint_with_invalid_credentials_should_return_401(){
        $body = [
            'email' => 'teste@teste.com',
            'password' => '1234567'
        ];

        $response = $this->postJson('/api/auth/login', $body);
        $response->assertStatus(401);
    }

    public function test_request_to_logout_endpoint_with_valid_token_should_return_200(){
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

    public function test_request_to_logout_endpoint_with_invalid_token_should_return_401(){

        $headers = [
            'Authorization' => 'Bearer A'
        ];

        $response = $this->postJson('api/auth/logout', [], $headers);
        $response->assertStatus(401);
    }

    public function test_request_to_register_endpoint_with_invalid_data_should_return_422(){
        $response = $this->postJson('api/auth/register', [
            "nickname" => "jpp",
            "first_name" => "joao",
            "last_name" => "mesquita",
            "email" => "test@test.com",
            "password" => "1234567"
        ]);
        $response->assertStatus(422);
    }

    public function test_request_to_register_endpoint_with_valid_data_should_return_201(){
        $response = $this->postJson('api/auth/register', [
            "nickname" => "jpp",
            "first_name" => "joao",
            "last_name" => "mesquita",
            "email" => "test@test.com",
            "password" => "12345678"
        ]);
        $response->assertStatus(201);
    }
}
