<?php

namespace App\Http\Controllers;

use App\Models\Penumpang;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenumpangController extends Controller
{

    public function index(Request $request)
    {
        // Query dasar dengan relasi
        $query = Penumpang::with(['latestTiket.jadwal.kapal']);

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%")
                  ->orWhere('no_telepon', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Pagination
        $penumpangs = $query->latest('created_at')->paginate(10);

        // Tambahkan data tiket aktif dan rute untuk setiap penumpang
        $penumpangs->getCollection()->transform(function ($penumpang) {
            // Ambil tiket terbaru
            $latestTiket = $penumpang->latestTiket;

            if ($latestTiket) {
                $penumpang->tiket_aktif = $latestTiket->tiket_id;
                $penumpang->latest_tiket = $latestTiket;

                // Ambil rute dari jadwal
                if ($latestTiket->jadwal) {
                    $jadwal = $latestTiket->jadwal;
                    $penumpang->rute = $jadwal->pelabuhan_asal . ' - ' . $jadwal->pelabuhan_tujuan;
                }
            }

            return $penumpang;
        });

        // Statistik
        $totalPenumpang = Penumpang::count();
        $totalLakiLaki = Penumpang::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Penumpang::where('jenis_kelamin', 'Perempuan')->count();
        $tiketAktif = Tiket::where('status_tiket', 'Valid')->count();

        return view('penumpang.index', compact(
            'penumpangs',
            'totalPenumpang',
            'totalLakiLaki',
            'totalPerempuan',
            'tiketAktif'
        ));
    }

    public function create()
    {
        return view('penumpang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:penumpangs,nik',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string'
        ]);

        // Generate ID Penumpang
        $lastPenumpang = Penumpang::withTrashed()->latest('penumpang_id')->first();
        $lastNumber = $lastPenumpang ? intval(substr($lastPenumpang->penumpang_id, 1)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $penumpangId = 'P' . $newNumber;

        $penumpang = Penumpang::create([
            'penumpang_id' => $penumpangId,
            'nama_lengkap' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'no_telepon' => $validated['no_telepon'],
            'email' => $validated['email'],
            'alamat' => $validated['alamat']
        ]);

        return redirect()->route('penumpang.index')
            ->with('success', 'Data penumpang berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $penumpang = Penumpang::with(['tikets.jadwal.kapal', 'tikets.kendaraan'])
            ->findOrFail($id);

        return view('penumpang.show', compact('penumpang'));
    }

    public function edit(string $id)
    {
        $penumpang = Penumpang::findOrFail($id);
        return view('penumpang.edit', compact('penumpang'));
    }

    public function update(Request $request, string $id)
    {
        $penumpang = Penumpang::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:penumpangs,nik,' . $id . ',penumpang_id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string'
        ]);

        $penumpang->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'no_telepon' => $validated['no_telepon'],
            'email' => $validated['email'],
            'alamat' => $validated['alamat']
        ]);

        return redirect()->route('penumpang.index')
            ->with('success', 'Data penumpang berhasil diperbarui!');
    }
                                                                                            
    public function destroy(string $id)
    {
        try {
            $penumpang = Penumpang::findOrFail($id);

            // Cek apakah penumpang memiliki tiket aktif
            $tiketAktif = Tiket::where('penumpang_id', $id)
                ->where('status_tiket', 'Valid')
                ->exists();

            if ($tiketAktif) {
                return redirect()->route('penumpang.index')
                    ->with('error', 'Tidak dapat menghapus penumpang yang memiliki tiket aktif!');
            }

            // Soft delete
            $penumpang->delete();

            return redirect()->route('penumpang.index')
                ->with('success', 'Data penumpang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('penumpang.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data penumpang!');
        }
    }
}
