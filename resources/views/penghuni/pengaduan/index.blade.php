<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Pengaduan Saya') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Kelola pengaduan yang telah Anda buat</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('penghuni.pengaduan.create') }}" 
                   class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Pengaduan Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-blue-500">
                    <div class="text-2xl font-bold text-blue-600">{{ $pengaduan->count() }}</div>
                    <div class="text-sm text-gray-600">Total Pengaduan</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-yellow-500">
                    <div class="text-2xl font-bold text-yellow-600">{{ $pengaduan->where('status', 'Menunggu')->count() }}</div>
                    <div class="text-sm text-gray-600">Menunggu</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-orange-500">
                    <div class="text-2xl font-bold text-orange-600">{{ $pengaduan->where('status', 'Diproses')->count() }}</div>
                    <div class="text-sm text-gray-600">Diproses</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-green-500">
                    <div class="text-2xl font-bold text-green-600">{{ $pengaduan->where('status', 'Selesai')->count() }}</div>
                    <div class="text-sm text-gray-600">Selesai</div>
                </div>
            </div>

            <!-- Pengaduan List -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                @if($pengaduan->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($pengaduan as $item)
                        <div class="p-6 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-lg font-medium text-gray-900 truncate">{{ $item->judul_pengaduan }}</h3>
                                            @if($item->status === 'Menunggu')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Menunggu
                                                </span>
                                            @elseif($item->status === 'Diproses')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    Diproses
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            #{{ str_pad($item->id_pengaduan, 6, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-3">
                                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($item->isi_pengaduan, 150) }}</p>
                                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-2-5a2 2 0 11-4 0 2 2 0 014 0zM9 3v2m0 0V3m0 2h6m-6 0h6m2 5H7m5 4v6m4-6v6m2-9a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                {{ $item->kamar->no_kamar }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-6 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2v-6a2 2 0 00-2-2"></path>
                                                </svg>
                                                {{ $item->kamar->tipeKamar->tipe_kamar }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $item->tanggal_pengaduan->format('d/m/Y H:i') }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                {{ $item->penghuni->user->nama }}
                                            </span>
                                            @if($item->hasResponse())
                                                <span class="flex items-center text-green-600">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.405L3 21l1.405-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                                    </svg>
                                                    Ada Response
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('penghuni.pengaduan.show', $item) }}" 
                                               class="text-orange-600 hover:text-orange-800 text-sm font-medium transition duration-200">
                                                Lihat Detail
                                            </a>
                                        </div>

                                        @if($item->status === 'Diproses')
                                            <form method="POST" action="{{ route('penghuni.pengaduan.markCompleted', $item) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-medium transition duration-200 flex items-center"
                                                        onclick="return confirm('Apakah Anda yakin bahwa masalah sudah selesai ditangani? Status pengaduan akan berubah menjadi Selesai.')">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Selesai
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                @if($item->foto_pengaduan)
                                    <div class="ml-4 flex-shrink-0">
                                        <img src="data:image/jpeg;base64,{{ $item->foto_pengaduan }}" 
                                             alt="Foto Pengaduan" 
                                             class="w-16 h-16 object-cover rounded-lg cursor-pointer"
                                             onclick="openImageModal('data:image/jpeg;base64,{{ $item->foto_pengaduan }}')">
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Pengaduan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Anda belum membuat pengaduan. Buat pengaduan baru jika ada masalah yang perlu dilaporkan.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('penghuni.pengaduan.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Pengaduan Baru
                            </a>
                        </div>
                    </div>
                @endif
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