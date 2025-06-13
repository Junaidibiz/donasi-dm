<x-app-layout title="Laporan Donasi">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Laporan Donasi</h1>
            </div>
        </div>

        {{-- Filter Form dengan Dua Input Tanggal --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 p-6 mb-8">
            <form action="{{ route('donation.filter') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    {{-- Input Tanggal Awal --}}
                    <div>
                        <x-label for="date_from">DARI TANGGAL</x-label>
                        <div class="relative">
                            <input class="datepicker form-input pl-9 dark:bg-gray-800 w-full" type="text" name="date_from" id="date_from" value="{{ $date_from ?? '' }}" required placeholder="Pilih tanggal awal...">
                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16" height="16" viewBox="0 0 16 16"><path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" /><path d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Input Tanggal Akhir --}}
                    <div>
                        <x-label for="date_to">SAMPAI TANGGAL</x-label>
                        <div class="relative">
                            <input class="datepicker form-input pl-9 dark:bg-gray-800 w-full" type="text" name="date_to" id="date_to" value="{{ $date_to ?? '' }}" required placeholder="Pilih tanggal akhir...">
                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16" height="16" viewBox="0 0 16 16"><path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" /><path d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Filter --}}
                    <div class="self-end">
                        <x-button type="submit" class="w-full h-full">FILTER</x-button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Hasil Laporan --}}
        @isset($donations)
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
                <div class="p-4 font-semibold text-lg text-gray-800 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700/60">
                    Laporan dari tanggal <span class="font-bold text-damu-500">{{ \Carbon\Carbon::parse($date_from)->format('d M Y') }}</span> s/d <span class="font-bold text-damu-500">{{ \Carbon\Carbon::parse($date_to)->format('d M Y') }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full dark:text-gray-300">
                        {{-- Table header --}}
                        <thead class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                            <tr>
                                <th class="p-4 whitespace-nowrap"><div class="font-semibold text-left">NAMA DONATUR</div></th>
                                <th class="p-4 whitespace-nowrap"><div class="font-semibold text-left">CAMPAIGN</div></th>
                                <th class="p-4 whitespace-nowrap"><div class="font-semibold text-left">TANGGAL</div></th>
                                <th class="p-4 whitespace-nowrap"><div class="font-semibold text-right">JUMLAH DONASI</div></th>
                            </tr>
                        </thead>
                        {{-- Table body --}}
                        <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                            @forelse ($donations as $donation)
                                <tr>
                                    <td class="p-2 whitespace-nowrap"><div class="font-medium">{{ $donation->donatur->name }}</div></td>
                                    <td class="p-2 whitespace-nowrap"><div class="font-medium">{{ $donation->campaign->title }}</div></td>
                                    <td class="p-2 whitespace-nowrap"><div class="font-medium">{{ $donation->created_at->format('d M Y, H:i') }}</div></td>
                                    <td class="p-2 whitespace-nowrap"><div class="font-bold text-right">{{ moneyFormat($donation->amount) }}</div></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-4 text-center text-gray-500">Tidak ada data donasi pada rentang tanggal ini.</td></tr>
                            @endforelse
                        </tbody>
                        {{-- Table footer untuk total --}}
                        <tfoot class="text-sm font-bold uppercase text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <td colspan="3" class="p-2 whitespace-nowrap text-right">TOTAL DONASI</td>
                                <td class="p-2 whitespace-nowrap text-right">{{ moneyFormat($total ?? 0) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endisset

    </div>
</x-app-layout>