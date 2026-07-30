<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\Admin\AdminAttractionController;
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


// 景點詳細
Route::middleware('routeId')->group(function () {

    Route::get(
        '/attractions/{id}',
        [AttractionController::class, 'show']
    );
});


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


        // 儲存新景點
        Route::post(
            '/',
            [AdminAttractionController::class, 'store']
        );


        // 需要 ID 的操作
        Route::middleware('routeId')->group(function () {

            // 編輯景點
            Route::get(
                '/edit/{id}',
                [AdminAttractionController::class, 'edit']
            );


            // 更新景點
            Route::put(
                '/{id}',
                [AdminAttractionController::class, 'update']
            );


            // 刪除景點
            Route::delete(
                '/{id}',
                [AdminAttractionController::class, 'destroy']
            );
        });
    });
});
