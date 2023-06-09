<?php 

namespace Tests\Helpers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Http\Kernel;

 class TestHelper{
    public static function getJwtToken()
    {
        $body = [
            'email' => 'teste@teste.com',
            'password' => '123456'
        ];

        $response = app()->make(Kernel::class)->handle(Request::create('/api/auth/login', 'POST', $body));

        $content = $response->getContent();
        $data = json_decode($content, true);

        return $data['access_token'];
    }
}

