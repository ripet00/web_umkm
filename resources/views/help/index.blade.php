@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
                <h1 class="text-3xl font-bold text-white text-center">Pusat Bantuan AMPUH</h1>
                <p class="text-blue-100 text-center mt-2">Kami siap membantu Anda 24/7</p>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- FAQ Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Pertanyaan yang Sering Diajukan</h2>
                    
                    <div class="space-y-4">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                            <button class="w-full text-left px-4 py-3 font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700" onclick="toggleFaq(1)">
                                <div class="flex justify-between items-center">
                                    <span>Bagaimana cara berbelanja di AMPUH?</span>
                                    <svg class="w-5 h-5 transform transition-transform" id="icon-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            <div class="hidden px-4 pb-3 text-gray-600 dark:text-gray-300" id="faq-1">
                                <p>1. Daftar akun atau login sebagai pembeli</p>
                                <p>2. Pilih produk yang Anda inginkan</p>
                                <p>3. Tambahkan ke keranjang</p>
                                <p>4. Checkout dan pilih metode pembayaran</p>
                                <p>5. Semua transaksi tercatat di blockchain untuk transparansi</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                            <button class="w-full text-left px-4 py-3 font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700" onclick="toggleFaq(2)">
                                <div class="flex justify-between items-center">
                                    <span>Bagaimana cara menjual produk di AMPUH?</span>
                                    <svg class="w-5 h-5 transform transition-transform" id="icon-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            <div class="hidden px-4 pb-3 text-gray-600 dark:text-gray-300" id="faq-2">
                                <p>1. Daftar sebagai seller/penjual</p>
                                <p>2. Upload produk dengan foto dan deskripsi lengkap</p>
                                <p>3. Atur harga dan stok</p>
                                <p>4. Kelola pesanan yang masuk</p>
                                <p>5. Setiap penjualan tercatat otomatis di blockchain</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                            <button class="w-full text-left px-4 py-3 font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700" onclick="toggleFaq(3)">
                                <div class="flex justify-between items-center">
                                    <span>Apa itu transparansi blockchain di AMPUH?</span>
                                    <svg class="w-5 h-5 transform transition-transform" id="icon-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            <div class="hidden px-4 pb-3 text-gray-600 dark:text-gray-300" id="faq-3">
                                <p>Setiap transaksi di AMPUH dicatat secara permanen di blockchain EQBR. Ini memastikan:</p>
                                <p>• Transparansi penuh semua transaksi</p>
                                <p>• Data tidak dapat dimanipulasi</p>
                                <p>• Verifikasi hash transaksi tersedia untuk publik</p>
                                <p>• Perlindungan privasi dengan enkripsi data sensitif</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                            <button class="w-full text-left px-4 py-3 font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700" onclick="toggleFaq(4)">
                                <div class="flex justify-between items-center">
                                    <span>Metode pembayaran apa saja yang tersedia?</span>
                                    <svg class="w-5 h-5 transform transition-transform" id="icon-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            <div class="hidden px-4 pb-3 text-gray-600 dark:text-gray-300" id="faq-4">
                                <p>AMPUH menggunakan Midtrans sebagai payment gateway dengan opsi:</p>
                                <p>• Transfer bank (BCA, BNI, BRI, Mandiri)</p>
                                <p>• E-wallet (GoPay, OVO, DANA, ShopeePay)</p>
                                <p>• Kartu kredit/debit</p>
                                <p>• Minimarket (Indomaret, Alfamart)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Masih Butuh Bantuan?</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Kirim pesan kepada kami dan tim support akan merespon dengan cepat!</p>

                    <form action="{{ route('help.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="gmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Anda</label>
                            <input type="email" 
                                   name="gmail" 
                                   id="gmail" 
                                   value="{{ old('gmail', Auth::guard('web')->user()->email ?? Auth::guard('seller')->user()->email ?? '') }}"
                                   required 
                                   placeholder="contoh: abc@gmail.com"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent">
                            @error('gmail')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pesan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pesan Anda</label>
                            <textarea name="pesan" 
                                      id="pesan" 
                                      rows="5" 
                                      required 
                                      placeholder="Jelaskan masalah atau pertanyaan Anda dengan detail..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent">{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="upload_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload File (Opsional)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-blue-400 dark:hover:border-blue-500 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="upload_file" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload foto atau video</span>
                                            <input id="upload_file" name="upload_file" type="file" class="sr-only" accept="image/*,video/*" onchange="validateFileSize(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG, GIF hingga 10MB<br>
                                        MP4, MOV, AVI, WMV hingga 10MB
                                    </p>
                                    <p id="file-name" class="text-sm text-green-600 font-medium hidden"></p>
                                    <p id="file-error" class="text-sm text-red-500 font-medium hidden"></p>
                                </div>
                            </div>
                            @error('upload_file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Privasi Anda terlindungi
                                </span>
                            </div>
                            <button type="submit" 
                                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-md hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Info -->
                
            </div>
        </div>
    </div>
</div>

<script>
function toggleFaq(id) {
    const faq = document.getElementById('faq-' + id);
    const icon = document.getElementById('icon-' + id);
    
    if (faq.classList.contains('hidden')) {
        faq.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        faq.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Validate file size and update display when file is selected
function validateFileSize(input) {
    const fileNameElement = document.getElementById('file-name');
    const fileErrorElement = document.getElementById('file-error');
    const submitButton = document.querySelector('button[type="submit"]');
    
    // Hide previous messages
    fileNameElement.classList.add('hidden');
    fileErrorElement.classList.add('hidden');
    
    // Remove existing preview
    const existingPreview = document.getElementById('image-preview');
    if (existingPreview) {
        existingPreview.remove();
    }
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        
        if (file.size > maxSize) {
            // File terlalu besar
            fileErrorElement.textContent = `❌ File terlalu besar! "${fileName}" berukuran ${fileSize}MB. Maksimal 10MB. Silakan pilih file yang lebih kecil.`;
            fileErrorElement.classList.remove('hidden');
            
            // Disable submit button
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.textContent = 'File Terlalu Besar - Pilih File Lain';
            
            // Clear the input
            input.value = '';
        } else {
            // File size OK
            fileNameElement.textContent = `✅ File dipilih: ${fileName} (${fileSize}MB)`;
            fileNameElement.classList.remove('hidden');
            
            // Enable submit button
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            submitButton.textContent = 'Kirim Pesan';
            
            // Preview for images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create new preview
                    const preview = document.createElement('img');
                    preview.id = 'image-preview';
                    preview.src = e.target.result;
                    preview.className = 'mt-2 mx-auto max-w-32 max-h-32 rounded-lg shadow-md';
                    fileNameElement.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        }
    } else {
        // No file selected - enable submit button
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        submitButton.textContent = 'Kirim Pesan';
    }
}

// Add drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('upload_file');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            validateFileSize(fileInput);
        }
    }
    
    // Add SVG content to icons
    const icons = document.querySelectorAll('[id^="icon-"]');
    icons.forEach(icon => {
        icon.innerHTML = '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
        icon.setAttribute('fill', 'none');
        icon.setAttribute('viewBox', '0 0 24 24');
    });
});
</script>
@endsection