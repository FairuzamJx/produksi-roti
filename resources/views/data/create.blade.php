@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Tambah Data Produksi</h4>
    <form action="{{ route('data.store') }}" method="POST">@csrf
        <input type="date" name="tgl" class="form-control mb-2" placeholder="Tanggal" required>
        <input type="number" name="produksi" class="form-control mb-2" placeholder="Produksi" required>
        <input type="number" name="penjualan" class="form-control mb-2" placeholder="Penjualan" required>
        <input type="number" name="rijek" class="form-control mb-3" placeholder="Rijek" required>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection