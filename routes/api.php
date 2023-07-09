<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\LetterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('verify', [AuthController::class, 'verify']);
    Route::post('revoke', [AuthController::class, 'revokeToken']);
    Route::post('decode', [AuthController::class, 'getPayload']);
    Route::post('register', [AuthController::class, 'register']);
});

//protected api routes
Route::middleware(['auth:api', SetLocale::class])->group(function () {
    Route::post('/letter', [LetterController::class, 'create']);
    Route::post('/draft', [DraftController::class, 'create']);
    Route::get('/dispatch', [LetterController::class, 'dispatch']);
});