@extends('layouts.ecommerce.app')
@section('content')
    <!-- breadcrumb start -->
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
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->





    <!-- section start -->
    <section>
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-slick">

                            @foreach ($product->images as $index => $image)
                                <div><img style="width:100%" src="{{ asset($image->media->path) }}"
                                        alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                        class="img-fluid blur-up lazyload image_zoom_cls-{{ $index }}"></div>
                            @endforeach


                        </div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">
                                    @foreach ($product->images as $index => $image)
                                        <div><img src="{{ asset($image->media->path) }}"
                                                alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                                class="img-fluid blur-up lazyload"></div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            {{-- <div class="product-count">
                                <ul>
                                    <li>
                                        <img src="../assets/images/fire.gif" class="img-fluid" alt="image">
                                        <span class="p-counter">37</span>
                                        <span class="lang">orders in last 24 hours</span>
                                    </li>
                                    <li>
                                        <img src="../assets/images/person.gif" class="img-fluid user_img" alt="image">
                                        <span class="p-counter">44</span>
                                        <span class="lang">active view this</span>
                                    </li>
                                </ul>
                            </div> --}}
                            <h2>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h2>
                            <div class="rating-section">
                                <div class="">{!! getAverageRatingWithStars($product) !!}
                                </div>
                                <h6>{{ __('ratings') . ' ' . $product->reviews->count() }}</h6>
                            </div>
                            <div class="label-section">
                                <span class="badge badge-grey-color">#1 Best seller</span>
                                <span
                                    class="label-text">{{ app()->getLocale() == 'ar' ? $product->categories()->first()->name_ar : $product->categories()->first()->name_en }}</span>
                            </div>
                            <div style="font-size: 15px;" class="ecommerce-product-price-{{ $product->id }} pb-2">
                                {!! getProductPrice($product) !!}
                            </div>
                            {{-- <h3 class="price-detail">$32.96 <del>$459.00</del><span>55% off</span></h3> --}}




                            <div id="selectSize" class="addeffect-section product-description border-product mt-2">
                                {{-- <h6 class="product-title size-text">select size <span><a href=""
                                            data-bs-toggle="modal" data-bs-target="#sizemodal">size
                                            chart</a></span></h6> --}}
                                {{-- <div class="modal fade" id="sizemodal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sheer
                                                    Straight Kurta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body"><img src="../assets/images/size-chart.jpg"
                                                    alt="" class="img-fluid blur-up lazyload"></div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="product-description product-attributes-{{ $product->id }}">
                                    @if ($product->product_type == 'variable')
                                        @foreach ($product->attributes as $attribute)
                                            @if ($attribute->name_en == 'color' ||
                                                $attribute->name_en == 'colors' ||
                                                $attribute->name_en == 'Color' ||
                                                $attribute->name_en == 'Colors')
                                                <div class="row">
                                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                        <h4>{{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <ul class="color-variant">
                                                            @foreach ($product->variations->where('attribute_id', $attribute->id) as $index => $variation)
                                                                <li style="background-color:{{ $variation->variation->value }} !important; {{ $variation->variation->value == '#ffffff' ? 'border: 1px solid #999999' : '' }}"
                                                                    class="bg-light0 color-select attribute-select"
                                                                    data-variation-id="{{ $variation->variation->id }}"
                                                                    data-product-id="{{ $product->id }}"
                                                                    data-url="{{ route('ecommerce.product.price') }}"
                                                                    data-locale="{{ app()->getLocale() }}"
                                                                    data-currency="{{ $product->country->currency }}">
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                        <h4>{{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                                        </h4>

                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="size-box attribute-box-{{ $attribute->id }}">
                                                            <ul>
                                                                @foreach ($product->variations->where('attribute_id', $attribute->id) as $index => $variation)
                                                                    <li class="attribute-select"
                                                                        data-attribute-id="{{ $attribute->id }}"
                                                                        data-variation-id="{{ $variation->variation->id }}"
                                                                        data-product-id="{{ $product->id }}"
                                                                        data-url="{{ route('ecommerce.product.price') }}"
                                                                        data-locale="{{ app()->getLocale() }}"
                                                                        data-currency="{{ $product->country->currency }}">
                                                                        <a
                                                                            href="javascript:void(0)">{{ app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <h6 class="product-title text-center">{{ __('Price') }}</h6>

                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div style="font-size: 15px" class="ecommerce-product-price-{{ $product->id }}">
                                            {!! getProductPrice($product) !!}
                                        </div>

                                    </div>
                                </div>


                                <div class="row pt-4">
                                    <div class="col-md-12 border-product p-3">
                                        <p>
                                            @if (app()->getLocale() == 'ar')
                                                {!! $product->description_ar !!}
                                            @else
                                                {!! $product->description_en !!}
                                            @endif
                                        </p>
                                    </div>
                                </div>



                                <h6 class="product-title">{{ __('quantity') }}</h6>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-left-minus" data-type="minus"
                                                data-field=""><i
                                                    class="ti-angle-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity" class="form-control qty-input input-number"
                                            value="1" data-min="{{ $product->product_min_order }}"
                                            data-max="{{ $product->product_max_order }}" disabled>
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus"
                                                data-field=""><i
                                                    class="ti-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="product-buttons"><a href="javascript:void(0)" id="cartEffect"
                                    class="btn btn-solid hover-solid btn-animation add-to-cart"
                                    data-url="{{ route('ecommerce.cart.store') }}" data-locale="{{ app()->getLocale() }}"
                                    data-product_id="{{ $product->id }}"
                                    data-image="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}">

                                    <div style="display: none; color: #ffffff; margin: 3px; padding: 6px;"
                                        class="spinner-border spinner-border-sm spinner spin-{{ $product->id }}"
                                        role="status">
                                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                                    </div>



                                    <i class="fa fa-shopping-cart cart-icon-{{ $product->id }} me-1"
                                        aria-hidden="true"></i>

                                    <span class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
                                    <span class="cart-added-{{ $product->id }}"
                                        style="display: none;">{{ __('Added to bag') }}</span>


                                </a>

                                <a style="display: none" href="{{ route('ecommerce.checkout') }}"
                                    class="btn btn-solid pay-now"><i class="fa fa-money fz-16 me-2"
                                        aria-hidden="true"></i>{{ __('pay now') }}</a>


                                <a href="#"
                                    data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                    data-product_id="{{ $product->id }}" class="btn btn-solid add-fav"><i
                                        style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                        class="fa fa-heart fav-{{ $product->id }} fz-16 me-2"
                                        aria-hidden="true"></i>{{ __('wishlist') }}</a>

                                </a>
                            </div>


                            <div class="col-6 mt-4">
                                <div style="display:none !important"
                                    class="alert alert-danger border-2 align-items-center alarm" role="alert">
                                    <div class="bg-danger me-3 icon-item"><span
                                            class="fas fa-times-circle text-white fs-3"></span>
                                    </div>
                                    <p class="mb-0 flex-1 alarm-text"></p>
                                </div>
                            </div>

                            @if ($product->shipping_method_id == '3')
                                <div class="product-count">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('e-assets/images/icon/truck.png') }}" class="img-fluid"
                                                alt="image">
                                            <span class="lang">{{ __('Order now with free shipping') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            @endif


                            {{-- <div class="border-product">
                                <h6 class="product-title">Sales Ends In</h6>
                                <div class="timer">
                                    <p id="demo"></p>
                                </div>
                            </div>
                            <div class="border-product">
                                <h6 class="product-title">shipping info</h6>
                                <ul class="shipping-info">
                                    <li>100% Original Products</li>
                                    <li>Free Delivery on order above Rs. 799</li>
                                    <li>Pay on delivery is available</li>
                                    <li>Easy 30 days returns and exchanges</li>
                                </ul>
                            </div>
                            <div class="border-product">
                                <h6 class="product-title">share it</h6>
                                <div class="product-icon">
                                    <ul class="product-social">
                                        <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                    </ul>
                                </div>
                            </div> --}}
                            <div class="border-product">
                                <h6 class="product-title">{{ __('100% secure payment') }}</h6>
                                <img src="{{ asset('e-assets/images/payment.png') }}" class="img-fluid mt-1"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->


    <!-- product-tab starts -->
    <section class="tab-product m-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab"
                                href="#top-home" role="tab" aria-selected="true"><i
                                    class="icofont icofont-ui-home"></i>{{ __('Details') }}</a>
                            <div class="material-border"></div>
                        </li>
                        @if ($product->video_url)
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
                                    href="#top-contact" role="tab" aria-selected="false"><i
                                        class="icofont icofont-contacts"></i>{{ __('Video') }}</a>
                                <div class="material-border"></div>
                            </li>
                        @endif
                        <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab"
                                href="#top-review" role="tab" aria-selected="false"><i
                                    class="icofont icofont-contacts"></i>{{ __('Write Review') }}</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>
                    <div class="tab-content nav-material" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                            aria-labelledby="top-home-tab">
                            <div class="product-tab-discription">
                                <div class="part">
                                    <p>{!! app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en !!}</p>
                                </div>

                            </div>
                        </div>

                        @if ($product->video_url)
                            <div class="tab-pane fade" id="top-contact" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <div class="">
                                    <iframe width="560" height="315" src="{{ $product->video_url }}"
                                        allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endif


                        <div class="tab-pane fade" id="top-review" role="tabpanel" aria-labelledby="review-top-tab">
                            <form method="POST"
                                action="{{ route('ecommerce.product.review', ['product' => $product->id]) }}">
                                @csrf
                                <div class="form-row row">
                                    <div class="col-md-12">
                                        <div class="media">
                                            <label>{{ __('Product Review') }}</label>
                                            <div class="media-body ms-3">
                                                {{-- <div class="rating three-star"><i class="fa fa-star"></i> <i
                                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                                        class="fa fa-star"></i> <i class="fa fa-star"></i></div> --}}

                                                @foreach ($product->reviews as $review)
                                                    <div class="mb-1">

                                                        {!! getRatingWithStars($review->rating) !!}

                                                        <span
                                                            class="ms-3 text-dark fw-semi-bold">{{ isset($review->user->name) ? $review->user->name : 'user' }}</span>
                                                    </div>
                                                    <p class="fs--1 mb-2 text-600">{{ interval($review->created_at) }}</p>
                                                    <p class="mb-0">{{ $review->review }}</p>
                                                    <hr class="my-4" />
                                                @endforeach
                                                @if ($product->reviews->count() == 0)
                                                    <p>{{ __('There are no reviews for the product') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name">{{ __('phone') }}</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            required>
                                        @error('review')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">{{ __('Rating') }}</label>
                                        <div style="direction: ltr !important" class="d-block" id="rate"
                                            data-rater='{"starSize":32,"step":0.5}'></div>
                                    </div>

                                    <div style="display: none" class="mb-3">
                                        <label class="form-label" for="rating">{{ __('Rating') }}</label>
                                        <input name="rating" class="form-control @error('rating') is-invalid @enderror"
                                            value="{{ old('rating') }}" type="text" autocomplete="on" id="rating"
                                            required />
                                        @error('rating')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label for="review">{{ __('Write Review') }}</label>
                                        <textarea class="form-control @error('review') is-invalid @enderror" id="review" rows="5" name="review"
                                            required></textarea>
                                        @error('review')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-solid review-btn"
                                            type="submit">{{ __('Submit your review') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-tab ends -->


    <!-- product section start -->
    <section class="section-b-space ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>{{ __('related products') }}</h2>
                </div>
            </div>
            <div class="row search-product">
                @foreach ($products as $product)
                    <div class="col-xl-2 col-md-4 col-6">

                        <div class="product-box">
                            <div class="img-wrapper">
                                <div class="front">
                                    <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                            src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                            class="img-fluid blur-up lazyload bg-img"
                                            alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                </div>
                                <div class="back">
                                    <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                            src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                            class="img-fluid blur-up lazyload bg-img"
                                            alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="javascript:void(0)" class="add-fav" title="Add to Wishlist"
                                        data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                        data-product_id="{{ $product->id }}"><i
                                            style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                            class="fa fa-heart fav-{{ $product->id }} " aria-hidden="true"></i></a>

                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view-{{ $product->id }}" title="Quick View"><i
                                            class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                        title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>

                                </div>
                            </div>
                            <div class="product-detail">
                                <div>
                                    <div class="">
                                        {!! getAverageRatingWithStars($product) !!}

                                    </div>
                                    <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
                                        <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                        </h6>
                                    </a>
                                    <p>
                                        @if (app()->getLocale() == 'ar')
                                            {!! $product->description_ar !!}
                                        @else
                                            {!! $product->description_en !!}
                                        @endif
                                    </p>
                                    <h4>{!! getProductPrice($product) !!}</h4>

                                    @if ($product->product_type != 'variable')
                                        <div class="add-btn mt-2">
                                            <a href="javascript:void(0)" class="add-to-cart"
                                                data-url="{{ route('ecommerce.cart.store') }}"
                                                data-locale="{{ app()->getLocale() }}"
                                                data-product_id="{{ $product->id }}"
                                                data-image="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}">
                                                <div style="display: none; color: #999999; margin: 3px; padding: 6px;"
                                                    class="spinner-border spinner-border-sm spinner spin-{{ $product->id }} "
                                                    role="status">
                                                </div>
                                                <i class="fa fa-shopping-cart cart-icon-{{ $product->id }}  me-1"
                                                    aria-hidden="true"></i>
                                                <span
                                                    class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
                                                <span class="cart-added-{{ $product->id }}"
                                                    style="display: none;">{{ __('Added to bag') }}</span>
                                            </a>
                                        </div>
                                    @endif

                                    {{-- <ul class="color-variant">
                                                <li class="bg-light0"></li>
                                                <li class="bg-light1"></li>
                                                <li class="bg-light2"></li>
                                            </ul> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- product section end -->


    <!-- added to cart notification -->
    <div class="added-notification">
        <img src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
            class="img-fluid" alt="">
        <h3>{{ __('added to cart') }}</h3>
    </div>
    <!-- added to cart notification -->



    <!-- Quick-view modal popup start-->

    @foreach ($products as $product)
        <div class="modal fade bd-example-modal-lg theme-modal" id="quick-view-{{ $product->id }}" tabindex="-1"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content quick-view-modal">
                    <div style="background: #ffffff" class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <div class="quick-view-img"><img
                                        src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                        alt="" class="img-fluid blur-up lazyload"></div>
                            </div>
                            <div class="col-lg-6 rtl-text">
                                <div class="product-right">
                                    <h2>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h2>
                                    <div class="ecommerce-product-price-{{ $product->id }}">
                                        {!! getProductPrice($product) !!}
                                    </div>
                                    <div class="border-product">
                                        <h6 class="product-title">{{ __('product details') }}</h6>
                                        <p>{!! app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en !!}</p>
                                    </div>
                                    <div
                                        class="product-description border-product product-attributes-{{ $product->id }}">
                                        @if ($product->product_type == 'variable')
                                            @foreach ($product->attributes as $attribute)
                                                @if ($attribute->name_en == 'color' ||
                                                    $attribute->name_en == 'colors' ||
                                                    $attribute->name_en == 'Color' ||
                                                    $attribute->name_en == 'Colors')
                                                    <div class="row">
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <h4>{{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <ul class="color-variant">
                                                                @foreach ($product->variations->where('attribute_id', $attribute->id) as $index => $variation)
                                                                    <li style="background-color:{{ $variation->variation->value }} !important; {{ $variation->variation->value == '#ffffff' ? 'border: 1px solid #999999' : '' }}"
                                                                        class="bg-light0 color-select attribute-select"
                                                                        data-variation-id="{{ $variation->variation->id }}"
                                                                        data-product-id="{{ $product->id }}"
                                                                        data-url="{{ route('ecommerce.product.price') }}"
                                                                        data-locale="{{ app()->getLocale() }}"
                                                                        data-currency="{{ $product->country->currency }}">
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <h4>{{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                                            </h4>

                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="size-box attribute-box-{{ $attribute->id }}">
                                                                <ul>
                                                                    @foreach ($product->variations->where('attribute_id', $attribute->id) as $index => $variation)
                                                                        <li class="attribute-select"
                                                                            data-attribute-id="{{ $attribute->id }}"
                                                                            data-variation-id="{{ $variation->variation->id }}"
                                                                            data-product-id="{{ $product->id }}"
                                                                            data-url="{{ route('ecommerce.product.price') }}"
                                                                            data-locale="{{ app()->getLocale() }}"
                                                                            data-currency="{{ $product->country->currency }}">
                                                                            <a
                                                                                href="javascript:void(0)">{{ app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        <h6 class="product-title">{{ __('quantity') }}</h6>
                                        <div class="qty-box">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-left-minus"
                                                        data-type="minus" data-field=""><i
                                                            class="ti-angle-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity"
                                                    class="form-control qty-input input-number" value="1"
                                                    data-min="{{ $product->product_min_order }}"
                                                    data-max="{{ $product->product_max_order }}" disabled>
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-right-plus"
                                                        data-type="plus" data-field=""><i
                                                            class="ti-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>

                                        <a href="javascript:void(0)" id="cartEffect"
                                            class="btn btn-solid btn-sm hover-solid btn-animation add-to-cart"
                                            data-url="{{ route('ecommerce.cart.store') }}"
                                            data-locale="{{ app()->getLocale() }}"
                                            data-product_id="{{ $product->id }}"
                                            data-image="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}">

                                            <div style="display: none; color: #ffffff; margin: 3px; padding: 6px;"
                                                class="spinner-border spinner-border-sm spinner spin-{{ $product->id }}"
                                                role="status">
                                                <span class="visually-hidden">{{ __('Loading...') }}</span>
                                            </div>



                                            <i class="fa fa-shopping-cart cart-icon-{{ $product->id }} me-1"
                                                aria-hidden="true"></i>

                                            <span class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
                                            <span class="cart-added-{{ $product->id }}"
                                                style="display: none;">{{ __('Added to bag') }}</span>


                                        </a>

                                        <a href="#"
                                            data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                            data-product_id="{{ $product->id }}"
                                            class="btn btn-solid btn-sm add-fav"><i
                                                style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                                class="fa fa-heart fav-{{ $product->id }} fz-16 me-2"
                                                aria-hidden="true"></i>{{ __('wishlist') }}</a>


                                        <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"
                                            class="btn btn-solid btn-sm">{{ __('view detail') }}</a>


                                    </div>

                                    <div class="col-6 mt-4">
                                        <div style="display:none !important"
                                            class="alert alert-danger border-2 align-items-center alarm" role="alert">
                                            <div class="bg-danger me-3 icon-item"><span
                                                    class="fas fa-times-circle text-white fs-3"></span>
                                            </div>
                                            <p class="mb-0 flex-1 alarm-text"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Quick-view modal popup end-->


@endsection
