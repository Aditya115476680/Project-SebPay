<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topping;
use App\Models\ToppingMovement;
use App\Models\Transaction;


class ToppingMovementController extends Controller
{
    // 📥 Halaman Topping In
    public function in()
    {
        $movements = ToppingMovement::with('topping')->where('jenis', 'in')->latest()->get();
        $topping = Topping::all();
        return view('topping_in.index', compact('movements', 'topping'));
    }

    // 📤 Halaman Topping Out
    public function out()
    {
        $movements = ToppingMovement::with('topping')->where('jenis', 'out')->latest()->get();
        $topping = Topping::all();
        return view('topping_out.index', compact('movements', 'topping'));
    }

    // 💾 Simpan Stok Masuk
    public function storeIn(Request $request)
    {
        $request->validate([
            'topping_id' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        $topping = Topping::findOrFail($request->topping_id);
        $topping->stok += $request->jumlah;
        $topping->save();

        ToppingMovement::create([
            'topping_id' => $request->topping_id,
            'jumlah' => $request->jumlah,
            'jenis' => 'in',
            'tanggal' => now(),
        ]);

        return redirect()->route('topping.in')->with('success', 'Stok topping berhasil ditambahkan!');
    }

    // 💾 Simpan Stok Keluar
        public function storeOut(Request $request)
    {
        ToppingMovement::create([
            'topping_id' => $request->topping_id,
            'quantity' => $request->quantity,
            'type' => 'out', // ini aja yang beda
            'note' => $request->note
    ]);

        return redirect()->route('topping.out')->with('success', 'Topping berhasil dikeluarkan!');
    }

    public function history()
    {
        $transactions = Transaction::with('details.topping')->orderBy('created_at', 'desc')->get();
        return view('transaksi.history', compact('transactions'));
}


        
}
