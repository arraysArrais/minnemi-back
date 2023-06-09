<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LetterApiTest extends TestCase
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

    public function test_create_letter_endpoint_with_no_token_and_return_401_unauthorized(): void
    {
        $body = [
            'title' => 'Letter #02',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante',
            'date_to_send' => '2099-12-12',
            'received' => 1,
            'read' => 0,
            'recipient_email' => 'johndoe@loremipsum.com',
            'user_id' => '1',
            'visibility_id' => 1
        ];

        $headers = [
            'lang' => 'pt'
        ];

        $response = $this->postJson('/api/letter', $body, $headers);

        $response->assertStatus(401);
    }
}
