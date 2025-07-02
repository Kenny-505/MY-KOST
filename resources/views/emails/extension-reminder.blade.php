<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Perpanjangan Booking - MYKOST</title>
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
            background: linear-gradient(135deg, #dc2626, #f59e0b);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .urgent-badge {
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
        .countdown-card {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .countdown-number {
            font-size: 48px;
            font-weight: 800;
            color: #92400e;
            line-height: 1;
        }
        .countdown-text {
            font-size: 18px;
            color: #92400e;
            font-weight: 600;
            margin-top: 5px;
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
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
        }
        .info-value {
            font-weight: 600;
            color: #1f2937;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            margin: 10px 5px;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(249, 115, 22, 0.4);
        }
        .secondary-button {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }
        .warning-box {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
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
            .cta-button {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">MYKOST</div>
            <p style="margin: 0; font-size: 16px; opacity: 0.9;">Reminder Perpanjangan Booking</p>
            <div class="urgent-badge">⚡ URGENT</div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $penghuni->user->nama }}</strong>,
            </div>

            <p>Kami ingin mengingatkan bahwa booking kamar Anda di MYKOST akan <strong>segera berakhir</strong>.</p>

            <!-- Countdown Card -->
            <div class="countdown-card">
                <div class="countdown-number">{{ $daysRemaining }}</div>
                <div class="countdown-text">Hari Tersisa</div>
                <p style="margin: 15px 0 0 0; color: #92400e; font-weight: 500;">
                    Booking berakhir pada: <strong>{{ $expiryDate }}</strong>
                </p>
            </div>

            <!-- Current Booking Details -->
            <div class="booking-card">
                <div class="booking-header">🏠 Detail Booking Saat Ini</div>
                
                <div class="info-row">
                    <span class="info-label">Nomor Kamar:</span>
                    <span class="info-value">{{ $kamar->no_kamar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipe Kamar:</span>
                    <span class="info-value">{{ $kamar->tipeKamar->tipe_kamar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paket Saat Ini:</span>
                    <span class="info-value">{{ $paket->jenis_paket }} - {{ $paket->jumlah_penghuni }} Orang</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Berakhir:</span>
                    <span class="info-value">{{ $expiryDate }}</span>
                </div>
                @if($teman)
                <div class="info-row">
                    <span class="info-label">Teman Sekamar:</span>
                    <span class="info-value">{{ $teman->user->nama }}</span>
                </div>
                @endif
            </div>

            <!-- Action Required -->
            <div style="text-align: center; margin: 30px 0;">
                <h3 style="color: #dc2626; margin-bottom: 20px;">🚨 Tindakan Diperlukan</h3>
                <p style="margin-bottom: 25px; font-size: 16px;">
                    Untuk tetap tinggal di kamar ini, silakan lakukan perpanjangan booking sebelum tanggal berakhir.
                </p>
                
                <a href="{{ route('penghuni.history.extension.create', $booking) }}" class="cta-button">
                    🔄 Perpanjang Booking Sekarang
                </a>
                
                <a href="{{ route('penghuni.history.show', $booking) }}" class="cta-button secondary-button">
                    📱 Lihat Detail Booking
                </a>
            </div>

            <!-- Warning Information -->
            <div class="warning-box">
                <h3 style="color: #dc2626; margin-top: 0;">⚠️ Penting untuk Diketahui:</h3>
                <ul style="color: #dc2626; margin: 10px 0; padding-left: 20px;">
                    <li><strong>Jika tidak diperpanjang:</strong> Booking akan otomatis berakhir</li>
                    <li><strong>Checkout otomatis:</strong> Akan dilakukan pada tanggal berakhir</li>
                    <li><strong>Barang tertinggal:</strong> Menjadi tanggung jawab penghuni</li>
                    <li><strong>Ketersediaan kamar:</strong> Tidak dijamin jika diperpanjang terlambat</li>
                </ul>
            </div>

            <p>Jika Anda memiliki pertanyaan atau memerlukan bantuan untuk perpanjangan, jangan ragu untuk menghubungi tim support kami.</p>

            <p style="margin-top: 30px;">
                <strong>Tim MYKOST</strong><br>
                <em>Selalu siap membantu Anda</em>
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