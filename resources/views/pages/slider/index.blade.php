<x-app-layout title="Manajemen Slider">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Image Sliders</h1>
            </div>
        </div>

        {{-- Form Upload --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 p-6 mb-8">
            <h2 class="text-lg text-gray-700 dark:text-gray-200 font-semibold capitalize mb-4">Upload Slider Baru</h2>
            <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="image">GAMBAR <span class="text-red-500">*</span></x-label>
                        <x-input type="file" name="image" id="image" class="w-full" required />
                        <div class="text-xs text-gray-500 mt-1">Disarankan gambar dengan rasio 16:9 atau landscape.
                        </div>
                        @error('image')
                            <div class="text-xs mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label for="link">LINK SLIDER (Opsional)</x-label>
                        <x-input type="text" name="link" id="link" class="w-full" value="{{ old('link') }}"
                            placeholder="Contoh: https://www.google.com" />
                        @error('link')
                            <div class="text-xs mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-start mt-6">
                    <x-button type="submit" class="bg-damu-500 hover:bg-damu-600">UPLOAD</x-button>
                </div>
            </form>
        </div>

        {{-- Tabel Daftar Slider --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300">
                    <thead
                        class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                        <tr>
                            <th class="p-4 whitespace-nowrap">
                                <div class="font-semibold text-center">GAMBAR</div>
                            </th>
                            <th class="p-4 whitespace-nowrap">
                                <div class="font-semibold text-left">LINK</div>
                            </th>
                            <th class="p-4 whitespace-nowrap">
                                <div class="font-semibold text-center">AKSI</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                        @forelse ($sliders as $slider)
                            <tr>
                                <td class="p-2 text-center">
                                    <img src="{{ $slider->image }}" class="h-16 object-contain inline-block">
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <a href="{{ $slider->link }}" target="_blank"
                                        class="font-medium text-blue-500 hover:underline">{{ $slider->link }}</a>
                                </td>
                                <td class="p-2 whitespace-nowrap text-center">
                                    <button onclick="destroy({{ $slider->id }})"
                                        class="btn-sm bg-red-500 hover:bg-red-600 text-white">HAPUS</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">Data Slider Belum Tersedia!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">{{ $sliders->links() }}</div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function destroy(id) {
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                Swal.fire({
                    title: 'APAKAH KAMU YAKIN ?',
                    text: "INGIN MENGHAPUS SLIDER INI!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'YA, HAPUS!',
                    cancelButtonText: 'BATAL',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/slider/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'Content-Type': 'application/json'
                                }
                            });
                            if (!response.ok) throw new Error('Terjadi masalah pada server.');
                            const data = await response.json();
                            if (data.status == "success") {
                                Swal.fire({
                                        icon: 'success',
                                        title: 'BERHASIL!',
                                        text: 'DATA BERHASIL DIHAPUS!',
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                    .then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan! ' + error.message
                            });
                        }
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
