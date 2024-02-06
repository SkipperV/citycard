<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CardTransactionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransportRouteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Empty path gets to '/login', which checks if user is already logged in
Route::get('/', [UserController::class, 'login']);

// Register new user
Route::get('/register', [UserController::class, 'create']);

Route::post('/users', [UserController::class, 'store']);

// Log into existing user
Route::get('/login', [UserController::class, 'login'])->name('login');

Route::post('/users/auth', [UserController::class, 'authenticate']);

// Accessible routes to authorised users
Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', [UserController::class, 'logout']);

    // Default users routes
    Route::group(['middleware' => ['user.default']], function () {

        Route::get('/profile', [UserController::class, 'index']);

        Route::get('/cards/{card_id}/history', [CardTransactionController::class, 'index']);
    });

    // Admin prefix routes
    Route::group(['prefix' => 'admin', 'middleware' => ['user.admin']], function () {

        //Redirect to working Route (cities)
        Route::get('/', function () {
            return redirect('/admin/cities');
        });

        // Admin Cities editing routes
        Route::get('/cities', [CityController::class, 'index']);

        Route::get('/cities/create', [CityController::class, 'create']);

        Route::post('/cities', [CityController::class, 'store']);

        Route::get('/cities/{city_id}/edit', [CityController::class, 'edit']);

        Route::put('/cities/{city_id}', [CityController::class, 'update']);

        Route::delete('/cities/{city_id}', [CityController::class, 'destroy']);

        // Admin transport_routes editing routes
        Route::get('/cities/{city_id}/transport', [TransportRouteController::class, 'index']);

        Route::get('/cities/{city_id}/transport/create', [TransportRouteController::class, 'create']);

        Route::post('/cities/{city_id}/transport', [TransportRouteController::class, 'store']);

        Route::get('/cities/{city_id}/transport/{transport_id}/edit', [TransportRouteController::class, 'edit']);

        Route::put('/cities/{city_id}/transport/{transport_id}', [TransportRouteController::class, 'update']);

        Route::delete('/cities/{city_id}/transport/{transport_id}', [TransportRouteController::class, 'destroy']);

        // Admin Tickets Editing routes
        Route::get('/cities/{city_id}/tickets', [TicketController::class, 'index']);

        Route::get('/cities/{city_id}/tickets/create', [TicketController::class, 'create']);

        Route::post('/cities/{city_id}/tickets', [TicketController::class, 'store']);

        Route::get('/cities/{city_id}/tickets/{ticket_id}/edit', [TicketController::class, 'edit']);

        Route::put('/cities/{city_id}/tickets/{ticket_id}', [TicketController::class, 'update']);

        Route::delete('/cities/{city_id}/tickets/{ticket_id}', [TicketController::class, 'destroy']);
    });
});

// Not supported requests
Route::fallback(function () {
    abort(404);
});
