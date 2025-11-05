<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\Operator::query();

    // Filter nama
    if ($request->filled('nama_operator')) {
        $query->where('nama_perusahaan', 'like', '%' . $request->nama_operator . '%');
    }

    // Filter status (pastikan kolom status ada)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Ambil data operator dengan hitungan kapal
    $operators = $query->withCount('kapals')
        ->orderBy('nama_perusahaan', 'asc')
        ->paginate(10);

    // Statistik
    $statistics = [
        'total' => $query->count(),
        'aktif' => $query->where('status', 'aktif')->count(),
        'tidak_aktif' => $query->where('status', 'tidak_aktif')->count(),
        'total_kapal' => \App\Models\Kapal::count(),
    ];

    return view('operator.index', compact('operators', 'statistics'));
}

    public function create()
    {
        return view('kapal-operator.create-operator');
    }

}
