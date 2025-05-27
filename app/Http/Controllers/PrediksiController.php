<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Data;
use Carbon\Carbon;

class PrediksiController extends Controller
{
    public function index()
    {
        return view('prediksi.index');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'n_pen' => 'required|numeric',
            'n_rijek' => 'required|numeric',
            'tgl' => 'required|date',
        ]);

        // Ambil tanggal terakhir dari data
        $latestDate = Data::max('tgl');
        $nextValidDate = \Carbon\Carbon::parse($latestDate)->addDay()->toDateString();

        // Jika tanggal input tidak sama dengan tanggal yang diperbolehkan
        if ($request->tgl !== $nextValidDate) {
            return back()->withErrors(['tgl' => 'Tanggal prediksi hanya diperbolehkan untuk 1 hari setelah data terakhir, yaitu: ' . $nextValidDate]);
        }

        $penjualan = $request->n_pen;
        $rijek = $request->n_rijek;

        $data7hari = Data::orderBy('tgl', 'desc')->take(7)->get();

        $pen_min = $data7hari->min('penjualan');
        $pen_max = $data7hari->max('penjualan');
        $rijek_min = $data7hari->min('rijek');
        $rijek_max = $data7hari->max('rijek');
        $prd_min = $data7hari->min('produksi');
        $prd_max = $data7hari->max('produksi');
        $x = $prd_max - $prd_min;

        $miu_sedikit_penjualan = ($penjualan <= $pen_min) ? 1 : (($penjualan >= $pen_max) ? 0 : ($pen_max - $penjualan) / ($pen_max - $pen_min));
        $miu_banyak_penjualan = ($penjualan >= $pen_max) ? 1 : (($penjualan <= $pen_min) ? 0 : ($penjualan - $pen_min) / ($pen_max - $pen_min));
        $miu_sedikit_rijek = ($rijek <= $rijek_min) ? 1 : (($rijek >= $rijek_max) ? 0 : ($rijek_max - $rijek) / ($rijek_max - $rijek_min));
        $miu_banyak_rijek = ($rijek >= $rijek_max) ? 1 : (($rijek <= $rijek_min) ? 0 : ($rijek - $rijek_min) / ($rijek_max - $rijek_min));

        $α1 = min($miu_banyak_penjualan, $miu_banyak_rijek);
        $α2 = min($miu_banyak_penjualan, $miu_sedikit_rijek);
        $α3 = min($miu_sedikit_penjualan, $miu_banyak_rijek);
        $α4 = min($miu_sedikit_penjualan, $miu_sedikit_rijek);

        $z1 = $prd_min + $α1 * $x;
        $z2 = $prd_min + $α2 * $x;
        $z3 = $prd_max - $α3 * $x;
        $z4 = $prd_max - $α4 * $x;

        $total_alpha_z = ($α1 * $z1) + ($α2 * $z2) + ($α3 * $z3) + ($α4 * $z4);
        $total_alpha = $α1 + $α2 + $α3 + $α4;
        $hasil = ($total_alpha > 0) ? round($total_alpha_z / $total_alpha) : 0;

        DB::table('fuzzifikasi')->insert([
            'mspenjualan' => round($miu_sedikit_penjualan, 2),
            'mbpenjualan' => round($miu_banyak_penjualan, 2),
            'msrijek' => round($miu_sedikit_rijek, 2),
            'mbrijek' => round($miu_banyak_rijek, 2),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('rule')->insert([
            'r1' => round($z1),
            'r2' => round($z2),
            'r3' => round($z3),
            'r4' => round($z4),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Data::create([
            'tgl' => $request->tgl,
            'penjualan' => $penjualan,
            'rijek' => $rijek,
            'produksi' => $hasil,
        ]);

        DB::table('prediksi')->insert([
            'n_pen' => $penjualan,
            'n_rijek' => $rijek,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('hasil')->insert([
            'hasil' => $hasil,
            'tgl' => $request->tgl,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('fuzzy', [
            'miu_sedikit_penjualan' => round($miu_sedikit_penjualan, 2),
            'miu_banyak_penjualan' => round($miu_banyak_penjualan, 2),
            'miu_sedikit_rijek' => round($miu_sedikit_rijek, 2),
            'miu_banyak_rijek' => round($miu_banyak_rijek, 2),
            'r1' => round($z1),
            'r2' => round($z2),
            'r3' => round($z3),
            'r4' => round($z4),
            'total_alpha_z' => round($total_alpha_z),
            'total_alpha' => round($total_alpha, 2),
            'hasil' => $hasil,
            'tgl' => Carbon::parse($request->tgl)->format('d-m-Y'),
        ]);
    }

    public function hasil()
    {
        $data = DB::table('hasil')->orderBy('tgl', 'desc')->get();
        return view('prediksi.hasil', compact('data'));
    }
}
