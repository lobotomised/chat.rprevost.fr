<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'blocker_id',
        'blocked_id',
        'conversation_id',
    ];

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
    public function active(Builder $query): void
    {
        $query->whereNull('deleted_at');
    }

    #[Scope]
    public function activeBetween(Builder $query, int $a, int $b): void
    {
        $low = min($a, $b);
        $high = max($a, $b);

        $query->active()->where(function (Builder $q) use ($low, $high) {
            $q->where(fn (Builder $q2) => $q2->where('blocker_id', $low)->where('blocked_id', $high))
                ->orWhere(fn (Builder $q2) => $q2->where('blocker_id', $high)->where('blocked_id', $low));
        });
    }
}
