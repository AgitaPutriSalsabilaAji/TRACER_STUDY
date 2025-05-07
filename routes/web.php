<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;

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
    return view('home');
})->name('home');


Route::fallback(function () {
    if (Auth::check()) {
        return response()->view('errors.404', [], 404);
    }
    return response()->view('errors.404_guest', [], 404);
});


Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware('auth');

Route::post('/lulusan/list', [AdminController::class, 'lulusanList'])->name('lulusan.list');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
