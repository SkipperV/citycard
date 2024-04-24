<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TransportRouteController;
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

        Route::get('/cities/{city}/transport', [TransportRouteController::class, 'index'])
            ->name('transport.index');
        Route::post('/cities/{city}/transport', [TransportRouteController::class, 'store'])
            ->name('transport.store');
        Route::get('/cities/{city}/transport/{transport}', [TransportRouteController::class, 'show'])
            ->name('transport.edit');
        Route::put('/cities/{city}/transport/{transport}', [TransportRouteController::class, 'update'])
            ->name('transport.update');
        Route::delete('/cities/{city}/transport/{transport}', [TransportRouteController::class, 'destroy'])
            ->name('transport.destroy');

        Route::get('/cities/{city}/tickets', [TicketController::class, 'index'])
            ->name('tickets.index');
        Route::post('/cities/{city}/tickets', [TicketController::class, 'store'])
            ->name('tickets.store');
        Route::get('/cities/{city}/tickets/{ticket}', [TicketController::class, 'show'])
            ->name('tickets.edit');
        Route::put('/cities/{city}/tickets/{ticket}', [TicketController::class, 'update'])
            ->name('tickets.update');
        Route::delete('/cities/{city}/tickets/{ticket}', [TicketController::class, 'destroy'])
            ->name('tickets.destroy');
    });

// Not supported requests
    Route::fallback(function () {
        abort(404);
    });
});
