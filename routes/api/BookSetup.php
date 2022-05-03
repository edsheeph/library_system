<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookTypeController;

Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['prefix' => 'books'], function() {
        Route::get('/', [BookController::class, 'index']);
        Route::post('/show/{id}', [BookController::class, 'show']);
        Route::post('/store', [BookController::class, 'store']);
        Route::post('/edit/{id}', [BookController::class, 'edit']);
        Route::put('/update/{id}', [BookController::class, 'update']);
        Route::delete('/destroy/{id}', [BookController::class, 'destroy']);

        Route::group(['prefix' => 'categories'], function() {
            Route::get('/', [BookCategoryController::class, 'index']);
            Route::post('/show/{id}', [BookCategoryController::class, 'show']);
            Route::post('/store', [BookCategoryController::class, 'store']);
            Route::post('/edit/{id}', [BookCategoryController::class, 'edit']);
            Route::put('/update/{id}', [BookCategoryController::class, 'update']);
            Route::delete('/destroy/{id}', [BookCategoryController::class, 'destroy']);
        });

        Route::group(['prefix' => 'types'], function() {
            Route::get('/', [BookTypeController::class, 'index']);
            Route::post('/show/{id}', [BookTypeController::class, 'show']);
            Route::post('/store', [BookTypeController::class, 'store']);
            Route::post('/edit/{id}', [BookTypeController::class, 'edit']);
            Route::put('/update/{id}', [BookTypeController::class, 'update']);
            Route::delete('/destroy/{id}', [BookTypeController::class, 'destroy']);
        });
    });
});