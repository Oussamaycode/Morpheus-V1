<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SessionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/{chatId}/messages', [MessageController::class, 'index'])->name('chats.messages.index');
    Route::post('/chats/{chatId}/messages', [MessageController::class, 'store'])->name('chats.messages.store');
    Route::get('/chats/{chatId}/messages/{messageId}', [MessageController::class, 'show'])->name('chats.messages.show');
    Route::get('/start', [SessionController::class, 'start']);
    Route::get('/games/fetch', [GameController::class, 'fetchGames']);
});

