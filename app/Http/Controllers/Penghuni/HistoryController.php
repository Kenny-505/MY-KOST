<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Penghuni;
use App\Models\PaketKamar;
use App\Mail\CheckoutConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        if (!$penghuni) {
            abort(403, 'Tidak memiliki status penghuni aktif.');
        }

        $bookings = Booking::where('id_penghuni', $penghuni->id_penghuni)
            ->orWhere('id_teman', $penghuni->id_penghuni)
            ->with(['kamar.tipeKamar', 'paketKamar', 'pembayaran'])
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('penghuni.history.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Check if user has access to this booking
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        $booking->load(['kamar.tipeKamar', 'paketKamar', 'pembayaran', 'penghuni.user', 'teman.user']);

        return view('penghuni.history.show', compact('booking'));
    }

    public function payments()
    {
        $user = Auth::user();
        
        $payments = Pembayaran::where('id_user', $user->id)
            ->with(['booking.kamar', 'booking.paketKamar'])
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        return view('penghuni.history.payments', compact('payments'));
    }

    // Extension Methods
    public function showExtendForm(Booking $booking)
    {
        // This method calls the existing createExtension method
        return $this->createExtension($booking);
    }

    public function createExtension(Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        // Check if booking is active
        if ($booking->status_booking !== 'Aktif') {
            return redirect()->back()->with('error', 'Booking tidak aktif.');
        }

        // Get available packages for the same room type
        $availablePackages = PaketKamar::where('id_tipe_kamar', $booking->kamar->id_tipe_kamar)
            ->orderBy('jenis_paket')
            ->orderBy('jumlah_penghuni')
            ->get();

        // Calculate remaining days until current booking expires
        $currentEndDate = Carbon::parse($booking->tanggal_selesai);
        $today = Carbon::now();
        $remainingDays = $today->diffInDays($currentEndDate, false);

        return view('penghuni.extension.create', compact('booking', 'availablePackages', 'remainingDays'));
    }

    public function extend(Request $request, Booking $booking)
    {
        // This method forwards to the existing storeExtension method
        return $this->storeExtension($request, $booking);
    }

    public function storeExtension(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        // Validate form input
        $request->validate([
            'id_paket_kamar' => 'required|exists:paket_kamar,id_paket_kamar',
            'tanggal_mulai_extension' => 'required|date|after_or_equal:' . $booking->tanggal_selesai,
            'tanggal_selesai_extension' => 'required|date|after:tanggal_mulai_extension',
        ], [
            'tanggal_mulai_extension.after_or_equal' => 'Tanggal mulai perpanjangan harus setelah atau sama dengan tanggal selesai booking saat ini.',
            'tanggal_selesai_extension.after' => 'Tanggal selesai perpanjangan harus setelah tanggal mulai.',
        ]);

        $extensionPackage = PaketKamar::findOrFail($request->id_paket_kamar);

        // Validate package compatibility
        if ($extensionPackage->id_tipe_kamar !== $booking->kamar->id_tipe_kamar) {
            return redirect()->back()->withErrors(['error' => 'Paket tidak sesuai dengan tipe kamar.']);
        }

        // Validate occupancy
        $currentOccupancy = $booking->id_teman ? 2 : 1;
        if ($extensionPackage->jumlah_penghuni != $currentOccupancy) {
            return redirect()->back()->withErrors(['error' => 'Jumlah penghuni paket tidak sesuai dengan booking saat ini.']);
        }

        DB::beginTransaction();
        try {
            // Calculate extension duration
            $startDate = Carbon::parse($request->tanggal_mulai_extension);
            $endDate = Carbon::parse($request->tanggal_selesai_extension);
            $totalDurasi = '';

            switch($extensionPackage->jenis_paket) {
                case 'Mingguan':
                    $days = $startDate->diffInDays($endDate);
                    $weeks = round($days / 7, 3);
                    $totalDurasi = $weeks . ' minggu';
                    break;
                case 'Bulanan':
                    $months = $startDate->diffInMonths($endDate);
                    if ($months == 0 && $startDate->diffInDays($endDate) > 0) {
                        $months = round($startDate->diffInDays($endDate) / 30, 3);
                    }
                    $totalDurasi = $months . ' bulan';
                    break;
                case 'Tahunan':
                    $years = $startDate->diffInYears($endDate);
                    if ($years == 0 && $startDate->diffInMonths($endDate) > 0) {
                        $years = round($startDate->diffInDays($endDate) / 365, 3);
                    }
                    $totalDurasi = $years . ' tahun';
                    break;
            }

            // Create new booking for extension
            $extensionBooking = Booking::create([
                'id_penghuni' => $booking->id_penghuni,
                'id_teman' => $booking->id_teman,
                'id_kamar' => $booking->id_kamar,
                'id_paket_kamar' => $request->id_paket_kamar,
                'tanggal_mulai' => $request->tanggal_mulai_extension,
                'tanggal_selesai' => $request->tanggal_selesai_extension,
                'total_durasi' => $totalDurasi,
                'status_booking' => 'Aktif'
            ]);

            // Create payment record for extension using current user's ID
            $payment = Pembayaran::create([
                'id_user' => $user->id, // Either primary or secondary tenant can pay
                'id_booking' => $extensionBooking->id_booking,
                'id_kamar' => $booking->id_kamar,
                'tanggal_pembayaran' => now(),
                'status_pembayaran' => 'Belum bayar',
                'jumlah_pembayaran' => $extensionPackage->harga,
                'payment_type' => 'Extension',
            ]);

            DB::commit();

            // Redirect to payment
            return redirect()->route('payment.form', ['booking' => $extensionBooking->id_booking])
                ->with('success', 'Perpanjangan booking berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Add Penghuni Methods - To be implemented in Phase 7
    public function addPenghuniForm(Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access (only primary tenant can add)
        if ($booking->id_penghuni !== $penghuni->id_penghuni) {
            abort(403, 'Hanya penghuni utama yang dapat menambah penghuni.');
        }

        // Check if booking is active
        if ($booking->status_booking !== 'Aktif') {
            return redirect()->back()->with('error', 'Hanya booking aktif yang dapat ditambahkan penghuni.');
        }

        // Check if room has capacity for 2 and currently only 1
        if ($booking->id_teman !== null) {
            return redirect()->back()->with('error', 'Kamar sudah terisi 2 penghuni.');
        }

        // Get current package details
        $currentPackage = $booking->paketKamar;
        
        // Check if room type supports 2 people
        $doublePackages = PaketKamar::where('id_tipe_kamar', $currentPackage->id_tipe_kamar)
            ->where('jenis_paket', $currentPackage->jenis_paket)
            ->where('kapasitas_kamar', $currentPackage->kapasitas_kamar)
            ->where('jumlah_penghuni', 2)
            ->get();

        if ($doublePackages->isEmpty()) {
            return redirect()->back()->with('error', 'Tipe kamar ini tidak mendukung 2 penghuni.');
        }

        // Get the target package for display in the summary
        $addFriendPackage = $doublePackages->first();

        // Load relationship data
        $booking->load(['kamar.tipeKamar', 'paketKamar']);
        
        return view('penghuni.add-penghuni.create', compact('booking', 'doublePackages', 'addFriendPackage'));
    }

    public function addPenghuni(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access (only primary tenant can add)
        if ($booking->id_penghuni !== $penghuni->id_penghuni) {
            abort(403, 'Hanya penghuni utama yang dapat menambah penghuni.');
        }

        // Validate form input
        $request->validate([
            'friend_email' => 'required|email|exists:users,email',
            'id_paket_kamar_double' => 'required|exists:paket_kamar,id_paket_kamar',
            'agree_terms' => 'required|accepted',
        ], [
            'friend_email.required' => 'Email teman harus diisi.',
            'friend_email.email' => 'Format email tidak valid.',
            'friend_email.exists' => 'Email teman tidak ditemukan dalam sistem.',
            'id_paket_kamar_double.required' => 'Paket 2 penghuni harus dipilih.',
            'id_paket_kamar_double.exists' => 'Paket yang dipilih tidak valid.',
            'agree_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        // Get friend user
        $friendUser = User::where('email', $request->friend_email)->first();

        // Check if friend user exists and is not the same as current user
        if (!$friendUser) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['friend_email' => 'Email teman tidak ditemukan dalam sistem MYKOST.']);
        }

        if ($friendUser->id === $user->id) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['friend_email' => 'Anda tidak dapat menambahkan diri sendiri sebagai teman.']);
        }

        // Check if friend is already in another active booking
        // For users who have penghuni records, check by penghuni_id
        // For new users who don't have penghuni records yet, they're automatically available
        $friendActiveBooking = false;
        $friendPenghuni = $friendUser->activePenghuni();
        
        if ($friendPenghuni) {
            $friendActiveBooking = Booking::where(function($query) use ($friendPenghuni) {
                    $query->where('id_penghuni', $friendPenghuni->id_penghuni)
                          ->orWhere('id_teman', $friendPenghuni->id_penghuni);
                })
                ->where('status_booking', 'Aktif')
                ->where('tanggal_selesai', '>=', now())
                ->exists();
        }

        if ($friendActiveBooking) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['friend_email' => 'Teman sedang memiliki booking aktif di kamar lain.']);
        }

        // Get selected double package
        $doublePackage = PaketKamar::findOrFail($request->id_paket_kamar_double);
        $currentPackage = $booking->paketKamar;

        // Validate package compatibility
        if ($doublePackage->id_tipe_kamar !== $currentPackage->id_tipe_kamar ||
            $doublePackage->jenis_paket !== $currentPackage->jenis_paket ||
            $doublePackage->kapasitas_kamar !== $currentPackage->kapasitas_kamar ||
            $doublePackage->jumlah_penghuni != 2) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['id_paket_kamar_double' => 'Paket yang dipilih tidak kompatibel dengan booking saat ini.']);
        }

        // Calculate remaining duration and additional cost
        $now = Carbon::now();
        $bookingStart = Carbon::parse($booking->tanggal_mulai);
        $bookingEnd = Carbon::parse($booking->tanggal_selesai);
        
        if ($bookingEnd <= $now) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Booking sudah berakhir atau akan berakhir hari ini.']);
        }

        // Calculate remaining days and additional payment (FAIR FORMULA)
        // Start counting from the later of: now OR booking start date
        $effectiveStart = $now->max($bookingStart);
        $remainingDays = $effectiveStart->diffInDays($bookingEnd);
        $totalBookingDays = $bookingStart->diffInDays($bookingEnd);
        
        // Prevent division by zero
        if ($totalBookingDays == 0) {
            $totalBookingDays = 1;
        }
        
        $priceDifference = $doublePackage->harga - $currentPackage->harga;
        $additionalPayment = ($priceDifference * $remainingDays) / $totalBookingDays;
        $additionalPayment = round($additionalPayment, 3); // Round to 3 decimal places

        DB::beginTransaction();

        try {
            // Create or reactivate penghuni record for friend
            $friendPenghuni = Penghuni::firstOrCreate(
                ['id_user' => $friendUser->id],
                ['status_penghuni' => 'Aktif']
            );
            
            // Ensure the friend's penghuni is active (handle case where friend previously checked out)
            if ($friendPenghuni->status_penghuni !== 'Aktif') {
                $friendPenghuni->status_penghuni = 'Aktif';
                $friendPenghuni->save();
            }

            // Update booking with friend
            $booking->update([
                'id_teman' => $friendPenghuni->id_penghuni,
                'id_paket_kamar' => $doublePackage->id_paket_kamar,
            ]);

            // Create additional payment record
            $payment = Pembayaran::create([
                'id_user' => $user->id,
                'id_booking' => $booking->id_booking,
                'id_kamar' => $booking->id_kamar,
                'tanggal_pembayaran' => now(),
                'status_pembayaran' => 'Belum bayar',
                'jumlah_pembayaran' => $additionalPayment,
                'payment_type' => 'Additional',
            ]);

            DB::commit();

            // Redirect to payment if there's additional cost
            if ($additionalPayment > 0) {
                return redirect()->route('payment.form', ['booking' => $booking->id_booking])
                    ->with('success', 'Teman berhasil ditambahkan. Silakan lakukan pembayaran tambahan sebesar Rp ' . number_format($additionalPayment, 3, ',', '.'));
            } else {
                return redirect()->route('penghuni.history.show', $booking)
                    ->with('success', 'Teman berhasil ditambahkan tanpa biaya tambahan.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Checkout Methods
    public function checkout(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access - user must be either main tenant or roommate
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        // Check if booking is active
        if ($booking->status_booking !== 'Aktif') {
            return redirect()->route('penghuni.history.show', $booking)
                ->with('error', 'Booking ini sudah tidak aktif.');
        }

        try {
            DB::beginTransaction();

            // Check if this is a shared room (has roommate)
            if ($booking->teman) {
                // If the person checking out is the main tenant
                if ($booking->id_penghuni === $penghuni->id_penghuni) {
                    // Transfer main tenant to roommate
                    $booking->update([
                        'id_penghuni' => $booking->id_teman,
                        'id_teman' => null
                    ]);
                    
                    // Update the current user's penghuni status to inactive
                    $penghuni->update(['status_penghuni' => 'Non-aktif']);
                    
                    // Send email notification
                    Mail::to($user->email)->send(new CheckoutConfirmation($booking, 'transferred'));
                    
                    $message = 'Checkout berhasil. Teman kamar Anda sekarang menjadi penyewa utama.';
                } else {
                    // If roommate is checking out, just remove them
                    $booking->update(['id_teman' => null]);
                    
                    // Update the current user's penghuni status to inactive
                    $penghuni->update(['status_penghuni' => 'Non-aktif']);
                    
                    // Send email notification
                    Mail::to($user->email)->send(new CheckoutConfirmation($booking, 'roommate_left'));
                    
                    $message = 'Checkout berhasil. Anda telah keluar dari kamar.';
                }
            } else {
                // Single occupancy - end the booking completely
                $booking->update(['status_booking' => 'Selesai']);
                
                // Update room status to available
                $booking->kamar->update(['status' => 'Kosong']);
                
                // Update penghuni status to inactive
                $penghuni->update(['status_penghuni' => 'Non-aktif']);
                
                // Send email notification
                Mail::to($user->email)->send(new CheckoutConfirmation($booking, 'single'));
                
                $message = 'Checkout berhasil. Kamar sekarang tersedia untuk disewa.';
            }

            DB::commit();
            
            // After checkout, user is no longer a penghuni, so redirect to user dashboard
            return redirect()->route('user.dashboard')->with('success', $message . ' Anda sekarang dapat menggunakan sistem sebagai user biasa.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('penghuni.history.show', $booking)
                ->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }

    /**
     * Display invoice details
     *
     * @param int $pembayaranId
     * @return \Illuminate\Http\Response
     */
    public function viewInvoice($pembayaranId)
    {
        $payment = \App\Models\Pembayaran::with(['booking.penghuni', 'booking.kamar', 'booking.paketKamar'])
            ->where('id_pembayaran', $pembayaranId)
            ->firstOrFail();
        
        // Pastikan penghuni hanya bisa melihat invoice miliknya
        if ($payment->id_user !== auth()->id()) {
            abort(403, 'Unauthorized access to payment invoice.');
        }
        
        return view('payment.success', [
            'payment' => $payment,
            'booking' => $payment->booking,
            'isViewingHistory' => true
        ]);
    }
}