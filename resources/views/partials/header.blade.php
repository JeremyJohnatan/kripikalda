<header id="home">
    <div id="header-fixed-height"></div>
    <div id="sticky-header" class="tg-menu-area menu-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mobile-nav-toggler"><i class="flaticon-layout"></i></div>
                    <div class="menu-wrap">
                        <nav class="menu-nav">
                            {{-- Logo Area --}}
                            <div class="logo">
                                <a href="{{ url('/') }}">
                                    <img src="assets/img/alda/logo.png" alt="Logo">
                                </a>
                            </div>

                            {{-- Navbar Menu --}}
                            <div class="navbar-wrap main-menu d-none d-xl-flex">
                                <ul class="navigation">
                                    <li class="{{ Request::is('welcome-page') ? 'active' : '' }}">
                                        <a href="{{ url('/welcome-page') }}">Home</a>
                                    </li>   
                                    <li>
                                        <a href="{{ route('keranjang') }}">Cart</a>
                                    </li>
                                    <li>
                                        <a href="#footer">Contact</a>
                                    </li>
                                </ul>
                            </div>

                            {{-- AREA KANAN: Order Now & Profile --}}
                            <div class="header-action d-none d-sm-block">
                                
                                {{-- Tombol Order Now --}}
                                <div class="header-btn">
                                    <a href="{{ route('keranjang')}}" class="tg-btn">Order Now</a>
                                </div>

                                {{-- Bagian Profile User --}}
                                @auth
                                    <div class="profile-dropdown">
                                        {{-- Foto Profile: Menggunakan background hijau tua agar selaras, teks putih --}}
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1a4d2e&color=fff&size=128" 
                                             alt="Profile" class="profile-img">
                                        
                                        {{-- Nama User --}}
                                        <span class="profile-name">
                                            {{ Str::limit(Auth::user()->name, 8) }} 
                                            <i class="fas fa-chevron-down"></i>
                                        </span>

                                        {{-- Dropdown Logout --}}
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
                                    {{-- Jika Belum Login --}}
                                    <a href="{{ route('login') }}" class="login-link">Login</a>
                                @endauth

                            </div>
                            {{-- End AREA KANAN --}}

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>