<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::resource('sales', SaleController::class);
