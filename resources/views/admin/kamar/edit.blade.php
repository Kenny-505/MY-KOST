<x-admin-layout>
    <x-slot name="pageTitle">Edit Kamar {{ $kamar->no_kamar }}</x-slot>
    <x-slot name="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a></li>
        <li class="text-gray-500">/</li>
        <li><a href="{{ route('admin.kamar.index') }}" class="text-blue-600 hover:text-blue-800">Kamar</a></li>
        <li class="text-gray-500">/</li>
        <li class="text-gray-900 font-medium">Edit {{ $kamar->no_kamar }}</li>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Kamar {{ $kamar->no_kamar }}</h2>
                    <p class="text-gray-600 mt-1">Perbarui informasi kamar</p>
                </div>
                <a href="{{ route('admin.kamar.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.kamar.update', $kamar) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
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
                                <option value="{{ $tipe->id_tipe_kamar }}" {{ old('id_tipe_kamar', $kamar->id_tipe_kamar) == $tipe->id_tipe_kamar ? 'selected' : '' }}>
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
                               value="{{ old('no_kamar', $kamar->no_kamar) }}"
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
                            <option value="Kosong" {{ old('status', $kamar->status) == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                            <option value="Dipesan" {{ old('status', $kamar->status) == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                            <option value="Terisi" {{ old('status', $kamar->status) == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($kamar->status === 'Terisi')
                        <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-sm text-yellow-700">
                                    Kamar saat ini sedang terisi. Pastikan untuk mengecek booking aktif sebelum mengubah status.
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Kamar
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="6" 
                                  placeholder="Tuliskan deskripsi kamar, kondisi khusus, atau catatan penting lainnya..."
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('deskripsi') border-red-300 @enderror">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Maksimal 1000 karakter
                        </p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Current Photos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Foto Kamar Saat Ini</label>
                        <div class="grid grid-cols-3 gap-4">
                            @php
                                $photos = $kamar->getPhotoUrls();
                            @endphp
                            
                            @foreach(['foto1', 'foto2', 'foto3'] as $index => $photoKey)
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                    @if($photos[$photoKey])
                                        <img src="{!! $photos[$photoKey] !!}" 
                                             alt="Foto Kamar {{ $index + 1 }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-xs text-gray-500">Foto {{ $index + 1 }}</p>
                                                <p class="text-xs text-gray-400">Kosong</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Upload foto baru di bawah untuk mengganti foto yang ada
                        </p>
                    </div>

                    <!-- Upload New Photos -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Upload Foto Baru (Opsional)</label>
                        
                        <div>
                            <label for="foto_kamar1" class="block text-sm text-gray-600 mb-2">Foto Kamar 1</label>
                            <input type="file" name="foto_kamar1" id="foto_kamar1" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            @error('foto_kamar1')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="foto_kamar2" class="block text-sm text-gray-600 mb-2">Foto Kamar 2</label>
                            <input type="file" name="foto_kamar2" id="foto_kamar2" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            @error('foto_kamar2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="foto_kamar3" class="block text-sm text-gray-600 mb-2">Foto Kamar 3</label>
                            <input type="file" name="foto_kamar3" id="foto_kamar3" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            @error('foto_kamar3')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.kamar.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Update Kamar</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById(previewId);
                    var img = preview.querySelector('img');
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Add drag and drop functionality
        document.querySelectorAll('input[type="file"]').forEach(input => {
            const dropZone = input.closest('.border-dashed');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-orange-400', 'bg-orange-50');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-orange-400', 'bg-orange-50');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                input.files = files;
                
                if (files.length > 0) {
                    const previewId = input.id.replace('foto_kamar', 'preview');
                    previewImage(input, previewId);
                }
            }
        });
    </script>
</x-admin-layout> 