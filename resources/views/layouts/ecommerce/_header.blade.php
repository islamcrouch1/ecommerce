@if (!Route::is('ecommerce.invoice'))
    <!-- loader start -->
    <div class="loader_skeleton">

        <header class="header-style-5 color-style">
            <div class="top-header top-header-theme">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="header-contact">
                                <ul>
                                    <li>{{ app()->getLocale() == 'ar' ? websiteSettingAr('welcome_text') : websiteSettingEn('welcome_text') }}
                                    </li>
                                    <li><i class="fa fa-phone"
                                            aria-hidden="true"></i>{{ __('Call Us:' . ' ' . websiteSettingAr('header_phone')) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="header-contact text-end">
                                <ul>
                                    <li><i class="fa fa-truck" aria-hidden="true"></i>Track Order</li>
                                    <li class="pe-0"><i class="fa fa-gift" aria-hidden="true"></i>Gift Cards</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="main-menu">
                            <div class="menu-left">
                                {{-- <div class="navbar d-block d-xl-none">
                                    <a href="javascript:void(0)">
                                        <div class="bar-style" id="toggle-sidebar-res"><i class="fa fa-bars sidebar-bar"
                                                aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </div> --}}
                                <div class="brand-logo">
                                    <a href="{{ route('ecommerce.home') }}"><img style="width:179px"
                                            src="{{ asset(websiteSettingMedia('header_logo')) }}"
                                            class="img-fluid blur-up lazyload" alt=""></a>
                                </div>
                            </div>
                            <div>
                                <form action="{{ route('ecommerce.products') }}"
                                    class="form_search ajax-search the-basics" role="form">
                                    <input style="{{ app()->getLocale() == 'ar' ? 'direction:rtl;' : '' }}"
                                        type="search" name="search" placeholder="{{ __('Search any product...') }}"
                                        class="nav-search nav-search-field typeahead" aria-expanded="true">
                                    <button type="submit" class="btn-search">
                                        <i class="ti-search"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="menu-right pull-right">
                                <nav class="text-start">
                                    <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                </nav>
                                <div class="top-header d-block">
                                    <ul class="header-dropdown">
                                        <li class="mobile-wishlist"><a href="#"><img
                                                    src="{{ asset('e-assets/images/icon/white-icon/heart.png') }}"
                                                    alt="">
                                            </a></li>
                                        <li class="onhover-dropdown mobile-account">
                                            <a
                                                href="{{ Auth::check() ? route('ecommerce.account') : route('ecommerce.user.show') }}">
                                                <img src="{{ asset('e-assets/images/icon/white-icon/user.png') }}"
                                                    alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <div class="icon-nav d-none d-sm-block">
                                        <ul>
                                            <li class="onhover-div d-xl-none d-inline-block mobile-search">
                                                <div><img src="{{ asset('e-assets/images/icon/search.png') }}"
                                                        class="img-fluid blur-up lazyload" alt=""> <i
                                                        class="ti-search"></i></div>
                                            </li>
                                            <li class="onhover-div mobile-setting">
                                                <div><img src="{{ asset('e-assets/images/icon/setting.png') }}"
                                                        class="img-fluid blur-up lazyload" alt=""> <i
                                                        class="ti-settings"></i></div>
                                            </li>
                                            <li class="onhover-div mobile-cart">
                                                <div><img src="{{ asset('e-assets/images/icon/cart.png') }}"
                                                        class="img-fluid blur-up lazyload" alt=""> <i
                                                        class="ti-shopping-cart"></i></div>
                                                <span class="cart_qty_cls">0</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-part">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="category-menu d-none d-xl-block h-100">
                                <div class="toggle-sidebar">
                                    <i class="fa fa-bars sidebar-bar"></i>
                                    <h5 class="mb-0">{{ __('shop by category') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-9">
                            <div class="main-nav-center">
                                <nav class="text-start">
                                    <!-- Sample menu definition -->
                                    <ul class="sm pixelstrap sm-horizontal">
                                        <li>
                                            <div class="mobile-back text-end">{{ __('Back') }}<i
                                                    class="fa fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ps-2 p-1"
                                                    aria-hidden="true"></i></div>
                                        </li>
                                        <li><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                                        <li><a
                                                href="{{ route('ecommerce.products', ['category' => null]) }}">{{ __('products') }}</a>
                                        </li>
                                        <li><a href="#">{{ __('brands') }}</a> </li>
                                        <li><a href="#">{{ __('about us') }}</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @if (Route::is('ecommerce.home'))
            <section class="pt-0 height-65">
                <div class="home-slider">
                    <div class="home"></div>
                </div>
            </section>
            <section class="pt-0 ratio3_2">
                <div class="container-fluid p-0">
                    <div class="row m-0">
                        <div class="col-lg-3 col-sm-6 p-0">
                            <a href="#">
                                <div class="collection-banner p-left">
                                    <div class="ldr-bg ldr-bg-dark">
                                        <div class="contain-banner banner-3">
                                            <div>
                                                <h4></h4>
                                                <h2></h2>
                                                <h6></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-0">
                            <a href="#">
                                <div class="collection-banner p-left">
                                    <div class="ldr-bg ldr-bg-darker">
                                        <div class="contain-banner banner-3">
                                            <div>
                                                <h4></h4>
                                                <h2></h2>
                                                <h6></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-0">
                            <a href="#">
                                <div class="collection-banner p-left">
                                    <div class="ldr-bg ldr-bg-dark">
                                        <div class="contain-banner banner-3">
                                            <div>
                                                <h4></h4>
                                                <h2></h2>
                                                <h6></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-0">
                            <a href="#">
                                <div class="collection-banner p-left">
                                    <div class="ldr-bg ldr-bg-darker">
                                        <div class="contain-banner banner-3">
                                            <div>
                                                <h4></h4>
                                                <h2></h2>
                                                <h6></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="product-para">
                                <p class="first"></p>
                                <p class="second"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="bag-product pt-0 section-b-space ratio_square">
                <div class="container">
                    <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gy-sm-4 gy-3">
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                        <div class="product-box product-sm">
                            <div class="img-wrapper"></div>
                            <div class="product-detail">
                                <h4></h4>
                                <h5></h5>
                                <h5 class="second"></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (Route::is('ecommerce.product'))
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-title">
                                <h2>{{ __('product') }}</h2>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="3">{{ __('Home') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('product') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section-b-space ratio_asos">
                <div class="collection-wrapper product-page">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="main-product lg-img"></div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="sm-product"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="sm-product"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="sm-product"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="product-right">
                                                <h2></h2>
                                                <h4></h4>
                                                <h3></h3>
                                                <ul>
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                </ul>
                                                <div class="btn-group">
                                                    <div class="btn-ldr"></div>
                                                    <div class="btn-ldr"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section class="tab-product m-0">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12">
                                            <ul>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                            </ul>
                                            <p></p>
                                            <p></p>
                                            <p></p>
                                            <p></p>
                                            <p></p>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        @if (Route::is('ecommerce.products'))
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-title">
                                <h2>{{ __('products') }}</h2>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="3">{{ __('Home') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('products') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <section class="section-b-space ratio_asos">
                <div class="collection-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3 collection-filter">
                                <!-- side-bar colleps block stat -->
                                <div class="collection-filter-block">
                                    <div class="filter-block">
                                        <h4 class="title-ldr"></h4>
                                        <ul>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                        </ul>
                                    </div>
                                    <div class="filter-block">
                                        <h4 class="title-ldr"></h4>
                                        <ul>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                        </ul>
                                    </div>
                                    <div class="filter-block">
                                        <h4 class="title-ldr"></h4>
                                        <ul>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- silde-bar colleps block end here -->
                                <!-- side-bar single product slider start -->
                                <div class="theme-card">
                                    <h5 class="title-border"></h5>
                                    <div>
                                        <div class="product-box">
                                            <div class="media">
                                                <div class="img-wrapper"></div>
                                                <div class="media-body align-self-center">
                                                    <div class="product-detail">
                                                        <h4></h4>
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-box">
                                            <div class="media">
                                                <div class="img-wrapper"></div>
                                                <div class="media-body align-self-center">
                                                    <div class="product-detail">
                                                        <h4></h4>
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-box">
                                            <div class="media">
                                                <div class="img-wrapper"></div>
                                                <div class="media-body align-self-center">
                                                    <div class="product-detail">
                                                        <h4></h4>
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- side-bar single product slider end -->
                                <!-- side-bar banner start here -->
                                <div class="collection-sidebar-banner"></div>
                                <!-- side-bar banner end here -->
                            </div>
                            <div class="collection-content col">
                                <div class="page-main-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="top-banner-wrapper">
                                                <div class="img-ldr-top"></div>
                                                <div class="top-banner-content small-section">
                                                    <h4></h4>
                                                    <h5></h5>
                                                    <p></p>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="collection-product-wrapper">
                                                <div class="product-top-filter">
                                                    <div class="row m-0 w-100">
                                                        <div class="col-xl-4">
                                                            <div class="filter-panel">
                                                                <h6 class="ldr-text"></h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-6">
                                                            <div class="filter-panel">
                                                                <h6 class="ldr-text"></h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-4 col-6">
                                                            <div class="filter-panel">
                                                                <h6 class="ldr-text"></h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-4 d-none d-lg-block">
                                                            <div class="filter-panel">
                                                                <h6 class="ldr-text"></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-wrapper-grid">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper"></div>
                                                                <div class="product-detail">
                                                                    <h4></h4>
                                                                    <h5></h5>
                                                                    <h6></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif




    </div>
    <!-- loader end -->
    <!-- header start -->
    <header class="header-style-5 color-style" id="">
        <div class="mobile-fix-option"></div>
        <div class="top-header top-header-theme">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header-contact">
                            <ul>
                                <li>{{ app()->getLocale() == 'ar' ? websiteSettingAr('welcome_text') : websiteSettingEn('welcome_text') }}
                                </li>
                                <li><i class="fa fa-phone"
                                        aria-hidden="true"></i>{{ __('Call Us:' . ' ' . websiteSettingAr('header_phone')) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="header-contact text-end">
                            <ul>
                                <li><i class="fa fa-truck" aria-hidden="true"></i>Track Order</li>
                                <li class="pe-0"><i class="fa fa-gift" aria-hidden="true"></i>Gift Cards</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-menu">
                        <div class="menu-left">
                            <div class="navbar d-block d-xl-none">
                                <a href="javascript:void(0)">
                                    <div class="bar-style" id="toggle-sidebar-res"><i class="fa fa-bars sidebar-bar"
                                            aria-hidden="true"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="brand-logo">
                                <a href="{{ route('ecommerce.home') }}"><img style="width:179px"
                                        src="{{ asset(websiteSettingMedia('header_logo')) }}"
                                        class="img-fluid blur-up lazyload" alt=""></a>
                            </div>
                        </div>
                        <div class="ajax-search" style="position:relative">
                            <form action={{ route('ecommerce.products') }} class="form_search the-basics"
                                role="form">
                                <input data-locale="{{ app()->getLocale() }}"
                                    data-url="{{ route('ecommerce.product.search') }}"
                                    style="{{ app()->getLocale() == 'ar' ? 'direction:rtl;' : '' }}" type="text"
                                    name="search" value="{{ request()->search }}"
                                    placeholder="{{ __('Search any product...') }}"
                                    class="nav-search nav-search-field search-input typeahead" aria-expanded="true">
                                <button type="submit" class="btn-search">
                                    <i class="ti-search"></i>
                                </button>
                            </form>
                            <div style="position: absolute;
                            width:100%;
                            background-color: #ffffff;
                            margin-top: 10px;
                            border-radius: 10px;
                            padding:15px;
                            display:none"
                                class="search-result tt-menu"></div>
                        </div>

                        <div class="menu-right pull-right">
                            <nav class="text-start">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                            </nav>
                            <div class="top-header d-block">
                                <ul class="header-dropdown">
                                    <li class="mobile-wishlist"><a href="{{ route('ecommerce.wishlist') }}"><img
                                                src="{{ asset('e-assets/images/icon/white-icon/heart.png') }}"
                                                alt=""> </a>
                                    </li>
                                    <li class="onhover-dropdown mobile-account">
                                        <a
                                            href="{{ Auth::check() ? route('ecommerce.account') : route('ecommerce.user.show') }}">
                                            <img src="{{ asset('e-assets/images/icon/white-icon/user.png') }}"
                                                alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <div class="icon-nav">
                                    <ul>
                                        <li class="onhover-div d-xl-none d-inline-block mobile-search">
                                            <div><img src="{{ asset('e-assets/images/icon/search.png') }}"
                                                    onclick="openSearch()" class="img-fluid blur-up lazyload"
                                                    alt=""> <i class="ti-search" onclick="openSearch()"></i>
                                            </div>
                                            <div id="search-overlay" class="search-overlay">
                                                <div> <span class="closebtn" onclick="closeSearch()"
                                                        title="Close Overlay">×</span>
                                                    <div class="overlay-content">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div style="position:relative"
                                                                    class="ajax-search col-xl-12">
                                                                    <form action={{ route('ecommerce.products') }}
                                                                        class="">
                                                                        <div class="form-group the-basics">
                                                                            <input
                                                                                data-locale="{{ app()->getLocale() }}"
                                                                                data-url="{{ route('ecommerce.product.search') }}"
                                                                                style="{{ app()->getLocale() == 'ar' ? 'direction:rtl;' : '' }}"
                                                                                type="text" name="search"
                                                                                value="{{ request()->search }}"
                                                                                placeholder="{{ __('Search any product...') }}"
                                                                                class="form-control search-input typeahead">
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-primary"><i
                                                                                class="fa fa-search"></i></button>
                                                                    </form>
                                                                    <div style="position: absolute;
                                                                            width:100%;
                                                                            margin-top: 10px;
                                                                            border-radius: 10px;
                                                                            padding:15px;
                                                                            display:none"
                                                                        class="search-result tt-menu">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="onhover-div mobile-setting">
                                            <div>
                                                <a href="{{ route('setlocale') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ __('Switch Language') }}">
                                                    <img src="{{ asset('e-assets/images/icon/setting.png') }}"
                                                        class="img-fluid blur-up lazyload" alt=""> <i
                                                        class="ti-settings"></i>
                                                </a>
                                            </div>
                                            {{-- <div class="show-div setting">
                                                <h6>language</h6>
                                                <ul>
                                                    <li><a href="#">english</a></li>
                                                    <li><a href="#">french</a></li>
                                                </ul>
                                                <h6>currency</h6>
                                                <ul class="list-inline">
                                                    <li><a href="#">euro</a></li>
                                                    <li><a href="#">rupees</a></li>
                                                    <li><a href="#">pound</a></li>
                                                    <li><a href="#">doller</a></li>
                                                </ul>
                                            </div> --}}
                                        </li>
                                        <li class="onhover-div mobile-cart">
                                            <div><img src="{{ asset('e-assets/images/icon/cart.png') }}"
                                                    class="img-fluid blur-up lazyload" alt=""> <i
                                                    class="ti-shopping-cart"></i></div>
                                            <span class="cart_qty_cls cart-count">{{ getCartItems()->count() }}</span>

                                            <ul class="show-div shopping-cart">


                                                @if (getCartItems()->count() == 0)
                                                    <h4 class="cart-empty">{{ __('Cart is empty!') }}</h4>

                                                    <li class="cart-buttons" style="display: none;">
                                                        <div class="total">
                                                            <h5>{{ __('subtotal') }} :
                                                                <span
                                                                    class="cart-subtotal">{{ getCartSubtotal(getCartItems()) . getCurrency() }}</span>
                                                            </h5>
                                                        </div>
                                                    </li>
                                                    <li class="cart-buttons" style="display: none;">
                                                        <div class="buttons"><a href="{{ route('ecommerce.cart') }}"
                                                                class="view-cart">{{ __('view cart') }}</a> <a
                                                                href="{{ route('ecommerce.checkout') }}"
                                                                class="checkout">{{ __('checkout') }}</a>
                                                        </div>
                                                    </li>
                                                @else
                                                    @foreach (getCartItems() as $item)
                                                        <li>
                                                            <div class="media">
                                                                <a
                                                                    href="{{ route('ecommerce.product', ['product' => $item->product->id]) }}"><img
                                                                        alt="" class="me-3"
                                                                        src="{{ asset($item->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $item->product->images[0]->media->path) }}"></a>
                                                                <div class="media-body">
                                                                    <a
                                                                        href="{{ route('ecommerce.product', ['product' => $item->product->id]) }}">
                                                                        <h4>{{ app()->getLocale() == 'ar' ? $item->product->name_ar : $item->product->name_en }}
                                                                        </h4>
                                                                    </a>
                                                                    @if ($item->product->product_type == 'variable')
                                                                        <h4><span>{{ __('price') . ': ' . productPrice($item->product, $item->product_combination_id) }}</span>
                                                                        </h4>
                                                                    @else
                                                                        <h4><span>{{ __('price') . ': ' . productPrice($item->product) }}</span>
                                                                        </h4>
                                                                    @endif

                                                                    <h4><span>{{ __('quantity ') . ': ' . $item->qty }}</span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="close-circle"><a
                                                                    href="{{ route('ecommerce.cart.destroy', ['product' => $item->product->id, 'combination' => $item->product_combination_id]) }}"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></a>
                                                            </div>
                                                        </li>
                                                    @endforeach


                                                    <li>
                                                        <div class="total">
                                                            <h5>{{ __('subtotal') }} :
                                                                <span
                                                                    class="cart-subtotal">{{ getCartSubtotal(getCartItems()) . getCurrency() }}</span>
                                                            </h5>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="buttons"><a href="{{ route('ecommerce.cart') }}"
                                                                class="view-cart">{{ __('view cart') }}</a> <a
                                                                href="{{ route('ecommerce.checkout') }}"
                                                                class="checkout">{{ __('checkout') }}</a>
                                                        </div>
                                                    </li>
                                                @endif

                                            </ul>


                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-part">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="category-menu d-none d-xl-block h-100">
                            <div id="toggle-sidebar" class="toggle-sidebar">
                                <i class="fa fa-bars sidebar-bar"></i>
                                <h5 class="mb-0">{{ __('shop by category') }}</h5>
                            </div>
                        </div>
                        <div class="sidenav fixed-sidebar marketplace-sidebar">
                            <nav>
                                <div>
                                    <div class="sidebar-back text-start d-xl-none d-block"><i
                                            class="fa fa-angle-left pe-2" aria-hidden="true"></i> Back</div>
                                </div>
                                <ul id="sub-menu" class="sm pixelstrap sm-vertical">

                                    @foreach (getCategories() as $category)
                                        <li> <a
                                                href="{{ route('ecommerce.products', ['category' => $category->id]) }}">{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</a>
                                            @if ($category->children->count() > 0)
                                                <ul>
                                                    @foreach ($category->children->sortBy('sort_order') as $subCat)
                                                        @include('layouts.ecommerce._category_options', [
                                                            'category' => $subCat,
                                                        ])
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-9 position-unset">
                        <div class="main-nav-center">
                            <nav class="text-start">
                                <!-- Sample menu definition -->
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <li>
                                        <div class="mobile-back text-end">{{ __('Back') }}<i
                                                class="fa fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ps-2 p-1"
                                                aria-hidden="true"></i></div>
                                    </li>
                                    <li><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>

                                    <li>
                                        <a href="{{ route('ecommerce.products') }}">{{ __('products') }}</a>

                                    </li>
                                    <li>
                                        <a href="#">{{ __('brands') }}</a>
                                        <ul>
                                            @foreach (getBrands() as $brand)
                                                <li><a
                                                        href="{{ route('ecommerce.products', ['brand[]' => $brand->id]) }}">{{ getName($brand) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li><a href="{{ route('ecommerce.about') }}">{{ __('about us') }}</a>

                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xxl-3 d-none d-xxl-inline-block">
                        <div class="header-options">
                            <div class="vertical-slider no-arrow">
                                @if (app()->getLocale() == 'ar')
                                    @foreach (websiteSettingMultiple('flash_news') as $item)
                                        <div>
                                            <span>{{ $item->value_ar }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach (websiteSettingMultiple('flash_news') as $item)
                                        <div>
                                            <span>{{ $item->value_en }}</span>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->
@endif
