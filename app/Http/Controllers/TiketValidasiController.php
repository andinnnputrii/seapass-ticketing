<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Penumpang;
use App\Models\Jadwal;
use App\Models\Kendaraan;
use App\Models\ValidasiTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TiketValidasiController extends Controller
{
    public function index(Request $request)
    {
        // Tab aktif
        $activeTab = $request->get('tab', 'tiket');

        // Statistik
        $totalPenumpang = Penumpang::count();
        $tiketTerjual = Tiket::count();
        $tervalidasi = Tiket::where('status_tiket', 'Tervalidasi')->count();
        $pendingBatal = Tiket::where('status_pembayaran', 'Pending')
                            ->orWhere('status_tiket', 'Batal')
                            ->count();
        $reschedule = Tiket::where('status_tiket', 'Reschedule')->count();

        // Data berdasarkan tab
        if ($activeTab == 'tiket') {
            // TAB TIKET PEMESANAN
            $tikets = Tiket::with(['penumpang', 'jadwal'])
                ->orderBy('waktu_pemesanan', 'desc')
                ->when($request->get('search'), function($q) use ($request) {
                    $search = $request->get('search');
                    $q->where('tiket_id', 'like', "%{$search}%")
                      ->orWhere('kode_booking', 'like', "%{$search}%")
                      ->orWhereHas('penumpang', function($q2) use ($search) {
                          $q2->where('nama_lengkap', 'like', "%{$search}%");
                      });
                })
                ->paginate(10);

            return view('tiket-validasi.index', compact(
                'activeTab',
                'totalPenumpang',
                'tiketTerjual',
                'tervalidasi',
                'pendingBatal',
                'reschedule',
                'tikets'
            ));

        } elseif ($activeTab == 'kendaraan') {
            // TAB KENDARAAN
            $kendaraans = Kendaraan::with(['tiket', 'tiket.penumpang'])
                ->orderBy('created_at', 'desc')
                ->when($request->get('search'), function($q) use ($request) {
                    $search = $request->get('search');
                    $q->where('kendaraan_id', 'like', "%{$search}%")
                      ->orWhere('plat_nomor', 'like', "%{$search}%")
                      ->orWhere('tiket_id', 'like', "%{$search}%");
                })
                ->paginate(10);

            return view('tiket-validasi.index', compact(
                'activeTab',
                'totalPenumpang',
                'tiketTerjual',
                'tervalidasi',
                'pendingBatal',
                'reschedule',
                'kendaraans'
            ));

        } elseif ($activeTab == 'validasi') {
            // TAB VALIDASI TIKET
            $validasis = ValidasiTiket::with(['tiket', 'tiket.penumpang'])
                ->orderBy('waktu_validasi', 'desc')
                ->when($request->get('search'), function($q) use ($request) {
                    $search = $request->get('search');
                    $q->where('tiket_id', 'like', "%{$search}%")
                      ->orWhere('petugas', 'like', "%{$search}%")
                      ->orWhere('lokasi_pintu', 'like', "%{$search}%");
                })
                ->paginate(10);

            return view('tiket-validasi.index', compact(
                'activeTab',
                'totalPenumpang',
                'tiketTerjual',
                'tervalidasi',
                'pendingBatal',
                'reschedule',
                'validasis'
            ));
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'nik' => 'nullable|string|unique:penumpangs,nik',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'jadwal_id' => 'required|exists:jadwals,id',
            'tipe_tiket' => 'required|in:Kendaraan,Penumpang',
            'kelas_tiket' => 'required|in:Ekonomi,Bisnis,VIP',
            'harga' => 'required|numeric',
            'metode_bayar' => 'required|in:QRIS,Tunai,Bank,E-Wallet',
            'nomor_kursi' => 'nullable|string',
            // Data kendaraan (jika tipe kendaraan)
            'plat_nomor' => 'required_if:tipe_tiket,Kendaraan',
            'jenis_kendaraan' => 'required_if:tipe_tiket,Kendaraan',
            'panjang' => 'nullable|numeric',
            'muatan' => 'nullable|integer'
        ]);

        DB::beginTransaction();
        try {
            // Buat penumpang
            $penumpangId = 'USR' . str_pad(Penumpang::count() + 1, 3, '0', STR_PAD_LEFT);
            $penumpang = Penumpang::create([
                'penumpang_id' => $penumpangId,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nik' => $validated['nik'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_telepon' => $validated['no_telepon'],
                'email' => $validated['email']
            ]);

            // Get jadwal untuk data kapal
            $jadwal = Jadwal::with('kapal')->findOrFail($validated['jadwal_id']);

            // Hitung pajak dan total
            $pajak = $validated['harga'] * 0.1;
            $totalBayar = $validated['harga'] + $pajak;

            // Buat tiket
            $tiketId = 'TKT' . str_pad(Tiket::count() + 1, 3, '0', STR_PAD_LEFT);
            $kodeBooking = 'BK' . strtoupper(substr(md5(time()), 0, 8));

            $tiket = Tiket::create([
                'tiket_id' => $tiketId,
                'penumpang_id' => $penumpang->penumpang_id,
                'jadwal_id' => $validated['jadwal_id'],
                'kapal_id' => $jadwal->kapal_id,
                'tipe_tiket' => $validated['tipe_tiket'],
                'kelas_tiket' => $validated['kelas_tiket'],
                'harga' => $validated['harga'],
                'pajak' => $pajak,
                'total_bayar' => $totalBayar,
                'metode_bayar' => $validated['metode_bayar'],
                'status_pembayaran' => 'Paid',
                'status_tiket' => 'Valid',
                'kode_booking' => $kodeBooking,
                'nomor_kursi' => $validated['nomor_kursi'],
                'waktu_pemesanan' => now(),
                'waktu_pembayaran' => now()
            ]);

            // Jika tipe kendaraan, buat data kendaraan
            if ($validated['tipe_tiket'] == 'Kendaraan') {
                $kendaraanId = 'KND' . str_pad(Kendaraan::count() + 1, 3, '0', STR_PAD_LEFT);

                Kendaraan::create([
                    'kendaraan_id' => $kendaraanId,
                    'tiket_id' => $tiketId,
                    'plat_nomor' => $validated['plat_nomor'],
                    'jenis_kendaraan' => $validated['jenis_kendaraan'],
                    'panjang' => $validated['panjang'] ?? 0,
                    'muatan' => $validated['muatan'] ?? 0
                ]);
            }

            DB::commit();

            return redirect()->route('tiket-validasi.index')
                ->with('success', 'Tiket berhasil dipesan dengan kode booking: ' . $kodeBooking);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memesan tiket: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function validasi(Request $request, $tiketId)
    {
        $validated = $request->validate([
            'status_validasi' => 'required|in:valid,invalid,gagal',
            'metode' => 'required|in:QR,Manual',
            'lokasi_pintu' => 'required|string',
            'petugas' => 'required|string',
            'catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $tiket = Tiket::where('tiket_id', $tiketId)->firstOrFail();

            // Update status tiket
            if ($validated['status_validasi'] == 'valid') {
                $tiket->update([
                    'status_tiket' => 'Tervalidasi',
                    'waktu_validasi' => now(),
                    'validasi_oleh' => $validated['petugas']
                ]);
            } elseif ($validated['status_validasi'] == 'invalid') {
                $tiket->update([
                    'status_tiket' => 'Batal',
                    'waktu_validasi' => now(),
                    'validasi_oleh' => $validated['petugas']
                ]);
            }

            // Simpan log validasi
            ValidasiTiket::create([
                'tiket_id' => $tiket->tiket_id,
                'waktu_validasi' => now(),
                'status_validasi' => $validated['status_validasi'],
                'metode' => $validated['metode'],
                'lokasi_pintu' => $validated['lokasi_pintu'],
                'petugas' => $validated['petugas'],
                'catatan' => $validated['catatan']
            ]);

            DB::commit();

            return redirect()->route('tiket-validasi.index', ['tab' => 'validasi'])
                ->with('success', 'Tiket berhasil divalidasi');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memvalidasi tiket: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $tiket = Tiket::with(['penumpang', 'jadwal.kapal', 'kendaraan', 'validasis'])
            ->where('tiket_id', $id)
            ->firstOrFail();

        return response()->json($tiket);
    }

    public function destroy($id)
    {
        try {
            $tiket = Tiket::where('tiket_id', $id)->firstOrFail();
            $tiket->delete();

            return redirect()->route('tiket-validasi.index')
                ->with('success', 'Tiket berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }
}
