<?php

use App\Http\Controllers\ImageProcessingController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/image')->group(function () {
    Route::post('/process', [ImageProcessingController::class, 'processImage']);
    Route::post('/process-batch', [ImageProcessingController::class, 'processBatch']);
});
