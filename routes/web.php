<?php

use App\Livewire\DigitalProduct\CheckoutDigitalProduct;
use App\Livewire\DigitalProduct\IndexDigitalProduct;
use App\Livewire\DigitalProduct\ReadDigitalProduct;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::prefix('digital-product')->name('digital-product.')->group(function() {
        Route::get('/', IndexDigitalProduct::class)->name('index');
        Route::get('/read/{id}', ReadDigitalProduct::class)->name('read');
        Route::get('/checkout/{id}', CheckoutDigitalProduct::class)->name('checkout');
    });

    foreach (glob(__DIR__ . '/partials/*.php') as $file) {
        require $file;
    }
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
