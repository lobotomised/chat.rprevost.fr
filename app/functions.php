<?php

declare(strict_types=1);

use App\Models\Domolog;

if (! function_exists('domolog')) {
    function domolog(string $type, string $message, int|string|null $model = null, array $context = []): void
    {
        /** @var Domolog $domolog */
        $domolog = app(Domolog::class);

        $domolog->log($type, $message, $model, $context);
    }
}
