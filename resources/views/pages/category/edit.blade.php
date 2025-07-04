<x-app-layout title="Edit Category">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            
            {{-- Left: Title --}}
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Edit Category</h1>
            </div>

            {{-- Right: Actions --}}
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                {{-- Tombol Kembali --}}
                <a href="{{ route('category.index') }}" class="btn bg-gray-200 dark:bg-gray-700/60 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
                    Kembali
                </a>
            </div>

        </div>

        {{-- Card --}}
        {{-- Di sini perubahannya: rounded-md diubah menjadi rounded-xl --}}
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl border border-gray-200 dark:border-gray-700/60 p-6">
            
            {{-- Form --}}
            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">

                    {{-- Nama Kategori --}}
                    <div>
                        <x-label for="name">Nama Kategori <span class="text-red-500">*</span></x-label>
                        <x-input type="text" name="name" id="name" class="w-full" value="{{ old('name', $category->name) }}" required />
                        @error('name')
                            <div class="text-xs mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <x-label for="image">Gambar (Opsional)</x-label>
                        <div class="mt-2 mb-2">
                            <img src="{{ $category->image }}" class="w-20 h-20 object-cover rounded-md">
                        </div>
                        <x-input type="file" name="image" id="image" class="w-full" />
                        <div class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar.</div>
                         @error('image')
                            <div class="text-xs mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end mt-6">
                    <x-button type="submit" class="bg-blue-500 hover:bg-blue-600">
                        Update Kategori
                    </x-button>
                </div>
            </form>

        </div>

    </div>
</x-app-layout>