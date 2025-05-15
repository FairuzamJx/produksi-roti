<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function index()
    {
        $prediksi = Prediksi::all();
        return view('prediksi.index', compact('prediksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_pro' => 'required',
            'n_rijek' => 'required',
        ]);

        Prediksi::create($request->all());

        return redirect()->route('prediksi.index')->with('success', 'Nilai berhasil ditambahkan');
    }
}
