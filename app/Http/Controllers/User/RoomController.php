<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use App\Models\PaketKamar;
use App\Models\AdvanceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of available rooms
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Kamar::with(['tipeKamar.paketKamar'])
            ->where(function($q) {
                $q->where('status', 'Kosong')
                  ->orWhere('status', 'Dipesan');
            });

        // Filter by type
        if ($request->filled('tipe')) {
            $query->whereHas('tipeKamar', function($q) use ($request) {
                $q->where('tipe_kamar', $request->tipe);
            });
        }

        // Filter by capacity
        if ($request->filled('kapasitas')) {
            $query->whereHas('tipeKamar.paketKamar', function($q) use ($request) {
                $q->where('kapasitas_kamar', $request->kapasitas);
            });
        }

        // Filter by price range
        if ($request->filled(['min_price', 'max_price'])) {
            $query->whereHas('tipeKamar.paketKamar', function($q) use ($request) {
                $q->whereBetween('harga', [
                    $request->min_price,
                    $request->max_price
                ]);
            });
        }

        // Search by room number or features
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_kamar', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('tipeKamar', function($sq) use ($search) {
                      $sq->where('fasilitas', 'like', "%{$search}%");
                  });
            });
        }

        // Sort results
        $sortField = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        
        if ($sortField === 'price') {
            // Join with paket_kamar through tipe_kamar to sort by price
            $query->join('tipe_kamar', 'kamar.id_tipe_kamar', '=', 'tipe_kamar.id_tipe_kamar')
                  ->join('paket_kamar', 'tipe_kamar.id_tipe_kamar', '=', 'paket_kamar.id_tipe_kamar')
                  ->orderBy('paket_kamar.harga', $sortOrder)
                  ->select('kamar.*')
                  ->distinct();
        } else {
            $query->orderBy($sortField, $sortOrder);
        }

        // Get room types for filter
        $tipeKamar = TipeKamar::all();
        
        // Get min and max prices for filter
        $priceRange = PaketKamar::select(
            DB::raw('MIN(harga) as min_price'),
            DB::raw('MAX(harga) as max_price')
        )->first();

        $rooms = $query->paginate(12)->withQueryString();

        return view('user.rooms.index', compact(
            'rooms',
            'tipeKamar',
            'priceRange'
        ));
    }

    /**
     * Display the specified room
     *
     * @param Kamar $room
     * @return \Illuminate\View\View
     */
    public function show(Kamar $room)
    {
        $room->load(['tipeKamar']);

        // Get advance bookings for this room
        $advanceBookings = AdvanceBooking::where('id_kamar', $room->id_kamar)
            ->where('status', 'Active')
            ->where('tanggal_mulai', '>=', now())
            ->get();

        // Get available packages for this room type
        $availablePackages = PaketKamar::where('id_tipe_kamar', $room->id_tipe_kamar)
            ->orderBy('harga')
            ->get();

        return view('user.rooms.show', compact(
            'room',
            'advanceBookings',
            'availablePackages'
        ));
    }

    /**
     * Check room availability for specific dates
     *
     * @param Request $request
     * @param Kamar $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailability(Request $request, Kamar $room)
    {
        $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Check existing bookings
        $existingBooking = $room->bookings()
            ->where('status_booking', '!=', 'Dibatalkan')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate]);
            })
            ->first();

        // Check advance bookings
        $advanceBooking = $room->advanceBookings()
            ->where('status', 'Active')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate]);
            })
            ->first();

        $isAvailable = !$existingBooking && !$advanceBooking;

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable 
                ? 'Kamar tersedia untuk periode yang dipilih'
                : 'Kamar tidak tersedia untuk periode yang dipilih'
        ]);
    }
}