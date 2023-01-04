@extends('layouts.store.app')

@section('content')
    <!-- vendor cover start -->
    <div class="vendor-cover">
        <div>
            <img src="{{ $user->store_cover == null ? asset('assets/img/store_cover.jpg') : asset('storage/images/users/' . $user->store_cover) }}"
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
                                        src="{{ $user->store_profile == null ? asset('storage/images/users/' . $user->profile) : asset('storage/images/users/' . $user->store_profile) }}"
                                        alt="" class="img-fluid">
                                </div>

                                <h3>{{ $user->store_name == null ? $user->name : $user->store_name }}</h3>
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
                                <p>{{ $user->store_description }}</p>
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

    <!-- collection section start -->
    <section class="section-b-space">
        <div class="container">
            <div class="row">
                {{-- <div class="col-sm-3 collection-filter">
                    <!-- side-bar colleps block stat -->
                    <div class="collection-filter-block">
                        <!-- brand filter start -->
                        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left"
                                    aria-hidden="true"></i> back</span></div>
                        <div class="collection-collapse-block open">
                            <h3 class="collapse-block-title">vendor category</h3>
                            <div class="collection-collapse-block-content">
                                <div class="collection-brand-filter">
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="zara">
                                        <label class="form-check-label" for="zara">bags</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="vera-moda">
                                        <label class="form-check-label" for="vera-moda">clothes</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="forever-21">
                                        <label class="form-check-label" for="forever-21">shoes</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="roadster">
                                        <label class="form-check-label" for="roadster">accessories</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="only">
                                        <label class="form-check-label" for="only">beauty products</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- color filter start here -->
                        <div class="collection-collapse-block open">
                            <h3 class="collapse-block-title">colors</h3>
                            <div class="collection-collapse-block-content">
                                <div class="color-selector">
                                    <ul>
                                        <li class="color-1 active"></li>
                                        <li class="color-2"></li>
                                        <li class="color-3"></li>
                                        <li class="color-4"></li>
                                        <li class="color-5"></li>
                                        <li class="color-6"></li>
                                        <li class="color-7"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- price filter start here -->
                        <div class="collection-collapse-block border-0 open">
                            <h3 class="collapse-block-title">price</h3>
                            <div class="collection-collapse-block-content">
                                <div class="collection-brand-filter">
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="hundred">
                                        <label class="form-check-label" for="hundred">$10 - $100</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="twohundred">
                                        <label class="form-check-label" for="twohundred">$100 - $200</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="threehundred">
                                        <label class="form-check-label" for="threehundred">$200 - $300</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="fourhundred">
                                        <label class="form-check-label" for="fourhundred">$300 - $400</label>
                                    </div>
                                    <div class="form-check collection-filter-checkbox">
                                        <input type="checkbox" class="form-check-input" id="fourhundredabove">
                                        <label class="form-check-label" for="fourhundredabove">$400 above</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collection-sidebar-banner">
                        <a href="#"><img src="../assets_store/images/side-banner.png" class="img-fluid blur-up lazyload"
                                alt=""></a>
                    </div>
                    <!-- silde-bar colleps block end here -->
                </div> --}}
                <div class="col">
                    <div class="collection-wrapper">
                        <div class="collection-content ratio_asos">
                            <div class="page-main-content">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="filter-main-btn"><span class="filter-btn btn btn-theme"><i
                                                    class="fa fa-filter" aria-hidden="true"></i> Filter</span></div>
                                    </div>
                                </div>
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
                                                            <li><img src="{{ asset('assets_store/images/icon/2.png') }}"
                                                                    alt="" class="product-2-layout-view"></li>
                                                            <li><img src="{{ asset('assets_store/images/icon/3.png') }}"
                                                                    alt="" class="product-3-layout-view"></li>
                                                            <li><img src="{{ asset('assets_store/images/icon/4.png') }}"
                                                                    alt="" class="product-4-layout-view"></li>
                                                            <li><img src="{{ asset('assets_store/images/icon/6.png') }}"
                                                                    alt="" class="product-6-layout-view"></li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-page-per-view">
                                                        <form action="">
                                                            <select name="pagination" onchange="this.form.submit()">
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
                                                        </form>

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
                                        <div class="row">
                                            @foreach ($products as $product)
                                                @if ($product->product->images->count() != 0)
                                                    @php
                                                        $url = $product->product->images[0]->image;
                                                    @endphp
                                                @else
                                                    @php
                                                        $url = 'place-holder.png';
                                                    @endphp
                                                @endif

                                                <div class="col-xl-3 col-6 col-grid-box">
                                                    <div class="product-box">
                                                        <div class="img-wrapper">
                                                            <div class="front">
                                                                <a
                                                                    href="{{ route('store.product', ['user' => $user->id, 'product' => $product]) }}"><img
                                                                        src="{{ asset('storage/images/products/' . $url) }}"
                                                                        class="img-fluid blur-up lazyload bg-img"
                                                                        alt=""></a>
                                                            </div>
                                                            {{-- <div class="cart-info cart-wrap">
                                                                <button data-bs-toggle="modal" data-bs-target="#addtocart"
                                                                    title="Add to cart"><i
                                                                        class="ti-shopping-cart"></i></button> <a
                                                                    href="javascript:void(0)" title="Add to Wishlist"><i
                                                                        class="ti-heart" aria-hidden="true"></i></a>
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#quick-view" title="Quick View"><i
                                                                        class="ti-search" aria-hidden="true"></i></a>
                                                                <a href="compare.html" title="Compare"><i
                                                                        class="ti-reload" aria-hidden="true"></i></a>
                                                            </div> --}}
                                                        </div>
                                                        <div class="product-detail">
                                                            <div>
                                                                {{-- <div class="rating"><i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i> <i
                                                                        class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i> <i
                                                                        class="fa fa-star"></i>
                                                                </div> --}}
                                                                <a
                                                                    href="{{ route('store.product', ['lang' => app()->getLocale(), 'user' => $user->id, 'product' => $product]) }}">
                                                                    <h6>{{ app()->getLocale() == 'ar' ? substr($product->product->name_ar, 0, 100) . '...' : substr($product->product->name_en, 0, 100) . '...' }}
                                                                    </h6>
                                                                </a>
                                                                <p>
                                                                    @if (app()->getLocale() == 'ar')
                                                                        {!! $product->product->description_ar !!}
                                                                    @else
                                                                        {!! $product->product->description_en !!}
                                                                    @endif
                                                                </p>
                                                                <h4>{{ $product->price . ' ' . $product->user->country->currency }}
                                                                </h4>
                                                                <ul class="color-variant">

                                                                    @foreach ($product->product->stocks as $stock)
                                                                        @php
                                                                            $stocks = $product->product->stocks->unique('color_id');
                                                                        @endphp
                                                                    @endforeach

                                                                    @foreach ($stocks as $stock)
                                                                        <li style="background-color:{{ $stock->color->hex }} !important; {{ $stock->color->hex == '#ffffff' ? 'border: 1px solid #999999' : '' }}"
                                                                            class="bg-light0"></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                            {{-- <li class="page-item"><a class="page-link" href="#"
                                                                    aria-label="Previous"><span aria-hidden="true"><i
                                                                            class="fa fa-chevron-left"
                                                                            aria-hidden="true"></i></span> <span
                                                                        class="sr-only">Previous</span></a></li>
                                                            <li class="page-item active"><a class="page-link"
                                                                    href="#">1</a>
                                                            </li>
                                                            <li class="page-item"><a class="page-link"
                                                                    href="#">2</a>
                                                            </li>
                                                            <li class="page-item"><a class="page-link"
                                                                    href="#">3</a>
                                                            </li>
                                                            <li class="page-item"><a class="page-link" href="#"
                                                                    aria-label="Next"><span aria-hidden="true"><i
                                                                            class="fa fa-chevron-right"
                                                                            aria-hidden="true"></i></span> <span
                                                                        class="sr-only">Next</span></a></li> --}}
                                                        </ul>
                                                    </nav>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="product-search-count-bottom">
                                                        <h5>Showing Products 1-24 of 10 Result</h5>
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
    <!-- collection section end -->
@endsection
