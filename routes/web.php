<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\InviteController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/i/{link:token}', InviteController::class);

Route::middleware('auth')->group(function() {
    Route::get('/chats', ChatController::class)->name('chats.index');
    Route::get('/chats/{conversation}', ConversationController::class)->name('chats.show');
});
