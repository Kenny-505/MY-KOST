<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketKamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaketKamarController extends Controller
{
    public function index(Request $request)
    {
        $query = PaketKamar::with('tipeKamar');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('tipeKamar', function($q) use ($request) {
                    $q->where('tipe_kamar', 'like', '%' . $request->search . '%');
                })
                ->orWhere('jenis_paket', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by type
        if ($request->filled('tipe')) {
            $query->whereHas('tipeKamar', function($q) use ($request) {
                $q->where('tipe_kamar', $request->tipe);
            });
        }

        // Filter by package type
        if ($request->filled('jenis_paket')) {
            $query->where('jenis_paket', $request->jenis_paket);
        }

        // Filter by capacity
        if ($request->filled('kapasitas')) {
            $query->where('kapasitas_kamar', $request->kapasitas);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Sort
        $sortField = $request->input('sort', 'harga');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $paketKamar = $query->paginate(15)->withQueryString();
        $tipeKamar = TipeKamar::all();

        return view('admin.paket-kamar.index', compact('paketKamar', 'tipeKamar'));
    }

    public function create()
    {
        $tipeKamar = TipeKamar::all();
        return view('admin.paket-kamar.create', compact('tipeKamar'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_tipe_kamar' => 'required|exists:tipe_kamar,id_tipe_kamar',
                'jenis_paket' => 'required|in:Mingguan,Bulanan,Tahunan',
                'kapasitas_kamar' => 'required|in:1,2',
                'jumlah_penghuni' => 'required|in:1,2|lte:kapasitas_kamar',
                'harga' => 'required|numeric|min:0|max:999999999',
            ], [
                'id_tipe_kamar.required' => 'Tipe kamar harus dipilih.',
                'id_tipe_kamar.exists' => 'Tipe kamar tidak valid.',
                'jenis_paket.required' => 'Jenis paket harus dipilih.',
                'jenis_paket.in' => 'Jenis paket tidak valid.',
                'kapasitas_kamar.required' => 'Kapasitas kamar harus dipilih.',
                'kapasitas_kamar.in' => 'Kapasitas kamar tidak valid.',
                'jumlah_penghuni.required' => 'Jumlah penghuni harus dipilih.',
                'jumlah_penghuni.in' => 'Jumlah penghuni tidak valid.',
                'jumlah_penghuni.lte' => 'Jumlah penghuni tidak boleh melebihi kapasitas kamar.',
                'harga.required' => 'Harga harus diisi.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'harga.min' => 'Harga tidak boleh negatif.',
                'harga.max' => 'Harga terlalu besar.',
            ]);

            // Check for duplicate package
            if (PaketKamar::where([
                'id_tipe_kamar' => $request->id_tipe_kamar,
                'jenis_paket' => $request->jenis_paket,
                'kapasitas_kamar' => $request->kapasitas_kamar,
                'jumlah_penghuni' => $request->jumlah_penghuni,
            ])->exists()) {
                throw new \Exception('Paket kamar dengan kombinasi yang sama sudah ada.');
            }

            DB::beginTransaction();

            PaketKamar::create($request->all());

            DB::commit();
            return redirect()->route('admin.paket-kamar.index')->with('success', 'Paket kamar berhasil ditambahkan.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menambahkan paket kamar. ' . $e->getMessage())->withInput();
        }
    }

    public function show(PaketKamar $paketKamar)
    {
        $paketKamar->load(['tipeKamar', 'bookings.penghuni.user']);
        return view('admin.paket-kamar.show', compact('paketKamar'));
    }

    public function edit(PaketKamar $paketKamar)
    {
        $tipeKamar = TipeKamar::all();
        return view('admin.paket-kamar.edit', compact('paketKamar', 'tipeKamar'));
    }

    public function update(Request $request, PaketKamar $paketKamar)
    {
        try {
            $request->validate([
                'id_tipe_kamar' => 'required|exists:tipe_kamar,id_tipe_kamar',
                'jenis_paket' => 'required|in:Mingguan,Bulanan,Tahunan',
                'kapasitas_kamar' => 'required|in:1,2',
                'jumlah_penghuni' => 'required|in:1,2|lte:kapasitas_kamar',
                'harga' => 'required|numeric|min:0|max:999999999',
            ], [
                'id_tipe_kamar.required' => 'Tipe kamar harus dipilih.',
                'id_tipe_kamar.exists' => 'Tipe kamar tidak valid.',
                'jenis_paket.required' => 'Jenis paket harus dipilih.',
                'jenis_paket.in' => 'Jenis paket tidak valid.',
                'kapasitas_kamar.required' => 'Kapasitas kamar harus dipilih.',
                'kapasitas_kamar.in' => 'Kapasitas kamar tidak valid.',
                'jumlah_penghuni.required' => 'Jumlah penghuni harus dipilih.',
                'jumlah_penghuni.in' => 'Jumlah penghuni tidak valid.',
                'jumlah_penghuni.lte' => 'Jumlah penghuni tidak boleh melebihi kapasitas kamar.',
                'harga.required' => 'Harga harus diisi.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'harga.min' => 'Harga tidak boleh negatif.',
                'harga.max' => 'Harga terlalu besar.',
            ]);

            // Check for duplicate package (excluding current package)
            if (PaketKamar::where([
                'id_tipe_kamar' => $request->id_tipe_kamar,
                'jenis_paket' => $request->jenis_paket,
                'kapasitas_kamar' => $request->kapasitas_kamar,
                'jumlah_penghuni' => $request->jumlah_penghuni,
            ])->where('id_paket_kamar', '!=', $paketKamar->id_paket_kamar)->exists()) {
                throw new \Exception('Paket kamar dengan kombinasi yang sama sudah ada.');
            }

            DB::beginTransaction();

            // Check if package has active bookings and price is being reduced
            if ($request->harga < $paketKamar->harga && 
                $paketKamar->bookings()->where('status_booking', 'Aktif')->exists()) {
                throw new \Exception('Tidak dapat menurunkan harga paket karena masih ada booking aktif.');
            }

            $paketKamar->update($request->all());

            DB::commit();
            return redirect()->route('admin.paket-kamar.index')->with('success', 'Paket kamar berhasil diupdate.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengupdate paket kamar. ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(PaketKamar $paketKamar)
    {
        try {
            DB::beginTransaction();

            // Check if package has any active bookings
            if ($paketKamar->bookings()->where('status_booking', 'Aktif')->exists()) {
                throw new \Exception('Tidak dapat menghapus paket kamar karena masih ada booking aktif.');
            }

            $paketKamar->delete();

            DB::commit();
            return redirect()->route('admin.paket-kamar.index')->with('success', 'Paket kamar berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus paket kamar. ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:paket_kamar,id_paket_kamar'
            ]);

            DB::beginTransaction();

            $packages = PaketKamar::whereIn('id_paket_kamar', $request->ids)->get();
            
            // Check for active bookings
            foreach ($packages as $package) {
                if ($package->bookings()->where('status_booking', 'Aktif')->exists()) {
                    throw new \Exception("Paket kamar {$package->jenis_paket} - {$package->tipeKamar->tipe_kamar} masih memiliki booking aktif.");
                }
            }

            PaketKamar::whereIn('id_paket_kamar', $request->ids)->delete();
            
            DB::commit();
            return response()->json(['message' => 'Paket kamar berhasil dihapus.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}