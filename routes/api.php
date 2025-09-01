<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// All routes are prefixed with /api automatically when using api.php
Route::get('category', [CategoryController::class, 'index']);
Route::get('category/{id}', [CategoryController::class, 'show']);
Route::post('category', [CategoryController::class, 'store']);
Route::put('category/{id}', [CategoryController::class, 'update']);
Route::delete('category/{id}', [CategoryController::class, 'destroy']);

// product Controller Routes
Route::apiResource('products', ProductController::class);
