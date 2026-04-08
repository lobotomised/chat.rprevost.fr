<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __invoke(Request $request, Conversation $conversation)
    {
        abort_unless(
            $request->user()->conversations->contains($conversation->id),
            403
        );

        $conversation->load(['messages.sender']);

        return view('chats.show', [
            'conversations' => Conversation::forUser($request->user()),
            'activeConversation' => $conversation,
        ]);
    }

}
