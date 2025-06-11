<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Menggunakan warna latar belakang 'damu' --}}
        <div class="relative bg-damu-200 dark:bg-damu-500/20 p-4 sm:p-6 rounded-sm overflow-hidden mb-8">

            <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
                <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                        <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                        <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                        {{-- Menggunakan warna gradient 'damu' --}}
                        <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                            <stop stop-color="#c2db93" offset="0%" />  {{-- damu-300 --}}
                            <stop stop-color="#89b61e" offset="100%" /> {{-- damu-500 --}}
                        </linearGradient>
                        <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                            <stop stop-color="#5f8011" offset="0%" />   {{-- damu-700 --}}
                            <stop stop-color="#89b61e" stop-opacity="0" offset="100%" /> {{-- damu-500 --}}
                        </linearGradient>
                    </defs>
                    <g fill="none" fill-rule="evenodd">
                        <g transform="rotate(64 36.592 105.604)">
                            <mask id="welcome-d" fill="#fff">
                                <use xlink:href="#welcome-a" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z" />
                        </g>
                        <g transform="rotate(-51 91.324 -105.372)">
                            <mask id="welcome-f" fill="#fff">
                                <use xlink:href="#welcome-e" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z" />
                        </g>
                        <g transform="rotate(44 61.546 392.623)">
                            <mask id="welcome-h" fill="#fff">
                                <use xlink:href="#welcome-g" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z" />
                        </g>
                    </g>
                </svg>
            </div>

            <div class="relative">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold mb-1">Selamat Datang! 👋</h1>
                {{-- Menggunakan warna teks 'damu' --}}
                <p class="dark:text-damu-200">Ini adalah halaman awal Anda. Mulailah membangun aplikasi Anda dari sini.</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Mulai di sini</h2>
            <p>Anda bisa mulai menambahkan komponen dan kode Anda di dalam area ini.</p>
        </div>

    </div>
</x-app-layout>