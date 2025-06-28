<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use App\Models\PaketKamar;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::with(['tipeKamar'])->where('status', 'Kosong');

        // Filter by room type
        if ($request->filled('tipe_kamar')) {
            $query->whereHas('tipeKamar', function ($q) use ($request) {
                $q->where('tipe_kamar', $request->tipe_kamar);
            });
        }

        // Search by room number
        if ($request->filled('search')) {
            $query->where('no_kamar', 'like', '%' . $request->search . '%');
        }

        $kamar = $query->paginate(12);
        $tipeKamar = TipeKamar::all();

        return view('user.rooms.index', compact('kamar', 'tipeKamar'));
    }

    public function show(Kamar $kamar)
    {
        $kamar->load('tipeKamar');
        $paketKamar = PaketKamar::where('id_tipe_kamar', $kamar->id_tipe_kamar)->get();
        
        return view('user.rooms.show', compact('kamar', 'paketKamar'));
    }
}