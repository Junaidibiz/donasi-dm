<x-app-layout title="Laporan Donasi">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Laporan Donasi</h1>
            </div>
        </div>

        {{-- Form Filter Terpadu --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 p-6 mb-8">
            <form action="{{ route('donation.index') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    {{-- Input Tanggal Awal --}}
                    <div>
                        <x-label for="date_from">DARI TANGGAL</x-label>
                        <div class="relative">
                            <input class="datepicker form-input pl-9 dark:bg-gray-800 w-full" type="text"
                                name="date_from" value="{{ request()->input('date_from') }}"
                                placeholder="Pilih tanggal...">
                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16"
                                    height="16" viewBox="0 0 16 16">
                                    <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                                    <path
                                        d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Input Tanggal Akhir --}}
                    <div>
                        <x-label for="date_to">SAMPAI TANGGAL</x-label>
                        <div class="relative">
                            <input class="datepicker form-input pl-9 dark:bg-gray-800 w-full" type="text"
                                name="date_to" value="{{ request()->input('date_to') }}" placeholder="Pilih tanggal...">
                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16"
                                    height="16" viewBox="0 0 16 16">
                                    <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                                    <path
                                        d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Kategori --}}
                    <div>
                        <x-label for="category_id">KATEGORI</x-label>
                        <select name="category_id" id="category_id" class="form-select w-full">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request()->input('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Campaign --}}
                    <div>
                        <x-label for="campaign_id">CAMPAIGN</x-label>
                        <select name="campaign_id" id="campaign_id" class="form-select w-full">
                            <option value="">Semua Campaign</option>
                            @foreach ($campaigns as $campaign)
                                <option value="{{ $campaign->id }}" @selected(request()->input('campaign_id') == $campaign->id)>
                                    {{ $campaign->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end items-center mt-6">
                    <button type="submit" class="btn bg-damu-500 hover:bg-damu-600 text-white">FILTER</button>
                </div>
            </form>
        </div>

        @isset($donations)
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
                <div
                    class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 dark:border-gray-700/60">
                    <span class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-2 sm:mb-0">
                        Hasil Laporan ({{ $donations->count() }} Transaksi)
                    </span>
                    <div class="flex space-x-2">
                        <a href="{{ route('donation.export.excel', request()->query()) }}"
                            class="btn bg-green-500 hover:bg-green-600 text-white">Excel</a>
                        <a href="{{ route('donation.export.pdf', request()->query()) }}"
                            class="btn bg-red-500 hover:bg-red-600 text-white">PDF</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full dark:text-gray-300">
                        <thead
                            class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                            <tr>
                                <th class="p-4 whitespace-nowrap">
                                    <div class="font-semibold text-left">NAMA DONATUR</div>
                                </th>
                                <th class="p-4 whitespace-nowrap">
                                    <div class="font-semibold text-left">CAMPAIGN</div>
                                </th>
                                <th class="p-4 whitespace-nowrap">
                                    <div class="font-semibold text-left">TANGGAL</div>
                                </th>
                                <th class="p-4 whitespace-nowrap">
                                    <div class="font-semibold text-right">JUMLAH DONASI</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                            @forelse ($donations as $donation)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="font-medium">{{ $donation->donatur->name }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="font-medium">{{ $donation->campaign->title }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="font-medium">{{ $donation->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="font-bold text-right">{{ moneyFormat($donation->amount) }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada data donasi yang
                                        cocok dengan kriteria filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if (count($donations) > 0)
                            <tfoot
                                class="text-sm font-bold uppercase text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-900">
                                <tr>
                                    <td colspan="3" class="p-2 whitespace-nowrap text-right">TOTAL</td>
                                    <td class="p-2 whitespace-nowrap text-right">{{ moneyFormat($total ?? 0) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        @endisset
    </div>

    @push('scripts')
        <script>
            // Inisialisasi Flatpickr secara lokal untuk halaman ini saja dengan mode single
            flatpickr('.datepicker-single', {
                mode: "single",
                static: true,
                monthSelectorType: "static",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        </script>
    @endpush
</x-app-layout>
