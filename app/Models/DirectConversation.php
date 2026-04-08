<?php

namespace App\Models;

use Database\Factories\DirectConversationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['conversation_id', 'user_low_id', 'user_high_id'])]
class DirectConversation extends Model
{
    /** @use HasFactory<DirectConversationFactory> */
    use HasFactory;

    protected $primaryKey = 'conversation_id';
    public $incrementing = false;
    protected $keyType = 'int';

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function userLow(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_low_id');
    }

    public function userHigh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_high_id');
    }

}
