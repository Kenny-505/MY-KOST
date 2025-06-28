@props(['room', 'showBookButton' => true])

@php
$statusColors = [
    'Kosong' => 'bg-green-100 text-green-800',
    'Dipesan' => 'bg-yellow-100 text-yellow-800',
    'Terisi' => 'bg-red-100 text-red-800',
];

$statusColor = $statusColors[$room->status] ?? 'bg-gray-100 text-gray-800';

// Get first image or use placeholder
$imageData = $room->foto_kamar1 ?? null;
$imageUrl = $imageData ? 'data:image/jpeg;base64,' . base64_encode($imageData) : asset('images/kost-background.png');
@endphp

<div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-200 hover:scale-105 hover:shadow-xl h-full flex flex-col">
    <!-- Room Image -->
    <div class="relative h-48 overflow-hidden flex-shrink-0">
        <img src="{{ $imageUrl }}" alt="Kamar {{ $room->no_kamar }}" class="w-full h-full object-cover">
        <div class="absolute top-4 right-4">
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                {{ $room->status }}
            </span>
        </div>
        <div class="absolute top-4 left-4">
            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500 text-white">
                {{ $room->tipeKamar->tipe_kamar ?? 'Standar' }}
            </span>
        </div>
    </div>

    <!-- Room Info -->
    <div class="p-6 flex flex-col flex-grow">
        <!-- Room Number & Type -->
        <div class="mb-3">
            <h3 class="text-xl font-bold text-gray-900 mb-1">Kamar {{ $room->no_kamar }}</h3>
            <p class="text-sm text-gray-600">{{ $room->tipeKamar->tipe_kamar ?? 'Standar' }}</p>
        </div>

        <!-- Description -->
        @if($room->deskripsi)
            <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ $room->deskripsi }}</p>
        @endif

        <!-- Facilities -->
        @if($room->tipeKamar && $room->tipeKamar->fasilitas)
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-900 mb-2">Fasilitas:</h4>
                <div class="text-xs text-gray-600 line-clamp-2">
                    {{ $room->tipeKamar->fasilitas }}
                </div>
            </div>
        @endif

        <!-- Price Range -->
        @if($minPrice && $maxPrice)
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Harga mulai dari:</span>
                    <div class="text-right">
                        @if($minPrice === $maxPrice)
                            <span class="text-lg font-bold text-orange-600">{{ $minPrice }}</span>
                        @else
                            <span class="text-lg font-bold text-orange-600">{{ $minPrice }}</span>
                            <span class="text-sm text-gray-500"> - {{ $maxPrice }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Spacer to push buttons to bottom -->
        <div class="flex-grow"></div>

        <!-- Action Buttons - Fixed at bottom -->
        <div class="flex gap-2 mt-4">
            <a href="{{ route('user.rooms.show', $room->id_kamar) }}" 
               class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded-lg transition-colors duration-200 text-sm font-medium">
                Lihat Detail
            </a>
            
            @if($showBookButton && $room->status === 'Kosong')
                <a href="{{ route('user.booking.create', ['kamar_id' => $room->id_kamar]) }}" 
                   class="flex-1 bg-orange-500 hover:bg-orange-600 text-white text-center py-2 px-4 rounded-lg transition-colors duration-200 text-sm font-medium">
                    Booking
                </a>
            @elseif($room->status !== 'Kosong')
                <button disabled 
                        class="flex-1 bg-gray-300 text-gray-500 text-center py-2 px-4 rounded-lg text-sm font-medium cursor-not-allowed">
                    Tidak Tersedia
                </button>
            @endif
        </div>
    </div>
</div>