<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\gameSessionController;
use App\Http\Controllers\VirtualMachineController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserGameController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SteamController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/plans', [PlanController::class, 'index']);
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::get('/auth/steam', [SteamController::class, 'redirect']);
Route::get('/auth/steam/callback', [SteamController::class, 'callback']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/users',[UserController::class,'index']);
    Route::post('/users/{user}/ban',[UserController::class,'ban']);
    Route::get('/chats/{chatId}/messages', [MessageController::class, 'index']);
    Route::post('/chats/{chatId}/messages', [MessageController::class, 'store']);
    Route::get('/chats/{chatId}/messages/{messageId}', [MessageController::class, 'show']);
    Route::post('buy-plan', [VirtualMachineController::class, 'store']);
    Route::post('session/start', [gameSessionController::class, 'store']);
    Route::get('sessions',[gameSessionController::class,'index']);
    Route::get('/tournaments', [TournamentController::class, 'index']);
    Route::post('/tournaments', [TournamentController::class, 'store']);
    Route::post('/tournaments/{tournament}/join', [TournamentController::class, 'join'])->middleware('can:join');
    Route::post('/tournaments/{tournament}/end', [TournamentController::class, 'end']);
    Route::post('/tournaments/{tournament}/start', [TournamentController::class, 'start']);
    Route::get('/tournaments/{tournament}/leaderboard', [TournamentController::class, 'leaderboard']);
    Route::post('/plans/{plan}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/games',[GameController::class,'index']);
    Route::post('/games',[GameController::class,'fetchGames']);
    Route::post('virtual-machines/{virtualMachine}/turn-on', [VirtualMachineController::class, 'turnOn'])->middleware('can:turnOn');
    Route::post('virtual-machines/{virtualMachine}/turn-off', [VirtualMachineController::class, 'turnOff'])->middleware('can:turnOff');
  
});

