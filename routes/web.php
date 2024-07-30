<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParameterController;

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
Route::get('/parameters', [ParameterController::class, 'index']);
Route::post('/parameters/{id}/upload-images', [ParameterController::class, 'uploadImages']);
Route::delete('/parameters/{id}/delete-image/{type}', [ParameterController::class, 'deleteImage']);

