@extends('pdf.layout', [
    'title' => $title ?? 'Laporan Transaksi',
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
        @if(!empty($filters['status']) && $filters['status'] !== 'all')
        <div class="col">
            <strong>Status:</strong> {{ ucfirst($filters['status']) }}
        </div>
        @endif
        @if(!empty($filters['payment_type']) && $filters['payment_type'] !== 'all')
        <div class="col">
            <strong>Tipe Pembayaran:</strong> {{ ucfirst($filters['payment_type']) }}
        </div>
        @endif
        @if(!empty($filters['room_type']) && $filters['room_type'] !== 'all')
        <div class="col">
            <strong>Tipe Kamar:</strong> {{ ucfirst($filters['room_type']) }}
        </div>
        @endif
        @if(!empty($filters['search']))
        <div class="col">
            <strong>Pencarian:</strong> {{ $filters['search'] }}
        </div>
        @endif
    </div>
</div>
@endif

<div class="card mb-20">
    <div class="card-header">Ringkasan Transaksi</div>
    <div class="grid-2">
        <div class="col">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; padding: 6px 0; width: 60%;"><strong>Total Transaksi:</strong></td>
                    <td style="border: none; padding: 6px 0;">{{ $transactions->count() }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Transaksi Lunas:</strong></td>
                    <td style="border: none; padding: 6px 0;">
                        <span class="badge badge-success">{{ $transactions->where('status_pembayaran', 'Lunas')->count() }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Belum Bayar:</strong></td>
                    <td style="border: none; padding: 6px 0;">
                        <span class="badge badge-warning">{{ $transactions->where('status_pembayaran', 'Belum bayar')->count() }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Gagal:</strong></td>
                    <td style="border: none; padding: 6px 0;">
                        <span class="badge badge-danger">{{ $transactions->where('status_pembayaran', 'Gagal')->count() }}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; padding: 6px 0; width: 60%;"><strong>Total Pendapatan:</strong></td>
                    <td style="border: none; padding: 6px 0;" class="currency">
                        Rp {{ number_format($transactions->where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Booking:</strong></td>
                    <td style="border: none; padding: 6px 0;" class="currency">
                        Rp {{ number_format($transactions->where('status_pembayaran', 'Lunas')->where('payment_type', 'Booking')->sum('jumlah_pembayaran'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Extension:</strong></td>
                    <td style="border: none; padding: 6px 0;" class="currency">
                        Rp {{ number_format($transactions->where('status_pembayaran', 'Lunas')->where('payment_type', 'Extension')->sum('jumlah_pembayaran'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 6px 0;"><strong>Additional:</strong></td>
                    <td style="border: none; padding: 6px 0;" class="currency">
                        Rp {{ number_format($transactions->where('status_pembayaran', 'Lunas')->where('payment_type', 'Additional')->sum('jumlah_pembayaran'), 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if(isset($summary) && is_array($summary) && isset($summary['monthly_stats']) && count($summary['monthly_stats']) > 0)
<div class="card mb-20">
    <div class="card-header">Ringkasan per Bulan</div>
    <table class="table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summary['monthly_stats'] as $month => $data)
            <tr>
                <td>{{ date('F Y', mktime(0, 0, 0, $month, 1, date('Y'))) }}</td>
                <td class="text-right currency">Rp {{ number_format($data->total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if($transactions->count() > 0)
<div class="card">
    <div class="card-header">Detail Transaksi</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">User</th>
                <th style="width: 8%;">Kamar</th>
                <th style="width: 10%;">Tipe</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 12%;">Jumlah</th>
                <th style="width: 25%;">ID Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ str_pad($transaction->id_pembayaran, 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $transaction->tanggal_pembayaran ? \Carbon\Carbon::parse($transaction->tanggal_pembayaran)->format('d/m/Y H:i') : '-' }}</td>
                <td style="font-size: 10px;">{{ $transaction->user->nama ?? '-' }}</td>
                <td>{{ $transaction->kamar->no_kamar ?? '-' }}</td>
                <td>{{ ucfirst($transaction->payment_type) }}</td>
                <td>
                    @if($transaction->status_pembayaran === 'Lunas')
                        <span class="badge badge-success">{{ $transaction->status_pembayaran }}</span>
                    @elseif($transaction->status_pembayaran === 'Belum bayar')
                        <span class="badge badge-warning">Pending</span>
                    @else
                        <span class="badge badge-danger">{{ $transaction->status_pembayaran }}</span>
                    @endif
                </td>
                <td class="text-right currency">Rp {{ number_format($transaction->jumlah_pembayaran, 0, ',', '.') }}</td>
                <td style="font-size: 9px;">{{ $transaction->midtrans_transaction_id ?? $transaction->midtrans_order_id ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa; font-weight: bold;">
                <td colspan="6" class="text-right">Total Pendapatan (Lunas):</td>
                <td class="text-right currency">
                    Rp {{ number_format($transactions->where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran'), 0, ',', '.') }}
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

@if($transactions->count() > 20)
<div class="page-break"></div>

<div class="card">
    <div class="card-header">Analisis Transaksi</div>
    
    <div class="grid-2 mb-20">
        <div class="col">
            <div class="card">
                <div class="card-header">Distribusi per Tipe Pembayaran</div>
                <table style="width: 100%; border: none;">
                    @php
                        $booking_count = $transactions->where('payment_type', 'Booking')->count();
                        $extension_count = $transactions->where('payment_type', 'Extension')->count();
                        $additional_count = $transactions->where('payment_type', 'Additional')->count();
                        $total = $transactions->count();
                    @endphp
                    <tr>
                        <td style="border: none; padding: 4px 0; width: 50%;"><strong>Booking:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $booking_count }} ({{ $total > 0 ? round(($booking_count/$total)*100, 1) : 0 }}%)</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Extension:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $extension_count }} ({{ $total > 0 ? round(($extension_count/$total)*100, 1) : 0 }}%)</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Additional:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $additional_count }} ({{ $total > 0 ? round(($additional_count/$total)*100, 1) : 0 }}%)</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col">
            <div class="card">
                <div class="card-header">Tingkat Keberhasilan</div>
                <table style="width: 100%; border: none;">
                    @php
                        $success_rate = $total > 0 ? round(($transactions->where('status_pembayaran', 'Lunas')->count()/$total)*100, 1) : 0;
                        $pending_rate = $total > 0 ? round(($transactions->where('status_pembayaran', 'Belum bayar')->count()/$total)*100, 1) : 0;
                        $failed_rate = $total > 0 ? round(($transactions->where('status_pembayaran', 'Gagal')->count()/$total)*100, 1) : 0;
                    @endphp
                    <tr>
                        <td style="border: none; padding: 4px 0; width: 50%;"><strong>Sukses:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $success_rate }}%</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Pending:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $pending_rate }}%</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;"><strong>Gagal:</strong></td>
                        <td style="border: none; padding: 4px 0;">{{ $failed_rate }}%</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">Rata-rata Transaksi</div>
        <table style="width: 100%; border: none;">
            @php
                $avg_transaction = $transactions->where('status_pembayaran', 'Lunas')->avg('jumlah_pembayaran');
                $min_transaction = $transactions->where('status_pembayaran', 'Lunas')->min('jumlah_pembayaran');
                $max_transaction = $transactions->where('status_pembayaran', 'Lunas')->max('jumlah_pembayaran');
            @endphp
            <tr>
                <td style="border: none; padding: 6px 0; width: 30%;"><strong>Rata-rata:</strong></td>
                <td style="border: none; padding: 6px 0;" class="currency">Rp {{ number_format($avg_transaction ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 6px 0;"><strong>Minimum:</strong></td>
                <td style="border: none; padding: 6px 0;" class="currency">Rp {{ number_format($min_transaction ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 6px 0;"><strong>Maximum:</strong></td>
                <td style="border: none; padding: 6px 0;" class="currency">Rp {{ number_format($max_transaction ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</div>
@endif

@else
<div class="card text-center" style="padding: 40px;">
    <div style="font-size: 14px; color: #666;">
        <strong>Tidak ada data transaksi</strong><br>
        <span style="font-size: 12px;">Sesuai dengan filter yang diterapkan</span>
    </div>
</div>
@endif

<div class="text-center" style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
    <div style="font-size: 11px; color: #666;">
        <strong>Laporan Transaksi MYKOST</strong><br>
        Dicetak pada: {{ $generated_at->format('d F Y \p\u\k\u\l H:i') }} WIB<br>
        <em>Dokumen ini sah dan diterbitkan secara elektronik</em>
    </div>
</div>
@endsection 