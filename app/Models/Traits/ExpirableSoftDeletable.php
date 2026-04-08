<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use LogicException;
use Throwable;

trait ExpirableSoftDeletable
{
    public function softDeleteExpiryDays(): int
    {
        return 30;
    }

    public static function purgeSoftDeletedExpired(): int
    {
        domolog('ExpirableSoftDeletable', 'Purging model [' . static::class . ']');

        $instance = new static;

        $tableName = $instance->getTable();
        $deletedAtColumnName = $instance->getDeletedAtColumn();

        if (! Schema::hasColumn($tableName, $deletedAtColumnName)) {
            throw new LogicException(
                'Attempt to forceDelete on model [' . static::class . "] (table \"$tableName\"), but the column \"$deletedAtColumnName\" does not exist."
            );
        }

        $cutoff = Carbon::now()->subDays($instance->softDeleteExpiryDays());

        $ids = [];
        $total = 0;

        static::query()
            ->onlyTrashed()
            ->where($deletedAtColumnName, '<', $cutoff)
            ->chunkById(1000, function ($models) use (&$total, &$ids) {
                $models->each(function (Model $model) use (&$total, &$ids) {
                    try {
                        Model::withoutEvents(fn () => $model->forceDelete());

                        $ids[] = $model->getKey();
                        $total++;
                    } catch (Throwable $e) {
                        $handler = app(ExceptionHandler::class);

                        if ($handler) {
                            $handler->report($e);
                        } else {
                            throw $e;
                        }
                    }
                });
            });

        domolog('ExpirableSoftDeletable', static::class . ' deleted', null, [
            'primaries key' => $ids,
        ]);

        return $total;
    }
}
