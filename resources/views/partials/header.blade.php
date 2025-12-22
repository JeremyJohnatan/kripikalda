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

                            </div>
                            {{-- End AREA KANAN --}}

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>