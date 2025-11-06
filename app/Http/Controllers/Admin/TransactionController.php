<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Refund;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    // Statistik Card
    $totalTransactions = Transaction::sum('amount');
    $pendingRefunds = Refund::where('status', 'pending')->count();
    $successfulTransactions = Transaction::where('payment_status', 'paid')->count();
    $pendingPayments = Transaction::where('payment_status', 'pending')->count();
    $refundedTransactions = Transaction::where('payment_status', 'refunded')->count();

    // Format Rupiah
    $formattedTotal = 'Rp ' . number_format($totalTransactions, 0, ',', '.');

    // Filter
    $query = Transaction::with(['ticket.schedule', 'user', 'refund']);

    if ($request->has('status') && $request->status != '') {
        $query->where('payment_status', $request->status);
    }

    if ($request->has('method') && $request->method != '') {
        $query->where('payment_method', $request->method);
    }

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
              ->orWhere('passenger_name', 'like', "%{$search}%");
        });
    }

    $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.transactions.index', compact(
        'transactions',
        'totalTransactions',
        'formattedTotal',
        'pendingRefunds',
        'successfulTransactions',
        'pendingPayments',
        'refundedTransactions'
    ));
}

}
