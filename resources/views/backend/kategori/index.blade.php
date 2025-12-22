@extends('layouts.app')

@section('content')
<div class="ml-1 mb-4">
    <h1 class="fw-bold">Kategori</h1>
</div>

<div class="d-flex flex-wrap card shadow-sm px-4" style="border-radius: 35px;">
    <!-- Action -->
    <div class="m-0 ms-2 me-4">
        <div class="d-flex justify-content-end">
            <a href="{{ route('kategori.create') }}"
               class="btn-success d-flex align-items-center p-2 gap-2">
                <img src="{{ asset('assets/img/icons/mdi_box-plus.svg') }}" alt="">
                Tambah Kategori
            </a>
        </div>
    </div>

    <div class="sub-title mt-0">
        <h2>Daftar Kategori</h2>
    </div>

    <div class="table mt-4">
        <table class="table mb-4">
            <thead class="border-top border-bottom border-dark">
                <tr>
                    <th class="fw-semibold py-1 text-start">No</th>
                    <th class="fw-semibold py-1 text-start">Nama Kategori</th>
                    <th class="fw-semibold py-1 text-center">Jumlah Produk</th>
                    <th class="fw-semibold py-1 text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($kategoris as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="fw-semibold">
                        {{ $kategori->nama_kategori }}
                    </td>

                    <td class="text-center">
    <span class="badge bg-info">
        {{ number_format($kategori->total_stok ?? 0) }} pcs
    </span>
</td>


                    <td class="text-end">
                        <a href="{{ route('kategori.edit', $kategori->id) }}"
                           class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('kategori.destroy', $kategori->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete-btn">
    Hapus
</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form'); 

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data kategori yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // submit form jika konfirmasi
            }
        });
    });
});
</script>
@endpush
