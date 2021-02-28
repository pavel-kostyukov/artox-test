<?php

use App\Http\Controllers\VenuesController;
use Illuminate\Support\Facades\Route;

Route::get('venues', [VenuesController::class, 'findVenuesAction']);
