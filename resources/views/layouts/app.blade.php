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
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    @stack('styles')
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

    @if (!request()->routeIs('demo') && !request()->routeIs('documents.show'))
        <x-app-footer />
    @endif

    {{-- <script src="https://unpkg.com/pdfjs-dist@4.0.269/build/pdf.mjs" type="module"></script> --}}
    {{-- <script src="https://unpkg.com/pdfjs-dist@4.0.269/web/pdf_viewer.mjs" type="module"></script> --}}


    {{-- <script src="/js/pdfobject.js"></script> --}}
    {{-- <script src="https://unpkg.com/pdfjs-dist@4.0.269/build/pdf.mjs"></script> --}}
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
    </script>

  
    @stack('scripts')

</body>

</html>
