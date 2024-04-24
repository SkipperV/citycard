<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\UserController;
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
Route::name('api.')->group(function () {

    Route::post('/register', [UserController::class, 'store'])->name('user.register');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

        Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
        Route::get('/cities/search/{searchString}', [CityController::class, 'search'])->name('cities.search');
        Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
        Route::get('/cities/{city}', [CityController::class, 'show'])->name('cities.show');
        Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
        Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');
    });

// Not supported requests
    Route::fallback(function () {
        abort(404);
    });
});
