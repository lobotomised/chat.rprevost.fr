<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Media;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['text', 'image', 'video']);

        return [
            'conversation_id' => Conversation::factory(),
            'sender_id' => User::factory(),
            'type' => $type,
            'body' => $type === 'text' ? $this->faker->sentence() : null,
            'media_id' => in_array($type, ['image', 'video'], true) ? Media::factory() : null,
            'edited_at' => null,
        ];
    }
}
