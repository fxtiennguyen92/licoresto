<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Products
Route::get('/products', [ProductController::class, 'list']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'view']);
Route::put('/products/{id}', [ProductController::class, 'edit']);
Route::delete('/products/{id}', [ProductController::class, 'delete']);

