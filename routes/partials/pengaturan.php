<?php

use App\Livewire\Pengaturan\Akun\CreatePengaturanAkun;
use App\Livewire\Pengaturan\Akun\IndexPengaturanAkun;
use App\Livewire\Pengaturan\Akun\ReadPengaturanAkun;
use App\Livewire\Pengaturan\Akun\UpdatePengaturanAkun;
use App\Livewire\Pengaturan\Peran\CreatePengaturanPeran;
use App\Livewire\Pengaturan\Peran\IndexPengaturanPeran;
use App\Livewire\Pengaturan\Peran\ReadPengaturanPeran;
use App\Livewire\Pengaturan\Peran\UpdatePengaturanPeran;
use App\Livewire\Pengaturan\Perizinan\CreatePengaturanPerizinan;
use App\Livewire\Pengaturan\Perizinan\IndexPengaturanPerizinan;
use App\Livewire\Pengaturan\Perizinan\ReadPengaturanPerizinan;
use App\Livewire\Pengaturan\Perizinan\UpdatePengaturanPerizinan;
use Illuminate\Support\Facades\Route;

Route::prefix('pengaturan')->group(function() {
    Route::prefix('akun')->name('akun.')->group(function() {
        Route::get('/', IndexPengaturanAkun::class)->name('index');
        Route::get('/create', CreatePengaturanAkun::class)->name('create');
        Route::get('/read/{id}', ReadPengaturanAkun::class)->name('read');
        Route::get('/update/{id}', UpdatePengaturanAkun::class)->name('update');
        Route::delete('/{id}', [IndexPengaturanAkun::class, 'destroy'])->name('delete');
    });

    Route::prefix('peran')->name('peran.')->group(function() {
        Route::get('/', IndexPengaturanPeran::class)->name('index');
        Route::get('/create', CreatePengaturanPeran::class)->name('create');
        Route::get('/read/{id}', ReadPengaturanPeran::class)->name('read');
        Route::get('/update/{id}', UpdatePengaturanPeran::class)->name('update');
        Route::delete('/{id}', [IndexPengaturanPeran::class, 'destroy'])->name('delete');
    });

    Route::prefix('perizinan')->name('perizinan.')->group(function() {
        Route::get('/', IndexPengaturanPerizinan::class)->name('index');
        Route::get('/create', CreatePengaturanPerizinan::class)->name('create');
        Route::get('/read/{id}', ReadPengaturanPerizinan::class)->name('read');
        Route::get('/update/{id}', UpdatePengaturanPerizinan::class)->name('update');
        Route::delete('/{id}', [IndexPengaturanPerizinan::class, 'destroy'])->name('delete');
    });
});
