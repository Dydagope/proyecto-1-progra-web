<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/vino', [CategoryController::class, 'wine'])->name('categories.wine');
Route::get('/champan', [CategoryController::class, 'champagne'])->name('categories.champagne');
Route::get('/categorias/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::resource('productos', ProductController::class);