<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLocale
{
    private array $supported = ['en', 'fr'];

    private string $default = 'en';

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = auth()->check() && auth()->user()->locale
            ? auth()->user()->locale
            : $request->getPreferredLanguage($this->supported) ?? $this->default;

        if (! in_array($locale, $this->supported, true)) {
            $locale = $this->default;
        }

        App::setLocale($locale);

        return $next($request);
    }
}
