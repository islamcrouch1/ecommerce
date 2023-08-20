@extends('layouts.ecommerce.app')

@section('content')
    <!-- vendor cover start -->
    <div class="vendor-cover">
        <div>
            <img src="{{ getUserInfo($user) != null && getUserInfo($user)->store_cover != null ? getMediaPath(getUserInfo($user)->store_cover) : asset('assets/img/store_cover.jpg') }}"
                alt="" class="bg-img lazyload blur-up">
        </div>
    </div>
    <!-- vendor cover end -->


    <!-- section start -->
    <section class="vendor-profile pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-left">
                        <div class="profile-image">
                            <div>
                                <div class="rounded-circle overflow-hidden">
                                    <img style="width:107px"
                                        src="{{ getUserInfo($user) != null && getUserInfo($user)->store_profile != null ? getMediaPath(getUserInfo($user)->store_profile) : asset('storage/images/users/' . $user->profile) }}"
                                        alt="" class="img-fluid">
                                </div>

                                <h3>{{ getUserInfo($user) != null ? getUserInfo($user)->store_name : '' }}
                                </h3>
                                {{-- <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <h6>750 followers | 10 review</h6> --}}
                            </div>
                        </div>
                        <div style="justify-content: center" class="profile-detail">
                            <div>
                                <p>{{ getUserInfo($user) != null ? getUserInfo($user)->store_description : '' }}
                                </p>
                            </div>
                        </div>
                        {{-- <div class="vendor-contact">
                            <div>
                                <h6>follow us:</h6>
                                <div class="footer-social">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                                <h6>if you have any query:</h6>
                                <a href="#" class="btn btn-solid btn-sm">contact seller</a>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Section ends -->

    <!-- section start -->
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <form class="product-form" action="">
                    <div class="row">
                        <div class="collection-content col-sm-12">
                            <div class="page-main-content">
                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="collection-product-wrapper">
                                            <div class="product-top-filter">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="product-filter-content">
                                                            <div class="search-count">
                                                                <h5>{{ __('Number of products shown:') . ' ' . $products->count() }}
                                                                </h5>
                                                            </div>
                                                            <div class="collection-view">
                                                                <ul>
                                                                    <li><i class="fa fa-th grid-layout-view"></i></li>
                                                                    <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                                </ul>
                                                            </div>
                                                            <div class="collection-grid-view">
                                                                <ul>
                                                                    <li><img src="{{ asset('e-assets/images/icon/2.png') }}"
                                                                            alt="" class="product-2-layout-view">
                                                                    </li>
                                                                    <li><img src="{{ asset('e-assets/images/icon/3.png') }}"
                                                                            alt="" class="product-3-layout-view">
                                                                    </li>
                                                                    <li><img src="{{ asset('e-assets/images/icon/4.png') }}"
                                                                            alt="" class="product-4-layout-view">
                                                                    </li>
                                                                    <li><img src="{{ asset('e-assets/images/icon/6.png') }}"
                                                                            alt="" class="product-6-layout-view">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="product-page-per-view">
                                                                <select name="pagination" class="filter">
                                                                    <option
                                                                        {{ request()->pagination == '24' ? 'selected' : '' }}
                                                                        value="24">{{ __('24 Products Par Page') }}
                                                                    </option>
                                                                    <option
                                                                        {{ request()->pagination == '50' ? 'selected' : '' }}
                                                                        value="50">{{ __('50 Products Par Page') }}
                                                                    </option>
                                                                    <option
                                                                        {{ request()->pagination == '100' ? 'selected' : '' }}
                                                                        value="100">{{ __('100 Products Par Page') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            {{-- <div class="product-page-filter">
                                                            <select>
                                                                <option value="High to low">Sorting items</option>
                                                                <option value="Low to High">50 Products</option>
                                                                <option value="Low to High">100 Products</option>
                                                            </select>
                                                        </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-wrapper-grid">
                                                <div class="row margin-res">

                                                    @foreach ($products as $product)
                                                        <div class="col-xl-3 col-6 col-grid-box">
                                                            @include('ecommerce._product_div', [
                                                                'product' => $product,
                                                            ])
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <div class="product-pagination mb-0">
                                                <div class="theme-paggination-block">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                                            <nav aria-label="Page navigation">
                                                                <ul class="pagination">
                                                                    {{ $products->appends(request()->query())->links() }}

                                                                </ul>
                                                            </nav>
                                                        </div>
                                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                                            <div class="product-search-count-bottom">
                                                                <h5>{{ __('Number of products shown:') . ' ' . $products->count() }}
                                                                </h5>
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
                </form>
            </div>
        </div>
    </section>
    <!-- section End -->




    <!-- Quick-view modal popup start-->

    @foreach ($products as $product)
        @include('ecommerce._product_modal', [
            'product' => $product,
        ])
    @endforeach

    <!-- Quick-view modal popup end-->



    <!-- added to cart notification -->
    <div class="added-notification cart-noty">
        <h3>{{ __('added to cart') }}</h3>
    </div>
    <!-- added to cart notification -->




    <!-- added to cart notification -->
    <div class="added-notification fav-noty">
        <h3>{{ __('added to wishlist') }}</h3>
    </div>
    <!-- added to cart notification -->
@endsection
