<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FuzzyfikasiController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Route untuk daftar pengguna (index)
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    // Taruh route ini sebelum yang pakai {id}
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');

    // Proses tambah pengguna
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    // Route edit juga harus di atas
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    
    // Proses edit pengguna
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    
    // Proses hapus pengguna
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Yang ini terakhir! Karena dia pakai {id}
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');

    // Route untuk prediksi
    Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index');
    Route::post('/prediksi', [PrediksiController::class, 'proses'])->name('prediksi.proses');
    Route::get('/hasil-prediksi', [PrediksiController::class, 'hasil'])->name('prediksi.hasil');

    // Route untuk data
    Route::get('/data', [DataController::class, 'index'])->name('data.index');
    Route::get('/data/create', [DataController::class, 'create'])->name('data.create');
    Route::post('/data', [DataController::class, 'store'])->name('data.store');
    Route::get('/data/{id}/edit', [DataController::class, 'edit'])->name('data.edit');
    Route::put('/data/{id}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/data/{id}', [DataController::class, 'destroy'])->name('data.destroy');
    Route::post('/data/import', [DataController::class, 'import'])->name('data.import');

    //Route untuk hasil
    Route::get('hasil', [PrediksiController::class, 'index'])->name('hasil.index');

    //Route untuk fuzzyfikasi
    Route::get('fuzzyfikasi', [FuzzyfikasiController::class, 'index'])->name('fuzzy.index');

    //Route untuk rule
    Route::get('rule', [RuleController::class, 'index'])->name('rule.index');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

