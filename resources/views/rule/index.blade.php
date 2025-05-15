@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4>Rule Inferensi</h4>



    <table class="table table-bordered">
        <thead>
            <tr><th>No</th><th>R1</th><th>R2</th><th>R3</th><th>R4</th></tr>
        </thead>
        <tbody>
            @forelse($rules as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r->r1 }}</td>
                <td>{{ $r->r2 }}</td>
                <td>{{ $r->r3 }}</td>
                <td>{{ $r->r4 }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Data kosong.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
