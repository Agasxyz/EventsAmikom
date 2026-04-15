<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [EventController::class,
'show'])->name('events.show');
Route::get('/checkout', [EventController::class,
'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

Route::get('/', [DashboardController::class,

'index'])->name('dashboard');

Route::get('/events', [EventController::class,

'indexAdmin'])->name('events.index');
});