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

        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf

            <a href="{{ route('logout') }}"
            class="nav-link nav-item text-danger"
            onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i>
                Logout
            </a>
        </form>

    </nav>
</div>
