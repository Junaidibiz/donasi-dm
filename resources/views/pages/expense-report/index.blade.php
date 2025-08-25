<x-app-layout title="Laporan Pengeluaran">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Laporan Pengeluaran</h1>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                {{-- Tombol Export Excel --}}
                <a href="{{ route('expense-reports.excel', request()->query()) }}"
                    class="btn bg-emerald-500 hover:bg-emerald-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 1H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V2a1 1 0 00-1-1zM9 12H7V8l-2 2-1-1 3-3 3 3-1 1-2-2v4z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Export Excel</span>
                </a>
                {{-- Tombol Export PDF --}}
                <a href="{{ route('expense-reports.pdf', request()->query()) }}"
                    class="btn bg-rose-500 hover:bg-rose-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 1H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V2a1 1 0 00-1-1zM9 12H7V8l-2 2-1-1 3-3 3 3-1 1-2-2v4z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Export PDF</span>
                </a>
                {{-- Tombol Tambah Laporan --}}
                <a href="{{ route('expense-reports.create') }}" class="btn bg-damu-500 hover:bg-damu-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Tambah Laporan</span>
                </a>
            </div>
        </div>

        {{-- Filter Form --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 p-6 mb-8">
            <form action="{{ route('expense-reports.index') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    {{-- Filter Kategori --}}
                    <div>
                        <x-label for="category_id">KATEGORI</x-label>
                        <select name="category_id" id="category_id" class="form-select w-full"
                            onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request()->query('category_id') == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Campaign (Dinamis) --}}
                    <div>
                        <x-label for="campaign_id">CAMPAIGN</x-label>
                        <select name="campaign_id" id="campaign_id" class="form-select w-full">
                            <option value="">Semua Campaign</option>
                            @foreach ($campaigns as $campaign)
                                <option value="{{ $campaign->id }}" @selected(request()->query('campaign_id') == $campaign->id)>{{ $campaign->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Input Tanggal Awal --}}
                    <div>
                        <x-label for="date_from">DARI TANGGAL</x-label>
                        <x-input type="date" name="date_from" id="date_from" class="w-full" :value="request()->query('date_from')" />
                    </div>

                    {{-- Input Tanggal Akhir --}}
                    <div>
                        <x-label for="date_to">SAMPAI TANGGAL</x-label>
                        <x-input type="date" name="date_to" id="date_to" class="w-full" :value="request()->query('date_to')" />
                    </div>
                </div>
                <div class="flex justify-end items-center mt-6">
                    <button type="submit" class="btn bg-damu-500 hover:bg-damu-600 text-white flex items-center">
                        <svg class="w-4 h-4 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M19.414,8.586l-2.007-2.008C17.228,6.398,17,6.185,17,5.949V4c0-0.553-0.447-1-1-1H4C3.447,3,3,3.447,3,4v1.949c0,0.236-0.228,0.449-0.407,0.637l-2.008,2.008C0.228,8.944,0,9.158,0,9.394V10c0,0.553,0.447,1,1,1h18c0.553,0,1-0.447,1-1V9.394C20,9.158,19.772,8.944,19.414,8.586z" />
                            <path
                                d="M15,12H5c-0.553,0-1,0.447-1,1v2c0,0.553,0.447,1,1,1h10c0.553,0,1-0.447,1-1v-2C16,12.447,15.553,12,15,12z" />
                        </svg>
                        <span>FILTER</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300">
                    <thead
                        class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                        <tr>
                            <th class="py-4 px-4 whitespace-nowrap">
                                <div class="font-semibold text-left">CAMPAIGN</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-left">DESKRIPSI</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-left">JUMLAH</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-left">TANGGAL</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-center">AKSI</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                        @forelse ($expenseReports as $report)
                            <tr>
                                <td class="p-2 px-5 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $report->campaign->title }}</div>
                                </td>
                                <td class="p-2 px-1 whitespace-nowrap max-w-sm truncate">
                                    <div>{{ Str::limit(strip_tags($report->description), 50) }}</div>
                                </td>
                                <td class="p-2 px-1 whitespace-nowrap">
                                    <div class="font-medium text-emerald-500">{{ moneyFormat($report->amount) }}</div>
                                </td>
                                <td class="p-2 px-1 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($report->expense_date)->format('d F Y') }}</div>
                                </td>
                                <td class="p-2 px-1 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('expense-reports.edit', $report->id) }}"
                                            class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 rounded-full p-1.5">
                                            <span class="sr-only">Edit</span>
                                            <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path class="fill-current"
                                                    d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('expense-reports.destroy', $report->id) }}"
                                            method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-rose-500 hover:text-rose-600 rounded-full p-1.5"
                                                type="submit">
                                                <span class="sr-only">Hapus</span>
                                                <svg class="w-4 h-4" viewBox="0 0 16 16"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path class="fill-current" d="M5 7h2v6H5V7zm4 0h2v6H9V7z"></path>
                                                    <path class="fill-current" d="M1 3h14v2H1z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    Data Laporan Pengeluaran Belum Tersedia!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $expenseReports->links() }}
        </div>
    </div>
</x-app-layout>
