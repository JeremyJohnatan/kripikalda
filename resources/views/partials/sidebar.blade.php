<div class="sidebar d-flex flex-column p-3" id="sidebarMenu">

    <div class="text-center mb-4">
        <img src="{{ asset('assets/img/alda/logo.png') }}"
             alt="Logo"
             class="img-fluid"
             style="width: 6rem; height: 6rem;">
    </div>

    <nav class="nav nav-pills flex-column gap-2">
        @if(request()->routeIs('keranjang', 'history.*'))
        <a href="{{ route('welcome-page') }}" class="nav-link nav-item {{ request()->routeIs('welcome-page') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i>
            Dashboard
        </a>
        <a href="{{ route('keranjang') }}" class="nav-link nav-item {{ request()->routeIs('keranjang') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart me-2"></i>
            Keranjang
        </a>
        <a href="{{ route('history.index') }}" class="nav-link nav-item {{ request()->routeIs('history.index') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list me-2"></i>
            Riwayat Beli
        </a>
        @else
        <a href="{{ route('dashboard') }}" class="nav-link nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list me-2"></i>
            Rincian Penjualan
        </a>

        <a href="{{ route('kategori.index') }}"
   class="nav-link nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
    <i class="fas fa-tags me-2"></i>
    Kategori
</a>


        <a href="{{ route('product.index') }}" class="nav-link nav-item {{ request()->routeIs('product.index') ? 'active' : '' }}">
            <i class="fas fa-box me-2"></i>
            Produk
        </a>

        <a href="{{ route('pesanan.index') }}" class="nav-link nav-item {{ request()->routeIs('pesanan.index') ? 'active' : '' }}">
            <i class="fas fa-clipboard-check me-2"></i>
            Pesanan
        </a>

        <a href="{{ route('promo.index') }}" class="nav-link nav-item {{ request()->routeIs('promo.index') ? 'active' : '' }}">
            <i class="fas fa-percent me-2"></i>
            Promo
        </a>

        <a href="{{ route('user.index') }}" class="nav-link nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
            <i class="fas fa-user me-2"></i>
            User
        </a>
        @endif

       <form id="logout-form" method="POST" action="{{ route('logout') }}" class="mt-auto">
        @csrf

        <a href="#" 
           class="nav-link nav-item text-danger"
           onclick="confirmLogout(event)">
            <i class="fas fa-sign-out-alt me-2"></i>
            Logout
        </a>
    </form>

</nav>
</div>





<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmLogout(event) {
        event.preventDefault(); // Mencegah link bekerja langsung
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan keluar dari sesi ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6', // Warna tombol konfirmasi (bisa disesuaikan)
            cancelButtonColor: '#d33',    // Warna tombol batal
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika user menekan tombol Ya
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>