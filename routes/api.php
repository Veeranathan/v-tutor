<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ZoomWebhookController;
use App\Services\DailyService;
use App\Http\Controllers\Admin\DailyWebhookController;

Route::get('/check', function (Request $request) {
    return "hi";
});

Route::post('/zoom/webhook', [ZoomWebhookController::class, 'handleWebhook']);
// Route::post('/zoom/webhook-usercreate', [ZoomWebhookController::class, 'handleUserCreated']);
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/daily-webhooks', [DailyWebhookController::class, 'handle']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
