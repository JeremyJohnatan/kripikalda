@extends('layouts.app')

@section('title', 'Home Page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">
@endpush

@section('content')
    
    {{-- =========================================
         HEADER / NAVBAR
         ========================================= --}}
    <header id="home">
        <div id="header-fixed-height"></div>
        <div id="sticky-header" class="tg-menu-area menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="mobile-nav-toggler"><i class="flaticon-layout"></i></div>
                        <div class="menu-wrap">
                            <nav class="menu-nav">
                                <div class="logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('assets/img/alda/logo.png') }}" alt="Logo">
                                    </a>
                                </div>
                                <div class="navbar-wrap main-menu d-none d-xl-flex">
                                    <ul class="navigation">
                                        <li class="{{ Request::is('welcome-page') ? 'active' : '' }}">
                                            <a href="{{ url('/welcome-page') }}">Home</a>
                                        </li>   
                                        <li><a href="{{ route('keranjang') }}">Cart</a></li>
                                        <li><a href="#footer">Contact</a></li>
                                    </ul>
                                </div>
                                <div class="header-action d-none d-sm-flex">
                                    <div class="header-btn">
                                        <a href="{{ route('keranjang')}}" class="tg-btn">Order Now</a>
                                    </div>
                                    @auth
                                        <div class="profile-dropdown">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1a4d2e&color=fff&size=128&bold=true" 
                                                 alt="Profile" class="profile-img">
                                            <span class="profile-name">
                                                {{ Str::limit(Auth::user()->name, 10) }} 
                                                <i class="fas fa-chevron-down"></i>
                                            </span>
                                            <div class="profile-menu">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="logout-btn">
                                                        <i class="fas fa-sign-out-alt"></i> Logout
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}" style="color: #fff; font-weight: 600; text-decoration: none;">Login</a>
                                    @endauth
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    {{-- =========================================
         MAIN CONTENT
         ========================================= --}}
    <main class="main-area-fixx">

        
        <div class="mobile-menu">
            <nav class="menu-box">
                <div class="close-btn"><i class="fas fa-times"></i></div>
                <div class="nav-logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('assets/img/alda/logo.png') }}" alt="Logo"></a>
                </div>
                <div class="menu-outer"></div>
            </nav>
        </div>
        <section class="hero-alda"
            style="
                /* 1. Setup Background Gambar (Layering) */
                background-image:
                    url('{{ asset('assets/img/alda/bg.png') }}'),       /* Layer Atas: Gelombang */
                    url('{{ asset('assets/img/alda/Background.png') }}'); /* Layer Bawah: Utama */
                
                /* 2. Posisi Background */
                background-position: top center, center center;
                
                /* 3. Ukuran Background (PENTING agar gelombang tidak gepeng) */
                /* 100% auto = lebar penuh, tinggi menyesuaikan proporsi gambar */
                background-size: 100% auto, cover;
                
                background-repeat: no-repeat, no-repeat;

                /* 4. Setup agar FIT SCREEN (PENTING) */
                min-height: 100vh; /* Tinggi minimal selebar layar gadget */
                display: flex;     /* Gunakan flexbox */
                align-items: center; /* Tengahkan konten secara vertikal */
                
                /* 5. Padding agar konten tidak tertutup Navbar */
                /* Sesuaikan nilai ini jika navbar Anda lebih tinggi/pendek */
                padding-top: 100px; 
                padding-bottom: 50px; /* Padding bawah agar tidak terlalu mepet di HP */
            ">

            <div class="container hero-content">
                <div class="row align-items-center justify-content-between">
                    {{-- Text Content --}}
                    <div class="col-lg-6 text-lg-start text-center">
                        <h1 class="hero-title">
                            Keripik Jamur
                            <span>ALDA</span>
                        </h1>
                        <a href="{{ route('keranjang')}}" class="btn-alda">Beli Sekarang</a>
                    </div>

                    {{-- Product Image --}}
                    <div class="col-lg-6 text-lg-end text-center">
                        <img src="{{ asset('assets/img/alda/product.png') }}" class="hero-product" alt="Keripik Jamur ALDA" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </section>

        <section class="tentang-kami-section" id="tentang">
            <div class="container">
                <div class="tentang-kami-card">
                    <div class="tentang-kami-content">
                        <h2>Tentang Kami</h2>
                        <p>
                            Sejak 2011, Kripik Alda hadir dengan camilan sehat yang nggak cuma enak, tapi juga bergizi! Kami menghadirkan Kripik Jamur dan Kripik Pare yang terbuat dari bahan alami pilihan, 
                            diproses dengan cara yang higienis untuk menjaga kualitas dan rasa. Tanpa bahan pengawet, kripik kami punya tekstur renyah yang cocok banget buat teman nongkrong atau ngemil sambil santai. 
                            Berlokasi di Rt/Rw 01/05, Ds. Jagul Dsn. Sraten, Kec. Ngancar, Kabupaten Kediri, Jawa Timur, kami siap memberikan camilan yang nggak hanya lezat, tapi juga mendukung gaya hidup sehat. Kripik Alda – camilan yang bikin ketagihan!
                        </p>
                    </div>
                    <div class="tentang-kami-image">
                        <img src="{{ asset('assets/img/alda/mascot.png') }}" alt="Mascot">
                    </div>
                </div>
            </div>
        </section>

        <section class="produk-section" id="produk">
            <div class="section-title"><h2>Produk</h2></div>
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-ayam-panggang.png') }}" alt="ayam" />
                        <div class="produk-label">Kripik Jamur Rasa Ayam Panggang</div>
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-balado.png') }}" alt="balado" />
                        <div class="produk-label">Kripik Jamur Rasa Balado</div>
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-bbq.png') }}" alt="bbq" />
                        <div class="produk-label">Kripik Jamur Rasa BBQ</div>
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-original.png') }}" alt="original" />
                        <div class="produk-label">Kripik Jamur Rasa Original</div>
                    </div>
                     <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-pedas.png') }}" alt="pedas" />
                        <div class="produk-label">Kripik Jamur Rasa Pedas</div>
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-ayam-panggang.png') }}" alt="ayam" />
                        <div class="produk-label">Kripik Jamur Rasa Ayam Panggang</div>
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-balado.png') }}" alt="balado" />
                        <div class="produk-label">Kripik Jamur Rasa Balado</div>
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-bbq.png') }}" alt="bbq" />
                        <div class="produk-label">Kripik Jamur Rasa BBQ</div>
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-original.png') }}" alt="original" />
                        <div class="produk-label">Kripik Jamur Rasa Original</div>
                    </div>
                     <div class="swiper-slide">
                        <img src="{{ asset('assets/img/alda/produk-pedas.png') }}" alt="pedas" />
                        <div class="produk-label">Kripik Jamur Rasa Pedas</div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <a href="{{ route('keranjang')}}"
            class="btn-beli">Beli Sekarang </a>
        </section>

    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".swiper", {
            slidesPerView: 5, centeredSlides: true, loop: true, initialSlide: 2, loopedSlides: 10, spaceBetween: 20, grabCursor: true,
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            breakpoints: {
                0: { slidesPerView: 1.5, spaceBetween: 10 },
                480: { slidesPerView: 3, spaceBetween: 15 },
                768: { slidesPerView: 5, spaceBetween: 30 },
            },
        });
    </script>
@endpush