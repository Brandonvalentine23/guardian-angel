<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationLogController;

Route::post('/location-log', [LocationLogController::class, 'storeLocationLog'])->name('store.locationlog');
