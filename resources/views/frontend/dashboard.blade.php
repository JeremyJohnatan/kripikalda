@extends('layouts.app')

@section('title', 'Home Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">
@endpush

@section('content')

{{-- =========================================
         HEADER / NAVBAR (TIDAK DIUBAH)
         ========================================= --}}
<div class="alda alda-fullpage">
    <header id="home">
        <div id="header-fixed-height">
        </div>
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
                                            <a href="{{ url('/home') }}">Home</a>
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
                                    <a href="{{ route('login') }}"
                                        style="color: #fff; font-weight: 600; text-decoration: none;">Login</a>
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
    <main class="main-area fix">

        <div class="mobile-menu">
            <nav class="menu-box">
                <div class="close-btn"><i class="fas fa-times"></i></div>
                <div class="nav-logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('assets/img/alda/logo.png') }}" alt="Logo"></a>
                </div>
                <div class="menu-outer"></div>
            </nav>
        </div>

        {{--
           HERO SECTION (HANYA BAGIAN INI YANG DIUBAH STYLE-NYA)
           Agar FIT di layar dan background benar.
        --}}
        <section class="hero-alda" style="
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
                        <a href="#produk" class="btn-alda">Beli Sekarang</a>
                    </div>

                    {{-- Product Image --}}
                    <div class="col-lg-6 text-lg-end text-center">
                        {{-- Tambahkan style max-width agar gambar produk responsif di dalam hero --}}
                        <img src="{{ asset('assets/img/alda/product.png') }}" class="hero-product"
                            alt="Keripik Jamur ALDA" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </section>

        {{-- Tentang Kami Section (TIDAK DIUBAH) --}}
        <section class="tentang-kami-section" id="tentang">
            <div class="container">
                <div class="tentang-kami-card">
                    <div class="tentang-kami-content">
                        <h2>Tentang Kami</h2>
                        <p>
                            Sejak 2011, Kripik Alda hadir dengan camilan sehat yang nggak cuma enak, tapi juga bergizi!
                            Kami
                            menghadirkan Kripik Jamur dan Kripik Pare yang terbuat dari bahan alami pilihan.
                        </p>
                    </div>
                    <div class="tentang-kami-image">
                        <img src="{{ asset('assets/img/alda/mascot.png') }}" alt="Mascot">
                    </div>
                </div>
            </div>
        </section>

        {{-- Produk Section (TIDAK DIUBAH) --}}
        <section class="produk-section" id="produk">
            <div class="section-title">
                <h2>Produk</h2>
            </div>
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
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <button class="btn-beli">Beli Sekarang</button>
        </section>

        {{-- ULASAN --}}
        <section id="ulasan" class="alda-ulasan">
            <h2 class="alda-ulasan__title">Ulasan Pelanggan</h2>

            <div class="alda-ulasan__grid">
                {{-- Kiri (kecil) --}}
                <article class="ulasan-card ulasan-card--small ulasan-card--left">
                    <div class="ulasan-card__avatar ulasan-card__avatar--left"></div>
                    <div class="ulasan-card__stars ulasan-card__stars--left">
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star off">★</span>
                    </div>
                </article>

                {{-- Tengah (besar) --}}
                <article class="ulasan-card ulasan-card--big">
                    <div class="ulasan-card__avatar ulasan-card__avatar--big"></div>
                    <h3 class="ulasan-card__name">Nama User</h3>
                    <div class="ulasan-card__stars ulasan-card__stars--center">
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star off">★</span>
                    </div>
                    <p class="ulasan-card__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ut feugiat, nisi nec
                        ullamcorper efficitur, turpis est hendrerit risus, nec tempus augue tellus et sapien.
                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                    </p>
                </article>

                {{-- Kanan (kecil) --}}
                <article class="ulasan-card ulasan-card--small ulasan-card--right">
                    <div class="ulasan-card__avatar ulasan-card__avatar--right"></div>
                    <div class="ulasan-card__stars ulasan-card__stars--right">
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                        <span class="star on">★</span>
                    </div>
                </article>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer id="footer" class="alda-foot">
            <div class="alda-foot__fullwidth-bg">
                <div class="alda-foot__container">
                    <div class="alda-foot__wrap">
                        {{-- Kolom Kiri: Logo & Alamat --}}
                        <div class="alda-foot__col alda-foot__col--left">
                            <div class="alda-foot__logo-wrapper">
                                <img class="alda-foot__logo" src="{{ asset('assets/img/alda/mascot.png') }}"
                                    alt="ALDA Logo">
                            </div>
                            <div class="alda-foot__address-section">
                                <div class="alda-foot__address-item">
                                    <div class="alda-foot__icon">📍</div>
                                    <div class="alda-foot__address">
                                        <span class="alda-foot__address-line">RT 01 RW 05 Dusun Saten, Desa Jagul, Kec.
                                            Ngancar, Kab. Kediri, Jawa Timur</span>
                                    </div>
                                </div>
                                <div class="alda-foot__address-item">
                                    <div class="alda-foot__icon">✉️</div>
                                    <a href="mailto:example@gmail.com" class="alda-foot__email">example@gmail.com</a>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Tengah: Jam Buka --}}
                        <div class="alda-foot__col alda-foot__col--center">
                            <div class="alda-foot__section-header">
                                <h3 class="alda-foot__section-title">Jam Buka</h3>
                                <div class="alda-foot__section-divider"></div>
                            </div>
                            <div class="alda-foot__hours">
                                <div class="alda-foot__hour-item">
                                    <span class="alda-foot__day">Senin - Sabtu</span>
                                    <span class="alda-foot__separator">:</span>
                                    <span class="alda-foot__time">09.00 - 21.00</span>
                                </div>
                                <div class="alda-foot__hour-item">
                                    <span class="alda-foot__day">Minggu</span>
                                    <span class="alda-foot__separator">:</span>
                                    <span class="alda-foot__time">10.00 - 20.00</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Kontak dengan Logo --}}
                        <div class="alda-foot__col alda-foot__col--right">
                            <div class="alda-foot__section-header">
                                <h3 class="alda-foot__section-title">Ikuti Kami</h3>
                                <div class="alda-foot__section-divider"></div>
                            </div>
                            <div class="alda-foot__contacts">
                                <div class="alda-foot__contact-item">
                                    <div class="alda-foot__contact-icon">
                                        <svg class="whatsapp-icon" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.43 0 4.68.94 6.4 2.66a8.994 8.994 0 0 1 2.63 6.4c0 4.97-4.04 9.01-9.01 9.01c-1.6 0-3.15-.43-4.51-1.22l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.88 8.88 0 0 1-1.24-4.63c0-4.97 4.04-9.01 9.01-9.01M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.28c-.25-.13-1.46-.72-1.69-.8c-.23-.08-.37-.12-.56.12c-.16.25-.64.8-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.51c.12-.12.27-.32.37-.48c.1-.16.17-.28.23-.45c.06-.17.03-.32-.02-.45c-.05-.12-.45-1.09-.62-1.5c-.16-.39-.33-.33-.45-.34c-.12 0-.24-.01-.37-.01z" />
                                        </svg>
                                    </div>
                                    <span class="alda-foot__contact-text">0857-8854-2083</span>
                                </div>
                                <div class="alda-foot__contact-item">
                                    <div class="alda-foot__contact-icon">
                                        <svg class="instagram-icon" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3z" />
                                        </svg>
                                    </div>
                                    <span class="alda-foot__contact-text">@kripikjamuralda_</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
const swiper = new Swiper(".swiper", {
    slidesPerView: 5,
    centeredSlides: true,
    loop: true,
    initialSlide: 2,
    loopedSlides: 10,
    spaceBetween: 20,
    grabCursor: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    },
    breakpoints: {
        0: {
            slidesPerView: 1.5,
            spaceBetween: 10
        },
        480: {
            slidesPerView: 3,
            spaceBetween: 15
        },
        768: {
            slidesPerView: 5,
            spaceBetween: 30
        },
    },
});
</script>
@endpush