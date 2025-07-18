@extends("layouts.admin")

@section("title", "Tambah Paket Kamar")

@section("content")
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route("admin.dashboard") }}" class="hover:text-gray-700">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route("admin.paket-kamar.index") }}" class="hover:text-gray-700">Paket Kamar</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900">Tambah Baru</span>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Paket Kamar</h1>
        
        <form action="{{ route("admin.paket-kamar.store") }}" method="POST">
            @csrf
            <!-- Form fields here -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="id_tipe_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Kamar
                    </label>
                    <select name="id_tipe_kamar" id="id_tipe_kamar" required class="w-full rounded-md border-gray-300">
                        <option value="">Pilih Tipe Kamar</option>
                        @foreach($tipeKamar as $tipe)
                            <option value="{{ $tipe->id_tipe_kamar }}">{{ $tipe->tipe_kamar }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- More form fields will be added -->
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg">
                    Simpan Paket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
