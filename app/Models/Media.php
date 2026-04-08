<?php

namespace App\Models;

use App\Models\Traits\ExpirableSoftDeletable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'uploader_id',
    'type',       // image|video
    'path',
    'thumb_path',
    'mime',
    'size_bytes',
])]
class Media extends Model
{
    use HasFactory;
    use ExpirableSoftDeletable;

    protected $table = 'media';

    protected function casts(): array
    {
        return [
            'size_bytes' => 'int',
            'deleted_at' => 'datetime',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'media_id');
    }
}
