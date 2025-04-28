<?php

use App\Http\Controllers\PaymentCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/tripay/callback', [PaymentCallbackController::class, 'callback']);
