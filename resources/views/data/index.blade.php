@extends('layouts.app')
@section('content')
@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <h4>Data Produksi</h4>
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <a href="{{ route('data.create') }}" class="btn btn-primary w-100">
                <i class="fas fa-keyboard"></i> Input Manual
            </a>
        </div>
        <div class="col-md-6 mb-2">
            <form action="{{ route('data.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="file" class="form-control" required>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Import Excel/CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped shadow-sm">
        <thead  class="table-primary">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produksi</th>
                <th>Penjualan</th>
                <th>Reject Penjualan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->tgl }}</td>
                <td>{{ $d->produksi }}</td>
                <td>{{ $d->penjualan }}</td>
                <td>{{ $d->rijek }}</td>
                <td>
                    <a href="{{ route('data.edit', $d->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                    <form action="{{ route('data.destroy', $d->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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