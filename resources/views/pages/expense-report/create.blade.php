<x-app-layout title="Tambah Laporan Pengeluaran">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Tambah Laporan Pengeluaran</h1>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 p-6">
            <form action="{{ route('expense-reports.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <x-label for="campaign_id">Pilih Campaign <span class="text-rose-500">*</span></x-label>
                        <select id="campaign_id" class="form-select w-full" name="campaign_id" required>
                            <option value="">Pilih sebuah campaign</option>
                            @foreach ($campaigns as $campaign)
                                <option value="{{ $campaign->id }}" @selected(old('campaign_id') == $campaign->id)>{{ $campaign->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('campaign_id')
                            <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label for="description">Deskripsi <span class="text-rose-500">*</span></x-label>
                        <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                        <trix-editor input="description" class="trix-content"></trix-editor>
                        @error('description')
                            <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label for="amount">Jumlah (Rp) <span class="text-rose-500">*</span></x-label>
                            <x-input id="amount" class="w-full" type="number" name="amount" :value="old('amount')"
                                required />
                            @error('amount')
                                <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <x-label for="expense_date">Tanggal Pengeluaran <span
                                    class="text-rose-500">*</span></x-label>
                            <x-input id="expense_date" class="w-full" type="date" name="expense_date"
                                :value="old('expense_date')" required />
                            @error('expense_date')
                                <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="btn bg-damu-500 hover:bg-damu-600 text-white">Simpan Laporan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
