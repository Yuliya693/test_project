<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

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

// Route::post('/register', [AuthController::class, 'register']); 
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api'); 

// Route::post('/librarian/login', [AuthController::class, 'librarianLogin']); 

// Route::get('/books', [BookController::class, 'index']); 
// Route::middleware('auth:api')->group(function () {
//     Route::post('/books/{id}/borrow', [BookController::class, 'borrow']); 
//     Route::post('/books/{id}/return', [BookController::class, 'return']); 
// });

Route::middleware(['auth:api'])->group(function () {
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
});

// Пользовательские маршруты
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books/{book}/borrow', [BookController::class, 'borrow']);
    Route::post('/books/{book}/return', [BookController::class, 'return']);
});

