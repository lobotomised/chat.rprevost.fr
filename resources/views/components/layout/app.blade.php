<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="/static/alpine-3.15.11.min.js"></script>
    <script src="/static/htmx-2.0.8.min.js"></script>
</head>
<body>

<div class="h-screen w-screen overflow-hidden bg-gray-100">
    <div class="flex h-full">

        {{-- Colonne gauche : conversations --}}
        <aside class="w-80 border-r border-gray-200 bg-white">
            {{ $sidebar ?? '' }}
        </aside>

        {{-- Zone principale --}}
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</div>

</body>
</html>
