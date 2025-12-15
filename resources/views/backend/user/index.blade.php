@extends('layouts.app')

@section('content')
<div class="ml-1 mb-4">
    <h1 class="fw-bold">User Management</h1>
</div>

<div class="d-flex flex-wrap card shadow-sm px-4" style="border-radius: 35px;">
    <div class="m-0 ms-2 me-4">

        <div class="sub-title mt-3">
            <h2>Daftar User</h2>
        </div>

        <div class="table mt-4">
            <table class="table mb-4">
                <thead class="border-top border-bottom border-dark">
                    <tr>
                        <th class="fw-semibold py-1 text-start">Nama</th>
                        <th class="fw-semibold py-1 text-center">Email</th>
                        <th class="fw-semibold py-1 text-center">No. HP</th>
                        <th class="fw-semibold py-1 text-center">Alamat</th>
                        <th class="fw-semibold py-1 text-center">Role</th>
                        <th class="fw-semibold py-1 text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="fw-semibold py-1 text-start">
                            {{ $user->name }}
                        </td>

                        <td class="fw-semibold py-1 text-center">
                            {{ $user->email }}
                        </td>

                        <td class="fw-semibold py-1 text-center">
                            {{ $user->no_hp ?? '-' }}
                        </td>

                        <td class="fw-semibold py-1 text-center">
                            {{ $user->alamat ?? '-' }}
                        </td>

                        <td class="fw-semibold py-1 text-center">
                            <span class="badge
                                {{ $user->role === 'Admin' ? 'bg-primary' : 'bg-secondary' }}">
                                {{ $user->role }}
                            </span>
                        </td>

                        <td class="fw-semibold py-1 text-end">
                            <form method="POST"
                                  action="{{ route('user.destroy', $user->id) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash me-1"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if($users->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-3">
                            Tidak ada user
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
