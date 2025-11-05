<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\Transaction;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::with(['transaction.ticket.schedule'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.refunds.index', compact('refunds'));
    }

    public function approve(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        
        $refund->update([
            'status' => 'approved',
            'approved_by' => session('admin_id'),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        // Update status transaksi
        $refund->transaction->update([
            'payment_status' => 'refunded'
        ]);

        // TODO: Integrasi dengan payment gateway untuk proses refund otomatis
        // Contoh: IPAYMU::refund($refund->transaction->order_number, $refund->refund_amount);

        return redirect()->back()->with('success', 'Refund berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        
        $refund->update([
            'status' => 'rejected',
            'approved_by' => session('admin_id'),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Refund ditolak');
    }
}