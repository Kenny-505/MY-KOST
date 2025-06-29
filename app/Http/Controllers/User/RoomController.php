<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\PaketKamar;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms with filtering and search
     */
    public function index(Request $request)
    {
        $query = Kamar::with(['tipeKamar']); // Show all rooms with their status

        // Search by room number
        if ($request->filled('search')) {
            $query->where('no_kamar', 'like', '%' . $request->search . '%');
        }

        // Filter by room type
        if ($request->filled('type')) {
            $query->whereHas('tipeKamar', function ($q) use ($request) {
                $q->where('tipe_kamar', $request->type);
            });
        }

        // Filter by availability status (optional)
        if ($request->filled('status')) {
            if ($request->status === 'available') {
                $query->where('status', 'Kosong')
                    ->whereDoesntHave('bookings', function ($q) {
                        $q->where('status_booking', 'Aktif')
                          ->where('tanggal_selesai', '>=', now());
                    });
            } elseif ($request->status === 'occupied') {
                $query->whereHas('bookings', function ($q) {
                    $q->where('status_booking', 'Aktif')
                      ->where('tanggal_selesai', '>=', now());
                });
            }
        }

        // Filter by capacity (from paket_kamar)
        if ($request->filled('capacity')) {
            $query->whereHas('tipeKamar.paketKamar', function ($q) use ($request) {
                $q->where('kapasitas_kamar', $request->capacity);
            });
        }

        // Price range filter
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('tipeKamar.paketKamar', function ($q) use ($request) {
                if ($request->filled('min_price')) {
                    $q->where('harga', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('harga', '<=', $request->max_price);
                }
            });
        }

        // Sort options
        $sortBy = $request->get('sort', 'no_kamar');
        $sortDirection = $request->get('direction', 'asc');

        switch ($sortBy) {
            case 'price':
                // Join with paket_kamar to sort by minimum price
                $query->join('tipe_kamar', 'kamar.id_tipe_kamar', '=', 'tipe_kamar.id_tipe_kamar')
                    ->join('paket_kamar', 'tipe_kamar.id_tipe_kamar', '=', 'paket_kamar.id_tipe_kamar')
                    ->select('kamar.*', DB::raw('MIN(paket_kamar.harga) as min_price'))
                    ->groupBy('kamar.id_kamar')
                    ->orderBy('min_price', $sortDirection);
                break;
            case 'type':
                $query->join('tipe_kamar', 'kamar.id_tipe_kamar', '=', 'tipe_kamar.id_tipe_kamar')
                    ->orderBy('tipe_kamar.tipe_kamar', $sortDirection)
                    ->select('kamar.*');
                break;
            default:
                $query->orderBy($sortBy, $sortDirection);
        }

        $rooms = $query->paginate(9)->withQueryString();

        // Get filter options for dropdowns
        $roomTypes = DB::table('tipe_kamar')->pluck('tipe_kamar')->unique();
        $capacities = DB::table('paket_kamar')->pluck('kapasitas_kamar')->unique()->sort();
        $priceRange = DB::table('paket_kamar')->selectRaw('MIN(harga) as min, MAX(harga) as max')->first();

        return view('user.rooms.index', compact('rooms', 'roomTypes', 'capacities', 'priceRange'));
    }

    /**
     * Display the specified room with details and booking availability
     */
    public function show(Kamar $room)
    {
        $room->load(['tipeKamar']);

        // Get available packages for this room type
        $paketKamar = PaketKamar::where('id_tipe_kamar', $room->id_tipe_kamar)
            ->orderBy('jenis_paket')
            ->orderBy('jumlah_penghuni')
            ->get();

        // Get current bookings to show unavailable dates
        $currentBookings = Booking::where('id_kamar', $room->id_kamar)
            ->where('status_booking', 'Aktif')
            ->where('tanggal_selesai', '>=', now())
            ->with(['penghuni.user', 'paketKamar'])
            ->get();

        return view('user.rooms.show', compact(
            'room',
            'paketKamar',
            'currentBookings'
        ));
    }

    /**
     * Check room availability for specific dates and package
     */
    public function checkAvailability(Request $request, Kamar $room)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'id_paket_kamar' => 'required|exists:paket_kamar,id_paket_kamar'
        ]);

        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);

        // Check for overlapping bookings
        $existingBooking = Booking::where('id_kamar', $room->id_kamar)
            ->where('status_booking', 'Aktif')
            ->where(function($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai])
                      ->orWhereBetween('tanggal_selesai', [$tanggalMulai, $tanggalSelesai])
                      ->orWhere(function($q) use ($tanggalMulai, $tanggalSelesai) {
                          $q->where('tanggal_mulai', '<=', $tanggalMulai)
                            ->where('tanggal_selesai', '>=', $tanggalSelesai);
                      });
            })
            ->exists();

        $isAvailable = !$existingBooking;

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable 
                ? 'Kamar tersedia untuk tanggal yang dipilih' 
                : 'Kamar sudah terbooked untuk tanggal tersebut'
        ]);
    }
}