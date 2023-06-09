<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    protected function getJwtToken(): string
    {
        $body = [
            'email' => 'teste@teste.com',
            'password' => '123456'
        ];

        $response = $this->postJson('/api/auth/login', $body);

        return $response['access_token'];
    }

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
}
