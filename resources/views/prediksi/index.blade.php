@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Form Prediksi Produksi Roti</h4>
    <form action="{{ route('prediksi.proses') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="penjualan" class="form-label">Penjualan (roti)</label>
                <input type="number" name="penjualan" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="rijek" class="form-label">Riject Penjualan</label>
                <input type="number" name="rijek" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="tgl" class="form-label">Tanggal Prediksi</label>
                <input type="date" name="tgl" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Proses Prediksi</button>
    </form>
</div>
@endsection