<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    public function direct(): HasOne
    {
        return $this->hasOne(DirectConversation::class, 'conversation_id');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot(['last_received_message_id', 'last_read_message_id'])
            ->withTimestamps();
    }

    public function participantStates(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class, 'conversation_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'conversation_id')->latestOfMany();
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class, 'conversation_id');
    }
}
