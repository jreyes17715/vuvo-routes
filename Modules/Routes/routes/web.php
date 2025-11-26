<?php

use Illuminate\Support\Facades\Route;
use Modules\Routes\App\Http\Controllers\RoutesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('routes', RoutesController::class)->names('routes');
});
