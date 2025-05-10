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

// //route form
// Route::get('/inform', [GuestController::class, 'showForm'])->name('form.show');
// Route::post('/inform', [GuestController::class, 'submitForm'])->name('form.submit');

Route::get('iniform', function () {
    return view('guest.form');
});




Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware('auth');

Route::post('/dashboard/lulusan/table', [AdminController::class, 'lulusan_table'])->name('lulusan.table');
Route::post('/dashboard/masa_tunggu/table', [AdminController::class, 'masa_tunggu_table'])->name('masa_tunggu.table');
Route::post('/dashboard/performa_lulusan/table', [AdminController::class, 'performa_lulusan_table'])->name('performa_lulusan.table');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// routes/web.php
Route::prefix('manajemen-data')->group(function () {
    Route::get('profesi', [ProfesiController::class, 'index'])->name('profesi.index');
    Route::post('profesi', [ProfesiController::class, 'store'])->name('profesi.store');
    Route::get('profesi/{id}/edit', [ProfesiController::class, 'edit'])->name('profesi.edit');
    Route::put('profesi/{id}', [ProfesiController::class, 'update'])->name('profesi.update');
    Route::delete('profesi/{id}', [ProfesiController::class, 'destroy'])->name('profesi.destroy');
});
