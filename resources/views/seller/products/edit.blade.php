<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Alert Messages -->
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <strong>Sukses!</strong> {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Nama Produk -->
                            <div>
                                <x-input-label for="nama_produk" value="Nama Produk" />
                                <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1 block w-full" :value="old('nama_produk', $product->nama_produk)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <x-input-label for="category_id" value="Kategori" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Pilih Kategori (Opsional)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <x-input-label for="deskripsi" value="Deskripsi" />
                                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                            </div>

                            <!-- Harga -->
                            <div>
                                <x-input-label for="harga" value="Harga" />
                                <x-text-input id="harga" name="harga" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('harga', $product->harga)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>

                            <!-- Stok -->
                            <div>
                                <x-input-label for="stok" value="Stok" />
                                <x-text-input id="stok" name="stok" type="number" min="0" class="mt-1 block w-full" :value="old('stok', $product->stok)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                            </div>

                            <!-- Gambar yang sudah ada (NEW) -->
                            @if($product->images->count() > 0)
                            <div>
                                <x-input-label value="Gambar Saat Ini ({{ $product->images->count() }})" />
                                <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                                    @foreach($product->images as $image)
                                    <div class="relative group rounded-lg">
                                        <!-- Image -->
                                        <div class="aspect-square relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                alt="Product Image"
                                                class="w-full h-full object-cover border-2 {{ $image->is_primary ? 'border-green-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg">
                                            
                                            <!-- Badge Utama (Kiri Atas) -->
                                            @if($image->is_primary)
                                            <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded font-medium shadow z-10 pointer-events-none">
                                                ✓ Utama
                                            </div>
                                            @endif

                                            <!-- Tombol Jadikan Utama (Tengah) - hanya muncul jika bukan primary -->
                                            @if(!$image->is_primary)
                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                                                <button type="button"
                                                        onclick="if(confirm('Jadikan gambar ini sebagai gambar utama?')) { document.getElementById('setPrimaryForm_{{ $image->id }}').submit(); }"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-2 rounded font-medium shadow"
                                                        title="Jadikan gambar utama">
                                                    Jadikan Utama
                                                </button>
                                            </div>
                                            @endif

                                            <!-- Tombol Hapus (Kanan Atas) -->
                                            @if($product->images->count() > 1)
                                            <div class="absolute top-2 right-2 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                <button type="button" 
                                                        onclick="if(confirm('⚠️ PERHATIAN!\n\nYakin hapus gambar ini?\nGambar yang dihapus tidak bisa dikembalikan!')) { document.getElementById('deleteImageForm_{{ $image->id }}').submit(); }"
                                                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded shadow"
                                                        title="Hapus gambar">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <!-- Hidden Forms - DI LUAR LOOP (PENTING!) -->
                                @foreach($product->images as $image)
                                    <form id="setPrimaryForm_{{ $image->id }}" 
                                        action="{{ route('seller.products.images.set-primary', [$product, $image]) }}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                    </form>

                                    <form id="deleteImageForm_{{ $image->id }}" 
                                        action="{{ route('seller.products.images.delete', [$product, $image]) }}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endforeach
                                
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Hover pada gambar untuk menampilkan tombol aksi
                                </p>
                            </div>
                            @endif
                            <!-- Upload Gambar Baru (NEW) -->
                            <div>
                                <x-input-label for="images" value="Tambah Gambar Baru" />
                                @if($product->images->count() > 0)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                    Saat ini: {{ $product->images->count() }}/5 gambar. 
                                    @if($product->images->count() < 5)
                                        Anda bisa tambah {{ 5 - $product->images->count() }} gambar lagi.
                                    @else
                                        Hapus gambar dulu untuk menambah gambar baru.
                                    @endif
                                </p>
                                @endif
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
                                                  dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Upload gambar tambahan (JPG, PNG, GIF, WebP. Max 2MB per gambar)
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('images')" />
                                <x-input-error class="mt-2" :messages="$errors->get('images.*')" />
                            </div>

                            <!-- Preview Gambar Baru -->
                            <div id="imagePreview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3"></div>

                            <div class="flex items-center gap-4">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Update
                                </button>
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
    const currentImageCount = {{ $product->images->count() }};
    const maxImages = 5;

    imageInput.addEventListener('change', function(e) {
        preview.innerHTML = '';
        
        const files = Array.from(e.target.files);
        const totalImages = currentImageCount + files.length;
        
        // Validasi total gambar tidak lebih dari 5
        if (totalImages > maxImages) {
            alert(`❌ Total gambar tidak boleh lebih dari ${maxImages}!\nSaat ini: ${currentImageCount} gambar, Upload: ${files.length} gambar\nTotal: ${totalImages} gambar`);
            e.target.value = '';
            return;
        }
        
        if (files.length === 0) {
            return;
        }

        files.forEach((file, index) => {
            // Validasi ukuran file
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
                             class="w-full h-full object-cover rounded-lg border-2 border-blue-500 group-hover:opacity-75 transition">
                        <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded font-medium shadow">+ Baru</div>
                    </div>
                    <p class="text-xs text-center mt-1 truncate text-gray-700 dark:text-gray-300 font-medium">${file.name}</p>
                    <p class="text-xs text-center text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });

    // Function untuk konfirmasi hapus gambar
    function confirmDeleteImage(productId, imageId) {
        if (confirm('⚠️ Yakin hapus gambar ini?\n\nGambar yang dihapus tidak bisa dikembalikan.')) {
            document.getElementById('deleteImageForm_' + imageId).submit();
        }
    }

    // Function untuk konfirmasi set primary
    function confirmSetPrimary(productId, imageId) {
        if (confirm('Jadikan gambar ini sebagai gambar utama?')) {
            document.getElementById('setPrimaryForm_' + imageId).submit();
        }
    }
    </script>
    @endpush
</x-seller-layout>