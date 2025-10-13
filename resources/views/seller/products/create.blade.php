<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Alert Error -->
                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Nama Produk -->
                            <div>
                                <x-input-label for="nama_produk" value="Nama Produk" />
                                <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1 block w-full" :value="old('nama_produk')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <x-input-label for="category_id" value="Kategori" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Pilih Kategori (Opsional)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <x-input-label for="deskripsi" value="Deskripsi" />
                                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                            </div>

                            <!-- Harga -->
                            <div>
                                <x-input-label for="harga" value="Harga" />
                                <x-text-input id="harga" name="harga" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('harga')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>

                            <!-- Stok -->
                            <div>
                                <x-input-label for="stok" value="Stok" />
                                <x-text-input id="stok" name="stok" type="number" min="0" class="mt-1 block w-full" :value="old('stok')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                            </div>

                            <!-- Upload Multiple Images (UPDATED) -->
                            <div>
                                <x-input-label for="images" value="Gambar Produk (Multiple)" />
                                <div class="mt-1">
                                    <input id="images" 
                                           name="images[]" 
                                           type="file" 
                                           multiple
                                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100
                                                  dark:file:bg-indigo-900 dark:file:text-indigo-300"
                                           required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Upload 1-5 gambar (JPG, PNG, GIF, WebP. Max 2MB per gambar). Gambar pertama akan menjadi gambar utama.
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('images')" />
                                <x-input-error class="mt-2" :messages="$errors->get('images.*')" />
                            </div>

                            <!-- Preview Images (NEW) -->
                            <div id="imagePreview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3"></div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                                <a href="{{ route('seller.products.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    const imageInput = document.getElementById('images');
    const preview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(e) {
        preview.innerHTML = '';
        
        const files = Array.from(e.target.files);
        
        // Validasi maksimal 5 gambar
        if (files.length > 5) {
            alert('❌ Maksimal 5 gambar!\nAnda memilih ' + files.length + ' gambar.');
            e.target.value = '';
            return;
        }
        
        if (files.length === 0) {
            return;
        }

        files.forEach((file, index) => {
            // Validasi ukuran file (max 2MB)
            if (file.size > 2048 * 1024) {
                alert('❌ File "' + file.name + '" terlalu besar!\nMaksimal 2MB per gambar.');
                e.target.value = '';
                preview.innerHTML = '';
                return;
            }

            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('❌ File "' + file.name + '" bukan gambar yang valid!\nHanya JPG, PNG, GIF, WebP yang diperbolehkan.');
                e.target.value = '';
                preview.innerHTML = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <div class="relative aspect-square">
                        <img src="${event.target.result}" 
                             class="w-full h-full object-cover rounded-lg border-2 ${index === 0 ? 'border-indigo-500' : 'border-gray-300 dark:border-gray-600'} group-hover:opacity-75 transition">
                        ${index === 0 ? '<div class="absolute top-2 left-2 bg-indigo-500 text-white text-xs px-2 py-1 rounded font-medium shadow">✓ Utama</div>' : ''}
                    </div>
                    <p class="text-xs text-center mt-1 truncate text-gray-700 dark:text-gray-300 font-medium">${file.name}</p>
                    <p class="text-xs text-center text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });
    </script>
    @endpush
</x-seller-layout>