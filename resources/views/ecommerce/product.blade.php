@php
    $title = getName($product);
    $productSeo = $product;
@endphp
@extends('layouts.ecommerce.app', ['page_title' => $title, 'product' => $productSeo])


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



    @if (session()->has('success'))
        <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
            <div class="bg-success me-3 icon-item"></div>
            <p style="width:90%;word-wrap: break-word" class="mb-0 flex-1">{{ session()->get('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @php
            session()->forget('success');
        @endphp
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
            <div class="bg-danger me-3 icon-item"><i class="fa fa-exclamation-circle text-white fs-3"></i></div>
            <p class="mb-0 flex-1">{{ session()->get('error') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @php
            session()->forget('error');
        @endphp
    @endif




    <!-- section start -->
    <section>
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-slick">

                            @if ($product->media != null)
                                <div><img style="width:100%" src="{{ asset($product->media->path) }}"
                                        alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                        class="img-fluid blur-up lazyload image_zoom_cls-0"></div>
                            @endif
                            @foreach ($product->images as $index => $image)
                                <div><img style="width:100%" src="{{ asset($image->media->path) }}"
                                        alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                        class="img-fluid blur-up lazyload image_zoom_cls-{{ $index + 1 }}"></div>
                            @endforeach


                        </div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">
                                    @if ($product->media != null)
                                        <div><img src="{{ asset($product->media->path) }}"
                                                alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                                class="img-fluid blur-up lazyload"></div>
                                    @endif
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




                                @if (
                                    $product->vendor_id != null &&
                                        getUserInfo($product->vendor) != null &&
                                        getUserInfo($product->vendor)->store_name != null &&
                                        checkUserInfo($product->vendor))
                                    <a
                                        href="{{ route('store.show', ['user' => $product->vendor->id, 'store_name' => getUserInfo($product->vendor)->store_name]) }}">
                                        <span
                                            class="badge badge-grey-color">{{ getUserInfo($product->vendor)->store_name }}</span>
                                    </a>
                                @endif
                                <span
                                    class="label-text">{{ app()->getLocale() == 'ar' ? $product->category->name_ar : $product->category->name_en }}</span>
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
                                            @if (
                                                $attribute->name_en == 'color' ||
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
                                                                    data-currency="{{ $product->country->currency }}"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="{{ getName($variation->variation) }}">
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
                                                            @if ($attribute->type == 'select')
                                                                <select>

                                                                    <option value="">
                                                                        {{ __('Select') . ' ' . getName($attribute) }}
                                                                    </option>
                                                                    @foreach ($product->variations->where('attribute_id', $attribute->id) as $index => $variation)
                                                                        <option class="attribute-select"
                                                                            data-attribute-id="{{ $attribute->id }}"
                                                                            data-variation-id="{{ $variation->variation->id }}"
                                                                            data-product-id="{{ $product->id }}"
                                                                            data-url="{{ route('ecommerce.product.price') }}"
                                                                            data-locale="{{ app()->getLocale() }}"
                                                                            data-currency="{{ $product->country->currency }}">
                                                                            {{ app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en }}
                                                                        </option>
                                                                    @endforeach


                                                                </select>
                                                            @else
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
                                                            @endif
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

                                @if (getOffers('product_page_offer', $product)->count() > 0)
                                    @php
                                        $offer = getOffers('product_page_offer', $product)->first();
                                    @endphp
                                    <div class="col-12">
                                        <h2 class="title"><i class="ti-bolt"></i> {{ getName($offer) }}</h2>
                                        <div class="title-basic">
                                            <div class="timer" data-locale="{{ app()->getLocale() }}"
                                                data-ended_at="{{ $offer->ended_at }}">
                                                <p id="demo"></p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif (getOffers('product_quantity_discount', $product)->count() > 0)
                                    @php
                                        $offer = getOffers('product_quantity_discount', $product)->first();
                                    @endphp
                                    <div class="col-12">
                                        <h2 class="title"><i class="ti-bolt"></i> {{ getName($offer) }}</h2>
                                        <div class="title-basic">
                                            <div class="timer" data-locale="{{ app()->getLocale() }}"
                                                data-ended_at="{{ $offer->ended_at }}">
                                                <p id="demo"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif





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
                                    data-url="{{ route('ecommerce.cart.store') }}"
                                    data-locale="{{ app()->getLocale() }}" data-product_id="{{ $product->id }}"
                                    data-image="{{ getProductImage($product) }}">

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



                                @if ($product->installment_companies()->count() > 0)
                                    <a href="" data-bs-toggle="modal"
                                        data-bs-target="#installment-company-{{ $product->id }}"
                                        class="btn btn-solid">{{ __('installemnt request') }}</a>

                                    </a>
                                @endif





                            </div>

                            <div class="col-6 mt-4">
                                <div style="display:none !important"
                                    class="alert alert-danger border-2 align-items-center alarm-{{ $product->id }}"
                                    role="alert">
                                    <div class="bg-danger me-3 icon-item"><i
                                            class="fa fa-exclamation-circle text-white fs-3"></i>
                                    </div>
                                    <p class="mb-0 flex-1 alarm-text-{{ $product->id }}"></p>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-12 mt-4">
                                <div style="display:none !important"
                                    class="alert alert-danger border-2 align-items-center alarm" role="alert">
                                    <div class="bg-danger me-3 icon-item"><i
                                            class="fa fa-exclamation-circle text-white fs-3"></i>
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



                            @if (getOffers('bundles_offer', $product)->count() > 0)
                                @php
                                    $offer = getOffers('bundles_offer', $product)->first();
                                @endphp

                                <div class="border-product">
                                    <div class="col-12">
                                        <h2 class="title"><i class="ti-bolt"></i> {{ getName($offer) }}</h2>
                                        <div class="title-basic">
                                            <div class="timer" data-locale="{{ app()->getLocale() }}"
                                                data-ended_at="{{ $offer->ended_at }}">
                                                <p id="demo"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bundle">
                                        <div class="bundle_img">

                                            @php
                                                $offer_products = getOfferProducts($offer);
                                            @endphp

                                            @foreach ($offer_products as $offer_product)
                                                <div class="img-box">
                                                    <a
                                                        href="{{ route('ecommerce.product', ['product' => $offer_product->id, 'slug' => createSlug(getName($offer_product))]) }}"><img
                                                            src="{{ asset($offer_product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : getImage($offer_product->images[0])) }}"
                                                            alt="" class="img-fluid blur-up lazyload"></a>
                                                </div>
                                                @if (!$loop->last)
                                                    <span class="plus">+</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="bundle_detail">
                                            <div class="theme_checkbox">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#offer-modal"
                                                    class="btn btn-solid btn-xs">{{ __('Buy the package') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-3 col-6 col-grid-box">
                                    @include('ecommerce._offer_modal', [
                                        'offer_products' => $offer_products,
                                        'offer' => $offer,
                                    ])
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
                                    class="icofont icofont-contacts"></i>{{ __('Reviews') }}</a>
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
                                                            class="ms-3 text-dark fw-semi-bold">{{ isset($review->user->name) ? $review->user->name : __('guest') }}</span>
                                                    </div>
                                                    {{-- <p class="fs--1 mb-2 text-600">{{ interval($review->created_at) }}</p> --}}
                                                    <p class="mb-0">{{ $review->review }}</p>
                                                    <hr class="my-4" />
                                                @endforeach
                                                @if ($product->reviews->count() == 0)
                                                    <p>{{ __('There are no reviews for the product') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if (setting('product_review'))
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
                                            <input name="rating"
                                                class="form-control @error('rating') is-invalid @enderror"
                                                value="{{ old('rating') }}" type="text" autocomplete="on"
                                                id="rating" required />
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
                                    @endif


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
                                    <a
                                        href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}"><img
                                            src="{{ getProductImage($product) }}"
                                            class="img-fluid blur-up lazyload bg-img"
                                            alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                </div>
                                <div class="back">
                                    <a
                                        href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}"><img
                                            src="{{ getProductImage($product) }}"
                                            class="img-fluid blur-up lazyload bg-img"
                                            alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="javascript:void(0)" class="add-fav" title="{{ __('Add to Wishlist') }}"
                                        data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                        data-product_id="{{ $product->id }}"><i
                                            style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                            class="fa fa-heart fav-{{ $product->id }} " aria-hidden="true"></i></a>

                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view-{{ $product->id }}"
                                        title="{{ __('Quick View') }}"><i class="ti-search" aria-hidden="true"></i></a>
                                    {{-- <a href="compare.html"
                                        title="Compare"><i class="ti-reload" aria-hidden="true"></i></a> --}}

                                </div>
                            </div>
                            <div class="product-detail">
                                <div>
                                    <div class="">
                                        {!! getAverageRatingWithStars($product) !!}

                                    </div>
                                    <a
                                        href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}">
                                        <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                        </h6>
                                    </a>
                                    {{-- <p>
                                        @if (app()->getLocale() == 'ar')
                                            {!! $product->description_ar !!}
                                        @else
                                            {!! $product->description_en !!}
                                        @endif
                                    </p> --}}
                                    <h4>{!! getProductPrice($product) !!}</h4>

                                    @if ($product->product_type != 'variable')
                                        <div class="add-btn mt-2">
                                            <a href="javascript:void(0)" class="add-to-cart"
                                                data-url="{{ route('ecommerce.cart.store') }}"
                                                data-locale="{{ app()->getLocale() }}"
                                                data-product_id="{{ $product->id }}"
                                                data-image="{{ getProductImage($product) }}">
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
                                    @else
                                        <div class="add-btn">
                                            <a href="3" data-bs-toggle="modal"
                                                data-bs-target="#quick-view-{{ $product->id }}">
                                                <i class="fa fa-shopping-cart cart-icon-{{ $product->id }} me-1"
                                                    aria-hidden="true"></i>
                                                <span>{{ __('add to cart') }}</span>
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
        <img src="{{ getProductImage($product) }}" class="img-fluid" alt="">
        <h3>{{ __('added to cart') }}</h3>
    </div>
    <!-- added to cart notification -->



    <!-- Quick-view modal popup start-->

    @foreach ($products as $product)
        @include('ecommerce._product_modal', [
            'product' => $product,
        ])
    @endforeach

    <!-- Quick-view modal popup end-->



    <div class="modal fade bd-example-modal-lg theme-modal" id="installment-company-{{ $product->id }}" tabindex="-1"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="background: #ffffff" class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div class="row p-3">


                        <form method="POST" action="{{ route('ecommerce.installment.store') }}">
                            @csrf


                            <input style="display: none" type="text" value="{{ $product->product_type }}"
                                name="product_type" required>

                            <input style="display: none" type="text" value="{{ $product->id }}" name="product_id"
                                required>


                            <input style="display: none" type="text" value="" class="combination_id"
                                name="combination_id">

                            <div class="data" style="display: none" data-months_url="{{ route('company.months') }}"
                                data-product_id="{{ $product->id }}"
                                data-price_url="{{ route('installment.product.price') }}"
                                data-locale="{{ app()->getLocale() }}"
                                data-currency="{{ $product->country->currency }}">
                            </div>

                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                <h4>{{ __('select installment company') }}</h4>
                                @foreach ($product->installment_companies as $company)
                                    <div class="radio-option">
                                        <input type="radio" value="{{ $company->id }}" name="company"
                                            id="company-{{ $company->id }}"
                                            data-admin_expenses="{{ $company->admin_expenses }}"
                                            data-type="{{ $company->type }}" data-amount="{{ $company->amount }}"
                                            data-installment_url="{{ route('installment.data') }}" required>
                                        <label for="company-{{ $company->id }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">
                                                        {{ getName($company) }}
                                                    </h5>
                                                </div>
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle" style="height:35px; margin:5px"
                                                        src="{{ asset($company->media->path) }}" alt="" />
                                                </div>

                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="product-right">
                                <div id="selectSize" class="addeffect-section product-description border-product mt-2">
                                    <h4>{{ __('select products attributes') }}</h4>
                                    <div class="product-description product-attributes-{{ $product->id }}">
                                        @if ($product->product_type == 'variable')
                                            @foreach ($product->attributes as $attribute)
                                                @if (
                                                    $attribute->name_en == 'color' ||
                                                        $attribute->name_en == 'colors' ||
                                                        $attribute->name_en == 'Color' ||
                                                        $attribute->name_en == 'Colors')
                                                    <div class="row">
                                                        <div
                                                            class="col-md-2 d-flex justify-content-center align-items-center">
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
                                                                        data-currency="{{ $product->country->currency }}"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="{{ getName($variation->variation) }}">
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div
                                                            class="col-md-2 d-flex justify-content-center align-items-center">
                                                            <h4>{{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                                            </h4>

                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="size-box attribute-box-{{ $attribute->id }}">
                                                                @if ($attribute->type == 'select')
                                                                    <select>

                                                                        <option value="">
                                                                            {{ __('Select') . ' ' . getName($attribute) }}
                                                                        </option>
                                                                        @foreach ($product->variations->where('attribute_id', $attribute->id) as $index => $variation)
                                                                            <option class="attribute-select"
                                                                                data-attribute-id="{{ $attribute->id }}"
                                                                                data-variation-id="{{ $variation->variation->id }}"
                                                                                data-product-id="{{ $product->id }}"
                                                                                data-url="{{ route('ecommerce.product.price') }}"
                                                                                data-locale="{{ app()->getLocale() }}"
                                                                                data-currency="{{ $product->country->currency }}">
                                                                                {{ app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en }}
                                                                            </option>
                                                                        @endforeach


                                                                    </select>
                                                                @else
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
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <h6 class="product-title text-center">{{ __('sale price') }}</h6>

                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <div style="font-size: 15px"
                                                class="ecommerce-product-price-{{ $product->id }}">
                                                {!! getProductPrice($product) !!}
                                            </div>

                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div class="product-right">
                                <div class="border-product">

                                    <h4>{{ __('advance amount') }}</h4>

                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <input name="amount"
                                            class="form-control advanced-amount @error('amount') is-invalid @enderror"
                                            value="0" step="0.01" min="0" type="number" id="amount"
                                            required />
                                        @error('amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <h4>{{ __('select installment period') }}</h4>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <select class="form-control months-select @error('months') is-invalid @enderror"
                                            id="months" name="months" required>

                                        </select>
                                        @error('months')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>




                                </div>
                            </div>

                            <div class="product-right">
                                <div class="border-product">

                                    <h4>{{ __('admin expenses') . ' : ' }} <span class="admin_expenses">0</span> </h4>
                                    <h4>{{ __('monthly installment') . ' : ' }} <span
                                            class="monthly_installment">0</span>
                                    </h4>


                                </div>
                            </div>

                            <div class="product-right">
                                <div class="border-product">


                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="checkout-title">
                                                <h3>{{ __('installment Details') }}</h3>
                                            </div>

                                            @php
                                                $address = getAddress();
                                            @endphp

                                            <div class="row check-out">
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <div class="field-label">{{ __('full name') . ' *' }}</div>
                                                    <input name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ Auth::check() ? Auth::user()->name : ($address ? $address->name : old('name')) }}"
                                                        type="text" autocomplete="on" id="name" required />
                                                    @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <div class="field-label">{{ __('phone') . ' *' }}</div>
                                                    <input name="phone"
                                                        class="form-control phone @error('phone') is-invalid @enderror"
                                                        value="{{ Auth::check() ? getPhoneWithoutCode(Auth::user()->phone, Auth::user()->country_id) : ($address ? $address->phone : old('phone')) }}"
                                                        type="tel" maxlength="{{ getCountry()->phone_digits }}"
                                                        autocomplete="on" id="phone"
                                                        data-phone_digits="{{ getCountry()->phone_digits }}" required />
                                                    @error('phone')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <div class="field-label">
                                                        {{ __('alternative phone') }}
                                                    </div>
                                                    <input name="phone2"
                                                        class="form-control phone @error('phone2') is-invalid @enderror"
                                                        value="{{ $address ? $address->phone2 : old('phone2') }}"
                                                        type="tel" maxlength="{{ getCountry()->phone_digits }}"
                                                        autocomplete="on" id="phone2"
                                                        data-phone_digits="{{ getCountry()->phone_digits }}" />
                                                    @error('phone2')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('country') }}</div>
                                                    <select
                                                        class="form-control country-select @error('country_id') is-invalid @enderror"
                                                        id="country_id" name="country_id"
                                                        data-url="{{ route('country.states') }}"
                                                        data-url_shipping="{{ route('ecommerce.shipping') }}" required>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                data-country_id="{{ $country->id }}"
                                                                {{ $country->id == getDefaultCountry()->id ? 'selected' : ($address && $address->country_id == $country->id ? 'selected' : '') }}>
                                                                {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('country_id')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>



                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('state') }}</div>
                                                    <select
                                                        class="form-control state-select @error('state_id') is-invalid @enderror"
                                                        id="state_id" name="state_id"
                                                        data-url="{{ route('state.cities') }}" required>

                                                    </select>
                                                    @error('state_id')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>



                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('city') }}</div>
                                                    <select
                                                        class="form-control city-select @error('city_id') is-invalid @enderror"
                                                        id="city_id" name="city_id" required>

                                                    </select>
                                                    @error('city_id')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('block') . ' *' }}</div>
                                                    <input name="block"
                                                        class="form-control @error('block') is-invalid @enderror"
                                                        value="{{ $address ? $address->block : old('block') }}"
                                                        type="text" autocomplete="on" id="block" required />
                                                    @error('block')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('street address') . ' *' }}</div>
                                                    <input name="address"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        value="{{ $address ? $address->address : old('address') }}"
                                                        type="text" autocomplete="on" id="address" required />
                                                    @error('address')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>



                                                @if (getCountry()->name_en == 'Kuwait' || getCountry()->name_en == 'kuwait')
                                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                        <div class="field-label">{{ __('avenue') }}</div>
                                                        <input name="avenue"
                                                            class="form-control @error('avenue') is-invalid @enderror"
                                                            value="{{ $address ? $address->avenue : old('avenue') }}"
                                                            type="text" autocomplete="on" id="avenue" />
                                                        @error('avenue')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endif

                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('house') . ' *' }}</div>
                                                    <input name="house"
                                                        class="form-control @error('house') is-invalid @enderror"
                                                        value="{{ $address ? $address->house : old('house') }}"
                                                        type="text" autocomplete="on" id="house" required />
                                                    @error('house')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('floor number') }}</div>
                                                    <input name="floor_no"
                                                        class="form-control @error('floor_no') is-invalid @enderror"
                                                        value="{{ $address ? $address->floor_no : old('floor_no') }}"
                                                        type="text" autocomplete="on" id="floor_no" />
                                                    @error('floor_no')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>





                                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                    <div class="field-label">{{ __('notes') }}</div>
                                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                                                        cols="50"></textarea>
                                                    @error('notes')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>



                                                @if (!Auth::check())
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <input type="checkbox" value="create_account"
                                                            name="create_account" id="account-option"> &ensp;
                                                        <label
                                                            for="account-option">{{ __('Create An Account?') }}</label>
                                                    </div>
                                                @endif


                                                <div style="display:none"
                                                    class="form-group col-md-6 col-sm-6 col-xs-12 checkout-password">
                                                    <div class="field-label">{{ __('Password') }}</div>
                                                    <input
                                                        class="form-control checkout-password-password @error('password') is-invalid @enderror"
                                                        type="password" autocomplete="on" id="password"
                                                        name="password" />
                                                    @error('password')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <div style="display:none"
                                                    class="form-group col-md-6 col-sm-6 col-xs-12 checkout-password">
                                                    <div class="field-label">{{ __('Confirm Password') }}</div>
                                                    <input
                                                        class="form-control checkout-password-password-confirm @error('password_confirmation') is-invalid @enderror"
                                                        type="password" autocomplete="on" id="password_confirmation"
                                                        name="password_confirmation" />
                                                    @error('password_confirmation')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div style="display:none" class="checkout-password">
                                                    <span class="p-4" for="check">{{ __('I accept the') }} <a
                                                            href="{{ route('ecommerce.terms') }}">{{ __('terms') }}
                                                        </a>{{ __('and') }} <a
                                                            href="{{ route('ecommerce.terms') }}">{{ __('privacy policy') }}</a></span>
                                                </div>


                                                <div class="text-end"><button type="submit"
                                                        class="btn-solid btn">{{ __('send installment request') }}</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
