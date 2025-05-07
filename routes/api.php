<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/all-category', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::apiResource('all-products', ProductController::class);           //apiresource untuk sisi api nya karena ada beberapa yang tidak akan terpakai jika kita menggunakan resource

// Route::get('/imad', function (Request $request) {
//     return response()->json([
//         'status' => 'error',
//         'message' => ['bagi broo.']
//     ]);
// });

