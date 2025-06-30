@extends('layouts.user')

@section('title', 'Riwayat Booking')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Booking Anda</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if(session('info'))
             <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        <div class="space-y-6">
            @forelse($bookings as $booking)
                <div class="border rounded-lg p-4 {{ $booking->status_booking == 'Aktif' ? 'border-green-400 bg-green-50' : 'border-gray-300 bg-gray-50' }}">
                    <div class="flex flex-col md:flex-row justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-semibold text-gray-900 mr-3">Kamar {{ $booking->kamar->no_kamar }}</span>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full
                                    @if($booking->status_booking == 'Aktif') bg-green-200 text-green-800
                                    @elseif($booking->status_booking == 'Selesai') bg-gray-200 text-gray-800
                                    @else bg-red-200 text-red-800
                                    @endif">
                                    {{ $booking->status_booking }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">
                                {{ $booking->kamar->tipeKamar->tipe_kamar }} - {{ $booking->paketKamar->jenis_paket }}
                            </p>
                            <p class="text-sm text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->isoFormat('D MMMM YYYY') }} &mdash; {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->isoFormat('D MMMM YYYY') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Total Durasi: {{ $booking->getFormattedTotalDurasi() }}
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0 md:ml-6 flex items-center space-x-3">
                             <a href="{{ route('penghuni.history.show', $booking->id_booking) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                                Detail
                            </a>
                             @if($booking->status_booking == 'Aktif')
                                 <a href="{{ route('penghuni.extension.create', $booking->id_booking) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                                     Perpanjang
                                 </a>
                             @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada riwayat booking</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum pernah melakukan booking kamar.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection 