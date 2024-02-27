<?php

use App\Http\Controllers\Api\ApiQuestionController;
use App\Http\Controllers\Api\ApiWeightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(ApiWeightController::class)->group(function () {
    Route::get('/weights', 'index')->name('weights.index');
    Route::get('/weights/{id}', 'show')->name('weights.show');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/weights', 'store')->name('weights.store');
        Route::put('/weights/{id}', 'update')->whereNumber('id')->name('weights.update');
        Route::delete('/weights/{id}', 'destroy')->whereNumber('id')->name('weights.destroy');
    });
});

Route::controller(ApiQuestionController::class)->group(function () {
    Route::get('/questions', 'index')->name('questions.index');
    Route::get('/questions/{id}', 'show')->name('questions.show');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/questions', 'store')->name('questions.store');
        Route::put('/questions/{id}', 'update')->whereNumber('id')->name('questions.update');
        Route::delete('/questions/{id}', 'destroy')->whereNumber('id')->name('questions.destroy');
    });
});
