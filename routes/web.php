<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PendaftaranController;

Route::get('/', function () {
    return view('welcome');
});
//login regist
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//route admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/pendaftar', [AdminController::class, 'pendaftar'])->name('admin.pendaftar');
    Route::get('/admin/lowongan', [AdminController::class, 'lowonganIndex'])->name('admin.lowongan.index');
    Route::get('/admin/lowongan/create', [AdminController::class, 'lowonganCreate'])->name('admin.lowongan.create');
    Route::post('/admin/lowongan', [AdminController::class, 'lowonganStore'])->name('admin.lowongan.store');
    Route::get('/admin/lowongan/{lowongan}/edit', [AdminController::class, 'lowonganEdit'])->name('admin.lowongan.edit');
    Route::put('/admin/lowongan/{lowongan}', [AdminController::class, 'lowonganUpdate'])->name('admin.lowongan.update');
    Route::delete('/admin/lowongan/{lowongan}', [AdminController::class, 'lowonganDestroy'])->name('admin.lowongan.destroy');
    Route::get('/admin/pendaftar/{id}', [AdminController::class, 'detail'])->name('admin.pendaftar.detail');
    Route::get('/admin/indent/{indent}', [AdminController::class, 'verifikasiIndent'])->name('admin.indent.verifikasi');
    Route::put('/admin/pendaftar/{id}/terima', [AdminController::class, 'terimaPendaftar'])->name('admin.pendaftar.terima');
    Route::put('/admin/pendaftar/{id}/tolak', [AdminController::class, 'tolakPendaftar'])->name('admin.pendaftar.tolak');
    Route::put('/admin/indent/{id}/terima', [AdminController::class, 'terimaIndent'])->name('admin.indent.terima');
    Route::put('/admin/indent/{id}/tolak', [AdminController::class, 'tolakIndent'])->name('admin.indent.tolak');
    Route::get('/admin/tabel', [AdminController::class, 'indexPendaftar'])->name('admin.tabel');
    Route::get('/admin/tabelindent', [AdminController::class, 'indexIndent'])->name('admin.tabelindent');
    Route::post('/admin/penolakan', [AdminController::class, 'tolakDenganAlasan'])->name('admin.tolak.alasan');
    Route::get('/admin/pendaftar/{id}/cetak-surat', [AdminController::class, 'cetakSuratBalasanPendaftar'])->name('admin.cetakSuratBalasanPendaftar');
    Route::get('/admin/indent/{id}/cetak-surat', [AdminController::class, 'cetakSuratBalasanIndent'])->name('admin.cetakSuratBalasanIndent');

});


//route pendaftar
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [PendaftaranController::class, 'index'])->name('pendaftar.dashboard');
    Route::get('/pendaftaran/{lowongan_id}', [PendaftaranController::class, 'create'])->name('pendaftar.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftar.store');
    Route::get('/pendaftar/pendaftaran', [PendaftaranController::class, 'pendaftaran'])->name('pendaftar.pendaftaran');
    Route::get('/pendaftar/status', [PendaftaranController::class, 'status'])->name('pendaftar.status');
    Route::get('/indent', [IndentController::class, 'create'])->name('pendaftar.indent.create');
    Route::post('/indent', [IndentController::class, 'store'])->name('pendaftar.indent.store');
    Route::get('/indent/status', [IndentController::class, 'status'])->name('pendaftar.indent.status');
    Route::get('/status', [StatusController::class, 'index'])->name('status.status');
});
