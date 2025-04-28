<?php

use App\Livewire\Database\AkunProduct\CreateDatabaseAkunProduct;
use App\Livewire\Database\AkunProduct\IndexDatabaseAkunProduct;
use App\Livewire\Database\AkunProduct\ReadDatabaseAkunProduct;
use App\Livewire\Database\AkunProduct\UpdateDatabaseAkunProduct;
use App\Livewire\Database\Product\CreateProduct;
use App\Livewire\Database\Product\IndexProduct;
use App\Livewire\Database\Product\ReadProduct;
use App\Livewire\Database\Product\UpdateProduct;
use Illuminate\Support\Facades\Route;

Route::prefix('database')->group(function() {
    Route::prefix('product')->name('product.')->group(function() {
        Route::get('/', IndexProduct::class)->name('index');
        Route::get('/create', CreateProduct::class)->name('create');
        Route::get('/read/{id}', ReadProduct::class)->name('read');
        Route::get('/update/{id}', UpdateProduct::class)->name('update');
        Route::delete('/{id}', [IndexProduct::class, 'destroy'])->name('delete');
    });

    Route::prefix('akun-product')->name('akun-product.')->group(function() {
        Route::get('/', IndexDatabaseAkunProduct::class)->name('index');
        Route::get('/create', CreateDatabaseAkunProduct::class)->name('create');
        Route::get('/read/{id}', ReadDatabaseAkunProduct::class)->name('read');
        Route::get('/update/{id}', UpdateDatabaseAkunProduct::class)->name('update');
        Route::delete('/{id}', [IndexDatabaseAkunProduct::class, 'destroy'])->name('delete');
    });
});
