<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomPageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    

    Route::post('/categories/store', [CategoryController::class, 'store']);  
    Route::put('/categories/update', [CategoryController::class, 'update']);  
    Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy']);  
    Route::get('/categories', [CategoryController::class, 'index']);  
    Route::get('/categories/{id}', [CategoryController::class, 'show']);  

    Route::post('/news/store', [NewsController::class, 'store']);  
    Route::put('/news/update', [NewsController::class, 'update']);  
    Route::delete('/news/destroy/{id}', [NewsController::class, 'destroy']);
    
    Route::post('/custom-pages/store', [CustomPageController::class, 'store']);  
    Route::put('/custom-pages/update', [CustomPageController::class, 'update']);  
    Route::delete('/custom-pages/destroy/{id}', [CustomPageController::class, 'destroy']);

});

Route::prefix('guest')->group(function () {
    Route::get('news', [NewsController::class, 'index']); 
    Route::get('news/{id}', [NewsController::class, 'show']); 
    
    Route::get('custom-pages', [CustomPageController::class, 'index']); 
    Route::get('custom-pages/{id}', [CustomPageController::class, 'show']); 

    Route::post('news/comment', [CommentController::class, 'store']);  
});

