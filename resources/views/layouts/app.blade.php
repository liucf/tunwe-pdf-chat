<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @isset($style)
        {{ $style }}
    @endisset
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    {{-- <x-app-header /> --}}
    <livewire:layout.navigation />


    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main class="space-y-40">
        {{ $slot }}
    </main>

    @if (!request()->routeIs('demo'))
        <x-app-footer />
    @endif

    <script src="/js/pdfobject.js"></script>
    @isset($scripts)
        {{ $scripts }}
    @endisset
</body>

</html>
