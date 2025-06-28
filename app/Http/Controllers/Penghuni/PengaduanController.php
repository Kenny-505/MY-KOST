<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        $pengaduan = Pengaduan::where('id_penghuni', $penghuni->id_penghuni)
            ->with('kamar')
            ->orderBy('tanggal_pengaduan', 'desc')
            ->get();

        return view('penghuni.pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Get rooms that this penghuni is currently occupying
        $kamar = Kamar::whereHas('booking', function ($query) use ($penghuni) {
            $query->where('status_booking', 'Aktif')
                  ->where(function ($q) use ($penghuni) {
                      $q->where('id_penghuni', $penghuni->id_penghuni)
                        ->orWhere('id_teman', $penghuni->id_penghuni);
                  });
        })->get();

        return view('penghuni.pengaduan.create', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'foto_pengaduan' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        $data = [
            'id_penghuni' => $penghuni->id_penghuni,
            'id_kamar' => $request->id_kamar,
            'judul_pengaduan' => $request->judul_pengaduan,
            'isi_pengaduan' => $request->isi_pengaduan,
            'tanggal_pengaduan' => now(),
            'status' => 'Menunggu',
        ];

        // Handle image upload
        if ($request->hasFile('foto_pengaduan')) {
            $image = $request->file('foto_pengaduan');
            $data['foto_pengaduan'] = base64_encode(file_get_contents($image->getRealPath()));
        }

        Pengaduan::create($data);

        return redirect()->route('penghuni.pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function show(Pengaduan $pengaduan)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Check if this pengaduan belongs to the current penghuni
        if ($pengaduan->id_penghuni !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        $pengaduan->load('kamar.tipeKamar');

        return view('penghuni.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Mark pengaduan as completed (only penghuni can do this)
     */
    public function markAsCompleted(Pengaduan $pengaduan)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Check if this pengaduan belongs to the current penghuni
        if ($pengaduan->id_penghuni !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        // Validation: can only mark as completed if status is "Diproses"
        if ($pengaduan->status !== 'Diproses') {
            return back()->with('error', 'Pengaduan hanya dapat diselesaikan jika sudah dalam status "Diproses".');
        }

        $pengaduan->update(['status' => 'Selesai']);

        return redirect()->route('penghuni.pengaduan.index')
                       ->with('success', 'Pengaduan berhasil ditandai sebagai selesai. Terima kasih atas konfirmasinya.');
    }
}