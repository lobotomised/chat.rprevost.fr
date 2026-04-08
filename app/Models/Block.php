<?php

namespace App\Models;

use Database\Factories\BlockFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    /** @use HasFactory<BlockFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function blocker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'blocker_id');
    }

    public function blocked(): BelongsTo
    {
        return $this->belongsTo(User::class, 'blocked_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->whereNull('deleted_at');
    }

    #[Scope]
    protected function activeBetween(Builder $query, int $a, int $b): void
    {
        $low = min($a, $b);
        $high = max($a, $b);

        $query->active()->where(function (Builder $q) use ($low, $high) {
            $q->where(fn (Builder $q2) => $q2->where('blocker_id', $low)->where('blocked_id', $high))
                ->orWhere(fn (Builder $q2) => $q2->where('blocker_id', $high)->where('blocked_id', $low));
        });
    }
}
