<?php

namespace Database\Factories;

use App\Models\ConversationParticipant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ConversationParticipant>
 */
class ConversationParticipantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'last_received_message_id' => null,
            'last_read_message_id' => null,
        ];
    }
}
