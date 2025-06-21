<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>
</head>

<body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400">

    <main class="bg-white dark:bg-gray-900">

        <div class="relative flex">

            <!-- Content -->
            <div class="w-full md:w-1/2">

                <div class="min-h-[100dvh] h-full flex flex-col after:flex-1">

                    <!-- Header -->
                    <div class="flex-1">
                        <div class="flex items-center center h-16 px-4 sm:px-6 lg:px-8">
                            <!-- Logo -->
                            <x-theme-toggle />
                        </div>
                    </div>

                    <div class="max-w-sm mx-auto w-full px-4 py-8">
                        {{ $slot }}
                    </div>

                </div>

            </div>

            <!-- Image -->
            <div class="bg-green-900 dark:bg-gray-900 hidden items-center md:block absolute top-0 bottom-0 right-0 md:w-1/2"
                aria-hidden="true">
                <div class="absolute right-0 top-0 z-10 w-full max-w-[250px] xl:max-w-[450px]">
                    <img src="{{ asset('images/grid-01.svg') }}" alt="grid">
                </div>
                <img class="opacity-80 dark:opacity-30 object-cover object-center w-full h-full"
                    src="{{ asset('images/Area-Lapangan-Bermain-Santri-1024x576.png') }}" width="760" height="1024"
                    alt="Authentication image" />
                <div class="absolute bottom-0 left-0 z-10 w-full max-w-[250px] rotate-180 xl:max-w-[450px]">
                    <img src="{{ asset('images/grid-01.svg') }}" alt="grid">
                </div>
            </div>

        </div>

    </main>

    @livewireScriptConfig
</body>

</html>
