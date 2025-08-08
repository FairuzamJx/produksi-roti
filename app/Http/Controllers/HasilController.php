<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hasil;

class HasilController extends Controller
{
    public function index()
    {
        $data = Hasil::latest()->paginate(10);
        return view('hasil.index', compact('data'));
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