<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Contracts\View\View;

class ChatController extends Controller
{
    public function __invoke(): View
    {
        $conversations = Conversation::forUser(auth()->user());

        return view('chats.index', [
            'conversations' => $conversations,
            'activeConversation' => null,
        ]);

    }
}
