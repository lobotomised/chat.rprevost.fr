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
        [$lowUser, $highUser] = User::limit(2)->orderBy('id')->get();

        $conversation = Conversation::create([
            'type' => 'direct',
        ]);

        DirectConversation::create([
            'conversation_id' => $conversation->id,
            'user_low_id' => $lowUser->id,
            'user_high_id' => $highUser->id,
        ]);

        $messages = Message::factory()
            ->count(4)
            ->state(fn () => [
                'type' => 'text',
                'body' => fake()->sentence(),
                'conversation_id' => $conversation->id,
                'sender_id' => rand(0, 1) ? $lowUser->id : $highUser->id,
            ])
            ->create();

        $lastMessage = $messages->last();

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $lowUser->id,
            'last_received_message_id' => $lastMessage->id,
            'last_read_message_id' => $lastMessage->id,
        ]);

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $highUser->id,
            'last_received_message_id' => $lastMessage->id,
            'last_read_message_id' => $lastMessage->id,
        ]);
    }
}
