<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\Admin\AdminAttractionController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| 前台頁面
|--------------------------------------------------------------------------
*/

// 首頁
Route::get('/', function () {
    return view('home');
});


// 景點列表
Route::get(
    '/attractions',
    [AttractionController::class, 'index']
);


// 單一景點詳細
Route::middleware('routeId')->group(function () {

    Route::get(
        '/attractions/{id}',
        [AttractionController::class, 'show']
    );
});


// 景點統計
Route::get('/statistics', [StatisticsController::class, 'index']);


/*
|--------------------------------------------------------------------------
| 後台管理
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::prefix('attractions')->group(function () {

        // 景點管理列表
        Route::get(
            '/',
            [AdminAttractionController::class, 'index']
        );

        // 新增景點頁面
        Route::get(
            '/create',
            [AdminAttractionController::class, 'create']
        );

        Route::middleware('routeId')->group(function () {

            // 編輯景點畫面
            Route::get(
                '/edit/{id}',
                [AdminAttractionController::class, 'edit']
            );
        });
    });
});
