<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\LazyLoadingViolationException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Model::handleLazyLoadingViolationUsing(function (Model $model, string $relation) {
            $this->app->isProduction()
                ? domolog('php', 'Lazy loading on model', null, ['relation' => $relation, 'class' => $model::class])
                : throw new LazyLoadingViolationException($model, $relation);
        });
        Model::preventLazyLoading();
    }
}
