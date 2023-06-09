<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Helpers\TestHelper;

class LetterApiTest extends TestCase
{

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

    public function test_create_letter_endpoint_with_token_and_return_201_created(): void
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

        $token = TestHelper::getJwtToken();

        $headers = [
            'lang' => 'pt',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->postJson('/api/letter', $body, $headers);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id']);
    }

    public function test_multiple_language_support_on_api_response(): void
    {
        $body = [
            'title' => 'Letter #02',
            'content' => '1',
            'date_to_send' => '2099-12-12',
            'received' => 1,
            'read' => 0,
            'recipient_email' => 'johndoe@loremipsum.com',
            'user_id' => '1',
            'visibility_id' => 1
        ];

        $token = TestHelper::getJwtToken();

        $headersPt = [
            'lang' => 'pt',
            'Authorization' => 'Bearer ' . $token
        ];

        $headersEn = [
            'lang' => 'en',
            'Authorization' => 'Bearer ' . $token
        ];

        $responsePt = $this->postJson('/api/letter', $body, $headersPt);
        $responsePt->assertStatus(422);
        $responsePt->assertJson([
            'message' => 'O campo content precisa conter pelo menos 100 caracteres.'
        ]);

        $responseEn = $this->postJson('/api/letter', $body, $headersEn);
        $responseEn->assertStatus(422);
        $responseEn->assertJson([
            'message' => 'The content field must be at least 100 characters.'
        ]);
    }

}
