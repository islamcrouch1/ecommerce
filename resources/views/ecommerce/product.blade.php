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
                    <nav style="direction: ltr; float:{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                        aria-label="breadcrumb" class="theme-breadcrumb">
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
                                <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                </div>
                                <h6>120 ratings</h6>
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
                                    data-url="{{ route('ecommerce.cart.store') }}"
                                    data-locale="{{ app()->getLocale() }}" data-product_id="{{ $product->id }}"
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


                                </a> <a href="#"
                                    data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                    data-product_id="{{ $product->id }}" class="btn btn-solid add-fav"><i
                                        style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                        class="fa fa-heart fav-{{ $product->id }} fz-16 me-2"
                                        aria-hidden="true"></i>{{ __('wishlist') }}</a>
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



                            {{-- <div class="product-count">
                                <ul>
                                    <li>
                                        <img src="../assets/images/icon/truck.png" class="img-fluid" alt="image">
                                        <span class="lang">Free shipping for orders above $500 USD</span>
                                    </li>
                                </ul>
                            </div> --}}
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
                            {{-- <div class="border-product">
                                <h6 class="product-title">100% secure payment</h6>
                                <img src="../assets/images/payment.png" class="img-fluid mt-1" alt="">
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->


    <!-- added to cart notification -->
    <div class="added-notification">
        <img src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
            class="img-fluid" alt="">
        <h3>{{ __('added to cart') }}</h3>
    </div>
    <!-- added to cart notification -->


@endsection
