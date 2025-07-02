<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking MYKOST</title>
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
            background: linear-gradient(135deg, #f97316, #1e40af);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
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
            <p style="margin: 0; font-size: 16px; opacity: 0.9;">Konfirmasi Booking Berhasil</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $penghuni->user->nama }}</strong>,
            </div>

            <p>Selamat! Booking kamar Anda di MYKOST telah <strong>berhasil dikonfirmasi</strong>. Berikut adalah detail booking Anda:</p>

            <!-- Booking Details Card -->
            <div class="booking-card">
                <div class="booking-header">📋 Detail Booking</div>
                
                <div class="info-row">
                    <span class="info-label">Nomor Kamar:</span>
                    <span class="info-value">{{ $kamar->no_kamar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipe Kamar:</span>
                    <span class="info-value">{{ $kamar->tipeKamar->tipe_kamar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paket:</span>
                    <span class="info-value">{{ $paket->jenis_paket }} - {{ $paket->jumlah_penghuni }} Orang</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Mulai:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Selesai:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Durasi:</span>
                    <span class="info-value">{{ $booking->total_durasi }}</span>
                </div>
                @if($teman)
                <div class="info-row">
                    <span class="info-label">Teman Sekamar:</span>
                    <span class="info-value">{{ $teman->user->nama }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Total Pembayaran:</span>
                    <span class="info-value">Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status Pembayaran:</span>
                    <span class="status-badge status-lunas">{{ $payment->status_pembayaran }}</span>
                </div>
            </div>

            <!-- Important Information -->
            <div style="background-color: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h3 style="color: #92400e; margin-top: 0;">📌 Informasi Penting:</h3>
                <ul style="color: #92400e; margin: 10px 0; padding-left: 20px;">
                    <li>Simpan email ini sebagai bukti booking Anda</li>
                    <li>Check-in dapat dilakukan mulai tanggal {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d F Y') }}</li>
                    <li>Hubungi admin untuk koordinasi check-in</li>
                    <li>Bawa identitas diri (KTP/SIM) saat check-in</li>
                </ul>
            </div>

            <!-- CTA Buttons -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('penghuni.history.show', $booking) }}" class="cta-button">
                    📱 Lihat Detail Booking
                </a>
            </div>

            <p>Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi tim support kami.</p>

            <p style="margin-top: 30px;">
                Terima kasih telah memilih <strong>MYKOST</strong>!<br>
                <em>Tim MYKOST</em>
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