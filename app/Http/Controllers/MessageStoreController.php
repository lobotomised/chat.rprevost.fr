<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageStoreController extends Controller
{
    public function __invoke(Request $request, Conversation $conversation)
    {
        abort_unless(
            $request->user()->conversations->contains($conversation->id),
            403
        );

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $request->user()->id,
            'type' => MessageType::Text,
            'body' => $validated['body'],
        ]);
    }
}
