<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Detail Pengaduan') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Lihat detail pengaduan dan response dari admin</p>
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
            <div class="space-y-6">
                
                <!-- Pengaduan Details -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Informasi Pengaduan</h3>
                            <div class="flex items-center space-x-2">
                                @if($pengaduan->status === 'Menunggu')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Menunggu
                                    </span>
                                @elseif($pengaduan->status === 'Diproses')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Diproses
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Selesai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Pengaduan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->tanggal_pengaduan->format('d F Y, H:i') }} WIB</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">ID Pengaduan</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">#{{ str_pad($pengaduan->id_pengaduan, 6, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kamar</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->kamar->no_kamar }} - {{ $pengaduan->kamar->tipeKamar->tipe_kamar }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dibuat Oleh</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->penghuni->user->nama }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $pengaduan->judul_pengaduan }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                                <div class="mt-1 bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $pengaduan->isi_pengaduan }}</p>
                                </div>
                            </div>

                            @if($pengaduan->foto_pengaduan)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Pengaduan</label>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <img src="data:image/jpeg;base64,{{ $pengaduan->foto_pengaduan }}" 
                                         alt="Foto Pengaduan" 
                                         class="max-w-full h-auto rounded-lg shadow-sm cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                    <p class="text-xs text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Admin Response -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Response Admin</h3>
                        
                        @if($pengaduan->hasResponse())
                            <!-- Admin Response Available -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.405L3 21l1.405-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="text-sm text-blue-700 mb-2">
                                            <strong>Response dari Admin</strong> - {{ $pengaduan->tanggal_response->format('d F Y, H:i') }} WIB
                                        </div>
                                        <p class="text-blue-800 whitespace-pre-wrap">{{ $pengaduan->response_admin }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- No Response Yet -->
                            <div class="text-center py-8">
                                @if($pengaduan->status === 'Menunggu')
                                    <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Menunggu Response</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Admin belum memberikan response untuk pengaduan Anda. Mohon tunggu sebentar.
                                    </p>
                                @elseif($pengaduan->status === 'Diproses')
                                    <svg class="mx-auto h-12 w-12 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Pengaduan Sedang Diproses</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Admin telah memproses pengaduan Anda tanpa mengirim pesan khusus.
                                    </p>
                                @else
                                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Pengaduan Selesai</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Pengaduan telah selesai ditangani.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Button -->
                @if($pengaduan->status === 'Diproses')
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Penyelesaian</h3>
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-orange-800">
                                        Pengaduan Sedang Diproses
                                    </h3>
                                    <div class="mt-2 text-sm text-orange-700">
                                        <p>
                                            Jika masalah sudah selesai ditangani secara langsung, silakan tekan tombol "Selesai" di bawah ini untuk mengkonfirmasi bahwa pengaduan telah selesai.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('penghuni.pengaduan.markCompleted', $pengaduan) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center"
                                    onclick="return confirm('Apakah Anda yakin bahwa masalah sudah selesai ditangani? Status pengaduan akan berubah menjadi Selesai dan tidak dapat diubah lagi.')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Tandai Sebagai Selesai
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Timeline Pengaduan</h3>
                        <div class="flow-root">
                            <ul class="space-y-6">
                                <!-- Step 1: Pengaduan dibuat -->
                                <li>
                                    <div class="relative flex items-center">
                                        @if($pengaduan->status !== 'Menunggu')
                                            <div class="absolute top-8 left-6 w-0.5 h-full bg-gray-200"></div>
                                        @endif
                                        <div class="relative w-12 h-12 flex items-center justify-center flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-4 ring-white shadow">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1 ml-4">
                                            <div class="text-sm text-gray-900">
                                                <p class="font-medium">Pengaduan dibuat</p>
                                                <p class="text-gray-500 mt-1">{{ $pengaduan->tanggal_pengaduan->format('d F Y, H:i') }} WIB</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                                <!-- Step 2: Admin memproses -->
                                @if($pengaduan->status !== 'Menunggu')
                                <li>
                                    <div class="relative flex items-center">
                                        @if($pengaduan->status === 'Selesai')
                                            <div class="absolute top-8 left-6 w-0.5 h-full bg-gray-200"></div>
                                        @endif
                                        <div class="relative w-12 h-12 flex items-center justify-center flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-orange-500 flex items-center justify-center ring-4 ring-white shadow">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1 ml-4">
                                            <div class="text-sm text-gray-900">
                                                <p class="font-medium">
                                                    @if($pengaduan->hasResponse())
                                                        Admin memberikan response dan memproses
                                                    @else
                                                        Admin memproses pengaduan
                                                    @endif
                                                </p>
                                                <p class="text-gray-500 mt-1">
                                                    @if($pengaduan->hasResponse())
                                                        {{ $pengaduan->tanggal_response->format('d F Y, H:i') }} WIB
                                                    @else
                                                        {{ $pengaduan->updated_at->format('d F Y, H:i') }} WIB
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif

                                <!-- Step 3: Konfirmasi selesai -->
                                @if($pengaduan->status === 'Selesai')
                                <li>
                                    <div class="relative flex items-center">
                                        <div class="relative w-12 h-12 flex items-center justify-center flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-4 ring-white shadow">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1 ml-4">
                                            <div class="text-sm text-gray-900">
                                                <p class="font-medium">Anda konfirmasi selesai</p>
                                                <p class="text-gray-500 mt-1">{{ $pengaduan->updated_at->format('d F Y, H:i') }} WIB</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="Foto Pengaduan" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    @push('scripts')
    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
    @endpush
</x-user-layout> 