@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">
@endpush
  <!-- header-area -->
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
                                            <img src="assets/img/alda/logo.png" alt="Logo">
                                        </a>
                                    </div>
                                    <div class="navbar-wrap main-menu d-none d-xl-flex">
                                        <ul class="navigation">
                                            <li class="active menu-item-has-children"><a href="#home" class="section-link">Home</a>
                                                <ul class="sub-menu">
                                                    <li><a href="index.html">Home One</a></li>
                                                    <li class="active"><a href="index-2.html">Home Two</a></li>
                                                    <li><a href="index-3.html">Home Three</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#ingredient" class="section-link">Ingredient</a></li>
                                            <li><a href="#supplement" class="section-link">Supplement</a></li>
                                            <li><a href="#feature" class="section-link">Feature</a></li>
                                            <li class="menu-item-has-children"><a href="#shop" class="section-link">Shop</a>
                                                <ul class="sub-menu">
                                                    <li><a href="shop.html">Our Shop</a></li>
                                                    <li><a href="shop-details.html">Shop Details</a></li>
                                                    <li><a href="cart.html">Cart Page</a></li>
                                                    <li><a href="checkout.html">Checkout Page</a></li>
                                                    <li><a href="login.html">Login Page</a></li>
                                                    <li><a href="register.html">Register Page</a></li>
                                                    <li><a href="reset-password.html">Reset Password Page</a></li>
                                                </ul>
                                            </li>

                                            <li><a href="contact.html">Ulasan</a></li>
                                            <li><a href="contact.html">contacts</a></li>
                                        </ul>
                                    </div>
                                    <div class="header-btn d-none d-sm-block">
                                        <a href="{{ route('keranjang')}}" class="tg-btn">Order Now</a>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header-area-end -->
