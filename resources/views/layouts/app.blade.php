<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Suxnix')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/alda/logo.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    @stack('styles')
</head>

<body>

    @include('partials.preloader')
    @include('partials.scrolltop')

    {{-- LOGIC ADMIN --}}
    @if(auth()->check() && auth()->user()->role === 'Admin')
    <div class="d-flex">
        @include('partials.sidebar')

        <main class="main-area">
            <button class="btn btn-light d-lg-none m-3" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>

            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
            @yield('content')
        </main>
    </div>

    {{-- LOGIC CUSTOMER --}}
    @elseif(auth()->check() && auth()->user()->role === 'Customer')

    @if(!request()->routeIs('keranjang'))

    {{--
               MODIFIKASI PENTING:
               Cek apakah ini Halaman Home ('/') atau ('welcome-page').
               Jika YA: Jangan load header bawaan (karena kita pakai header custom transparan).
               Jika BUKAN: Load header biasa.
            --}}
    @if(!request()->is('/') && !request()->is('welcome-page'))
    @include('partials.header')
    @endif

    <main class="main-full">
        @yield('content')
    </main>



    {{-- Footer tetap ditampilkan di semua halaman --}}
    @include('partials.footer')

    @else
    {{-- Tampilan Halaman Keranjang (Pakai Sidebar) --}}
    <div class="d-flex">
        @include('partials.sidebar')
        <main class="main-area">
            <button class="btn btn-light d-lg-none m-3" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
            @yield('content')
        </main>
    </div>
    @endif

    {{-- LOGIC GUEST (BELUM LOGIN) --}}
    @else
    {{--
           MODIFIKASI PENTING:
           Jika di halaman Home, hapus class "main-area" agar tidak ada padding bawaan 
           yang merusak tampilan Hero Full Screen.
        --}}
    <main
        class="{{ (request()->is('/') || request()->is('welcome-page')) ? '' : 'main-area fix' }} {{ request()->routeIs('login','register') ? 'no-padding' : '' }}">
        @yield('content')
    </main>
    @endif


    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.paroller.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inview.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/svg-inject.min.js') }}"></script>
    <script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/validator.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    // Cek null safety sebelum inject
    const injectImages = document.querySelectorAll("img.injectable");
    if (injectImages.length > 0) {
        SVGInject(injectImages);
    }
    </script>

    <script>
    const sidebar = document.getElementById('sidebarMenu');
    const backdrop = document.getElementById('sidebarBackdrop');
    const toggleBtn = document.getElementById('toggleSidebar');

    if (toggleBtn && sidebar && backdrop) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        });

        backdrop.addEventListener('click', () => {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        });
    }
    </script>

    @stack('scripts')
</body>

</html>