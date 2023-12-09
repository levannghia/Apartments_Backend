<?php

use App\Http\Controllers\Admin\ApartmentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('apartment')->name('apartment.')->group(function () {
        Route::get('/', [ApartmentController::class, 'index'])->name('index');
        Route::get('/create', [ApartmentController::class, 'create'])->name('create');
        Route::post('/store', [ApartmentController::class, 'store'])->name('store');
    });
});

require __DIR__ . '/auth.php';
