@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4>Fuzzifikasi</h4>



    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Sedikit Penjualan</th>
                <th>Banyak Penjualan</th>
                <th>Sedikit Rijek</th>
                <th>Banyak Rijek</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fuzzy as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->mspenjualan }}</td>
                <td>{{ $item->mbpenjualan }}</td>
                <td>{{ $item->msrijek }}</td>
                <td>{{ $item->mbrijek }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Data kosong.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
