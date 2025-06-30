@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Form Prediksi Produksi Roti</h4>
    
    {{-- Tampilkan error validasi --}}
    @if($errors->any())
        <div class="alert alert-danger" id="error-alert">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('prediksi.proses') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="penjualan" class="form-label">Penjualan (roti)</label>
                <input type="number" name="n_pen" class="form-control" value="{{ old('n_pen') }}" required>
            </div>
            <div class="col-md-4">
                <label for="rijek" class="form-label">Rijek Penjualan </label>
                <input type="number" name="n_rijek" class="form-control" value="{{ old('n_rijek') }}" required>
            </div>
            <div class="col-md-4">
                <label for="tgl" class="form-label">Tanggal Prediksi</label>
                <input type="date" name="tgl" class="form-control" 
                value="{{ $nextDate }}" 
                min="{{ $nextDate }}" 
                max="{{ $nextDate }}" 
                readonly required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Proses Prediksi</button>
    </form>

    {{-- Hasil Fuzzy (jika ada di session) --}}
    @if(session('fuzzy'))
        @php $fuzzy = session('fuzzy'); @endphp

        <hr>

        <h5 class="mt-4">Interpretasi Nilai Keanggotaan</h5>
        <p>Berdasarkan input penjualan dan jumlah roti yang tidak laku (reject):</p>
        <ul>
            <li>
                Penjualan dianggap <strong>rendah</strong>: 
                <strong>{{ number_format($fuzzy['miu_sedikit_penjualan'] * 100, 0) }}%</strong>
                <br><small class="text-muted">Semakin tinggi persen ini, semakin sedikit roti yang terjual.</small>
            </li>
            <li>
                Penjualan dianggap <strong>tinggi</strong>: 
                <strong>{{ number_format($fuzzy['miu_banyak_penjualan'] * 100, 0) }}%</strong>
                <br><small class="text-muted">Angka tinggi menandakan penjualan sedang bagus.</small>
            </li>
            <li>
                Reject dianggap <strong>rendah</strong>: 
                <strong>{{ number_format($fuzzy['miu_sedikit_rijek'] * 100, 0) }}%</strong>
                <br><small class="text-muted">Menunjukkan bahwa roti yang dibuang atau tidak terjual sedikit.</small>
            </li>
            <li>
                Reject dianggap <strong>tinggi</strong>: 
                <strong>{{ number_format($fuzzy['miu_banyak_rijek'] * 100, 0) }}%</strong>
                <br><small class="text-muted">Jika tinggi, berarti banyak roti tidak laku.</small>
            </li>
        </ul>

        <h5>Aturan Produksi yang Diterapkan</h5>
        <ul>
            <li><strong>Aturan 1</strong>: Penjualan tinggi & reject tinggi → Produksi naik ke: <strong>{{ round($fuzzy['r1']) }}</strong> roti</li>
            <li><strong>Aturan 2</strong>: Penjualan tinggi & reject rendah → Produksi naik ke: <strong>{{ round($fuzzy['r2']) }}</strong> roti</li>
            <li><strong>Aturan 3</strong>: Penjualan rendah & reject tinggi → Produksi turun ke: <strong>{{ round($fuzzy['r3']) }}</strong> roti</li>
            <li><strong>Aturan 4</strong>: Penjualan rendah & reject rendah → Produksi turun ke: <strong>{{ round($fuzzy['r4']) }}</strong> roti</li>
        </ul>

        <h5>Kesimpulan Akhir</h5>
        <p class="fs-5">
            Rekomendasi produksi roti untuk tanggal 
            <strong>{{ \Carbon\Carbon::createFromFormat('d-m-Y', $fuzzy['tgl'])->translatedFormat('d F Y') }}</strong>: 
            <strong>{{ $fuzzy['hasil'] }} roti</strong>.
        </p>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertError = document.getElementById('error-alert');
        const alertSuccess = document.getElementById('success-alert');

        if (alertError) {
            setTimeout(function () {
                alertError.style.transition = 'opacity 0.5s ease';
                alertError.style.opacity = 0;
                setTimeout(() => alertError.remove(), 500);
            }, 3000);
        }

        if (alertSuccess) {
            setTimeout(function () {
                alertSuccess.style.transition = 'opacity 0.5s ease';
                alertSuccess.style.opacity = 0;
                setTimeout(() => alertSuccess.remove(), 500);
            }, 3000);
        }
    });
</script>
@endsection
