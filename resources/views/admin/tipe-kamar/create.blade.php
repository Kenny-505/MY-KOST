@extends('layouts.admin')

@section('title', 'Tambah Tipe Kamar')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('admin.tipe-kamar.index') }}" class="hover:text-gray-700">Tipe Kamar</a>
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
                <h1 class="text-2xl font-bold text-gray-900">Tambah Tipe Kamar</h1>
                <p class="text-gray-600">Buat tipe kamar baru dengan fasilitas yang disediakan</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('admin.tipe-kamar.store') }}" method="POST" class="space-y-6 p-6">
            @csrf

            <!-- Tipe Kamar -->
            <div>
                <label for="tipe_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Kamar <span class="text-red-500">*</span>
                </label>
                <select name="tipe_kamar" id="tipe_kamar" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('tipe_kamar') border-red-300 @enderror" 
                        required>
                    <option value="">Pilih Tipe Kamar</option>
                    <option value="Standar" {{ old('tipe_kamar') == 'Standar' ? 'selected' : '' }}>Standar</option>
                    <option value="Elite" {{ old('tipe_kamar') == 'Elite' ? 'selected' : '' }}>Elite</option>
                    <option value="Exclusive" {{ old('tipe_kamar') == 'Exclusive' ? 'selected' : '' }}>Exclusive</option>
                </select>
                @error('tipe_kamar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Pilih kategori tipe kamar yang akan ditambahkan
                </p>
            </div>

            <!-- Fasilitas -->
            <div>
                <label for="fasilitas" class="block text-sm font-medium text-gray-700 mb-2">
                    Fasilitas <span class="text-red-500">*</span>
                </label>
                <textarea name="fasilitas" id="fasilitas" rows="6" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('fasilitas') border-red-300 @enderror" 
                          placeholder="Masukkan daftar fasilitas yang disediakan untuk tipe kamar ini..."
                          required>{{ old('fasilitas') }}</textarea>
                @error('fasilitas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Deskripsikan fasilitas yang tersedia untuk tipe kamar ini. Maksimal 1000 karakter.
                </p>
            </div>

            <!-- Preview Card -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Preview</h3>
                <div class="flex items-start space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center" id="preview-icon">
                        <span class="text-white font-bold text-lg" id="preview-letter">?</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900" id="preview-title">Pilih Tipe Kamar</h4>
                        <p class="text-gray-600 mt-1" id="preview-facilities">Fasilitas akan muncul di sini...</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.tipe-kamar.index') }}" 
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
                    Simpan Tipe Kamar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for preview -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeSelect = document.getElementById('tipe_kamar');
    const fasilitasTextarea = document.getElementById('fasilitas');
    const previewIcon = document.getElementById('preview-icon');
    const previewLetter = document.getElementById('preview-letter');
    const previewTitle = document.getElementById('preview-title');
    const previewFacilities = document.getElementById('preview-facilities');

    function updatePreview() {
        const tipe = tipeSelect.value;
        const fasilitas = fasilitasTextarea.value;

        // Update title
        previewTitle.textContent = tipe || 'Pilih Tipe Kamar';
        
        // Update letter
        previewLetter.textContent = tipe ? tipe.charAt(0) : '?';
        
        // Update icon color
        previewIcon.className = 'w-16 h-16 bg-gradient-to-br rounded-lg flex items-center justify-center';
        if (tipe === 'Standar') {
            previewIcon.classList.add('from-green-400', 'to-green-600');
        } else if (tipe === 'Elite') {
            previewIcon.classList.add('from-blue-400', 'to-blue-600');
        } else if (tipe === 'Exclusive') {
            previewIcon.classList.add('from-purple-400', 'to-purple-600');
        } else {
            previewIcon.classList.add('from-gray-400', 'to-gray-600');
        }
        
        // Update facilities
        previewFacilities.textContent = fasilitas || 'Fasilitas akan muncul di sini...';
    }

    tipeSelect.addEventListener('change', updatePreview);
    fasilitasTextarea.addEventListener('input', updatePreview);
    
    // Initial update
    updatePreview();
});
</script>
@endsection 