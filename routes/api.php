<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/product/getProductsAll', [ProductController::class, 'getProductsAll']);
Route::get('/product/getProductsBySearch/{searchTerm}', [ProductController::class, 'getProductsBySearch']);
Route::get('/product/getProductsCheap', [ProductController::class, 'getProductsCheap']);

Route::middleware('auth:api')->group(function () {
    Route::post('/store/store', [StoreController::class, 'store']);
    Route::post('/store/update', [StoreController::class, 'update']);
    Route::delete('/store/delete/{id}', [StoreController::class, 'destroy']);
    Route::get('/store/getStoresByUser', [StoreController::class, 'getStoresByUser']);

    Route::post('/product/store', [ProductController::class, 'store']);
    Route::post('/product/update', [ProductController::class, 'update']);
    Route::delete('/product/delete/{id}', [ProductController::class, 'destroy']);
    Route::get('/product/getProductsByStore/{id}', [ProductController::class, 'getProductsByStore']);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});