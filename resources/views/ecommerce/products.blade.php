@extends('layouts.ecommerce.app')
@section('content')
    <!-- breadcrumb start -->
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
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('products') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->




    <!-- section start -->
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 collection-filter">
                        <!-- side-bar colleps block stat -->
                        <div class="collection-filter-block">
                            <!-- brand filter start -->
                            <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left"
                                        aria-hidden="true"></i> back</span></div>
                            <div class="collection-collapse-block open">
                                <h3 class="collapse-block-title">{{ __('brands') }}</h3>
                                <div class="collection-collapse-block-content">
                                    <div class="collection-brand-filter">
                                        <form action="">

                                            @foreach ($brands as $brand)
                                                <div class="form-check collection-filter-checkbox">
                                                    <input onchange="this.form.submit()" name="brand[]" type="checkbox"
                                                        value="{{ $brand->id }}"
                                                        {{ in_array($brand->id, request()->brand) ? 'checked' : '' }}
                                                        class="form-check-input" id="zara">
                                                    <label class="form-check-label"
                                                        for="zara">{{ app()->getLocale() == 'ar' ? $brand->name_ar : $brand->name_en }}</label>
                                                </div>
                                            @endforeach
                                        </form>


                                    </div>
                                </div>
                            </div>
                            <!-- color filter start here -->
                            {{-- <div class="collection-collapse-block open">
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
                            </div> --}}
                            <!-- size filter start here -->
                            {{-- <div class="collection-collapse-block border-0 open">
                                <h3 class="collapse-block-title">size</h3>
                                <div class="collection-collapse-block-content">
                                    <div class="collection-brand-filter">
                                        <div class="form-check collection-filter-checkbox">
                                            <input type="checkbox" class="form-check-input" id="hundred">
                                            <label class="form-check-label" for="hundred">s</label>
                                        </div>
                                        <div class="form-check collection-filter-checkbox">
                                            <input type="checkbox" class="form-check-input" id="twohundred">
                                            <label class="form-check-label" for="twohundred">m</label>
                                        </div>
                                        <div class="form-check collection-filter-checkbox">
                                            <input type="checkbox" class="form-check-input" id="threehundred">
                                            <label class="form-check-label" for="threehundred">l</label>
                                        </div>
                                        <div class="form-check collection-filter-checkbox">
                                            <input type="checkbox" class="form-check-input" id="fourhundred">
                                            <label class="form-check-label" for="fourhundred">xl</label>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- price filter start here -->
                            <div class="collection-collapse-block border-0 open">
                                <h3 class="collapse-block-title">{{ __('price') }}</h3>
                                <div class="collection-collapse-block-content">
                                    <div class="wrapper mt-3">
                                        <form action="">
                                            <div class="range-slider price-range" data-currency="{{ getCurrency() }}"
                                                data-max="{{ $max_price }}" data-min="{{ $min_price }}">
                                                <input name="range" onmouseup="mouseUp()" type="text"
                                                    class="js-range-slider" value="" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- silde-bar colleps block end here -->
                        <!-- side-bar single product slider start -->


                        <div class="theme-card">

                            <h5 class="title-border">{{ __('Top collections') }}</h5>
                            <div class="offer-slider slide-1">


                                @foreach ($top_collection as $index => $product)
                                    @if ($loop->first || $index % 3 == 0)
                                        <div>
                                    @endif


                                    <div class="media">
                                        <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                                class="img-fluid blur-up lazyload"
                                                src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                                alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                        <div class="media-body align-self-center">
                                            <div class="">
                                                {!! getAverageRatingWithStars($product) !!}
                                            </div>
                                            <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
                                                <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                </h6>
                                            </a>
                                            {!! getProductPrice($product) !!}
                                            @if ($product->product_type != 'variable')
                                                <div class="add-btn mt-2">
                                                    <a href="javascript:void(0)" class="add-to-cart"
                                                        data-url="{{ route('ecommerce.cart.store') }}"
                                                        data-locale="{{ app()->getLocale() }}"
                                                        data-product_id="{{ $product->id }}"
                                                        data-image="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}">
                                                        <div style="display: none; color: #999999; margin: 3px; padding: 6px;"
                                                            class="spinner-border spinner-border-sm spinner spin-{{ $product->id }}"
                                                            role="status">
                                                        </div>
                                                        <i class="fa fa-shopping-cart cart-icon-{{ $product->id }} me-1"
                                                            aria-hidden="true"></i>
                                                        <span
                                                            class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
                                                        <span class="cart-added-{{ $product->id }}"
                                                            style="display: none;">{{ __('Added to bag') }}</span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if (($index + 1) % 3 == 0 || $loop->last)
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="theme-card mt-3">
                        <h5 class="title-border">{{ __('Best seller') }}</h5>
                        <div class="offer-slider slide-1">


                            @foreach ($best_selling as $index => $product)
                                @if ($loop->first || $index % 3 == 0)
                                    <div>
                                @endif


                                <div class="media">
                                    <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                            class="img-fluid blur-up lazyload"
                                            src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                            alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                    <div class="media-body align-self-center">
                                        <div class=""> {!! getAverageRatingWithStars($product) !!}
                                        </div>
                                        <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
                                            <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                            </h6>
                                        </a>
                                        {!! getProductPrice($product) !!}
                                        @if ($product->product_type != 'variable')
                                            <div class="add-btn mt-2">
                                                <a href="javascript:void(0)" class="add-to-cart"
                                                    data-url="{{ route('ecommerce.cart.store') }}"
                                                    data-locale="{{ app()->getLocale() }}"
                                                    data-product_id="{{ $product->id }}"
                                                    data-image="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}">
                                                    <div style="display: none; color: #999999; margin: 3px; padding: 6px;"
                                                        class="spinner-border spinner-border-sm spinner spin-{{ $product->id }}"
                                                        role="status">
                                                    </div>
                                                    <i class="fa fa-shopping-cart cart-icon-{{ $product->id }} me-1"
                                                        aria-hidden="true"></i>
                                                    <span
                                                        class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
                                                    <span class="cart-added-{{ $product->id }}"
                                                        style="display: none;">{{ __('Added to bag') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if (($index + 1) % 3 == 0 || $loop->last)
                        </div>
                        @endif
                        @endforeach
                    </div>


                </div>


                <!-- side-bar single product slider end -->
                <!-- side-bar banner start here -->
                {{-- <div class="collection-sidebar-banner">
                            <a href="#"><img src="../assets/images/side-banner.png"
                                    class="img-fluid blur-up lazyload" alt=""></a>
                        </div> --}}
                <!-- side-bar banner end here -->
            </div>
            <div class="collection-content col">
                <div class="page-main-content">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="collection-product-wrapper">
                                <div class="product-top-filter">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="filter-main-btn"><span class="filter-btn btn btn-theme"><i
                                                        class="fa fa-filter" aria-hidden="true"></i> Filter</span>
                                            </div>
                                        </div>
                                    </div>
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
                                                                alt="" class="product-2-layout-view"></li>
                                                        <li><img src="{{ asset('e-assets/images/icon/3.png') }}"
                                                                alt="" class="product-3-layout-view"></li>
                                                        <li><img src="{{ asset('e-assets/images/icon/4.png') }}"
                                                                alt="" class="product-4-layout-view"></li>
                                                        <li><img src="{{ asset('e-assets/images/icon/6.png') }}"
                                                                alt="" class="product-6-layout-view"></li>
                                                    </ul>
                                                </div>
                                                <div class="product-page-per-view">
                                                    <form action="">
                                                        <select name="pagination" onchange="this.form.submit()">
                                                            <option {{ request()->pagination == '24' ? 'selected' : '' }}
                                                                value="24">{{ __('24 Products Par Page') }}
                                                            </option>
                                                            <option {{ request()->pagination == '50' ? 'selected' : '' }}
                                                                value="50">{{ __('50 Products Par Page') }}
                                                            </option>
                                                            <option {{ request()->pagination == '100' ? 'selected' : '' }}
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
                                    <div class="row margin-res">

                                        @foreach ($products as $product)
                                            <div class="col-xl-3 col-6 col-grid-box">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="front">
                                                            <a
                                                                href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                                                    src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                                                    class="img-fluid blur-up lazyload bg-img"
                                                                    alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                                        </div>
                                                        <div class="back">
                                                            <a
                                                                href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                                                    src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                                                    class="img-fluid blur-up lazyload bg-img"
                                                                    alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                                        </div>
                                                        <div class="cart-info cart-wrap">
                                                            <a href="javascript:void(0)" class="add-fav"
                                                                title="Add to Wishlist"
                                                                data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                                                data-product_id="{{ $product->id }}"><i
                                                                    style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                                                    class="fa fa-heart fav-{{ $product->id }} "
                                                                    aria-hidden="true"></i></a>

                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view-{{ $product->id }}"
                                                                title="Quick View"><i class="ti-search"
                                                                    aria-hidden="true"></i></a> <a href="compare.html"
                                                                title="Compare"><i class="ti-reload"
                                                                    aria-hidden="true"></i></a>

                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div>
                                                            <div class=""> {!! getAverageRatingWithStars($product) !!}

                                                            </div>
                                                            <a
                                                                href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
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
        </div>
        </div>
    </section>
    <!-- section End -->




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



    <!-- added to cart notification -->
    <div class="added-notification fav-noty">
        <h3>{{ __('added to wishlist') }}</h3>
    </div>
    <!-- added to cart notification -->
@endsection
