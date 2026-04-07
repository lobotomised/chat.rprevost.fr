<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DirectConversation extends Model
{
    protected $primaryKey = 'conversation_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'conversation_id',
        'user_low_id',
        'user_high_id',
    ];

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
