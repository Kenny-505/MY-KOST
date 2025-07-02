<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Perpanjangan Booking - MYKOST</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .success-badge {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .success-card {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border: 2px solid #10b981;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .success-icon {
            font-size: 48px;
            color: #059669;
            margin-bottom: 15px;
        }
        .success-text {
            font-size: 18px;
            color: #065f46;
            font-weight: 600;
        }
        .booking-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .booking-header {
            color: #1e40af;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
            font-weight: 600;
            color: #1e40af;
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
        }
        .info-value {
            font-weight: 600;
            color: #1f2937;
        }
        .timeline {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .timeline-item {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }
        .timeline-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .dot-completed {
            background-color: #10b981;
        }
        .dot-current {
            background-color: #0ea5e9;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-lunas {
            background-color: #dcfce7;
            color: #166534;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #1f2937;
            color: #d1d5db;
            padding: 30px;
            text-align: center;
        }
        .footer-links {
            margin: 20px 0;
        }
        .footer-links a {
            color: #f97316;
            text-decoration: none;
            margin: 0 15px;
        }
        .contact-info {
            font-size: 14px;
            margin-top: 20px;
            color: #9ca3af;
        }
        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">MYKOST</div>
            <p style="margin: 0; font-size: 16px; opacity: 0.9;">Perpanjangan Booking Berhasil</p>
            <div class="success-badge">✅ BERHASIL</div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $penghuni->user->nama }}</strong>,
            </div>

            <p>Selamat! Perpanjangan booking kamar Anda di MYKOST telah <strong>berhasil dikonfirmasi</strong>.</p>

            <!-- Success Confirmation -->
            <div class="success-card">
                <div class="success-icon">🎉</div>
                <div class="success-text">Perpanjangan Booking Berhasil!</div>
                <p style="margin: 15px 0 0 0; color: #065f46; font-weight: 500;">
                    Anda dapat tetap tinggal di kamar hingga periode baru berakhir
                </p>
            </div>

            <!-- Extension Timeline -->
            <div class="timeline">
                <h3 style="color: #0c4a6e; margin-top: 0; margin-bottom: 20px;">📅 Timeline Booking</h3>
                
                <div class="timeline-item">
                    <div class="timeline-dot dot-completed"></div>
                    <div>
                        <strong>Booking Awal:</strong> 
                        {{ \Carbon\Carbon::parse($originalBooking->tanggal_mulai)->format('d F Y') }} - 
                        {{ \Carbon\Carbon::parse($originalBooking->tanggal_selesai)->format('d F Y') }}
                        <span style="color: #10b981; font-weight: 600;"> ✓ Selesai</span>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot dot-current"></div>
                    <div>
                        <strong>Periode Perpanjangan:</strong> 
                        {{ \Carbon\Carbon::parse($extensionBooking->tanggal_mulai)->format('d F Y') }} - 
                        {{ \Carbon\Carbon::parse($extensionBooking->tanggal_selesai)->format('d F Y') }}
                        <span style="color: #0ea5e9; font-weight: 600;"> ⚡ Aktif Sekarang</span>
                    </div>
                </div>
            </div>

            <!-- Extension Details Card -->
            <div class="booking-card">
                <div class="booking-header">🔄 Detail Perpanjangan</div>
                
                <div class="info-row">
                    <span class="info-label">Nomor Kamar:</span>
                    <span class="info-value">{{ $kamar->no_kamar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipe Kamar:</span>
                    <span class="info-value">{{ $kamar->tipeKamar->tipe_kamar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paket Perpanjangan:</span>
                    <span class="info-value">{{ $paket->jenis_paket }} - {{ $paket->jumlah_penghuni }} Orang</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Periode Baru:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($extensionBooking->tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($extensionBooking->tanggal_selesai)->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Durasi Perpanjangan:</span>
                    <span class="info-value">{{ $extensionBooking->total_durasi }}</span>
                </div>
                @if($teman)
                <div class="info-row">
                    <span class="info-label">Teman Sekamar:</span>
                    <span class="info-value">{{ $teman->user->nama }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Biaya Perpanjangan:</span>
                    <span class="info-value">Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status Pembayaran:</span>
                    <span class="status-badge status-lunas">{{ $payment->status_pembayaran }}</span>
                </div>
            </div>

            <!-- Important Information -->
            <div style="background-color: #eff6ff; border: 1px solid #3b82f6; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h3 style="color: #1d4ed8; margin-top: 0;">📌 Informasi Penting:</h3>
                <ul style="color: #1d4ed8; margin: 10px 0; padding-left: 20px;">
                    <li>Simpan email ini sebagai bukti perpanjangan booking</li>
                    <li>Booking baru berlaku dari tanggal {{ \Carbon\Carbon::parse($extensionBooking->tanggal_mulai)->format('d F Y') }}</li>
                    <li>Tidak perlu check-in ulang, Anda dapat tetap tinggal</li>
                    <li>Invoice perpanjangan terlampir dalam email ini</li>
                </ul>
            </div>

            <!-- CTA Buttons -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('penghuni.history.show', $extensionBooking) }}" class="cta-button">
                    📱 Lihat Detail Booking Baru
                </a>
            </div>

            <p>Terima kasih telah memperpanjang tinggalan Anda di MYKOST. Jika ada pertanyaan, jangan ragu untuk menghubungi tim support kami.</p>

            <p style="margin-top: 30px;">
                Selamat menikmati periode tinggal yang baru!<br>
                <strong>Tim MYKOST</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-links">
                <a href="mailto:admin@mykost.com">📧 admin@mykost.com</a>
                <a href="tel:+62-xxx-xxxx-xxxx">📞 +62-xxx-xxxx-xxxx</a>
            </div>
            
            <div class="contact-info">
                <p>MYKOST - Solusi Hunian Terpercaya</p>
                <p style="font-size: 12px; opacity: 0.8;">
                    Email ini dikirim otomatis, mohon tidak membalas email ini.
                </p>
            </div>
        </div>
    </div>
</body>
</html> 