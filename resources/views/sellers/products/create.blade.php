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
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
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
                                <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" :value="old('harga')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>

                            <!-- Stok -->
                            <div>
                                <x-input-label for="stok" value="Stok" />
                                <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                            </div>

                            <!-- Gambar Produk -->
                            <div>
                                <x-input-label for="gambar_produk" value="Gambar Produk" />
                                <input id="gambar_produk" name="gambar_produk" type="file" class="mt-1 block w-full text-gray-500">
                                <x-input-error class="mt-2" :messages="$errors->get('gambar_produk')" />
                            </div>

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
</x-seller-layout>
