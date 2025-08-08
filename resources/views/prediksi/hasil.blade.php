@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Hasil Prediksi Produksi</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Hasil Prediksi (roti)</th>
                </tr>
            </thead>
            <tbody>
                  @foreach($data as $item)
                <tr>
                    <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl)->format('d-m-Y') }}</td>
                    <td>{{ $item->hasil }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection
