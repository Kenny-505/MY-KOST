<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Buat Pengaduan Baru') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Laporkan masalah atau keluhan terkait kamar Anda</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('penghuni.pengaduan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Pengaduan</h3>
                            
                            <form method="POST" action="{{ route('penghuni.pengaduan.store') }}" enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                <!-- Room Selection -->
                                <div>
                                    <label for="id_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kamar <span class="text-red-500">*</span>
                                    </label>
                                    <select id="id_kamar" name="id_kamar" 
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('id_kamar') border-red-500 @enderror">
                                        <option value="">Pilih kamar yang ingin diadukan</option>
                                        @foreach($kamar as $room)
                                            <option value="{{ $room->id_kamar }}" {{ old('id_kamar') == $room->id_kamar ? 'selected' : '' }}>
                                                {{ $room->no_kamar }} - {{ $room->tipeKamar->tipe_kamar }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kamar')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @if($kamar->isEmpty())
                                        <p class="mt-1 text-sm text-yellow-600">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            Anda belum memiliki booking aktif. Pengaduan hanya dapat dibuat untuk kamar yang sedang Anda tinggali.
                                        </p>
                                    @endif
                                </div>

                                <!-- Title -->
                                <div>
                                    <label for="judul_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Judul Pengaduan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="judul_pengaduan" 
                                           name="judul_pengaduan" 
                                           value="{{ old('judul_pengaduan') }}"
                                           placeholder="Masukkan judul singkat pengaduan Anda"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('judul_pengaduan') border-red-500 @enderror">
                                    @error('judul_pengaduan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">
                                        Contoh: "AC tidak dingin", "Lampu kamar mati", "Keran air bocor"
                                    </p>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="isi_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Isi Pengaduan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="isi_pengaduan" 
                                              name="isi_pengaduan" 
                                              rows="6" 
                                              placeholder="Jelaskan masalah yang Anda alami secara detail..."
                                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('isi_pengaduan') border-red-500 @enderror">{{ old('isi_pengaduan') }}</textarea>
                                    @error('isi_pengaduan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">
                                        Jelaskan masalah sedetail mungkin agar admin dapat memahami dan menangani dengan tepat.
                                    </p>
                                </div>

                                <!-- Photo Upload -->
                                <div>
                                    <label for="foto_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Foto Pengaduan (Opsional)
                                    </label>
                                    
                                    <!-- File Input (Similar to Admin Style) -->
                                    <input type="file" 
                                           name="foto_pengaduan" 
                                           id="foto_pengaduan" 
                                           accept="image/*"
                                           onchange="previewImage(this)"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('foto_pengaduan') border-red-300 @enderror">
                                    
                                    <p class="mt-1 text-sm text-gray-500">
                                        PNG, JPG, JPEG hingga 2MB. Sertakan foto untuk memperjelas masalah yang dilaporkan.
                                    </p>
                                    
                                    @error('foto_pengaduan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-4 hidden">
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                            <div class="flex items-center mb-3">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-2">
                                                    <p class="text-sm font-medium text-green-800">Foto berhasil dipilih</p>
                                                    <p id="fileInfo" class="text-sm text-green-600"></p>
                                                </div>
                                                <div class="ml-auto">
                                                    <button type="button" 
                                                            onclick="removeImage()" 
                                                            class="text-red-600 hover:text-red-800 transition duration-200 p-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <!-- Image Preview Container -->
                                            <div class="relative bg-white rounded-lg overflow-hidden border border-gray-200">
                                                <img id="previewImg" 
                                                     src="" 
                                                     alt="Preview Foto Pengaduan" 
                                                     class="w-full h-48 object-cover">
                                                <div class="absolute top-2 right-2">
                                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                                        Ready to Upload
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Image Actions -->
                                            <div class="mt-3 flex items-center justify-between text-sm">
                                                <div class="flex items-center text-gray-600">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>Foto akan dikirim bersama pengaduan</span>
                                                </div>
                                                <button type="button" 
                                                        onclick="document.getElementById('previewImg').style.transform = document.getElementById('previewImg').style.transform === 'scale(1.5)' ? 'scale(1)' : 'scale(1.5)'"
                                                        class="text-orange-600 hover:text-orange-800 font-medium">
                                                    Zoom
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-orange-500 to-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:from-orange-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            Kirim Pengaduan
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tips Pengaduan
                            </h3>
                            <div class="space-y-3 text-sm text-gray-600">
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Berikan judul yang jelas dan spesifik</span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Jelaskan masalah secara detail dan kronologis</span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Sertakan foto jika memungkinkan untuk memperjelas masalah</span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Gunakan bahasa yang sopan dan jelas</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-gradient-to-br from-orange-50 to-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Kontak Darurat
                        </h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>Untuk masalah darurat yang memerlukan penanganan segera:</p>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="font-medium">+62 812-3456-7890</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium">admin@mykost.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (2MB max)
                const maxSize = 2 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    input.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Hanya file gambar yang diperbolehkan (PNG, JPG, JPEG)');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Show preview elements
                    const imagePreview = document.getElementById('imagePreview');
                    const previewImg = document.getElementById('previewImg');
                    const fileInfo = document.getElementById('fileInfo');
                    
                    if (imagePreview && previewImg && fileInfo) {
                        imagePreview.classList.remove('hidden');
                        previewImg.src = e.target.result;
                        fileInfo.textContent = `${file.name} (${formatFileSize(file.size)})`;
                        
                        // Show success notification
                        showSuccessMessage('Foto berhasil dipilih dan siap di-upload!');
                    }
                }
                
                reader.onerror = function() {
                    alert('Gagal membaca file. Silakan coba lagi.');
                }
                
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const fileInput = document.getElementById('foto_pengaduan');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const fileInfo = document.getElementById('fileInfo');
            
            if (fileInput) fileInput.value = '';
            if (imagePreview) imagePreview.classList.add('hidden');
            if (previewImg) {
                previewImg.src = '';
                previewImg.style.transform = 'scale(1)'; // Reset zoom
            }
            if (fileInfo) fileInfo.textContent = '';
            
            showSuccessMessage('Foto berhasil dihapus');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showSuccessMessage(message) {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.upload-notification');
            existingNotifications.forEach(notification => {
                notification.remove();
            });

            // Create new notification
            const successDiv = document.createElement('div');
            successDiv.className = 'upload-notification fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center animate-pulse';
            successDiv.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                ${message}
            `;
            
            document.body.appendChild(successDiv);
            
            // Fade in animation
            setTimeout(() => {
                successDiv.classList.remove('animate-pulse');
            }, 500);
            
            // Remove after 3 seconds
            setTimeout(() => {
                if (successDiv.parentNode) {
                    successDiv.style.opacity = '0';
                    successDiv.style.transform = 'translateX(100%)';
                    successDiv.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        successDiv.remove();
                    }, 300);
                }
            }, 3000);
        }
    </script>
    @endpush
</x-user-layout> 