@extends("layouts.admin")

@section("title", "Detail Paket Kamar")

@section("content")
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route("admin.dashboard") }}" class="hover:text-gray-700">Dashboard</a>
            <span class="text-gray-400">/</span>
            <a href="{{ route("admin.paket-kamar.index") }}" class="hover:text-gray-700">Paket Kamar</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900">Detail</span>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $paketKamar->tipeKamar->tipe_kamar }} {{ $paketKamar->jenis_paket }}</h1>
                <p class="text-gray-600">ID: {{ $paketKamar->id_paket_kamar }}</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-gray-900">
                    Rp {{ number_format($paketKamar->harga, 0, ",", ".") }}
                </div>
                <div class="text-sm text-gray-500">per {{ strtolower($paketKamar->jenis_paket) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Paket</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipe Kamar</dt>
                        <dd class="text-sm text-gray-900">{{ $paketKamar->tipeKamar->tipe_kamar }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jenis Paket</dt>
                        <dd class="text-sm text-gray-900">{{ $paketKamar->jenis_paket }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kapasitas Kamar</dt>
                        <dd class="text-sm text-gray-900">{{ $paketKamar->kapasitas_kamar }} orang</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jumlah Penghuni</dt>
                        <dd class="text-sm text-gray-900">{{ $paketKamar->jumlah_penghuni }} orang</dd>
                    </div>
                </dl>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ $paketKamar->bookings->count() }}</div>
                        <div class="text-sm text-blue-600">Total Booking</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">
                            {{ $paketKamar->bookings->where("status_booking", "Aktif")->count() }}
                        </div>
                        <div class="text-sm text-green-600">Booking Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex space-x-3">
            <a href="{{ route("admin.paket-kamar.edit", $paketKamar) }}" 
               class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                Edit Paket
            </a>
            
            <a href="{{ route("admin.paket-kamar.index") }}" 
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
