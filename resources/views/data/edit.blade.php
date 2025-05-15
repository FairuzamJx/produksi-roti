@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Edit Data Produksi</h4>
    <form action="{{ route('data.update', $data->id) }}" method="POST">
        @csrf @method('PUT')
        <input type="date" name="tgl" value="{{ $data->tgl }}" class="form-control mb-2">
        <input type="number" name="produksi" value="{{ $data->produksi }}" class="form-control mb-2">
        <input type="number" name="penjualan" value="{{ $data->penjualan }}" class="form-control mb-2">
        <input type="number" name="rijek" value="{{ $data->rijek }}" class="form-control mb-3">
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
