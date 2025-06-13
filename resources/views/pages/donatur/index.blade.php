<x-app-layout title="Manajemen Donatur">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            
            {{-- Left: Title --}}
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Donatur</h1>
            </div>

            {{-- Right: Actions --}}
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                {{-- Search form --}}
                <form class="relative" action="{{ route('donatur.index') }}" method="GET">
                    <input id="action-search" class="form-input w-full pl-9" type="search" name="q" value="{{ request()->query('q') }}" placeholder="Cari donatur..." />
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 ml-3 mr-2" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" /><path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300">
                    {{-- Table header --}}
                    <thead class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                        <tr>
                            <th class="p-4 whitespace-nowrap"><div class="font-semibold text-left">NAMA LENGKAP</div></th>
                            <th class="p-4 whitespace-nowrap"><div class="font-semibold text-left">EMAIL</div></th>
                            <th class="p-4 whitespace-nowrap"><div class="font-semibold text-left">TANGGAL BERGABUNG</div></th>
                        </tr>
                    </thead>
                    {{-- Table body --}}
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                        @forelse ($donaturs as $donatur)
                            <tr>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $donatur->name }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $donatur->email }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $donatur->created_at->format('d F Y') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">
                                    Data Donatur Belum Tersedia!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Pagination --}}
        <div class="mt-8">
            {{ $donaturs->links() }}
        </div>
    </div>
</x-app-layout>