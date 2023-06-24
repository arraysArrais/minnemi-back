<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\TestHelper;
use Tests\TestCase;

class DraftApiTest extends TestCase
{
    protected $seed = true;
    use RefreshDatabase;
    public function test_create_draft_endpoint_with_no_token_and_return_401_unauthorized(): void
    {
        $body = [
            'title' => 'Letter #02',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante',
            'user_id' => '1',
        ];

        $headers = [
            'lang' => 'pt'
        ];

        $response = $this->postJson('/api/draft', $body, $headers);

        $response->assertStatus(401);
    }

    public function test_create_draft_endpoint_with_token_and_return_201_created(): void
    {
        $body = [
            'title' => 'Letter #02',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante',
            'user_id' => '1',
        ];

        $token = TestHelper::getJwtToken();

        $headers = [
            'lang' => 'pt',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->postJson('/api/draft', $body, $headers);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id']);
    }

    public function test_multiple_language_support_on_api_response(): void
    {
        $body = [
            'title' => 'Letter #02',
            'content' => 'ab',
            'user_id' => '1',
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

        $responsePt = $this->postJson('/api/draft', $body, $headersPt);
        $responsePt->assertStatus(422);
        $responsePt->assertJson([
            'message' => 'O campo content precisa conter pelo menos 3 caracteres.'
        ]);

        $responseEn = $this->postJson('/api/draft', $body, $headersEn);
        $responseEn->assertStatus(422);
        $responseEn->assertJson([
            'message' => 'The content field must be at least 3 characters.'
        ]);
    }
}
