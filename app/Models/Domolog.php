<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use LogicException;

final class Domolog extends Model
{
    use HasFactory;
    use Prunable;

    protected function casts(): array
    {
        return [
            'context' => 'array',
        ];
    }

    // @phpstan-ignore-next-line
    public function prunable(): Builder
    {
        return Domolog::query()->where('created_at', '<=', now()->subDays(60));
    }

    /**
     * @return Attribute<string, never>
     */
    public function hostname(): Attribute
    {
        return new Attribute(
            get: fn () => gethostbyaddr($this->ip),
            set: fn () => throw new LogicException('Hostname cannot be set')
        );
    }

    public function log(string $type, string $message, int|string|null $model = null, array $context = []): void
    {
        Domolog::query()->create([
            'type' => Str::substr($type, 0, 255),
            'message' => Str::substr($message, 0, 255),
            'model' => $model,
            'context' => $this->sanitize(Context::all() + $context),
            'trace' => Context::get('trace_id'),
            'user' => auth()->check() ? auth()->user()->name : 'Anonyme',
            'stack_trace' => $this->getStackTrace(),
            'method' => php_sapi_name() === 'cli' ? 'CLI' : request()->method(),
            'request_uri' => Str::substr(request()->getRequestUri(), 0, 255),
            'referer' => Str::substr(request()->headers->get('referer') ?? '', 0, 255),
            'ip' => request()->ip(),
        ]);
    }

    private function getStackTrace(): string
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 512);

        $formatted = array_map(fn ($item) => isset($item['file'], $item['line']) ? "{$item['file']}:{$item['line']}" : '[internal function]', $trace);

        return implode("\n", $formatted);
    }

    public function sanitize(array $array): array
    {
        $keysToRemove = [
            'old_password',
            'current_password',
            'password',
            'password_confirmation',
            'remember_token',
        ];

        $result = [];

        foreach ($array as $key => $value) {
            if (is_string($key) && in_array(mb_strtolower($key), $keysToRemove, true)) {
                continue;
            }

            $result[$key] = is_array($value) ? $this->sanitize($value) : $value;
        }

        unset($result['trace_id']);

        return $result;
    }
}
