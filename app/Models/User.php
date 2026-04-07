<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;
    use HasPushSubscriptions;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function inviteLink(): HasOne|User
    {
        return $this->hasOne(InviteLink::class, 'user_id');
    }

    public function sentMessages(): User|HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function uploadedMedia(): User|HasMany
    {
        return $this->hasMany(Media::class, 'uploader_id');
    }

    public function blocksGiven(): User|HasMany
    {
        return $this->hasMany(Block::class, 'blocker_id');
    }

    public function blocksReceived(): User|HasMany
    {
        return $this->hasMany(Block::class, 'blocked_id');
    }

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot(['last_received_message_id', 'last_read_message_id'])
            ->withTimestamps();
    }

    public function directConversationsAsLow(): User|HasMany
    {
        return $this->hasMany(DirectConversation::class, 'user_low_id');
    }

    public function directConversationsAsHigh(): User|HasMany
    {
        return $this->hasMany(DirectConversation::class, 'user_high_id');
    }

    public function isBlockedWith(User $other): bool
    {
        return Block::activeBetween($this->id, $other->id)->exists();
    }

}
