<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kapal;
use App\Models\JadwalLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class JadwalKapalController extends Controller
{
    public function index(Request $request)
{
    // FORCE Oktober 2025 - Ignore request month
    $date = Carbon::create(2025, 10, 1);

    // Filter
    $status = $request->get('status');
    $pelabuhanAsal = $request->get('pelabuhan_asal');
    $pelabuhanTujuan = $request->get('pelabuhan_tujuan');
    $search = $request->get('search');

    // Statistik untuk Oktober 2025
    $totalKapalBerlayar = Jadwal::whereMonth('tanggal_keberangkatan', 10)
        ->whereYear('tanggal_keberangkatan', 2025)
        ->distinct('kapal_id')
        ->count('kapal_id');

    $totalKapalCadangan = Kapal::where('status_operasional', 'Beroperasi')->count() - $totalKapalBerlayar;

    $totalWaktu = Jadwal::whereMonth('tanggal_keberangkatan', 10)
        ->whereYear('tanggal_keberangkatan', 2025)
        ->count();

    $penerbitan = Jadwal::whereMonth('created_at', 10)
        ->whereYear('created_at', 2025)
        ->count();

    $pembatalan = Jadwal::where('status', 'Cancelled')
        ->whereMonth('tanggal_keberangkatan', 10)
        ->whereYear('tanggal_keberangkatan', 2025)
        ->count();

    // Calendar data untuk Oktober 2025
    $startOfMonth = Carbon::create(2025, 10, 1)->startOfMonth();
    $endOfMonth = Carbon::create(2025, 10, 31)->endOfMonth();

    // Jadwal untuk Oktober 2025 - GROUPING BY DATE
    $jadwals = Jadwal::with('kapal')
        ->whereBetween('tanggal_keberangkatan', [$startOfMonth, $endOfMonth])
        ->orderBy('tanggal_keberangkatan')
        ->orderBy('jam_berangkat')
        ->get()
        ->groupBy(function($item) {
            return $item->tanggal_keberangkatan->format('Y-m-d');
        });

    // Jadwal keberangkatan (tabel) dengan filter - Oktober 2025
    $jadwalQuery = Jadwal::with(['kapal', 'kapal.operator'])
        ->whereMonth('tanggal_keberangkatan', 10)
        ->whereYear('tanggal_keberangkatan', 2025)
        ->orderBy('tanggal_keberangkatan', 'desc')
        ->orderBy('jam_berangkat', 'desc');

    if ($status) {
        $jadwalQuery->where('status', $status);
    }

    if ($pelabuhanAsal) {
        $jadwalQuery->where('pelabuhan_asal', $pelabuhanAsal);
    }

    if ($pelabuhanTujuan) {
        $jadwalQuery->where('pelabuhan_tujuan', $pelabuhanTujuan);
    }

    if ($search) {
        $jadwalQuery->where(function($q) use ($search) {
            $q->where('id_jadwal', 'like', "%{$search}%")
              ->orWhereHas('kapal', function($q2) use ($search) {
                  $q2->where('nama_kapal', 'like', "%{$search}%");
              });
        });
    }

    $jadwalKeberangkatan = $jadwalQuery->paginate(10, ['*'], 'jadwal_page');

    // Log perubahan dengan filter
    $logQuery = JadwalLog::with(['kapal'])
        ->orderBy('created_at', 'desc');

    // Filter log by search
    if ($request->get('log_search')) {
        $logSearch = $request->get('log_search');
        $logQuery->where(function($q) use ($logSearch) {
            $q->where('id_jadwal', 'like', "%{$logSearch}%")
              ->orWhere('nama_kapal', 'like', "%{$logSearch}%")
              ->orWhere('diubah_oleh', 'like', "%{$logSearch}%");
        });
    }

    // Filter log by jenis perubahan
    if ($request->get('jenis_perubahan')) {
        $logQuery->where('jenis_perubahan', $request->get('jenis_perubahan'));
    }

    // Filter log by date range
    if ($request->get('log_date_from')) {
        $logQuery->whereDate('created_at', '>=', $request->get('log_date_from'));
    }
    if ($request->get('log_date_to')) {
        $logQuery->whereDate('created_at', '<=', $request->get('log_date_to'));
    }

    $logPerubahan = $logQuery->paginate(10, ['*'], 'log_page');

    // Data untuk dropdown filter
    $pelabuhanAsalList = Jadwal::distinct()->pluck('pelabuhan_asal');
    $pelabuhanTujuanList = Jadwal::distinct()->pluck('pelabuhan_tujuan');

    // List kapal aktif untuk modal
    $kapalsAktif = Kapal::beroperasi()->get();

    // Alias untuk compatibility dengan view
    $startDate = $date;

    return view('jadwal-kapal.index', compact(
        'totalKapalBerlayar',
        'totalKapalCadangan',
        'totalWaktu',
        'penerbitan',
        'pembatalan',
        'date',
        'startDate',
        'jadwals',
        'jadwalKeberangkatan',
        'logPerubahan',
        'pelabuhanAsalList',
        'pelabuhanTujuanList',
        'kapalsAktif'
    ));
}
}
