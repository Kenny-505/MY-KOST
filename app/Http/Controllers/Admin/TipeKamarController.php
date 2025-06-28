<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TipeKamarController extends Controller
{
    public function index(Request $request)
    {
        $query = TipeKamar::withCount(['kamar', 'paketKamar']);

        // Search
        if ($request->filled('search')) {
            $query->where('tipe_kamar', 'like', '%' . $request->search . '%')
                  ->orWhere('fasilitas', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortField = $request->input('sort', 'tipe_kamar');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $tipeKamar = $query->paginate(10)->withQueryString();
        return view('admin.tipe-kamar.index', compact('tipeKamar'));
    }

    public function create()
    {
        return view('admin.tipe-kamar.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tipe_kamar' => 'required|in:Standar,Elite,Exclusive|unique:tipe_kamar,tipe_kamar',
                'fasilitas' => 'required|string|max:1000',
            ], [
                'tipe_kamar.required' => 'Tipe kamar harus dipilih.',
                'tipe_kamar.in' => 'Tipe kamar tidak valid.',
                'tipe_kamar.unique' => 'Tipe kamar sudah ada.',
                'fasilitas.required' => 'Fasilitas harus diisi.',
                'fasilitas.max' => 'Fasilitas maksimal 1000 karakter.',
            ]);

            DB::beginTransaction();

            TipeKamar::create($request->all());

            DB::commit();
            return redirect()->route('admin.tipe-kamar.index')->with('success', 'Tipe kamar berhasil ditambahkan.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menambahkan tipe kamar. ' . $e->getMessage())->withInput();
        }
    }

    public function show(TipeKamar $tipeKamar)
    {
        $tipeKamar->load(['kamar', 'paketKamar']);
        return view('admin.tipe-kamar.show', compact('tipeKamar'));
    }

    public function edit(TipeKamar $tipeKamar)
    {
        return view('admin.tipe-kamar.edit', compact('tipeKamar'));
    }

    public function update(Request $request, TipeKamar $tipeKamar)
    {
        try {
            $request->validate([
                'tipe_kamar' => 'required|in:Standar,Elite,Exclusive|unique:tipe_kamar,tipe_kamar,' . $tipeKamar->id_tipe_kamar . ',id_tipe_kamar',
                'fasilitas' => 'required|string|max:1000',
            ], [
                'tipe_kamar.required' => 'Tipe kamar harus dipilih.',
                'tipe_kamar.in' => 'Tipe kamar tidak valid.',
                'tipe_kamar.unique' => 'Tipe kamar sudah ada.',
                'fasilitas.required' => 'Fasilitas harus diisi.',
                'fasilitas.max' => 'Fasilitas maksimal 1000 karakter.',
            ]);

            DB::beginTransaction();

            $tipeKamar->update($request->all());

            DB::commit();
            return redirect()->route('admin.tipe-kamar.index')->with('success', 'Tipe kamar berhasil diupdate.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengupdate tipe kamar. ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(TipeKamar $tipeKamar)
    {
        try {
            DB::beginTransaction();

            // Check if type has any rooms
            if ($tipeKamar->kamar()->exists()) {
                throw new \Exception('Tidak dapat menghapus tipe kamar karena masih ada kamar yang menggunakan tipe ini.');
            }

            // Check if type has any packages
            if ($tipeKamar->paketKamar()->exists()) {
                throw new \Exception('Tidak dapat menghapus tipe kamar karena masih ada paket kamar yang menggunakan tipe ini.');
            }

            $tipeKamar->delete();

            DB::commit();
            return redirect()->route('admin.tipe-kamar.index')->with('success', 'Tipe kamar berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus tipe kamar. ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:tipe_kamar,id_tipe_kamar'
            ]);

            DB::beginTransaction();

            $types = TipeKamar::whereIn('id_tipe_kamar', $request->ids)->get();
            
            // Check for dependencies
            foreach ($types as $type) {
                if ($type->kamar()->exists()) {
                    throw new \Exception("Tipe kamar {$type->tipe_kamar} masih memiliki kamar yang aktif.");
                }
                if ($type->paketKamar()->exists()) {
                    throw new \Exception("Tipe kamar {$type->tipe_kamar} masih memiliki paket yang aktif.");
                }
            }

            TipeKamar::whereIn('id_tipe_kamar', $request->ids)->delete();
            
            DB::commit();
            return response()->json(['message' => 'Tipe kamar berhasil dihapus.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}