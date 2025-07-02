@extends('pdf.layout', [
    'title' => $title ?? 'Laporan Pengaduan',
    'period' => $period ?? 'Semua Periode'
])

@section('content')
@if(isset($filters) && (count($filters) > 1 || !empty($filters['search'])))
<div class="card mb-20">
    <div class="card-header">Filter yang Diterapkan</div>
    <div class="grid-2">
        @if(!empty($filters['search']))
        <div class="col">
            <strong>Pencarian:</strong> {{ $filters['search'] }}
        </div>
        @endif
        @if(!empty($filters['status']) && $filters['status'] !== 'all')
        <div class="col">
            <strong>Status:</strong> {{ ucfirst($filters['status']) }}
        </div>
        @endif
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
        @if(!empty($filters['response_status']) && $filters['response_status'] !== 'all')
        <div class="col">
            <strong>Status Respon:</strong> {{ $filters['response_status'] === 'responded' ? 'Sudah Direspon' : 'Belum Direspon' }}
        </div>
        @endif
    </div>
</div>
@endif

<div class="card mb-20">
    <div class="card-header">Statistik Pengaduan</div>
    <div class="grid-2">
        <div class="col">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; padding: 4px 0; width: 50%;"><strong>Total Pengaduan:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $complaints->count() }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Menunggu:</strong></td>
                    <td style="border: none; padding: 4px 0;">
                        <span class="badge badge-warning">{{ $complaints->where('status', 'Menunggu')->count() }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Diproses:</strong></td>
                    <td style="border: none; padding: 4px 0;">
                        <span class="badge badge-info">{{ $complaints->where('status', 'Diproses')->count() }}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; padding: 4px 0; width: 50%;"><strong>Selesai:</strong></td>
                    <td style="border: none; padding: 4px 0;">
                        <span class="badge badge-success">{{ $complaints->where('status', 'Selesai')->count() }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Sudah Direspon:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $complaints->whereNotNull('response_admin')->count() }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Belum Direspon:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $complaints->whereNull('response_admin')->count() }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if($complaints->count() > 0)
<div class="card">
    <div class="card-header">Daftar Pengaduan</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">Penghuni</th>
                <th style="width: 10%;">Kamar</th>
                <th style="width: 20%;">Judul</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Respon</th>
                <th style="width: 15%;">Tgl Respon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $pengaduan)
            <tr>
                <td>{{ str_pad($pengaduan->id_pengaduan, 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('d/m/Y') }}</td>
                <td>{{ $pengaduan->penghuni->user->nama ?? '-' }}</td>
                <td>{{ $pengaduan->kamar->no_kamar ?? '-' }}</td>
                <td style="font-size: 10px;">{{ Str::limit($pengaduan->judul_pengaduan, 30) }}</td>
                <td>
                    @if($pengaduan->status === 'Menunggu')
                        <span class="badge badge-warning">{{ $pengaduan->status }}</span>
                    @elseif($pengaduan->status === 'Diproses')
                        <span class="badge badge-info">{{ $pengaduan->status }}</span>
                    @else
                        <span class="badge badge-success">{{ $pengaduan->status }}</span>
                    @endif
                </td>
                <td>
                    @if($pengaduan->response_admin)
                        <span class="badge badge-success">Ada</span>
                    @else
                        <span class="badge badge-warning">Belum</span>
                    @endif
                </td>
                <td>{{ $pengaduan->tanggal_response ? \Carbon\Carbon::parse($pengaduan->tanggal_response)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($complaints->chunk(3) as $chunk)
@if(!$loop->first)
<div class="page-break"></div>
@endif

<div class="card">
    <div class="card-header">Detail Pengaduan ({{ $loop->iteration * 3 - 2 }} - {{ min($loop->iteration * 3, $complaints->count()) }})</div>
    
    @foreach($chunk as $pengaduan)
    <div class="card mb-10" style="border-left: 4px solid 
        @if($pengaduan->status === 'Menunggu') #ffc107 
        @elseif($pengaduan->status === 'Diproses') #17a2b8 
        @else #28a745 @endif;">
        <div style="padding: 10px;">
            <div class="grid-2 mb-10">
                <div class="col">
                    <strong>ID:</strong> {{ str_pad($pengaduan->id_pengaduan, 4, '0', STR_PAD_LEFT) }}<br>
                    <strong>Penghuni:</strong> {{ $pengaduan->penghuni->user->nama ?? '-' }}<br>
                    <strong>Kamar:</strong> {{ $pengaduan->kamar->no_kamar ?? '-' }} ({{ $pengaduan->kamar->tipeKamar->tipe_kamar ?? '-' }})<br>
                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('d F Y H:i') }}
                </div>
                <div class="col">
                    <strong>Status:</strong> 
                    @if($pengaduan->status === 'Menunggu')
                        <span class="badge badge-warning">{{ $pengaduan->status }}</span>
                    @elseif($pengaduan->status === 'Diproses')
                        <span class="badge badge-info">{{ $pengaduan->status }}</span>
                    @else
                        <span class="badge badge-success">{{ $pengaduan->status }}</span>
                    @endif
                    <br><br>
                    @if($pengaduan->foto_pengaduan)
                        <strong>Foto:</strong> <span class="badge badge-info">Ada Lampiran</span><br>
                    @endif
                    @if($pengaduan->response_admin)
                        <strong>Respon Admin:</strong> {{ \Carbon\Carbon::parse($pengaduan->tanggal_response)->format('d/m/Y H:i') }}
                    @endif
                </div>
            </div>
            
            <div class="mb-10">
                <strong>Judul:</strong> {{ $pengaduan->judul_pengaduan }}
            </div>
            
            <div class="mb-10">
                <strong>Isi Pengaduan:</strong><br>
                <div style="font-size: 11px; line-height: 1.4; background: #f8f9fa; padding: 8px; border-radius: 4px;">
                    {{ $pengaduan->isi_pengaduan }}
                </div>
            </div>
            
            @if($pengaduan->response_admin)
            <div>
                <strong>Respon Admin:</strong><br>
                <div style="font-size: 11px; line-height: 1.4; background: #e8f5e8; padding: 8px; border-radius: 4px; border-left: 3px solid #28a745;">
                    {{ $pengaduan->response_admin }}
                </div>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endforeach

@else
<div class="card text-center" style="padding: 40px;">
    <div style="font-size: 14px; color: #666;">
        <strong>Tidak ada data pengaduan</strong><br>
        <span style="font-size: 12px;">Sesuai dengan filter yang diterapkan</span>
    </div>
</div>
@endif

<div class="text-center" style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
    <div style="font-size: 11px; color: #666;">
        <strong>Laporan Pengaduan MYKOST</strong><br>
        Dicetak pada: {{ $generated_at->format('d F Y \p\u\k\u\l H:i') }} WIB<br>
        <em>Dokumen ini sah dan diterbitkan secara elektronik</em>
    </div>
</div>
@endsection 