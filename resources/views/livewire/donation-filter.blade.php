<form action="{{ route('donation.index') }}" method="GET">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Filter Kategori --}}
        <div>
            <x-label for="category_id">KATEGORI</x-label>
            <select wire:model.live="selectedCategory" name="category_id" id="category_id" class="form-select w-full">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Campaign (Dinamis) --}}
        <div>
            <x-label for="campaign_id">CAMPAIGN</x-label>
            <select wire:model="selectedCampaign" name="campaign_id" id="campaign_id" class="form-select w-full">
                <option value="">Semua Campaign</option>
                @if ($campaigns->count() > 0)
                    @foreach ($campaigns as $campaign)
                        <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Input Tanggal Awal --}}
        <div wire:ignore>
            <x-label for="date_from">DARI TANGGAL</x-label>
            <div class="relative">
                <input class="datepicker form-input pl-9 dark:bg-gray-800 w-full" type="text" name="date_from"
                    wire:model="date_from" placeholder="Pilih tanggal...">
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16" height="16"
                        viewBox="0 0 16 16">
                        <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                        <path
                            d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Input Tanggal Akhir --}}
        <div wire:ignore>
            <x-label for="date_to">SAMPAI TANGGAL</x-label>
            <div class="relative">
                <input class="datepicker form-input pl-9 dark:bg-gray-800 w-full" type="text" name="date_to"
                    wire:model="date_to" placeholder="Pilih tanggal...">
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16" height="16"
                        viewBox="0 0 16 16">
                        <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                        <path
                            d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                    </svg>
                </div>
            </div>
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
