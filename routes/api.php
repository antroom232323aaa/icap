<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAttractionController;
use App\Http\Controllers\Api\ApiStatisticsController;

Route::prefix('attractions')->group(function () {

    Route::get('/', [ApiAttractionController::class, 'index']);

    Route::get('/{id}', [ApiAttractionController::class, 'show']);

    Route::post('/', [ApiAttractionController::class, 'store']);

    Route::put('/{id}', [ApiAttractionController::class, 'update']);

    Route::delete('/{id}', [ApiAttractionController::class, 'destroy']);
});

// 統計圖表用
Route::get('/statistics', [ApiStatisticsController::class, 'index']);
