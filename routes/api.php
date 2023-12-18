<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MapController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\PropertiesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('location')->group(function () {
    Route::get('/autocomplete', [MapController::class, 'autocomplete']);
    Route::get('/search', [MapController::class, 'search']);
});

Route::prefix('country')->name('country.')->group(function () {
    Route::get('/state', [CountryController::class, 'selectState'])->name('state');
    Route::get('/street', [CountryController::class, 'selectStreet'])->name('street');
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::get('/forgot-password/{token}/{email}', [AuthController::class, 'updatePassword'])->name('auth.update.password');
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('property')->name('property.')->group(function () {
    Route::get('/', [PropertiesController::class, 'index'])->name('index');
});
