<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\PaketKamar;
use App\Models\Booking;
use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $kamar = Kamar::with('tipeKamar')->findOrFail($request->kamar_id);
        
        // Check if room is available for booking (not just status, but also no active bookings)
        if (!$kamar->isAvailableForBooking()) {
            $message = $kamar->hasActiveBookings() 
                ? 'Kamar sedang ditempati oleh penghuni lain' 
                : 'Kamar sedang tidak tersedia untuk booking';
                
            return redirect()->route('user.rooms.show', $kamar)
                ->with('error', $message);
        }
        
        // Get available packages for this room type
        $paketKamar = PaketKamar::where('id_tipe_kamar', $kamar->id_tipe_kamar)
            ->orderBy('jenis_paket')
            ->orderBy('jumlah_penghuni')
            ->get();

        $paketKamar->each(function ($paket) {
            switch ($paket->jenis_paket) {
                case 'Mingguan':
                    $paket->durasi_hari = 7;
                    break;
                case 'Bulanan':
                    $paket->durasi_hari = 30;
                    break;
                case 'Tahunan':
                    $paket->durasi_hari = 365;
                    break;
                default:
                    $paket->durasi_hari = 0;
            }
        });
            
        // Debug logging
        \Log::info('Kamar data:', [
            'no_kamar' => $kamar->no_kamar,
            'tipe_kamar' => $kamar->tipeKamar->nama_tipe,
            'kapasitas_max' => $kamar->kapasitas_max,
            'id_tipe_kamar' => $kamar->id_tipe_kamar
        ]);
        
        \Log::info('Available packages:', $paketKamar->toArray());
            
        return view('user.booking.create', compact('kamar', 'paketKamar'));
    }

    public function store(Request $request)
    {
        \Log::info('=== BOOKING STORE START ===');
        \Log::info('Request data received:', $request->all());
        
        // Get package first to determine validation rules
        $paket = PaketKamar::findOrFail($request->id_paket_kamar);
        \Log::info('Package details:', [
            'id' => $paket->id_paket_kamar,
            'jenis' => $paket->jenis_paket,
            'jumlah_penghuni' => $paket->jumlah_penghuni
        ]);
        
        // Dynamic validation rules
        $rules = [
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'id_paket_kamar' => 'required|exists:paket_kamar,id_paket_kamar',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ];
        
        $messages = [
            'friend_email.exists' => 'Email teman tidak terdaftar di sistem MYKOST. Pastikan teman Anda sudah mendaftar terlebih dahulu.',
            'friend_email.email' => 'Format email tidak valid.',
            'friend_email.required' => 'Email teman wajib diisi untuk paket 2 orang.',
            'friend_email.different' => 'Email teman tidak boleh sama dengan email Anda sendiri.',
        ];
        
        // Add friend email validation if package is for 2 people
        if ($paket->jumlah_penghuni == 2) {
            $rules['friend_email'] = [
                'required',
                'email',
                'exists:users,email',
                'different:user_email' // We'll add user email to request for validation
            ];
            // Add current user email to request for validation
            $request->merge(['user_email' => auth()->user()->email]);
        } else {
            $rules['friend_email'] = 'nullable|email|exists:users,email';
        }
        
        \Log::info('Validation rules applied:', $rules);
        $request->validate($rules, $messages);
        \Log::info('Validation passed successfully');

        $kamar = Kamar::findOrFail($request->id_kamar);
        
        // Validate room availability
        if ($kamar->status !== 'Kosong') {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Kamar sedang tidak tersedia']);
        }

        // Check for booking conflicts
        $hasConflict = Booking::where('id_kamar', $request->id_kamar)
            ->where('status_booking', 'Aktif')
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                          ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Tanggal yang dipilih sudah ada booking lain']);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            
            // Double-check room availability before creating booking
            if (!$kamar->isAvailableForBooking()) {
                throw new \Exception('Kamar tidak tersedia. Mungkin sudah di-booking oleh penghuni lain.');
            }

            // Create or find penghuni for main user and ensure active status
            $penghuni = Penghuni::firstOrCreate(
                ['id_user' => $user->id],
                ['status_penghuni' => 'Aktif']
            );
            // Ensure the penghuni is active (handle case where user previously checked out)
            if ($penghuni->status_penghuni !== 'Aktif') {
                $penghuni->status_penghuni = 'Aktif';
                $penghuni->save();
            }

            // Handle friend booking based on package jumlah_penghuni
            $temanId = null;
            if ($paket->jumlah_penghuni == 2 && $request->friend_email) {
                $temanUser = User::where('email', $request->friend_email)
                                ->where('role', 'User')
                                ->first();
                
                if (!$temanUser) {
                    throw new \Exception('Teman dengan email tersebut tidak ditemukan atau bukan User');
                }
                
                // Create or find penghuni for friend and ensure active status
                $temanPenghuni = Penghuni::firstOrCreate(
                    ['id_user' => $temanUser->id],
                    ['status_penghuni' => 'Aktif']
                );
                // Ensure the friend's penghuni is active
                if ($temanPenghuni->status_penghuni !== 'Aktif') {
                    $temanPenghuni->status_penghuni = 'Aktif';
                    $temanPenghuni->save();
                }
                $temanId = $temanPenghuni->id_penghuni;
                
                \Log::info('Friend booking created:', [
                    'friend_email' => $request->friend_email,
                    'friend_user_id' => $temanUser->id,
                    'friend_penghuni_id' => $temanId
                ]);
            }

            // Calculate duration based on package type
            $startDate = Carbon::parse($request->tanggal_mulai);
            $endDate = Carbon::parse($request->tanggal_selesai);
            $totalDurasi = '';

            switch($paket->jenis_paket) {
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
                default:
                    throw new \Exception('Jenis paket tidak valid');
            }

            // Create booking
            $booking = Booking::create([
                'id_penghuni' => $penghuni->id_penghuni,
                'id_teman' => $temanId,
                'id_kamar' => $request->id_kamar,
                'id_paket_kamar' => $request->id_paket_kamar,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'total_durasi' => $totalDurasi,
                'status_booking' => 'Aktif'
            ]);

            // Log booking creation
            \Log::info('Booking created successfully:', [
                'booking_id' => $booking->id_booking,
                'penghuni_id' => $booking->id_penghuni,
                'teman_id' => $booking->id_teman,
                'kamar_id' => $booking->id_kamar,
                'paket_id' => $booking->id_paket_kamar
            ]);

            // Update room status
            $kamar->update(['status' => 'Dipesan']);

            DB::commit();

            // Redirect to payment
            return redirect()->route('payment.form', ['booking' => $booking->id_booking])
                ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Booking creation failed:', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'valid' => !is_null($user),
            'message' => is_null($user) 
                ? 'Email tidak terdaftar di sistem MYKOST' 
                : 'Email valid'
        ]);
    }

    public function validateFriendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $currentUser = Auth::user();
        
        // Check if email is not the same as current user
        if ($request->email === $currentUser->email) {
            return response()->json([
                'valid' => false,
                'message' => 'Anda tidak dapat booking dengan email Anda sendiri'
            ]);
        }

        $user = User::where('email', $request->email)
                   ->where('role', 'User')
                   ->first();

        if ($user) {
            return response()->json([
                'valid' => true,
                'message' => 'Email valid dan terdaftar',
                'name' => $user->nama
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => 'Email tidak terdaftar di sistem MYKOST atau bukan akun User'
        ]);
    }
}