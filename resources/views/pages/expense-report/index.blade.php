<x-app-layout title="Laporan Pengeluaran">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Laporan Pengeluaran</h1>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                {{-- Add Report button --}}
                <a href="{{ route('expense-reports.create') }}" class="btn bg-damu-500 hover:bg-damu-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Tambah Laporan</span>
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300">
                    {{-- Table header --}}
                    <thead
                        class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                        <tr>
                            <th class="py-4 px-4 whitespace-nowrap">
                                <div class="font-semibold text-left">CAMPAIGN</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-left">JUDUL LAPORAN</div>
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
                    {{-- Table body --}}
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                        @forelse ($expenseReports as $report)
                            <tr>
                                <td class="p-2 px-5 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $report->campaign->title }}</div>
                                </td>
                                <td class="p-2 px-1 whitespace-nowrap max-w-sm truncate">
                                    <div>{{ $report->title }}</div>
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
