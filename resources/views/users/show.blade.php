@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Pengguna</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">Nama</label>
            <p>{{ $user->name }}</p>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <p>{{ $user->username }}</p>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <p>{{ ucfirst($user->role) }}</p>
        </div>

        <div class="form-group">
            <label for="created_at">Dibuat Pada</label>
            <p>{{ $user->created_at->format('d M Y H:i:s') }}</p>
        </div>

        <div class="form-group">
            <label for="updated_at">Terakhir Diperbarui</label>
            <p>{{ $user->updated_at->format('d M Y H:i:s') }}</p>
        </div>
    </div>
</div>
@endsection
