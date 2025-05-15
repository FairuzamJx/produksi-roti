<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Data;
use App\Models\Hasil;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah baris data
        $jumlahDataPenjualan = Data::count();
        $jumlahHasilPrediksi = Hasil::count();

        return view('dashboard', compact(
            'jumlahDataPenjualan',
            'jumlahHasilPrediksi',
        ));
    }
}