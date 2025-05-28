<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    session()->flush();

    return view('guest.home');
})->name('guest.home');

// Fallback untuk 404
Route::fallback(function () {
    if (Auth::check()) {
        return response()->view('errors.404', [], 404);
    }
    return response()->view('errors.404_guest', [], 404);
});

// ==========================
// Guest (Alumni)
// ==========================
Route::get('/form-alumni', [GuestController::class, 'create'])->name('form.alumni');
Route::post('/form-alumni', [GuestController::class, 'store'])->name('submit.alumni');
Route::get('/form-alumni/autocomplete-alumni', [GuestController::class, 'getNama'])->name('autocomplete.alumni');
Route::post('/validate-code/alumni',  [GuestController::class, 'validateKode'])->name('validate.alumni');

// ==========================
// Atasan
// ==========================
Route::get('/form-atasan', [AlumniController::class, 'create'])->name('form.atasan');
Route::post('/form-atasan', [AlumniController::class, 'store'])->name('submit.atasan');
Route::get('/form-atasan/autocomplete-atasan', [AlumniController::class, 'getNama'])->name('autocomplete.atasan');
Route::post('/validate-code/atasan',  [AlumniController::class, 'validateKode'])->name('validate.atasan');

// ==========================
// Auth
// ==========================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['web'])->group(function () {
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
});

Route::get('/change-password', [AuthController::class, 'editPassword'])->name('password.form');
Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

// ==========================
// Dashboard
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter', [AdminController::class, 'filter'])->name('dashboard.filter');

    Route::post('/dashboard/lulusan/table', [AdminController::class, 'lulusan_table'])->name('lulusan.table');
    Route::post('/dashboard/masa_tunggu/table', [AdminController::class, 'masa_tunggu_table'])->name('masa_tunggu.table');
    Route::post('/dashboard/performa_lulusan/table', [AdminController::class, 'performa_lulusan_table'])->name('performa_lulusan.table');


    // ==========================
    // Admin (CRUD)
    // ==========================
    Route::get('/admin/list', [AdminController::class, 'list'])->name('admin.list');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/list-admin', [AdminController::class, 'index_admin'])->name('admin.index');

    // ==========================
    // Profesi
    // ==========================
    Route::prefix('profesi')->group(function () {
        Route::get('/', [ProfesiController::class, 'index'])->name('profesi.index');
        Route::get('/list', [ProfesiController::class, 'list'])->name('profesi.list');
        Route::post('/profesi/store', [ProfesiController::class, 'store'])->name('profesi.store');
        Route::put('/profesi/update/{id}', [ProfesiController::class, 'update'])->name('profesi.update');
        Route::delete('/profesi/destroy/{id}', [ProfesiController::class, 'destroy'])->name('profesi.destroy');
        Route::get('/tambah-profesi', [ProfesiController::class, 'index_profesi'])->name('profesi.index');
    });

    // ==========================
    // Laporan / Rekap Data
    // ==========================
    Route::get('/laporan', [RekapDataController::class, 'index'])->name('laporan');
    Route::get('/laporan/filter', [RekapDataController::class, 'filter'])->name('laporan.filter');
    Route::post('/export-tracer', [RekapDataController::class, 'exportExcel'])->name('laporan.export.tracer');
    Route::post('/export-kepuasan', [RekapDataController::class, 'exportSurveiKepuasan'])->name('laporan.export.kepuasan');
    Route::post('/export-belum-tracer', [RekapDataController::class, 'exportBelumTS'])->name('laporan.export.belumTracer');
    Route::post('/export-belum-survei', [RekapDataController::class, 'exportBelumSurvei'])->name('laporan.export.belumSurvei');

    // Data Alumni (CRUD Sederhana)
    Route::middleware('auth')->group(function () {
        Route::get('/data-alumni', [AlumniController::class, 'index'])->name('data-alumni.index');
        Route::post('/data-alumni', [AlumniController::class, 'storeAlumni'])->name('data-alumni.store');
        Route::get('/data-alumni/create', [AlumniController::class, 'createAlumni'])->name('data-alumni.create');
        Route::get('/data-alumni/{id}/edit', [AlumniController::class, 'editAlumni'])->name('data-alumni.edit');
        Route::put('/data-alumni/{id}', [AlumniController::class, 'updateAlumni'])->name('data-alumni.update');
        Route::delete('/data-alumni/{id}', [AlumniController::class, 'destroyAlumni'])->name('data-alumni.destroy');
        Route::get('/data-alumni/list', [AlumniController::class, 'list'])->name('data-alumni.list');
        Route::delete('/alumni/{id}', [AlumniController::class, 'destroy'])->name('data-alumni.destroy');
        Route::middleware(['superadmin'])->group(function () {
            Route::post('/data-alumni/{id}/restore', [AlumniController::class, 'restore'])->name('data-alumni.restore');
            Route::delete('/data-alumni/{id}/force-delete', [AlumniController::class, 'forceDelete'])->name('data-alumni.forceDelete');
        });
    });
});
