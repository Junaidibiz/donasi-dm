<x-app-layout title="Kelola Doa Donatur">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Doa Para Donatur</h1>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300">
                    <thead
                        class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                        <tr>
                            <th class="py-4 px-4 whitespace-nowrap">
                                <div class="font-semibold text-left">DONATUR</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-left">DOA</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-left">CAMPAIGN</div>
                            </th>
                            <th class="py-4 px-1 whitespace-nowrap">
                                <div class="font-semibold text-center">TAMPILKAN PUBLIK</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                        @forelse ($donations as $donation)
                            <tr>
                                <td class="p-2 px-5 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $donation->donatur->name }}</div>
                                </td>
                                <td class="p-2 px-1">
                                    <div class="max-w-xs truncate" title="{{ $donation->pray }}">{{ $donation->pray }}
                                    </div>
                                </td>
                                <td class="p-2 px-1 whitespace-nowrap">
                                    <div class="text-gray-600 dark:text-gray-400 max-w-xs truncate"
                                        title="{{ $donation->campaign->title }}">{{ $donation->campaign->title }}</div>
                                </td>
                                <td class="p-2 px-1 whitespace-nowrap text-center">
                                    <form action="{{ route('prayers.update', $donation->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @if ($donation->is_pray_visible)
                                            <button type="submit"
                                                class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white">YA</button>
                                        @else
                                            <button type="submit"
                                                class="btn-sm bg-gray-400 hover:bg-gray-500 text-white">TIDAK</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">Belum ada doa yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-8">{{ $donations->links() }}</div>
    </div>
</x-app-layout>
