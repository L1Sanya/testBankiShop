<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Api\ParameterController;

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

Route::get('/parameters', [ParameterController::class, 'index']);
Route::post('/parameters', [ParameterController::class, 'store']);
Route::get('/parameters/{id}', [ParameterController::class, 'show']);
Route::put('/parameters/{id}', [ParameterController::class, 'update']);
Route::delete('/parameters/{id}', [ParameterController::class, 'destroy']);
Route::get('/parameters/type/2', [ParameterController::class, 'getType2Parameters']);
Route::get('/parameters/type/1', [ParameterController::class, 'getType1Parameters']);
