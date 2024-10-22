<?php

use App\Controllers\HomeController;
use App\Controllers\NewsController;
use App\Kernel\Router\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/news', [HomeController::class, 'index']),
    Route::get('/news/{id}', [NewsController::class, 'show']),
];
