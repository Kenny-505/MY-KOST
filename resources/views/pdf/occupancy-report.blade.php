@extends('pdf.layout', [
    'title' => $title ?? 'Laporan Okupansi',
    'period' => $period ?? 'Semua Periode'
])

@section('content')
@if(isset($filters) && count($filters) > 0)
<div class="card mb-20">
    <div class="card-header">Filter yang Diterapkan</div>
    <div class="grid-2">
        @if(!empty($filters['start_date']))
        <div class="col">
            <strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }}
        </div>
        @endif
        @if(!empty($filters['end_date']))
        <div class="col">
            <strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}
        </div>
        @endif
        @if(!empty($filters['room_type']) && $filters['room_type'] !== 'all')
        <div class="col">
            <strong>Tipe Kamar:</strong> {{ ucfirst($filters['room_type']) }}
        </div>
        @endif
        @if(!empty($filters['status']) && $filters['status'] !== 'all')
        <div class="col">
            <strong>Status:</strong> {{ ucfirst($filters['status']) }}
        </div>
        @endif
    </div>
</div>
@endif

@if(isset($summary))
<div class="card mb-20">
    <div class="card-header">Ringkasan Okupansi</div>
    <div class="grid-2">
        <div class="col">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; padding: 6px 0; width: 60%;"><strong>Total Kamar:</strong></td>
                    <td style="border: none; padding: 6px 0;">{{ $summary['total_rooms'] ?? 0 }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Kamar Terisi:</strong></td>
                    <td style="border: none; padding: 6px 0;">
                        <span class="badge badge-success">{{ $summary['occupied_rooms'] ?? 0 }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Kamar Dipesan:</strong></td>
                    <td style="border: none; padding: 6px 0;">
                        <span class="badge badge-warning">{{ $summary['booked_rooms'] ?? 0 }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Kamar Kosong:</strong></td>
                    <td style="border: none; padding: 6px 0;">
                        <span class="badge badge-info">{{ $summary['empty_rooms'] ?? 0 }}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; padding: 6px 0; width: 60%;"><strong>Tingkat Okupansi:</strong></td>
                    <td style="border: none; padding: 6px 0;" class="currency">
                        {{ $summary['occupancy_rate'] ?? 0 }}%
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Total Penghuni Aktif:</strong></td>
                    <td style="border: none; padding: 6px 0;">{{ $summary['active_tenants'] ?? 0 }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Booking Aktif:</strong></td>
                    <td style="border: none; padding: 6px 0;">{{ $summary['active_bookings'] ?? 0 }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Kapasitas Maksimal:</strong></td>
                    <td style="border: none; padding: 6px 0;">{{ $summary['max_capacity'] ?? 0 }} orang</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endif

@if(isset($occupancy_data) && count($occupancy_data) > 0)
<div class="card mb-20">
    <div class="card-header">Status Kamar per Tipe</div>
    <table class="table">
        <thead>
            <tr>
                <th>Tipe Kamar</th>
                <th class="text-center">Total</th>
                <th class="text-center">Terisi</th>
                <th class="text-center">Dipesan</th>
                <th class="text-center">Kosong</th>
                <th class="text-center">Okupansi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($occupancy_data->groupBy('kamar.tipeKamar.tipe_kamar') as $tipe => $rooms)
            @php
                $total = $rooms->count();
                $terisi = $rooms->where('status', 'Terisi')->count();
                $dipesan = $rooms->where('status', 'Dipesan')->count();
                $kosong = $rooms->where('status', 'Kosong')->count();
                $okupansi = $total > 0 ? round((($terisi + $dipesan) / $total) * 100, 1) : 0;
            @endphp
            <tr>
                <td><strong>{{ $tipe }}</strong></td>
                <td class="text-center">{{ $total }}</td>
                <td class="text-center">
                    <span class="badge badge-success">{{ $terisi }}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-warning">{{ $dipesan }}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-info">{{ $kosong }}</span>
                </td>
                <td class="text-center currency">{{ $okupansi }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card mb-20">
    <div class="card-header">Detail Status Kamar</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 15%;">No. Kamar</th>
                <th style="width: 15%;">Tipe</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 20%;">Penghuni</th>
                <th style="width: 15%;">Mulai Sewa</th>
                <th style="width: 15%;">Selesai Sewa</th>
                <th style="width: 8%;">Sisa Hari</th>
            </tr>
        </thead>
        <tbody>
            @foreach($occupancy_data as $kamar)
            <tr>
                <td><strong>{{ $kamar->no_kamar }}</strong></td>
                <td>{{ $kamar->tipeKamar->tipe_kamar ?? '-' }}</td>
                <td>
                    @if($kamar->status === 'Terisi')
                        <span class="badge badge-success">{{ $kamar->status }}</span>
                    @elseif($kamar->status === 'Dipesan')
                        <span class="badge badge-warning">{{ $kamar->status }}</span>
                    @else
                        <span class="badge badge-info">{{ $kamar->status }}</span>
                    @endif
                </td>
                <td style="font-size: 10px;">
                    @if($kamar->currentBooking)
                        {{ $kamar->currentBooking->penghuni->user->nama ?? '-' }}
                        @if($kamar->currentBooking->teman)
                            <br><small>+ {{ $kamar->currentBooking->teman->user->nama }}</small>
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td>
                    {{ $kamar->currentBooking && $kamar->currentBooking->tanggal_mulai 
                        ? \Carbon\Carbon::parse($kamar->currentBooking->tanggal_mulai)->format('d/m/Y') 
                        : '-' }}
                </td>
                <td>
                    {{ $kamar->currentBooking && $kamar->currentBooking->tanggal_selesai 
                        ? \Carbon\Carbon::parse($kamar->currentBooking->tanggal_selesai)->format('d/m/Y') 
                        : '-' }}
                </td>
                <td class="text-center">
                    @if($kamar->currentBooking && $kamar->currentBooking->tanggal_selesai)
                        @php
                            $remaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($kamar->currentBooking->tanggal_selesai), false);
                        @endphp
                        @if($remaining > 0)
                            {{ $remaining }} hari
                        @elseif($remaining == 0)
                            <span class="badge badge-warning">Hari ini</span>
                        @else
                            <span class="badge badge-danger">Expired</span>
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($occupancy_data->count() > 15)
<div class="page-break"></div>

<div class="card mb-20">
    <div class="card-header">Analisis Okupansi</div>
    
    <div class="grid-2 mb-20">
        <div class="col">
            <div class="card">
                <div class="card-header">Distribusi Tipe Kamar</div>
                <table style="width: 100%; border: none;">
                    @php
                        $standar_count = $occupancy_data->where('tipeKamar.tipe_kamar', 'Standar')->count();
                        $elite_count = $occupancy_data->where('tipeKamar.tipe_kamar', 'Elite')->count();
                        $exclusive_count = $occupancy_data->where('tipeKamar.tipe_kamar', 'Exclusive')->count();
                        $total_rooms = $occupancy_data->count();
                    @endphp
                    <tr>
                        <td style="border: none; padding: 4px 0; width: 50%;"><strong>Standar:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $standar_count }} ({{ $total_rooms > 0 ? round(($standar_count/$total_rooms)*100, 1) : 0 }}%)</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Elite:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $elite_count }} ({{ $total_rooms > 0 ? round(($elite_count/$total_rooms)*100, 1) : 0 }}%)</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Exclusive:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $exclusive_count }} ({{ $total_rooms > 0 ? round(($exclusive_count/$total_rooms)*100, 1) : 0 }}%)</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col">
            <div class="card">
                <div class="card-header">Tingkat Utilitas</div>
                <table style="width: 100%; border: none;">
                    @php
                        $occupied_percentage = $total_rooms > 0 ? round(($occupancy_data->where('status', 'Terisi')->count()/$total_rooms)*100, 1) : 0;
                        $booked_percentage = $total_rooms > 0 ? round(($occupancy_data->where('status', 'Dipesan')->count()/$total_rooms)*100, 1) : 0;
                        $empty_percentage = $total_rooms > 0 ? round(($occupancy_data->where('status', 'Kosong')->count()/$total_rooms)*100, 1) : 0;
                    @endphp
                    <tr>
                        <td style="border: none; padding: 4px 0; width: 50%;"><strong>Terisi:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $occupied_percentage }}%</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Dipesan:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $booked_percentage }}%</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Kosong:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $empty_percentage }}%</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">Kamar yang Akan Berakhir (30 hari ke depan)</div>
        @php
            $expiring_soon = $occupancy_data->filter(function($kamar) {
                if (!$kamar->currentBooking || !$kamar->currentBooking->tanggal_selesai) {
                    return false;
                }
                $remaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($kamar->currentBooking->tanggal_selesai), false);
                return $remaining >= 0 && $remaining <= 30;
            });
        @endphp
        
        @if($expiring_soon->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>No. Kamar</th>
                    <th>Penghuni</th>
                    <th>Tanggal Selesai</th>
                    <th class="text-center">Sisa Hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expiring_soon->sortBy(function($kamar) {
                    return \Carbon\Carbon::parse($kamar->currentBooking->tanggal_selesai);
                }) as $kamar)
                @php
                    $remaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($kamar->currentBooking->tanggal_selesai), false);
                @endphp
                <tr>
                    <td><strong>{{ $kamar->no_kamar }}</strong></td>
                    <td>{{ $kamar->currentBooking->penghuni->user->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($kamar->currentBooking->tanggal_selesai)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($remaining > 7)
                            {{ $remaining }} hari
                        @elseif($remaining > 0)
                            <span class="badge badge-warning">{{ $remaining }} hari</span>
                        @else
                            <span class="badge badge-danger">Hari ini</span>
                        @endif
                    </td>
                    <td>
                        @if($remaining > 7)
                            <span class="badge badge-info">Normal</span>
                        @elseif($remaining > 0)
                            <span class="badge badge-warning">Perhatian</span>
                        @else
                            <span class="badge badge-danger">Urgent</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center" style="padding: 20px; color: #666;">
            <em>Tidak ada kamar yang akan berakhir dalam 30 hari ke depan</em>
        </div>
        @endif
    </div>
</div>
@endif

@else
<div class="card text-center" style="padding: 40px;">
    <div style="font-size: 14px; color: #666;">
        <strong>Tidak ada data okupansi</strong><br>
        <span style="font-size: 12px;">Sesuai dengan filter yang diterapkan</span>
    </div>
</div>
@endif

<div class="text-center" style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
    <div style="font-size: 11px; color: #666;">
        <strong>Laporan Okupansi MYKOST</strong><br>
        Dicetak pada: {{ $generated_at->format('d F Y \p\u\k\u\l H:i') }} WIB<br>
        <em>Dokumen ini sah dan diterbitkan secara elektronik</em>
    </div>
</div>
@endsection 