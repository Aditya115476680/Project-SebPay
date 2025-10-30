<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topping;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua topping buat ditampilkan di transaksi
        $toppings = Topping::all();
        return view('transaksi.index', compact('toppings'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Simpan transaksi utama
            $transaction = Transaction::create([
                'tr_total_amount' => $request->total,
                'tr_payment' => $request->payment,
                'tr_change' => $request->change,
                'tr_date' => now(),
            ]);

            // Simpan detail transaksi
            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'tr_dtl_tr_id' => $transaction->tr_id,
                    'tr_dtl_tp_id' => $item['id'],
                    'tr_dtl_qty' => $item['qty'],
                    'tr_dtl_subtotal' => $item['subtotal'],
                ]);

                // Kurangi stok topping
                $topping = Topping::find($item['id']);
                $topping->tp_stock -= $item['qty'];
                $topping->save();
            }

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

         public function history(Request $request)
    {
                $query = Transaction::with('user'); // pastikan relasi ke user ada

    // 🔍 Pencarian
         if ($request->has('search')) {
                $search = $request->search;
                 $query->whereHas('user', function($q) use ($search) {
                 $q->where('name', 'like', "%{$search}%");
        })->orWhere('tr_total_amount', 'like', "%{$search}%");
    }

    // 📅 Filter tanggal
         if ($request->has('date') && $request->date != '') {
             $query->whereDate('created_at', $request->date);
    }

             $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

             {
                $transactions = Transaction::with('kasir')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            
                $tanggalList = Transaction::selectRaw('DATE(created_at) as tanggal')
                    ->distinct()
                    ->pluck('tanggal');
            
                return view('transaksi.history', compact('transactions', 'tanggalList'));
            }
    }

    public function show($id)
{
    $transaction = Transaction::with(['details.topping'])->findOrFail($id);
    return view('transaksi.show', compact('transaction'));
}

public function filter(Request $request)
{
    $query = Transaction::with('kasir');

    if ($request->search) {
        $query->whereHas('kasir', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        })
        ->orWhere('total', 'like', '%' . $request->search . '%');
    }

    if ($request->tanggal) {
        $query->whereDate('created_at', $request->tanggal);
    }

    $transactions = $query->orderBy('created_at', 'desc')->get();

    $table = view('transaksi.partials.table', compact('transactions'))->render();

    return response()->json(['table' => $table]);
}



}
