<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\gameSessionController;
use App\Http\Controllers\VirtualMachineController;
use App\Http\Controllers\PlanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('/plans', [PlanController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/{chatId}/messages', [MessageController::class, 'index'])->name('chats.messages.index');
    Route::post('/chats/{chatId}/messages', [MessageController::class, 'store'])->name('chats.messages.store');
    Route::get('/chats/{chatId}/messages/{messageId}', [MessageController::class, 'show'])->name('chats.messages.show');
    Route::get('/start', [gameSessionController::class, 'start']);
    Route::get('/games/fetch', [GameController::class, 'fetchGames']);
    Route::post('buy-plan',[VirtualMachineController::class,'store']);
    Route::post('session/start',[gameSessionController::class,'store']);
});

