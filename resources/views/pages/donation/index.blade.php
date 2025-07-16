<x-app-layout title="Laporan Donasi">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Laporan Donasi</h1>
            </div>
        </div>

        {{-- Filter Form (Menggunakan Komponen Livewire) --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 p-6 mb-8">
            {{-- Memanggil komponen Livewire untuk form filter --}}
            @livewire('donation-filter', ['donations' => $donations ?? null, 'total' => $total ?? 0])
        </div>

        {{-- Tabel Hasil Laporan (Logika ini akan dipindahkan ke dalam komponen Livewire) --}}
        {{-- Anda bisa membiarkan bagian ini kosong atau menghapusnya, karena tabel akan dirender oleh Livewire --}}
        {{-- Namun, untuk sementara kita biarkan di sini jika ingin ada tampilan awal sebelum filter --}}
        @isset($donations)
            @if ($donations->isNotEmpty())
                <div
                    class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
                    <div
                        class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 dark:border-gray-700/60">
                        <span class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-2 sm:mb-0">
                            Hasil Laporan ({{ $donations->count() }} Transaksi)
                        </span>
                        <div class="flex space-x-2">
                            {{-- Tombol Ekspor Excel dengan Ikon --}}
                            <a href="{{ route('donation.export.excel', request()->query()) }}"
                                class="btn bg-green-500 hover:bg-green-600 text-white flex items-center">
                                <svg class="w-4 h-4 fill-current mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M15 1H1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM9 12h3l-4 4-4-4h3V4h2v8z" />
                                </svg>
                                <span>Excel</span>
                            </a>

                            {{-- Tombol Ekspor PDF dengan Ikon --}}
                            <a href="{{ route('donation.export.pdf', request()->query()) }}"
                                class="btn bg-red-500 hover:bg-red-600 text-white flex items-center">
                                <svg class="w-4 h-4 fill-current mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M7 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7L9 0H7zM2 2h4v5h5v9H2V2z" />
                                </svg>
                                <span>PDF</span>
                            </a>
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
                                @foreach ($donations as $donation)
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
                                @endforeach
                            </tbody>
                            <tfoot
                                class="text-sm font-bold uppercase text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-900">
                                <tr>
                                    <td colspan="3" class="p-2 whitespace-nowrap text-right">TOTAL</td>
                                    <td class="p-2 whitespace-nowrap text-right">{{ moneyFormat($total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif
        @endisset

    </div>
</x-app-layout>
