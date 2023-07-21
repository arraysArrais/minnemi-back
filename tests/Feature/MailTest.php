<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailTest extends TestCase
{

    protected $seed = true;
    use RefreshDatabase;
    public function request_to_sendmail_endpoint_should_return_valid_response(): void
    {
        $body = [
            'email' => env('USER_MAIL'),
            'password' => env('USER_PASSWORD')
        ];

        $response = $this->postJson('/api/auth/login', $body);

        $mailApiResponse = $this->postJson('/api/sendMail', [], ['Authorization'=> 'Bearer '.$response['access_token']]);
        $data = $mailApiResponse->json();
        
        $this->assertArrayHasKey('sent to:', $data);
    }
}
