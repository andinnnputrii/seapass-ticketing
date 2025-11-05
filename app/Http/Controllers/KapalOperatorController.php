<?php

namespace App\Http\Controllers;

use App\Models\Kapal;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KapalOperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil query view=operator atau view=kapal
        $view = $request->query('view', 'kapal'); // default: kapal

        if ($view === 'operator') {
            // Ambil data operator beserta daftar kapal yang mereka kelola
            $operators = Operator::with(['kapals' => function ($q) {
                $q->select('operator_id', 'nama_kapal');
            }])
                ->orderBy('nama_operator')
                ->paginate(10);

            return view('kapal-operator.index', [
                'view' => 'operator',
                'operators' => $operators,
            ]);
        }

        // Jika view = kapal
        $kapals = Kapal::with('operator')
            ->when($request->nama_kapal, function ($query) use ($request) {
                $query->where('nama_kapal', 'like', '%' . $request->nama_kapal . '%');
            })
            ->orderBy('nama_kapal')
            ->paginate(10);

        return view('kapal-operator.index', [
            'view' => 'kapal',
            'kapals' => $kapals,
        ]);
    }

    public function create(Request $request)
    {
        $view = $request->query('view', 'kapal');

        if ($view === 'operator') {
            return view('kapal-operator.create-operator');
        }

        $operators = Operator::orderBy('nama_operator')->get();
        return view('kapal-operator.create-kapal', compact('operators'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kapal' => 'required|string|max:255',
            'jenis_kapal' => 'nullable|string|max:255',
            'operator_id' => 'nullable|exists:operators,operator_id',
            'kapasitas' => 'required|integer|min:0',
            'pelabuhan_asal' => 'nullable|string|max:255',
            'rute_aktif' => 'nullable|string|max:255',
            'tanggal_registrasi' => 'nullable|date',
            'status_operasional' => 'required|in:Beroperasi,Pemeliharaan,Tidak Beroperasi',
            'status_kebersihan' => 'nullable|in:Bersih,Cukup Bersih,Kotor',
            'foto_kapal' => 'nullable|image|mimes:jpeg,jpg,png|max:3072',
            'keterangan_tambahan' => 'nullable|string',
            'nomor_registrasi' => 'nullable|string|max:255',
            'tahun_pembuatan' => 'nullable|integer|min:1900|max:' . date('Y'),
            'panjang_kapal' => 'nullable|numeric|min:0',
            'lebar_kapal' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('foto_kapal')) {
            $file = $request->file('foto_kapal');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['foto_kapal'] = $file->storeAs('kapal_photos', $filename, 'public');
        }

        Kapal::create($validated);

        return redirect()->route('kapal-operator.index')->with('success', 'Data kapal berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kapal = Kapal::findOrFail($id);
        $operators = Operator::orderBy('nama_operator')->get();

        return view('kapal.edit', compact('kapal', 'operators'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kapal = Kapal::findOrFail($id);

        $validated = $request->validate([
            'nama_kapal' => 'required|string|max:255',
            'jenis_kapal' => 'nullable|string|max:255',
            'operator_id' => 'nullable|exists:operators,operator_id',
            'kapasitas' => 'required|integer|min:0',
            'pelabuhan_asal' => 'nullable|string|max:255',
            'rute_aktif' => 'nullable|string|max:255',
            'tanggal_registrasi' => 'nullable|date',
            'status_operasional' => 'required|in:Beroperasi,Pemeliharaan,Tidak Beroperasi',
            'status_kebersihan' => 'nullable|in:Bersih,Cukup Bersih,Kotor',
            'foto_kapal' => 'nullable|image|mimes:jpeg,jpg,png|max:3072',
            'keterangan_tambahan' => 'nullable|string',
            'nomor_registrasi' => 'nullable|string|max:255',
            'tahun_pembuatan' => 'nullable|integer|min:1900|max:' . date('Y'),
            'panjang_kapal' => 'nullable|numeric|min:0',
            'lebar_kapal' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('foto_kapal')) {
            if ($kapal->foto_kapal && Storage::disk('public')->exists($kapal->foto_kapal)) {
                Storage::disk('public')->delete($kapal->foto_kapal);
            }

            $file = $request->file('foto_kapal');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['foto_kapal'] = $file->storeAs('kapal_photos', $filename, 'public');
        }

        $kapal->update($validated);

        return redirect()->route('kapal-operator.index')->with('success', 'Data kapal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kapal = Kapal::findOrFail($id);

        if ($kapal->foto_kapal && Storage::disk('public')->exists($kapal->foto_kapal)) {
            Storage::disk('public')->delete($kapal->foto_kapal);
        }

        $kapal->delete();

        return redirect()->route('kapal-operator.index')->with('success', 'Data kapal berhasil dihapus!');
    }
}
