<?php
// routes/api.php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
Route::get('index', [ArticleController::class, 'index']);
Route::get('show/{id}', [ArticleController::class, 'show']);
Route::get('search', [ArticleController::class, 'search']);


Route::post('fav/store', [FavoriteController::class, 'store']);
Route::get('fav/index', [FavoriteController::class, 'index']);
Route::delete('fav/delete/{id}', [FavoriteController::class, 'delete']);

Route::get('favoriteResults', [ArticleController::class, 'favoriteResults']);


Route::prefix('subCategory')->group(function () {
    Route::post('store', [SubCategoryController::class, 'store']);
    Route::delete('delete/{id}', [SubCategoryController::class, 'destroy']);
    Route::get('index', [SubCategoryController::class, 'index']);
});
