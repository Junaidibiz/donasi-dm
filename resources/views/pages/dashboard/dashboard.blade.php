<x-app-layout title="Dashboard">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="relative bg-damu-200 dark:bg-damu-900/50 p-4 sm:p-6 rounded-xl overflow-hidden mb-8">
            <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
                <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                        <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                        <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                        <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                            <stop stop-color="#c2db93" offset="0%" />
                            <stop stop-color="#89b61e" offset="100%" />
                        </linearGradient>
                        <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                            <stop stop-color="#5f8011" offset="0%" />
                            <stop stop-color="#89b61e" stop-opacity="0" offset="100%" />
                        </linearGradient>
                    </defs>
                    <g fill="none" fill-rule="evenodd">
                        <g transform="rotate(64 36.592 105.604)"><mask id="welcome-d" fill="#fff"><use xlink:href="#welcome-a" /></mask><use fill="url(#welcome-b)" xlink:href="#welcome-a" /><path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z" /></g>
                        <g transform="rotate(-51 91.324 -105.372)"><mask id="welcome-f" fill="#fff"><use xlink:href="#welcome-e" /></mask><use fill="url(#welcome-b)" xlink:href="#welcome-e" /><path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z" /></g>
                        <g transform="rotate(44 61.546 392.623)"><mask id="welcome-h" fill="#fff"><use xlink:href="#welcome-g" /></mask><use fill="url(#welcome-b)" xlink:href="#welcome-g" /><path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z" /></g>
                    </g>
                </svg>
            </div>
            <div class="relative">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="dark:text-damu-200">Berikut adalah ringkasan untuk aplikasi donasi Anda.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

            <div class="flex items-center p-5 bg-white dark:bg-gray-800 shadow-lg rounded-xl">
                <div class="flex-shrink-0 flex justify-center items-center w-16 h-16 rounded-full bg-damu-100 dark:bg-damu-500/20">
                    <svg class="w-8 h-8 text-damu-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $donaturs }}</h4>
                    <div class="text-gray-500 dark:text-gray-400">DONATUR</div>
                </div>
            </div>

            <div class="flex items-center p-5 bg-white dark:bg-gray-800 shadow-lg rounded-xl">
                <div class="flex-shrink-0 flex justify-center items-center w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-500/20">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $campaigns }}</h4>
                    <div class="text-gray-500 dark:text-gray-400">CAMPAIGN</div>
                </div>
            </div>

            <div class="flex items-center p-5 bg-white dark:bg-gray-800 shadow-lg rounded-xl">
                <div class="flex-shrink-0 flex justify-center items-center w-16 h-16 rounded-full bg-pink-100 dark:bg-pink-500/20">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Rp {{ number_format($donations, 0, ',', '.') }}</h4>
                    <div class="text-gray-500 dark:text-gray-400">DONASI TERKUMPUL</div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>