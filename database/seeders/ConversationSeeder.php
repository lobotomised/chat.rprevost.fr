<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Conversation;
use App\Models\DirectConversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all()->shuffle();

        $pairs = $users->chunk(2);

        foreach ($pairs as $pair) {
            if ($pair->count() < 2) {
                continue;
            }

            $pair = $pair->values();

            $a = $pair->get(0);
            $b = $pair->get(1);

            $low = min($a->id, $b->id);
            $high = max($a->id, $b->id);

            $conversation = Conversation::create([
                'type' => 'direct',
            ]);

            DirectConversation::create([
                'conversation_id' => $conversation->id,
                'user_low_id' => $low,
                'user_high_id' => $high,
            ]);

            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $a->id,
            ]);

            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $b->id,
            ]);

            // Messages
            $messages = Message::factory()
                ->count(rand(3, 15))
                ->state(function () use ($conversation, $a, $b) {
                    return [
                        'conversation_id' => $conversation->id,
                        'sender_id' => rand(0, 1) ? $a->id : $b->id,
                    ];
                })
                ->create();

            $lastMessage = $messages->last();

            // États lu/reçu
            foreach ([$a, $b] as $user) {
                ConversationParticipant::where('conversation_id', $conversation->id)
                    ->where('user_id', $user->id)
                    ->update([
                        'last_received_message_id' => $lastMessage->id,
                        'last_read_message_id' => $lastMessage->id,
                    ]);
            }
        }
    }
}
