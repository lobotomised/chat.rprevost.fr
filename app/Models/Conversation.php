<?php

namespace App\Models;

use App\Enums\ConversationType;
use Database\Factories\ConversationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Conversation extends Model
{
    /** @use HasFactory<ConversationFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => ConversationType::class,
        ];
    }

    public function direct(): HasOne
    {
        return $this->hasOne(DirectConversation::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot(['last_received_message_id', 'last_read_message_id'])
            ->withTimestamps();
    }

    public function participantStates(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class, 'conversation_id');
    }

    public static function forUser(User $user): Collection
    {
        return Conversation::query()
            ->whereHas('participants', fn(Builder $query) => $query->where('users.id', $user->id))
            ->with(['lastMessage', 'direct'])
            ->orderByDesc(
                Conversation::select('created_at')
                    ->from('conversation_participants')
                    ->whereColumn('conversation_participants.conversation_id', 'conversations.id')
                    ->where('conversation_participants.user_id', $user->id)
            )
            ->get();
    }
}
