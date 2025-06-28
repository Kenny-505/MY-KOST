@extends('layouts.admin')

@section('title', 'Edit Tipe Kamar')

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
            <span class="text-gray-900">Edit {{ $tipeKamar->tipe_kamar }}</span>
        </nav>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br 
                @if($tipeKamar->tipe_kamar == 'Standar') 
                    from-green-400 to-green-600
                @elseif($tipeKamar->tipe_kamar == 'Elite')
                    from-blue-400 to-blue-600
                @else
                    from-purple-400 to-purple-600
                @endif
                rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Tipe Kamar</h1>
                <p class="text-gray-600">Ubah informasi tipe kamar {{ $tipeKamar->tipe_kamar }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('admin.tipe-kamar.update', $tipeKamar) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Tipe Kamar -->
            <div>
                <label for="tipe_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Kamar <span class="text-red-500">*</span>
                </label>
                <select name="tipe_kamar" id="tipe_kamar" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('tipe_kamar') border-red-300 @enderror" 
                        required>
                    <option value="">Pilih Tipe Kamar</option>
                    <option value="Standar" {{ old('tipe_kamar', $tipeKamar->tipe_kamar) == 'Standar' ? 'selected' : '' }}>Standar</option>
                    <option value="Elite" {{ old('tipe_kamar', $tipeKamar->tipe_kamar) == 'Elite' ? 'selected' : '' }}>Elite</option>
                    <option value="Exclusive" {{ old('tipe_kamar', $tipeKamar->tipe_kamar) == 'Exclusive' ? 'selected' : '' }}>Exclusive</option>
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
                          required>{{ old('fasilitas', $tipeKamar->fasilitas) }}</textarea>
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

            <!-- Warning if has dependencies -->
            @if($tipeKamar->kamar()->exists() || $tipeKamar->paketKamar()->exists())
            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Tipe kamar ini memiliki:</p>
                            <ul class="list-disc list-inside mt-1">
                                @if($tipeKamar->kamar()->exists())
                                    <li>{{ $tipeKamar->kamar()->count() }} kamar terkait</li>
                                @endif
                                @if($tipeKamar->paketKamar()->exists())
                                    <li>{{ $tipeKamar->paketKamar()->count() }} paket kamar terkait</li>
                                @endif
                            </ul>
                            <p class="mt-1">Perubahan akan mempengaruhi semua data terkait.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    <a href="{{ route('admin.tipe-kamar.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    
                    <a href="{{ route('admin.tipe-kamar.show', $tipeKamar) }}" 
                       class="inline-flex items-center px-4 py-2 border border-blue-300 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
                    </a>
                </div>
                
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
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