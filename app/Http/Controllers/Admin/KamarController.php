<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::with('tipeKamar');

        // Search by room number
        if ($request->filled('search')) {
            $query->where('no_kamar', 'like', '%' . $request->search . '%');
        }

        // Filter by type
        if ($request->filled('tipe')) {
            $query->whereHas('tipeKamar', function ($q) use ($request) {
                $q->where('tipe_kamar', $request->tipe);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortField = $request->input('sort', 'no_kamar');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $kamar = $query->paginate(10)->withQueryString();
        $tipeKamar = TipeKamar::all();

        return view('admin.kamar.index', compact('kamar', 'tipeKamar'));
    }

    public function create()
    {
        $tipeKamar = TipeKamar::all();
        return view('admin.kamar.create', compact('tipeKamar'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_tipe_kamar' => 'required|exists:tipe_kamar,id_tipe_kamar',
                'no_kamar' => 'required|string|max:50|unique:kamar,no_kamar',
                'deskripsi' => 'nullable|string|max:1000',
                'foto_kamar1' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
                'foto_kamar2' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
                'foto_kamar3' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
            ], [
                'id_tipe_kamar.required' => 'Tipe kamar harus dipilih.',
                'no_kamar.required' => 'Nomor kamar harus diisi.',
                'no_kamar.unique' => 'Nomor kamar sudah digunakan.',
                'foto_kamar1.image' => 'File harus berupa gambar.',
                'foto_kamar1.max' => 'Ukuran gambar maksimal 2MB.',
                'foto_kamar1.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            ]);

            DB::beginTransaction();

            $data = $request->only(['id_tipe_kamar', 'no_kamar', 'deskripsi']);
            $data['status'] = 'Kosong'; // Default status for new rooms
            
            // Handle image uploads - store as binary data (not base64 encoded)
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile("foto_kamar$i")) {
                    $image = $request->file("foto_kamar$i");
                    // Store binary data directly (not base64 encoded)
                    $data["foto_kamar$i"] = file_get_contents($image->getRealPath());
                }
            }

            Kamar::create($data);
            
            DB::commit();
            return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menambahkan kamar. ' . $e->getMessage())->withInput();
        }
    }

    public function show(Kamar $kamar)
    {
        $kamar->load(['tipeKamar', 'bookings.penghuni.user', 'pengaduan']);
        return view('admin.kamar.show', compact('kamar'));
    }

    public function edit(Kamar $kamar)
    {
        $tipeKamar = TipeKamar::all();
        return view('admin.kamar.edit', compact('kamar', 'tipeKamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        try {
            $request->validate([
                'id_tipe_kamar' => 'required|exists:tipe_kamar,id_tipe_kamar',
                'no_kamar' => 'required|string|max:50|unique:kamar,no_kamar,' . $kamar->id_kamar . ',id_kamar',
                'status' => 'required|in:Kosong,Dipesan,Terisi',
                'deskripsi' => 'nullable|string|max:1000',
                'foto_kamar1' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
                'foto_kamar2' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
                'foto_kamar3' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
            ], [
                'id_tipe_kamar.required' => 'Tipe kamar harus dipilih.',
                'no_kamar.required' => 'Nomor kamar harus diisi.',
                'no_kamar.unique' => 'Nomor kamar sudah digunakan.',
                'status.required' => 'Status kamar harus dipilih.',
                'status.in' => 'Status kamar tidak valid.',
            ]);

            DB::beginTransaction();

            $data = $request->only(['id_tipe_kamar', 'no_kamar', 'status', 'deskripsi']);
            
            // Handle image uploads - store as binary data (not base64 encoded)
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile("foto_kamar$i")) {
                    $image = $request->file("foto_kamar$i");
                    // Store binary data directly (not base64 encoded)
                    $data["foto_kamar$i"] = file_get_contents($image->getRealPath());
                }
            }

            // Check if status is being changed from Terisi to something else
            if ($kamar->status === 'Terisi' && $request->status !== 'Terisi') {
                // Check if there are active bookings
                if ($kamar->bookings()->where('status_booking', 'Aktif')->exists()) {
                    throw new \Exception('Tidak dapat mengubah status kamar karena masih ada penghuni aktif.');
                }
            }

            $kamar->update($data);
            
            DB::commit();
            return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil diupdate.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengupdate kamar. ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Kamar $kamar)
    {
        try {
            DB::beginTransaction();

            // Check if room has any active bookings
            if ($kamar->bookings()->where('status_booking', 'Aktif')->exists()) {
                throw new \Exception('Tidak dapat menghapus kamar karena masih ada penghuni aktif.');
            }

            // Check if room has any future bookings
            if ($kamar->advanceBookings()->where('status', 'Active')->exists()) {
                throw new \Exception('Tidak dapat menghapus kamar karena masih ada booking di masa depan.');
            }

            $kamar->delete();
            
            DB::commit();
            return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus kamar. ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:kamar,id_kamar'
            ]);

            DB::beginTransaction();

            $rooms = Kamar::whereIn('id_kamar', $request->ids)->get();
            
            // Check for active bookings in any of the selected rooms
            foreach ($rooms as $room) {
                if ($room->bookings()->where('status_booking', 'Aktif')->exists()) {
                    throw new \Exception("Kamar {$room->no_kamar} masih memiliki penghuni aktif.");
                }
                if ($room->advanceBookings()->where('status', 'Active')->exists()) {
                    throw new \Exception("Kamar {$room->no_kamar} masih memiliki booking di masa depan.");
                }
            }

            Kamar::whereIn('id_kamar', $request->ids)->delete();
            
            DB::commit();
            return response()->json(['message' => 'Kamar berhasil dihapus.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}