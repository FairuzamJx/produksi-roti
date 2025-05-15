<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hasil;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = Hasil::latest()->get();
        return view('hasil.index', compact('hasil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hasil' => 'required',
            'tgl' => 'required|date',
        ]);

        Hasil::create($request->all());

        return redirect()->route('hasil.index')->with('success', 'Hasil prediksi disimpan');
    }
}
