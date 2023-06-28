<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SwaggerTest extends TestCase
{
    public function test_request_to_swagger_swagger_ui_endpoint_should_return_200(): void
    {
        $response = $this->get('/api/doc');
        $response->assertStatus(200);
    }

    public function test_generate_openapi_json(){
        $generatedJson = $this->get('/docs/api-docs.json');
        $generatedJson->assertJson([
            'info' => [
                'title' => 'Minnemi API',
                'description' => 'Documentação das APIs para interação com a aplicação Minnemi',
            ],
            'paths' => [
                '/api/auth/login'=>[],
                '/api/auth/logout'=>[],
                '/api/draft/'=>[],
                '/api/letter/'=>[],
            ]
        ]);
    }
}
