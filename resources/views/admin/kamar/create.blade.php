@extends('layouts.admin')

@section('title', 'Tambah Kamar')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('admin.kamar.index') }}" class="hover:text-gray-700">Kamar</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900">Tambah Baru</span>
        </nav>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Kamar Baru</h1>
                <p class="text-gray-600">Buat kamar baru dengan informasi lengkap dan foto</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('admin.kamar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Tipe Kamar -->
                    <div>
                        <label for="id_tipe_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Kamar <span class="text-red-500">*</span>
                        </label>
                        <select name="id_tipe_kamar" id="id_tipe_kamar" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('id_tipe_kamar') border-red-300 @enderror" 
                                required>
                            <option value="">Pilih Tipe Kamar</option>
                            @foreach($tipeKamar as $tipe)
                                <option value="{{ $tipe->id_tipe_kamar }}" {{ old('id_tipe_kamar') == $tipe->id_tipe_kamar ? 'selected' : '' }}>
                                    {{ $tipe->tipe_kamar }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_tipe_kamar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Kamar -->
                    <div>
                        <label for="no_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Kamar <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_kamar" id="no_kamar" 
                               value="{{ old('no_kamar') }}"
                               placeholder="Contoh: 101, A-01, B2-03"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('no_kamar') border-red-300 @enderror" 
                               required>
                        @error('no_kamar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Nomor kamar harus unik dan tidak boleh sama
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('status') border-red-300 @enderror" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="Kosong" {{ old('status') == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                            <option value="Dipesan" {{ old('status') == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                            <option value="Terisi" {{ old('status') == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" 
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('deskripsi') border-red-300 @enderror" 
                                  placeholder="Deskripsi tambahan untuk kamar ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Opsional. Deskripsi khusus untuk kamar ini
                        </p>
                    </div>
                </div>

                <!-- Right Column - Image Upload -->
                <div class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900">Foto Kamar</h3>
                    
                    <!-- Foto Kamar 1 -->
                    <div>
                        <label for="foto_kamar1" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Kamar 1 <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-orange-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="foto_kamar1" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                        <span>Upload foto utama</span>
                                        <input id="foto_kamar1" name="foto_kamar1" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                            </div>
                        </div>
                        @error('foto_kamar1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Kamar 2 -->
                    <div>
                        <label for="foto_kamar2" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Kamar 2
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-orange-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="foto_kamar2" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                        <span>Upload foto tambahan</span>
                                        <input id="foto_kamar2" name="foto_kamar2" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                            </div>
                        </div>
                        @error('foto_kamar2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Kamar 3 -->
                    <div>
                        <label for="foto_kamar3" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Kamar 3
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-orange-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="foto_kamar3" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                        <span>Upload foto tambahan</span>
                                        <input id="foto_kamar3" name="foto_kamar3" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                            </div>
                        </div>
                        @error('foto_kamar3')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Preview Kamar</h3>
                <div class="flex items-start space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center" id="preview-icon">
                        <span class="text-white font-bold text-lg" id="preview-number">?</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900" id="preview-title">Kamar [Nomor]</h4>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800" id="preview-type">
                                Tipe Kamar
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800" id="preview-status">
                                Status
                            </span>
                        </div>
                        <p class="text-gray-600 mt-2" id="preview-description">Deskripsi akan muncul di sini...</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.kamar.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Kamar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for preview -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeSelect = document.getElementById('id_tipe_kamar');
    const noKamarInput = document.getElementById('no_kamar');
    const statusSelect = document.getElementById('status');
    const deskripsiTextarea = document.getElementById('deskripsi');
    
    const previewIcon = document.getElementById('preview-icon');
    const previewNumber = document.getElementById('preview-number');
    const previewTitle = document.getElementById('preview-title');
    const previewType = document.getElementById('preview-type');
    const previewStatus = document.getElementById('preview-status');
    const previewDescription = document.getElementById('preview-description');

    const tipeKamarData = @json($tipeKamar->keyBy('id_tipe_kamar'));

    function updatePreview() {
        const tipeId = tipeSelect.value;
        const noKamar = noKamarInput.value;
        const status = statusSelect.value;
        const deskripsi = deskripsiTextarea.value;

        // Update room number
        previewNumber.textContent = noKamar || '?';
        previewTitle.textContent = noKamar ? `Kamar ${noKamar}` : 'Kamar [Nomor]';
        
        // Update icon color based on type
        const tipeData = tipeKamarData[tipeId];
        previewIcon.className = 'w-16 h-16 bg-gradient-to-br rounded-lg flex items-center justify-center';
        
        if (tipeData) {
            if (tipeData.tipe_kamar === 'Standar') {
                previewIcon.classList.add('from-green-400', 'to-green-600');
                previewType.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
            } else if (tipeData.tipe_kamar === 'Elite') {
                previewIcon.classList.add('from-blue-400', 'to-blue-600');
                previewType.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
            } else if (tipeData.tipe_kamar === 'Exclusive') {
                previewIcon.classList.add('from-purple-400', 'to-purple-600');
                previewType.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800';
            }
            previewType.textContent = tipeData.tipe_kamar;
        } else {
            previewIcon.classList.add('from-gray-400', 'to-gray-600');
            previewType.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            previewType.textContent = 'Tipe Kamar';
        }
        
        // Update status badge
        previewStatus.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium';
        if (status === 'Kosong') {
            previewStatus.classList.add('bg-green-100', 'text-green-800');
        } else if (status === 'Dipesan') {
            previewStatus.classList.add('bg-yellow-100', 'text-yellow-800');
        } else if (status === 'Terisi') {
            previewStatus.classList.add('bg-red-100', 'text-red-800');
        } else {
            previewStatus.classList.add('bg-gray-100', 'text-gray-800');
        }
        previewStatus.textContent = status || 'Status';
        
        // Update description
        previewDescription.textContent = deskripsi || 'Deskripsi akan muncul di sini...';
    }

    tipeSelect.addEventListener('change', updatePreview);
    noKamarInput.addEventListener('input', updatePreview);
    statusSelect.addEventListener('change', updatePreview);
    deskripsiTextarea.addEventListener('input', updatePreview);
    
    // Initial update
    updatePreview();

    // File upload preview
    ['foto_kamar1', 'foto_kamar2', 'foto_kamar3'].forEach(function(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const label = input.closest('.border-dashed').querySelector('label span');
                    label.textContent = file.name;
                    label.classList.add('text-green-600');
                }
            });
        }
    });
});
</script>
@endsection 