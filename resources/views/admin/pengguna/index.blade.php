@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="page-head">
        <h1>Kelola Pengguna</h1>
        <p><a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary">+ Tambah Pengguna</a></p>
    </div>

    <section class="panel">
        <div class="table-wrap">
            <table class="tabel">
                <thead>
                    <tr><th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($daftar as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @can('kelola role pengguna')
                                    <form method="POST" action="{{ route('admin.pengguna.role', $u) }}" class="inline-form">
                                        @csrf @method('PATCH')
                                        <select name="role">
                                            @foreach ($roles as $r)
                                                <option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-reset">Simpan</button>
                                    </form>
                                @endcan
                            </td>
                            <td>
                                <a href="{{ route('admin.pengguna.edit', $u) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}" class="inline-form"
                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection