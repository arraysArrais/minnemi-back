<?php

use App\Http\Controllers\DraftController;
use App\Http\Controllers\LetterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::post('/letter', [LetterController::class, 'create']);
Route::post('/draft', [DraftController::class, 'create']);
Route::get('/dispatch', [LetterController::class, 'dispatch']);

Route::get('/liveness_check', function(){
    return http_response_code(200);
});

Route::get('/readiness_check', function(){
    return http_response_code(200);
});
