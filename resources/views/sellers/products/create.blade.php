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
                                <x-input-label for="nama_produk" :value="__('Nama Produk')" />
                                <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1 block w-full" :value="old('nama_produk')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                                <textarea id="deskripsi" name="deskripsi" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">{{ old('deskripsi') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                            </div>

                            <!-- Harga -->
                            <div>
                                <x-input-label for="harga" :value="__('Harga')" />
                                <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" :value="old('harga')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>

                            <!-- Stok -->
                            <div>
                                <x-input-label for="stok" :value="__('Stok')" />
                                <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <x-input-label for="category_id" :value="__('Kategori')" />
                                <!-- FIX: Menambahkan class styling untuk dark mode -->
                                <select name="category_id" id="category_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                             <!-- Gambar Produk -->
                            <div>
                                <x-input-label for="gambar_produk" :value="__('Gambar Produk')" />
                                <input type="file" name="gambar_produk" id="gambar_produk" class="mt-1 block w-full text-gray-900 dark:text-gray-100">
                                <x-input-error class="mt-2" :messages="$errors->get('gambar_produk')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>

