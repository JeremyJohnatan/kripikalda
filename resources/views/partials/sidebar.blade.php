<div class="sidebar d-flex flex-column p-3" id="sidebarMenu">

    <div class="text-center mb-4">
        <img src="{{ asset('assets/img/alda/logo.png') }}"
             alt="Logo"
             class="img-fluid"
             style="width: 6rem; height: 6rem;">
    </div>

    <nav class="nav nav-pills flex-column gap-2">
        @if(request()->routeIs('keranjang'))
        <a href="{{ route('welcome-page') }}" class="nav-link nav-item">
            <i class="fas fa-home me-2"></i>
            Dashboard
        </a>
        @else
        <a href="{{ route('dashboard') }}" class="nav-link nav-item">
            <i class="fas fa-clipboard-list me-2"></i>
            Rincian Penjualan
        </a>

        <a href="{{ route('product.index') }}" class="nav-link nav-item">
            <i class="fas fa-box me-2"></i>
            Produk
        </a>

        <a href="{{ route('pesanan.index') }}" class="nav-link nav-item">
            <i class="fas fa-clipboard-check me-2"></i>
            Pesanan
        </a>

        <a href="{{ route('user.index') }}" class="nav-link nav-item">
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
