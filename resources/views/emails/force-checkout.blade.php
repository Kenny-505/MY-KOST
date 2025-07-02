<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Otomatis - MYKOST</title>
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
            background: linear-gradient(135deg, #dc2626, #991b1b);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .alert-badge {
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
        .alert-card {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 2px solid #dc2626;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .alert-icon {
            font-size: 48px;
            color: #dc2626;
            margin-bottom: 15px;
        }
        .alert-text {
            font-size: 18px;
            color: #991b1b;
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
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
        }
        .info-value {
            font-weight: 600;
            color: #1f2937;
        }
        .status-expired {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .instruction-box {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
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
            <p style="margin: 0; font-size: 16px; opacity: 0.9;">Notifikasi Checkout Otomatis</p>
            <div class="alert-badge">🚨 PENTING</div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $recipient->nama }}</strong>,
            </div>

            <p>Kami informasikan bahwa booking kamar Anda di MYKOST telah <strong>berakhir</strong> dan checkout otomatis telah dilakukan.</p>

            <!-- Alert Card -->
            <div class="alert-card">
                <div class="alert-icon">⏰</div>
                <div class="alert-text">Booking Telah Berakhir</div>
                <p style="margin: 15px 0 0 0; color: #991b1b; font-weight: 500;">
                    Checkout otomatis pada: <strong>{{ $checkoutDate }}</strong>
                </p>
            </div>

            <!-- Booking Details Card -->
            <div class="booking-card">
                <div class="booking-header">📋 Detail Booking yang Berakhir</div>
                
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
                    <span class="info-label">Periode Booking:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Durasi Total:</span>
                    <span class="info-value">{{ $booking->total_durasi }}</span>
                </div>
                @if($teman)
                <div class="info-row">
                    <span class="info-label">Teman Sekamar:</span>
                    <span class="info-value">{{ $teman->user->nama }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Status Booking:</span>
                    <span class="status-expired">{{ $booking->status_booking }}</span>
                </div>
            </div>

            <!-- What Happens Next -->
            <div class="instruction-box">
                <h3 style="color: #92400e; margin-top: 0;">📌 Yang Terjadi Setelah Checkout:</h3>
                <ul style="color: #92400e; margin: 10px 0; padding-left: 20px;">
                    <li><strong>Akses kamar:</strong> Sudah tidak berlaku lagi</li>
                    <li><strong>Barang pribadi:</strong> Harap segera diambil jika masih ada</li>
                    <li><strong>Data booking:</strong> Tetap tersimpan dalam riwayat Anda</li>
                    <li><strong>Keamanan:</strong> Kunci/akses kamar telah dinonaktifkan</li>
                </ul>
            </div>

            <!-- Action Required -->
            <div style="background-color: #eff6ff; border: 1px solid #3b82f6; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h3 style="color: #1d4ed8; margin-top: 0;">🔔 Tindakan yang Perlu Dilakukan:</h3>
                <ol style="color: #1d4ed8; margin: 10px 0; padding-left: 20px;">
                    <li>Pastikan semua barang pribadi sudah diambil</li>
                    <li>Serahkan kunci kamar kepada admin (jika belum)</li>
                    <li>Lakukan pengecekan kondisi kamar dengan admin</li>
                    <li>Konfirmasi proses checkout dengan tim MYKOST</li>
                </ol>
            </div>

            <!-- Call to Action -->
            <div style="text-align: center; margin: 30px 0;">
                <h3 style="color: #f97316; margin-bottom: 20px;">Ingin Booking Lagi?</h3>
                <p style="margin-bottom: 25px; font-size: 16px;">
                    Kami senang dapat melayani Anda selama ini. Jika ingin booking kamar lagi di masa depan, silakan hubungi kami.
                </p>
                
                <a href="{{ route('user.rooms.index') }}" class="cta-button">
                    🏠 Lihat Kamar Tersedia
                </a>
            </div>

            <!-- Thank You Message -->
            <div style="background-color: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 25px; margin: 25px 0; text-align: center;">
                <h3 style="color: #0c4a6e; margin-top: 0;">🙏 Terima Kasih</h3>
                <p style="color: #0c4a6e; margin: 15px 0; font-size: 16px;">
                    Terima kasih telah memilih <strong>MYKOST</strong> sebagai tempat tinggal Anda. 
                    Kami berharap pengalaman Anda selama tinggal bersama kami menyenangkan.
                </p>
                <p style="color: #0c4a6e; margin: 10px 0; font-weight: 600;">
                    Semoga sukses dan sampai jumpa lagi! ✨
                </p>
            </div>

            <p>Jika ada pertanyaan mengenai proses checkout atau memerlukan bantuan, jangan ragu untuk menghubungi tim support kami.</p>

            <p style="margin-top: 30px;">
                <strong>Tim MYKOST</strong><br>
                <em>Terima kasih atas kepercayaan Anda</em>
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