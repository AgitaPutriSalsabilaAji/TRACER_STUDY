<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\GuestController;
use App\Models\Admin;

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

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/', function () {
    return view('guest.home'); // <== Pastikan ini sesuai
});


// Route::get('/iniform', function () {
//     return view('form.Alumni');
// });


Route::fallback(function () {
    if (Auth::check()) {
        return response()->view('errors.404', [], 404);
    }
    return response()->view('errors.404_guest', [], 404);
});

//guest
Route::get('/form-alumni', [GuestController::class, 'create'])->name('form.alumni');
Route::post('/form-alumni', [GuestController::class, 'store'])->name('submit.alumni');
Route::get('/autocomplete-alumni', [GuestController::class, 'getNama'])->name('autocomplete.alumni');

//atasan
use App\Http\Controllers\TracerAlumniController;

Route::get('/tracer-alumni', [AlumniController::class, 'create'])->name('tracer-alumni.create');
Route::post('/tracer-alumni', [AlumniController::class, 'store'])->name('tracer-alumni.store');


Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/filter', [AdminController::class, 'filter'])->name('dashboard.filter')->middleware('auth');

Route::post('/dashboard/lulusan/table', [AdminController::class, 'lulusan_table'])->name('lulusan.table');
Route::post('/dashboard/masa_tunggu/table', [AdminController::class, 'masa_tunggu_table'])->name('masa_tunggu.table');
Route::post('/dashboard/performa_lulusan/table', [AdminController::class, 'performa_lulusan_table'])->name('performa_lulusan.table');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['web'])->group(function () {
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
});

Route::prefix('manajemen_data')->group(function () {
    Route::get('/profesi', [ProfesiController::class, 'index'])->name('profesi.index');
    Route::get('/profesi/create_ajax', [ProfesiController::class, 'create_ajax'])->name('profesi.create_ajax');
    Route::post('/profesi/store_ajax', [ProfesiController::class, 'store_ajax'])->name('profesi.store_ajax');
    Route::get('/profesi/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax'])->name('profesi.edit_ajax');
    Route::put('/profesi/{id}/update_ajax', [ProfesiController::class, 'update_ajax'])->name('profesi.update_ajax');
    Route::get('/profesi/{id}/confirm_delete', [ProfesiController::class, 'confirm_ajax'])->name('profesi.confirm_ajax');
    Route::delete('/profesi/{id}/delete', [ProfesiController::class, 'delete_ajax'])->name('profesi.delete_ajax');
});
