@extends('layouts.app')

@section('content')
<div class="card">
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
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna</h3>
        <a href="/users/create" class="btn btn-primary btn-sm float-right">+Tambah Pengguna</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped shadow-sm">
            <thead  class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ ucfirst($user->role) }}</td> {{-- Tampilkan role di sini --}}
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        {{-- Cegah user menghapus dirinya sendiri --}}
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
         {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
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
