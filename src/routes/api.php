<?php

use App\Http\Controllers\Admin\Category\CreateCategoryController;
use App\Http\Controllers\Admin\Category\DeleteCategoryController;
use App\Http\Controllers\Admin\Category\ShowCategoryController;
use App\Http\Controllers\Admin\Category\UpdateCategoryController;
use App\Http\Controllers\RedisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});





Route::middleware(['auth:sanctum'])->prefix('categories')->as('categories.')->group(function () {
    Route::post('/', CreateCategoryController::class)->name('store');
    Route::get('/{category}', ShowCategoryController::class)->name('show');
    Route::put('/{category}', UpdateCategoryController::class)->name('update');
    Route::delete('/', DeleteCategoryController::class)->name('delete');
});


Route::get('/redis', [RedisController::class, 'index']);