<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Checkout - MYKOST</title>
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
            background: linear-gradient(135deg, #16a34a, #15803d);
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
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border: 2px solid #16a34a;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .success-icon {
            font-size: 48px;
            color: #16a34a;
            margin-bottom: 15px;
        }
        .success-text {
            font-size: 18px;
            color: #166534;
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
        .status-complete {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .info-box {
            background-color: #eff6ff;
            border: 1px solid #3b82f6;
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
            <p style="margin: 0; font-size: 16px; opacity: 0.9;">Konfirmasi Checkout Berhasil</p>
            <div class="success-badge">✅ BERHASIL</div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $penghuni->user->nama }}</strong>,
            </div>

            <p>Kami informasikan bahwa proses checkout kamar Anda di MYKOST telah <strong>berhasil dilakukan</strong>.</p>

            <!-- Success Card -->
            <div class="success-card">
                <div class="success-icon">✅</div>
                <div class="success-text">Checkout Berhasil</div>
                <p style="margin: 15px 0 0 0; color: #166534; font-weight: 500;">
                    Checkout pada: <strong>{{ $checkoutDate }}</strong>
                </p>
            </div>

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
                    <span class="info-label">Periode Booking:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d F Y') }}</span>
                </div>
                @if($teman)
                <div class="info-row">
                    <span class="info-label">Teman Sekamar:</span>
                    <span class="info-value">{{ $teman->user->nama }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Status Booking:</span>
                    <span class="status-complete">
                        @if($checkoutType === 'roommate_left')
                            Masih Aktif (Teman Keluar)
                        @elseif($checkoutType === 'transferred')
                            Dipindahkan
                        @else
                            {{ $booking->status_booking }}
                        @endif
                    </span>
                </div>
            </div>

            <!-- Status Information -->
            @if($checkoutType === 'roommate_left')
            <div class="info-box">
                <h3 style="color: #1d4ed8; margin-top: 0;">ℹ️ Informasi Checkout:</h3>
                <p style="color: #1d4ed8; margin: 10px 0;">
                    Anda telah berhasil checkout dari kamar. Teman sekamar Anda tetap tinggal dan menjadi penyewa utama kamar.
                </p>
            </div>
            @elseif($checkoutType === 'transferred')
            <div class="info-box">
                <h3 style="color: #1d4ed8; margin-top: 0;">ℹ️ Informasi Checkout:</h3>
                <p style="color: #1d4ed8; margin: 10px 0;">
                    Anda telah berhasil checkout dari kamar. Teman sekamar Anda sekarang menjadi penyewa utama kamar.
                </p>
            </div>
            @else
            <div class="info-box">
                <h3 style="color: #1d4ed8; margin-top: 0;">ℹ️ Informasi Checkout:</h3>
                <p style="color: #1d4ed8; margin: 10px 0;">
                    Anda telah berhasil checkout dari kamar. Booking telah selesai dan kamar sekarang tersedia untuk disewa.
                </p>
            </div>
            @endif

            <!-- What's Next -->
            <div style="background-color: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h3 style="color: #92400e; margin-top: 0;">📌 Yang Perlu Dilakukan:</h3>
                <ul style="color: #92400e; margin: 10px 0; padding-left: 20px;">
                    <li><strong>Barang pribadi:</strong> Pastikan semua barang sudah diambil</li>
                    <li><strong>Kunci kamar:</strong> Serahkan kepada admin jika belum</li>
                    <li><strong>Kondisi kamar:</strong> Lakukan pengecekan dengan admin</li>
                    <li><strong>Deposit:</strong> Akan diproses sesuai kondisi kamar</li>
                </ul>
            </div>

            <!-- Call to Action -->
            <div style="text-align: center; margin: 30px 0;">
                <h3 style="color: #f97316; margin-bottom: 20px;">Butuh Kamar Lagi?</h3>
                <p style="margin-bottom: 25px; font-size: 16px;">
                    Terima kasih telah memilih MYKOST. Jika suatu saat membutuhkan kamar lagi, kami akan senang melayani Anda.
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
                    Kami berharap pengalaman tinggal bersama kami menyenangkan.
                </p>
                <p style="color: #0c4a6e; margin: 10px 0; font-weight: 600;">
                    Semoga sukses dan sampai jumpa lagi! ✨
                </p>
            </div>

            <p>Jika ada pertanyaan mengenai proses checkout atau deposit, jangan ragu untuk menghubungi tim support kami.</p>

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