@extends('pdf.layout', [
    'title' => isset($pembayaran) ? 'Invoice Pembayaran' : 'Invoice Booking',
    'document_number' => isset($pembayaran) 
        ? 'INV-' . str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT)
        : 'INV-' . str_pad($booking->id_booking, 6, '0', STR_PAD_LEFT),
    'company' => $company ?? []
])

@section('content')
<div class="grid-2 mb-20">
    <div class="col">
        <div class="card">
            <div class="card-header">Informasi Penyewa</div>
            <table style="width: 100%; border: none;">
                @if(isset($pembayaran))
                <tr>
                    <td style="border: none; padding: 4px 0; width: 35%;"><strong>Nama:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->user->nama }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Email:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->user->email }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>No. HP:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->user->no_hp }}</td>
                </tr>
                @if($pembayaran->booking && $pembayaran->booking->teman)
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Teman:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->booking->teman->user->nama }}</td>
                </tr>
                @endif
                @else
                <tr>
                    <td style="border: none; padding: 4px 0; width: 35%;"><strong>Nama:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->penghuni->user->nama }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Email:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->penghuni->user->email }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>No. HP:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->penghuni->user->no_hp }}</td>
                </tr>
                @if($booking->teman)
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Teman:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->teman->user->nama }}</td>
                </tr>
                @endif
                @endif
            </table>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">Informasi {{ isset($pembayaran) ? 'Pembayaran' : 'Booking' }}</div>
            <table style="width: 100%; border: none;">
                @if(isset($pembayaran))
                <tr>
                    <td style="border: none; padding: 4px 0; width: 40%;"><strong>ID Pembayaran:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Tanggal:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->tanggal_pembayaran->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Status:</strong></td>
                    <td style="border: none; padding: 4px 0;">
                        @if($pembayaran->status_pembayaran === 'Lunas')
                            <span class="badge badge-success">{{ $pembayaran->status_pembayaran }}</span>
                        @elseif($pembayaran->status_pembayaran === 'Belum bayar')
                            <span class="badge badge-warning">{{ $pembayaran->status_pembayaran }}</span>
                        @else
                            <span class="badge badge-danger">{{ $pembayaran->status_pembayaran }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Jenis Pembayaran:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->payment_type }}</td>
                </tr>
                @else
                <tr>
                    <td style="border: none; padding: 4px 0; width: 40%;"><strong>ID Booking:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ str_pad($booking->id_booking, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Tanggal Booking:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Status:</strong></td>
                    <td style="border: none; padding: 4px 0;">
                        @if($booking->status_booking === 'Aktif')
                            <span class="badge badge-success">{{ $booking->status_booking }}</span>
                        @elseif($booking->status_booking === 'Selesai')
                            <span class="badge badge-info">{{ $booking->status_booking }}</span>
                        @else
                            <span class="badge badge-danger">{{ $booking->status_booking }}</span>
                        @endif
                    </td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>

<div class="card mb-20">
    <div class="card-header">Detail Kamar & Paket</div>
    <table class="table">
        <thead>
            <tr>
                <th>No. Kamar</th>
                <th>Tipe Kamar</th>
                <th>Paket</th>
                <th>Kapasitas</th>
                <th>Penghuni</th>
                <th class="text-right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($pembayaran) && $pembayaran->booking && $pembayaran->booking->kamar)
            <tr>
                <td>{{ $pembayaran->booking->kamar->no_kamar }}</td>
                <td>{{ $pembayaran->booking->kamar->tipeKamar->tipe_kamar }}</td>
                <td>{{ $pembayaran->booking->paketKamar->jenis_paket }}</td>
                <td class="text-center">{{ $pembayaran->booking->paketKamar->kapasitas_kamar }} orang</td>
                <td class="text-center">{{ $pembayaran->booking->paketKamar->jumlah_penghuni }} orang</td>
                <td class="text-right currency">Rp {{ number_format($pembayaran->booking->paketKamar->harga, 0, ',', '.') }}</td>
            </tr>
            @elseif(isset($booking))
            <tr>
                <td>{{ $booking->kamar->no_kamar }}</td>
                <td>{{ $booking->kamar->tipeKamar->tipe_kamar }}</td>
                <td>{{ $booking->paketKamar->jenis_paket }}</td>
                <td class="text-center">{{ $booking->paketKamar->kapasitas_kamar }} orang</td>
                <td class="text-center">{{ $booking->paketKamar->jumlah_penghuni }} orang</td>
                <td class="text-right currency">Rp {{ number_format($booking->paketKamar->harga, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="grid-2 mb-20">
    <div class="col">
        <div class="card">
            <div class="card-header">Periode Sewa</div>
            <table style="width: 100%; border: none;">
                @if(isset($pembayaran) && $pembayaran->booking)
                <tr>
                    <td style="border: none; padding: 4px 0; width: 40%;"><strong>Mulai:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->booking->tanggal_mulai ? \Carbon\Carbon::parse($pembayaran->booking->tanggal_mulai)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Selesai:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->booking->tanggal_selesai ? \Carbon\Carbon::parse($pembayaran->booking->tanggal_selesai)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Durasi:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $pembayaran->booking->total_durasi ?? '-' }}</td>
                </tr>
                @elseif(isset($booking))
                <tr>
                    <td style="border: none; padding: 4px 0; width: 40%;"><strong>Mulai:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->tanggal_mulai ? \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Selesai:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->tanggal_selesai ? \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 4px 0;"><strong>Durasi:</strong></td>
                    <td style="border: none; padding: 4px 0;">{{ $booking->total_durasi ?? '-' }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">Fasilitas Kamar</div>
            <div style="font-size: 11px; line-height: 1.5;">
                @if(isset($pembayaran) && $pembayaran->booking && $pembayaran->booking->kamar)
                {{ $pembayaran->booking->kamar->tipeKamar->fasilitas ?? 'Fasilitas standar kost' }}
                @elseif(isset($booking))
                {{ $booking->kamar->tipeKamar->fasilitas ?? 'Fasilitas standar kost' }}
                @else
                Fasilitas standar kost
                @endif
            </div>
        </div>
    </div>
</div>

@if(isset($pembayaran) && $pembayaran->midtrans_transaction_id)
<div class="card mb-20">
    <div class="card-header">Detail Transaksi</div>
    <table style="width: 100%; border: none;">
        @if($pembayaran->midtrans_order_id)
        <tr>
            <td style="border: none; padding: 4px 0; width: 40%;"><strong>Order ID:</strong></td>
            <td style="border: none; padding: 4px 0;">{{ $pembayaran->midtrans_order_id }}</td>
        </tr>
        @endif
        @if($pembayaran->midtrans_transaction_id)
        <tr>
            <td style="border: none; padding: 4px 0; width: 40%;"><strong>Transaction ID:</strong></td>
            <td style="border: none; padding: 4px 0;">{{ $pembayaran->midtrans_transaction_id }}</td>
        </tr>
        @endif
        <tr>
            <td style="border: none; padding: 4px 0; width: 40%;"><strong>Tanggal Transaksi:</strong></td>
            <td style="border: none; padding: 4px 0;">{{ $pembayaran->tanggal_pembayaran->format('d/m/Y H:i') }} WIB</td>
        </tr>
    </table>
</div>
@endif

@if(isset($booking) && $booking->pembayaranList && $booking->pembayaranList->count() > 0)
<div class="card mb-20">
    <div class="card-header">Riwayat Pembayaran</div>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Tipe Pembayaran</th>
                <th>Status</th>
                <th class="text-right">Jumlah</th>
                <th>ID Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->pembayaranList as $payment)
            <tr>
                <td>{{ $payment->tanggal_pembayaran ? \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d/m/Y H:i') : '-' }}</td>
                <td>{{ ucfirst($payment->payment_type) }}</td>
                <td>
                    @if($payment->status_pembayaran === 'Lunas')
                        <span class="badge badge-success">{{ $payment->status_pembayaran }}</span>
                    @elseif($payment->status_pembayaran === 'Belum bayar')
                        <span class="badge badge-warning">{{ $payment->status_pembayaran }}</span>
                    @else
                        <span class="badge badge-danger">{{ $payment->status_pembayaran }}</span>
                    @endif
                </td>
                <td class="text-right currency">Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</td>
                <td style="font-size: 10px;">{{ $payment->midtrans_transaction_id ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa; font-weight: bold;">
                <td colspan="3" class="text-right">Total Pembayaran:</td>
                <td class="text-right currency">
                    Rp {{ number_format($booking->pembayaranList->where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran'), 0, ',', '.') }}
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
@endif

<div class="card mb-20">
    <div class="card-header">Ringkasan Pembayaran</div>
    <table style="width: 100%; border: none;">
        @if(isset($pembayaran))
        <tr>
            <td style="border: none; padding: 8px 0; width: 70%;"><strong>{{ $pembayaran->payment_type }} Payment:</strong></td>
            <td style="border: none; padding: 8px 0; text-align: right;" class="currency">
                Rp {{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}
            </td>
        </tr>
        <tr style="border-top: 2px solid #f97316; font-size: 14px;">
            <td style="border: none; padding: 12px 0;"><strong>TOTAL:</strong></td>
            <td style="border: none; padding: 12px 0; text-align: right;" class="currency text-large">
                <strong>Rp {{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}</strong>
            </td>
        </tr>
        @else
        <tr>
            <td style="border: none; padding: 8px 0; width: 70%;"><strong>Subtotal:</strong></td>
            <td style="border: none; padding: 8px 0; text-align: right;" class="currency">
                Rp {{ number_format($booking->paketKamar->harga, 0, ',', '.') }}
            </td>
        </tr>
        @if($booking->pembayaranList && $booking->pembayaranList->where('payment_type', 'Additional')->count() > 0)
        <tr>
            <td style="border: none; padding: 8px 0;"><strong>Biaya Tambahan:</strong></td>
            <td style="border: none; padding: 8px 0; text-align: right;" class="currency">
                Rp {{ number_format($booking->pembayaranList->where('payment_type', 'Additional')->sum('jumlah_pembayaran'), 0, ',', '.') }}
            </td>
        </tr>
        @endif
        <tr style="border-top: 2px solid #f97316; font-size: 14px;">
            <td style="border: none; padding: 12px 0;"><strong>TOTAL:</strong></td>
            <td style="border: none; padding: 12px 0; text-align: right;" class="currency text-large">
                <strong>Rp {{ number_format($booking->pembayaranList ? $booking->pembayaranList->sum('jumlah_pembayaran') : $booking->paketKamar->harga, 0, ',', '.') }}</strong>
            </td>
        </tr>
        @endif
    </table>
</div>

<div class="text-center" style="margin-top: 40px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
    <div style="font-size: 11px; color: #666; line-height: 1.5;">
        <strong>Terima kasih telah mempercayai MYKOST sebagai tempat hunian Anda!</strong><br>
        Untuk pertanyaan lebih lanjut, silakan hubungi kami di {{ $company['phone'] ?? '0812-3456-7890' }} atau {{ $company['email'] ?? 'info@mykost.com' }}<br>
        <br>
        <em>Invoice ini sah dan diterbitkan secara elektronik oleh sistem MYKOST</em>
    </div>
</div>
@endsection 