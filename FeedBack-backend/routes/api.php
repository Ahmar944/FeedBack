<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\FeedbackCommentController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group( function () {
	Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('products', ProductsController::class);
    Route::get('getUserData', [UserController::class, 'getUserData']);


    Route::get('feedbacks', [FeedbackController::class, 'index']);
    Route::post('feedbacks', [FeedbackController::class, 'store']);
    Route::delete('feedbacks', [FeedbackController::class, 'destroy']);

    Route::post('feedback-comments', [FeedbackCommentController::class, 'store']);
    Route::get('feedback-comments', [FeedbackCommentController::class, 'index']);

});

