<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToppingController extends Controller
{
    public function index()
    {
        $topping = DB::table('topping')->get();
        return view('topping.index', compact('topping'));
    }

    public function create()
    {
        return view('topping.create');
    }

    public function store(Request $request)
    {
        DB::table('topping')->insert([
            'nama' => $request->nama,
            'stok' => $request->stok,
        ]);

        return redirect()->route('topping.index')->with('success', 'Topping berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $topping = DB::table('topping')->where('id', $id)->first();
        return view('topping.edit', compact('topping'));
    }

    public function update(Request $request, $id)
    {
        DB::table('topping')->where('id', $id)->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
        ]);

        return redirect()->route('topping.index')->with('success', 'Topping berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('topping')->where('id', $id)->delete();
        return redirect()->route('topping.index')->with('success', 'Topping berhasil dihapus!');
    }
}
