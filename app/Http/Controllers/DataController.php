<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport;
use App\Models\Data;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        $data = Data::all();
        return view('data.index', compact('data'));
    }

    public function create()
    {
        return view('data.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'produksi' => 'required|integer',
            'penjualan' => 'required|integer',
            'rijek' => 'required|integer',
        ]);

        Data::create($request->all());

        return redirect()->route('data.index')->with('success', 'Data berhasil ditambahkan');
    }
    
    public function import(Request $request)
    {
        //validasi file yang diupload
        $allowedExtensions = ['xlsx', 'csv', 'xls'];
        $extension = $request->file('file')->getClientOriginalExtension();

        if (!in_array($extension, $allowedExtensions)) {
            return redirect()->back()->with('error', 'File tidak support');
        }

        //tambahkan notif jika bukan file excel
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }
       
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:10240' // 10MB (max size), bisa disesuaikan
        ]);
    
        $fileSize = $request->file('file')->getSize(); // Ukuran file dalam bytes
        if ($fileSize > 10485765) { // 10MB = 1048576 bytes
            return redirect()->back()->with('error', 'Ukuran file terlalu kecil. Minimal 1MB');
        }

        $data = Excel::toArray(new DataImport, $request->file('file'));
    
        // dd($data); // Melihat array yang dihasilkan oleh file CSV yang diimpor
    
        Excel::import(new DataImport, $request->file('file'));
    
        return redirect()->route('data.index')->with('success', 'Import berhasil!');
    }

    public function edit($id)
    {
        $data = Data::findOrFail($id);
        return view('data.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl' => 'required|date',
            'produksi' => 'required|integer',
            'penjualan' => 'required|integer',
            'rijek' => 'required|integer',
        ]);

        $data = Data::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('data.index')->with('success', 'Data berhasil diperbarui');
        return redirect()->back()->with('error', 'File tidak support');
        
    }

    public function destroy($id)
    {
        $data = Data::findOrFail($id);
        $data->delete();

        return redirect()->route('data.index')->with('error', 'Data berhasil dihapus');
    }
}
