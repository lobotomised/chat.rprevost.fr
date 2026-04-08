<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\MessageStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/i/{link:token}', InviteController::class);

Route::middleware('auth')->group(function() {
    Route::prefix('chats')->group(function() {
        Route::get('', ChatController::class)->name('chats.index');
        Route::get('{conversation}', ConversationController::class)->name('chats.show');
        Route::post('{conversation}/messages', MessageStoreController::class)->name('messages.store');
    });

});
