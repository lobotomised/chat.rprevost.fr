<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Traits\ExpirableSoftDeletable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

final class PurgeExpiredSoftDeletedCommand extends Command
{
    protected $signature = 'app:model:purge-expired-soft-deleted
                                    {--model=* : Class names of the models to purge}';

    protected $description = 'Purge expired softdeleted models';

    public function __construct()
    {
        parent::__construct();

        Context::add('trace_id', Str::uuid()->toString());
    }

    public function handle(): int
    {
        $this->getModelsFromOption()
            ->merge($this->getModelsFromApp())
            ->filter(fn (string $model) => $this->filterSoftDeletableWithExpiryModels($model))
            ->whenEmpty(fn () => $this->info('No expired soft deleted models found. Ending command'))
            ->whenNotEmpty(function (Collection $models) {
                $this->info(sprintf('Found %d expirable models. Starting to purge them.', $models->count()));

                $total = $models->sum(function (string $model) {
                    $count_deleted = (new $model)->purgeSoftDeletedExpired();
                    $this->info(sprintf('%s %s deleted', $count_deleted, $model));

                    return $count_deleted;
                });

                $this->info("$total models deleted.");
            });

        return self::SUCCESS;
    }

    public function filterSoftDeletableWithExpiryModels(string $model): bool
    {
        $ref = new ReflectionClass($model);

        if (! $ref->isSubclassOf(Model::class)) {
            return false;
        }

        if (! in_array(ExpirableSoftDeletable::class, class_uses_recursive($model))) {
            return false;
        }

        return true;
    }

    public function getModelsFromOption(): Collection
    {
        $models = $this->option('model');

        return new Collection($models)
            ->filter(fn (string $model) => class_exists($model))
            ->values();
    }

    public function getModelsFromApp(): Collection
    {
        $namespace = "App\Models";

        return new Collection(File::files(app_path('Models')))
            ->map(fn (SplFileInfo $file) => $namespace . '\\' . $file->getFilenameWithoutExtension())
            ->filter(fn (string $model) => class_exists($model))
            ->values();
    }
}
