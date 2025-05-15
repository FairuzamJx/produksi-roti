<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrediksiController extends Controller
{
    public function index()
    {
        return view('prediksi.index');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'penjualan' => 'required|numeric',
            'rijek' => 'required|numeric',
            'tgl' => 'required|date',
        ]);

        // Ambil data referensi dari tabel 'data' 7 hari terakhir
        $now = now();
        $range = [$now->subDays(7)->toDateString(), now()->toDateString()];

        $p_min = DB::table('data')->whereBetween('tgl', $range)->min('penjualan');
        $p_max = DB::table('data')->whereBetween('tgl', $range)->max('penjualan');
        $r_min = DB::table('data')->whereBetween('tgl', $range)->min('rijek');
        $r_max = DB::table('data')->whereBetween('tgl', $range)->max('rijek');
        $prd_min = DB::table('data')->whereBetween('tgl', $range)->min('produksi');
        $prd_max = DB::table('data')->whereBetween('tgl', $range)->max('produksi');

        // Fuzzifikasi
        $miu_sedikit_penjualan = ($request->penjualan <= $p_min) ? 1 : (($request->penjualan >= $p_max) ? 0 : ($p_max - $request->penjualan) / ($p_max - $p_min));
        $miu_banyak_penjualan  = ($request->penjualan <= $p_min) ? 0 : (($request->penjualan >= $p_max) ? 1 : ($request->penjualan - $p_min) / ($p_max - $p_min));
        $miu_sedikit_rijek     = ($request->rijek <= $r_min) ? 1 : (($request->rijek >= $r_max) ? 0 : ($r_max - $request->rijek) / ($r_max - $r_min));
        $miu_banyak_rijek      = ($request->rijek <= $r_min) ? 0 : (($request->rijek >= $r_max) ? 1 : ($request->rijek - $r_min) / ($r_max - $r_min));

        // Simpan ke tabel fuzzyfikasi
        DB::table('fuzzyfikasi')->insert([
            'mspenjualan' => $miu_sedikit_penjualan,
            'mbpenjualan' => $miu_banyak_penjualan,
            'msrijek'     => $miu_sedikit_rijek,
            'mbrijek'     => $miu_banyak_rijek,
        ]);

        // Inferensi Rules R1–R4
        $x = $prd_max - $prd_min;

        $r1 = $prd_min + min($miu_banyak_penjualan, $miu_banyak_rijek) * $x;
        $r2 = $prd_min + min($miu_banyak_penjualan, $miu_sedikit_rijek) * $x;
        $r3 = $prd_max - min($miu_sedikit_penjualan, $miu_banyak_rijek) * $x;
        $r4 = $prd_max - min($miu_sedikit_penjualan, $miu_sedikit_rijek) * $x;

        DB::table('rule')->insert([
            'r1' => round($r1),
            'r2' => round($r2),
            'r3' => round($r3),
            'r4' => round($r4),
        ]);

        // Defuzzifikasi
        $total_alpha_z = 
            min($miu_banyak_penjualan, $miu_banyak_rijek) * $r1 +
            min($miu_banyak_penjualan, $miu_sedikit_rijek) * $r2 +
            min($miu_sedikit_penjualan, $miu_banyak_rijek) * $r3 +
            min($miu_sedikit_penjualan, $miu_sedikit_rijek) * $r4;

        $total_alpha = 
            min($miu_banyak_penjualan, $miu_banyak_rijek) +
            min($miu_banyak_penjualan, $miu_sedikit_rijek) +
            min($miu_sedikit_penjualan, $miu_banyak_rijek) +
            min($miu_sedikit_penjualan, $miu_sedikit_rijek);

        $hasil = ($total_alpha > 0) ? round($total_alpha_z / $total_alpha) : 0;

        DB::table('hasil')->insert([
            'hasil' => $hasil,
            'tgl' => $request->tgl
        ]);

        return redirect()->route('prediksi.hasil')->with('success', 'Prediksi berhasil dihitung');
    }

    public function hasil()
    {
        $data = DB::table('hasil')->orderBy('tgl', 'desc')->get();
        return view('prediksi.hasil', compact('data'));
    }
}
