<x-app-layout title="Manajemen Category">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Donation Categories</h1>
            </div>

            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                
                <form class="relative" action="{{ route('category.index') }}" method="GET">
                    <input id="action-search" class="form-input w-full pl-9" type="search" name="q" value="{{ request()->query('q') }}" placeholder="Cari kategori..." />
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 ml-3 mr-2" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" /><path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </form>
                
                <a href="{{ route('category.create') }}" class="btn bg-damu-500 hover:bg-damu-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16"><path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" /></svg>
                    <span class="hidden xs:block ml-2">Add Category</span>
                </a>

            </div>
        </div>

        {{-- Table Card --}}
        {{-- Di sini perubahannya: ditambahkan kelas overflow-hidden --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300">
                    <thead class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-500 bg-damu-700/40 dark:bg-gray-700/50">
                        <tr>
                            <th class="py-4 px-2 whitespace-nowrap"><div class="font-semibold text-center">GAMBAR</div></th>
                            <th class="py-4 px-1 whitespace-nowrap"><div class="font-semibold text-left">NAMA KATEGORI</div></th>
                            <th class="py-4 px-2 whitespace-nowrap"><div class="font-semibold text-center">AKSI</div></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="p-2 whitespace-nowrap text-center">
                                    <img src="{{ $category->image }}" class="w-12 h-12 object-cover rounded-md inline-block">
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $category->name }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-center">
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn-sm bg-blue-500 hover:bg-blue-600 text-white">EDIT</a>
                                    <button onclick="destroy({{ $category->id }})" class="btn-sm bg-red-500 hover:bg-red-600 text-white">HAPUS</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-4 text-center text-gray-500">Data Belum Tersedia!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8">{{ $categories->links() }}</div>

    </div>

    @push('scripts')
    {{-- ... Script Anda tidak perlu diubah ... --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function destroy(id) {
          var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          Swal.fire({
              title: 'APAKAH KAMU YAKIN ?',
              text: "INGIN MENGHAPUS DATA INI!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'YA, HAPUS!',
              cancelButtonText: 'BATAL',
          }).then(async (result) => {
              if (result.isConfirmed) {
                  try {
                      const response = await fetch(`/category/${id}`, {
                          method: 'DELETE',
                          headers: {
                              'X-CSRF-TOKEN': token,
                              'Content-Type': 'application/json'
                          }
                      });
                      if (!response.ok) {
                          throw new Error('Terjadi masalah pada server.');
                      }
                      const data = await response.json();
                      if (data.status == "success") {
                          Swal.fire({ icon: 'success', title: 'BERHASIL!', text: 'DATA BERHASIL DIHAPUS!', showConfirmButton: false, timer: 2000 })
                          .then(() => location.reload());
                      } else {
                          Swal.fire({ icon: 'error', title: 'GAGAL!', text: 'DATA GAGAL DIHAPUS!', showConfirmButton: false, timer: 2000 });
                      }
                  } catch (error) {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Terjadi kesalahan! ' + error.message,
                      });
                  }
              }
          })
      }
    </script>
    @endpush
</x-app-layout>