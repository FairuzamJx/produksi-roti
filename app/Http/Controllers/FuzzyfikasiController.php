<?php

namespace App\Http\Controllers;

use App\Models\Fuzzyfikasi;
use Illuminate\Http\Request;

class FuzzyfikasiController extends Controller
{
    public function index()
    {
        $fuzzy = Fuzzyfikasi::all();
        return view('fuzzy.index', compact('fuzzy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mspenjualan' => 'required',
            'mbpenjualan' => 'required',
            'msrijek' => 'required',
            'mbrijek' => 'required',
        ]);

        Fuzzyfikasi::create($request->all());

        return redirect()->back()->with('success', 'Fuzzyfikasi berhasil disimpan');
    }
}
