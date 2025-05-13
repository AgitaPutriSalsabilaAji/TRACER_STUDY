<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfesiController;
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


Route::prefix('manajemen_data')->group(function () {
    Route::get('/profesi', [ProfesiController::class, 'index'])->name('profesi.index');
    Route::get('/profesi/create_ajax', [ProfesiController::class, 'create_ajax'])->name('profesi.create_ajax');
    Route::post('/profesi/store_ajax', [ProfesiController::class, 'store_ajax'])->name('profesi.store_ajax');
    Route::get('/profesi/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax'])->name('profesi.edit_ajax');
    Route::put('/profesi/{id}/update_ajax', [ProfesiController::class, 'update_ajax'])->name('profesi.update_ajax');
    Route::get('/profesi/{id}/confirm_delete', [ProfesiController::class, 'confirm_ajax'])->name('profesi.confirm_ajax');
    Route::delete('/profesi/{id}/delete', [ProfesiController::class, 'delete_ajax'])->name('profesi.delete_ajax');
});

