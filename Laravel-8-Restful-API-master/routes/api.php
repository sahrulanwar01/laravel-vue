<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\ContentController;
use App\Http\Controllers\PostController;

// Rute untuk Content berdasarkan Post
Route::prefix('post')->group(function () {
    Route::get('/{post}/contents', [ContentController::class, 'index']);
    Route::get('/{post}/contents/{content}', [ContentController::class, 'show']);
    Route::post('/{post}/contents', [ContentController::class, 'store']);
    Route::put('/{post}/contents/{content}', [ContentController::class, 'update']);
    Route::delete('/{post}/contents/{content}', [ContentController::class, 'destroy']);
});

/**
 * route resource post
 */
Route::resource('/post', PostController::class);
