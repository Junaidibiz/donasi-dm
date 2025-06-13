<x-app-layout title="Tambah Campaign">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Tambah Campaign Baru</h1>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('campaign.index') }}" class="btn bg-gray-200 dark:bg-gray-700/60 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 p-6">
            <form action="{{ route('campaign.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        <div>
                            <x-label for="title">JUDUL CAMPAIGN <span class="text-red-500">*</span></x-label>
                            <x-input type="text" name="title" id="title" class="w-full" value="{{ old('title') }}" required placeholder="Judul Campaign" />
                            @error('title') <div class="text-xs mt-1 text-red-500">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <x-label for="category_id">KATEGORI <span class="text-red-500">*</span></x-label>
                            <select id="category_id" name="category_id" class="form-select w-full">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="text-xs mt-1 text-red-500">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <x-label for="image">GAMBAR <span class="text-red-500">*</span></x-label>
                            <x-input type="file" name="image" id="image" class="w-full" />
                            @error('image') <div class="text-xs mt-1 text-red-500">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-4">
                        <div>
                            <x-label for="target_donation">TARGET DONASI <span class="text-red-500">*</span></x-label>
                            <x-input type="number" name="target_donation" id="target_donation" class="w-full" value="{{ old('target_donation') }}" required placeholder="Contoh: 10000000" />
                            @error('target_donation') <div class="text-xs mt-1 text-red-500">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <x-label for="max_date">TANGGAL BERAKHIR <span class="text-red-500">*</span></x-label>
                            <div class="relative">
                                {{-- PERUBAHAN 1: Menggunakan kembali kelas 'datepicker' --}}
                                <input class="datepicker form-input pl-9 dark:bg-gray-800 w-full" type="text" name="max_date" id="max_date" value="{{ old('max_date') }}" required placeholder="Pilih tanggal...">
                                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                    <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16" height="16" viewBox="0 0 16 16"><path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" /><path d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" /></svg>
                                </div>
                            </div>
                             @error('max_date') <div class="text-xs mt-1 text-red-500">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    {{-- Label sekarang menargetkan editor, bukan input tersembunyi --}}
                    <x-label for="trix-description-editor">DESKRIPSI <span class="text-red-500">*</span></x-label>
                    <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                    {{-- Editor diberi id yang sesuai dengan label --}}
                    <trix-editor id="trix-description-editor" input="description" class="form-input"></trix-editor>
                    @error('description') <div class="text-xs mt-1 text-red-500">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end mt-6">
                    <x-button type="submit" class="bg-damu-500 hover:bg-damu-600">
                        Simpan Campaign
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@push('scripts')
    <script>
        // ... (skrip flatpickr Anda yang sudah ada) ...
        
        // --- SCRIPT UNTUK UPLOAD GAMBAR TRIX ---
        document.addEventListener("trix-attachment-add", function(event) {
            var attachment = event.attachment;
            if (attachment.file) {
                uploadFile(attachment);
            }
        });

        document.addEventListener("trix-attachment-remove", function(event) {
            var attachment = event.attachment;
            if (attachment.file) {
                removeFile(attachment);
            }
        });

        function uploadFile(attachment) {
            var file = attachment.file;
            var form = new FormData;
            form.append("Content-Type", file.type);
            form.append("attachment", file);

            var xhr = new XMLHttpRequest;
            xhr.open("POST", "{{ route('trix.upload') }}", true);
            xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("meta[name='csrf-token']").content);

            xhr.upload.onprogress = function(event) {
                var progress = event.loaded / event.total * 100;
                attachment.setUploadProgress(progress);
            }

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    attachment.setAttributes({
                        url: data.url,
                        href: data.url
                    });
                }
            }

            xhr.send(form);
        }

        function removeFile(attachment) {
            var form = new FormData;
            form.append("url", attachment.attachment.attributes.values.url);

            var xhr = new XMLHttpRequest;
            xhr.open("POST", "{{ route('trix.remove') }}", true);
            xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("meta[name='csrf-token']").content);
            xhr.send(form);
        }
        // --- AKHIR SCRIPT UPLOAD GAMBAR TRIX ---
    </script>
@endpush
</x-app-layout>