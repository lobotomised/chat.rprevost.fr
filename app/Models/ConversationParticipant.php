<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConversationParticipant extends Model
{
    public $incrementing = false;
    protected $primaryKey = null;
    protected $keyType = 'int';

    protected $fillable = [
        'conversation_id',
        'user_id',
        'last_received_message_id',
        'last_read_message_id',
    ];

    protected function casts(): array
    {
        return [
            'conversation_id' => 'int',
            'user_id' => 'int',
            'last_received_message_id' => 'int',
            'last_read_message_id' => 'int',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lastReceivedMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_received_message_id');
    }

    public function lastReadMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_read_message_id');
    }

    #[Scope]
    public function forUserInConversation($query, int $conversationId, int $userId): void
    {
        $query->where('conversation_id', $conversationId)
            ->where('user_id', $userId);
    }
}
