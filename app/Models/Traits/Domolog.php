<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait Domolog
{
    public static function bootDomolog(): void
    {
        static::created(fn (Model $model) => $model->domologCreated()); // @phpstan-ignore method.notFound
        static::updated(fn (Model $model) => $model->domologUpdated($model->getOriginal())); // @phpstan-ignore method.notFound
        static::deleted(fn (Model $model) => $model->domologDeleted()); // @phpstan-ignore method.notFound
    }

    private function domologCreated(): void
    {
        domolog(self::class, "Création d'un model", $this->id, $this->toArray());
    }

    /**
     * @param  array<mixed, mixed>  $originalData
     */
    private function domologUpdated(array $originalData): void
    {
        domolog(self::class, "Mise à jour d'un model", $this->id, ['originalData' => $originalData, 'attribues' => $this->toArray()]);
    }

    private function domologDeleted(): void
    {
        domolog(self::class, 'Suppression du model', $this->id, $this->toArray());
    }
}
