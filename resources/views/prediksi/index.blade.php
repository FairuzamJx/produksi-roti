@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Form Prediksi Produksi Roti</h4>
    
    {{-- Tampilkan error validasi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
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
                <input type="date" name="tgl" class="form-control" value="{{ old('tgl') }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Proses Prediksi</button>
    </form>

    {{-- Hasil Fuzzy (jika ada di session) --}}
    @if(session('fuzzy'))
        @php $fuzzy = session('fuzzy'); @endphp

        <hr>
        <h5 class="mt-4">Hasil Fuzzifikasi</h5>
        <ul>
            <li>MiU Penjualan Sedikit: {{ number_format($fuzzy['miu_sedikit_penjualan'], 3) }}</li>
            <li>MiU Penjualan Banyak: {{ number_format($fuzzy['miu_banyak_penjualan'], 3) }}</li>
            <li>MiU Rijek Sedikit: {{ number_format($fuzzy['miu_sedikit_rijek'], 3) }}</li>
            <li>MiU Rijek Banyak: {{ number_format($fuzzy['miu_banyak_rijek'], 3) }}</li>
        </ul>

        <h5>Inferensi Rule</h5>
        <ul>
            <li>R1 (↑) : {{ round($fuzzy['r1']) }}</li>
            <li>R2 (↑) : {{ round($fuzzy['r2']) }}</li>
            <li>R3 (↓) : {{ round($fuzzy['r3']) }}</li>
            <li>R4 (↓) : {{ round($fuzzy['r4']) }}</li>
        </ul>

        <h5>Hasil Defuzzifikasi</h5>
        <p class="fs-5">Jumlah Produksi Roti: <strong>{{ $fuzzy['hasil'] }}</strong></p>
    @endif
</div>
@endsection
