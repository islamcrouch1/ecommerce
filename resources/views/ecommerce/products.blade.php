@php
    if (isset(request()->category)) {
        $title = getName(getItemById(request()->category, 'category'));
    } else {
        $title = 'Products';
    }
@endphp

@extends('layouts.ecommerce.app', ['page_title' => $title])
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
                            <li class="breadcrumb-item active" aria-current="page">
                                @if (isset(request()->category))
                                    {{ getName(getItemById(request()->category, 'category')) }}
                                @else
                                    {{ __('products') }}
                                @endif
                            </li>
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
                <form class="product-form" action="">
                    <div class="row">
                        <div class="col-sm-3 collection-filter">
                            <!-- side-bar colleps block stat -->
                            <div class="collection-filter-block">
                                <!-- brand filter start -->
                                <div class="collection-mobile-back"><span class="filter-back"><i
                                            class="fa fa-angle-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                            aria-hidden="true"></i> {{ __('Back') }}</span>
                                </div>
                                <div class="collection-collapse-block open">
                                    <h3 class="collapse-block-title">{{ __('brands') }}</h3>
                                    <div class="collection-collapse-block-content">
                                        <div class="collection-brand-filter">
                                            <div class="row">

                                                @foreach (getBrands() as $brand)
                                                    <div class="col-{{ getBrands()->count() > 10 ? '6' : '12' }}">
                                                        <div class="form-check collection-filter-checkbox">
                                                            <input name="brands[]" type="checkbox"
                                                                value="{{ $brand->id }}"
                                                                {{ in_array($brand->id, request()->brands) ? 'checked' : '' }}
                                                                class="form-check-input filter" id="{{ $brand->name_ar }}">
                                                            <label class="form-check-label"
                                                                for="{{ $brand->name_ar }}">{{ app()->getLocale() == 'ar' ? $brand->name_ar : $brand->name_en }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input style="display: none" name="category" value="{{ request()->category }}"
                                                type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="collection-collapse-block open">
                                    <h3 class="collapse-block-title">{{ __('categories') }}</h3>
                                    <div class="collection-collapse-block-content">
                                        <div class="collection-brand-filter mt-4">



                                            @foreach (getCategories() as $category)
                                                <div class="btn-group m-1">
                                                    <a href="{{ route('ecommerce.products', ['category' => $category->id]) }}"
                                                        class="btn btn-danger btn-category">{{ getName($category) }}</a>

                                                    @if ($category->children->count() > 0)
                                                        <button type="button"
                                                            class="btn btn-danger btn-category dropdown-toggle dropdown-toggle-split"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu">

                                                            @foreach ($category->children->sortBy('sort_order') as $subCat)
                                                                <li style="width:100%"><a class="dropdown-item"
                                                                        href="{{ route('ecommerce.products', ['category' => $subCat->id]) }}">{{ getName($subCat) }}</a>
                                                                </li>
                                                            @endforeach

                                                        </ul>
                                                    @endif

                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>


                                @foreach ($attributes as $attribute)
                                    @if (
                                        $attribute->name_en == 'color' ||
                                            $attribute->name_en == 'colors' ||
                                            $attribute->name_en == 'Color' ||
                                            $attribute->name_en == 'Colors')
                                        <!-- color filter start here -->
                                        <div class="collection-collapse-block open">
                                            <h3 class="collapse-block-title">{{ getName($attribute) }}</h3>
                                            <div class="collection-collapse-block-content">
                                                <div class="color-selector">
                                                    <ul>

                                                        @foreach ($attribute->variations as $index => $variation)
                                                            <label for="color-{{ $variation->id }}">
                                                                <li class="color-li {{ in_array($variation->id, request()->variations) ? 'active' : '' }}"
                                                                    style="background-color:{{ $variation->value }} !important; {{ $variation->value == '#ffffff' ? 'border: 1px solid #999999' : '' }}"
                                                                    data-variation-id="{{ $variation->id }}">
                                                                </li>
                                                            </label>

                                                            <input style="display:none" name="variations[]" type="checkbox"
                                                                value="{{ $variation->id }}"
                                                                {{ in_array($variation->id, request()->variations) ? 'checked' : '' }}
                                                                class="form-check-input filter"
                                                                id="color-{{ $variation->id }}">
                                                        @endforeach

                                                        {{-- <li class="color-1 active"></li> --}}

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- color filter start here -->
                                        <div class="collection-collapse-block open">
                                            <h3 class="collapse-block-title"> {{ getName($attribute) }}</h3>
                                            <div class="collection-collapse-block-content">
                                                <div class="color-selector box-selector">
                                                    <ul>

                                                        @foreach ($attribute->variations as $index => $variation)
                                                            <label for="variation-{{ $variation->id }}">
                                                                <li class="color-li {{ in_array($variation->id, request()->variations) ? 'active' : '' }}"
                                                                    style=""
                                                                    data-variation-id="{{ $variation->id }}">
                                                                    {{ getName($variation) }}
                                                                </li>
                                                            </label>

                                                            <input style="display:none" name="variations[]" type="checkbox"
                                                                value="{{ $variation->id }}"
                                                                {{ in_array($variation->id, request()->variations) ? 'checked' : '' }}
                                                                class="form-check-input filter"
                                                                id="variation-{{ $variation->id }}">
                                                        @endforeach

                                                        {{-- <li class="color-1 active"></li> --}}

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach



                                <!-- price filter start here -->
                                <div class="collection-collapse-block border-0 open">
                                    <h3 class="collapse-block-title">{{ __('price') }}</h3>
                                    <div class="collection-collapse-block-content">
                                        <div class="collection-brand-filter">
                                            <div class="form-check collection-filter-checkbox">
                                                <input name="range" value="0;5" type="checkbox"
                                                    class="form-check-input filter" id="one"
                                                    {{ request()->range == '0;5' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="one">{{ __('less than') . ' ' . '5' . getCurrency() }}</label>
                                            </div>
                                            <div class="form-check collection-filter-checkbox">
                                                <input name="range" value="5;10" type="checkbox"
                                                    class="form-check-input filter" id="two"
                                                    {{ request()->range == '5;10' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="two">{{ '5' . getCurrency() . ' - ' . '10' . getCurrency() }}</label>
                                            </div>
                                            <div class="form-check collection-filter-checkbox">
                                                <input name="range" value="10;20" type="checkbox"
                                                    class="form-check-input filter" id="three"
                                                    {{ request()->range == '10;20' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="three">{{ '10' . getCurrency() . ' - ' . '20' . getCurrency() }}</label>
                                            </div>
                                            <div class="form-check collection-filter-checkbox">
                                                <input name="range" value="20;40" type="checkbox"
                                                    class="form-check-input filter" id="four"
                                                    {{ request()->range == '20;40' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="four">{{ '20' . getCurrency() . ' - ' . '40' . getCurrency() }}</label>
                                            </div>
                                            <div class="form-check collection-filter-checkbox">
                                                <input name="range" value="40;999999" type="checkbox"
                                                    class="form-check-input filter" id="five"
                                                    {{ request()->range == '20;40' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="five">{{ __('more than') . ' ' . '40' . getCurrency() }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="collection-collapse-block border-0 open">
                                    <h3 class="collapse-block-title">{{ __('price') }}</h3>
                                    <div class="collection-collapse-block-content">
                                        <div class="wrapper mt-3">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href=""
                                                        class="btn btn-solid btn-sm btn-xs me-3 p-1 price-filter">{{ __('search') }}</a>

                                                </div>
                                                <div class="range-slider price-range col-sm-12"
                                                    data-currency="{{ getCurrency() }}" data-max="{{ $max_price }}"
                                                    data-min="{{ $min_price }}">
                                                    <input name="range" onmouseover="mouseup()" type="text"
                                                        class="js-range-slider" value="" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <!-- silde-bar colleps block end here -->
                            <!-- side-bar single product slider start -->


                            @if (getTopCollections()->count() > 0)
                                @include('ecommerce._products_slider', [
                                    'products' => getTopCollections(),
                                    'type' => 'Top collections',
                                ])
                            @endif


                            @if (getBestSelling()->count() > 0)
                                @include('ecommerce._products_slider', [
                                    'products' => getBestSelling(),
                                    'type' => 'Best seller',
                                ])
                            @endif



                            <!-- side-bar single product slider end -->
                            <!-- side-bar banner start here -->
                            {{-- <div class="collection-sidebar-banner">
                                                <a href="#"><img src="../assets/images/side-banner.png"
                                                        class="img-fluid blur-up lazyload" alt=""></a>
                                            </div> --}}
                            <!-- side-bar banner end here -->
                        </div>
                        <div class="collection-content col-sm-9">
                            <div class="page-main-content">
                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="collection-product-wrapper">
                                            <div class="product-top-filter">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="filter-main-btn"><span
                                                                class="filter-btn btn btn-theme"><i class="fa fa-filter"
                                                                    aria-hidden="true"></i>
                                                                {{ __('Filter') }}</span>
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
                                                                            title="{{ __('Add to Wishlist') }}"
                                                                            data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                                                            data-product_id="{{ $product->id }}"><i
                                                                                style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                                                                class="fa fa-heart fav-{{ $product->id }} "
                                                                                aria-hidden="true"></i></a>

                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#quick-view-{{ $product->id }}"
                                                                            title="{{ __('Quick View') }}"><i
                                                                                class="ti-search"
                                                                                aria-hidden="true"></i></a>
                                                                        {{-- <a href="compare.html"
                                                                title="Compare"><i class="ti-reload"
                                                                    aria-hidden="true"></i></a> --}}

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
                                                                                <a href="javascript:void(0)"
                                                                                    class="add-to-cart"
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
                                                                                    <span
                                                                                        class="cart-added-{{ $product->id }}"
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
