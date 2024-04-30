<?php

use App\Http\Controllers\CardTransactionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransportRouteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin) {
            return redirect()->route('cities.index');
        } else {
            return redirect()->route('user.profile.index');
        }
    } else {
        return redirect()->route('user.login');
    }
})->name('home.path.redirect');

Route::group(['middleware' => ['guest']], function () {

    // Register new user
    Route::get('/register', [UserController::class, 'create'])->name('user.create');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');

    // Log into existing user
    Route::get('/login', [UserController::class, 'login'])->name('user.login');
    Route::post('/users/auth', [UserController::class, 'authenticate'])->name('user.authenticate');
});

// Accessible routes to authorised users
Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

    // Default users routes
    Route::group(['middleware' => ['user.default']], function () {
        Route::get('/profile', [UserController::class, 'index'])->name('user.profile.index');
        Route::get('/cards/{card}/history', [CardTransactionController::class, 'index'])
            ->name('cards.transactions.index');
    });

    // Admin prefix routes
    Route::group(['prefix' => 'admin', 'middleware' => ['user.admin']], function () {

        //Redirect admin users to Dashboard
        Route::get('/', function () {
            return redirect()->route('cities.index');
        });

        // Dashboard (cities list)
        Route::get('/cities', [CityController::class, 'index'])->name('cities.index');

        // Dashboard Cities editing
        Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
        Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
        Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
        Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
        Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

        // Dashboard transport routes editing
        Route::get('/cities/{city}/transport', [TransportRouteController::class, 'index'])
            ->name('transport.index');
        Route::get('/cities/{city}/transport/create', [TransportRouteController::class, 'create'])
            ->name('transport.create');
        Route::post('/cities/{city}/transport', [TransportRouteController::class, 'store'])
            ->name('transport.store');
        Route::get('/cities/{city}/transport/{transport}/edit', [TransportRouteController::class, 'edit'])
            ->name('transport.edit');
        Route::put('/cities/{city}/transport/{transport}', [TransportRouteController::class, 'update'])
            ->name('transport.update');
        Route::delete('/cities/{city}/transport/{transport}', [TransportRouteController::class, 'destroy'])
            ->name('transport.destroy');

        // Dashboard Tickets Editing routes
        Route::get('/cities/{city}/tickets', [TicketController::class, 'index'])
            ->name('tickets.index');
        Route::get('/cities/{city}/tickets/create', [TicketController::class, 'create'])
            ->name('tickets.create');
        Route::post('/cities/{city}/tickets', [TicketController::class, 'store'])
            ->name('tickets.store');
        Route::get('/cities/{city}/tickets/{ticket}/edit', [TicketController::class, 'edit'])
            ->name('tickets.edit');
        Route::put('/cities/{city}/tickets/{ticket}', [TicketController::class, 'update'])
            ->name('tickets.update');
        Route::delete('/cities/{city}/tickets/{ticket}', [TicketController::class, 'destroy'])
            ->name('tickets.destroy');
    });
});

// Not supported requests
Route::fallback(function () {
    abort(404);
});
