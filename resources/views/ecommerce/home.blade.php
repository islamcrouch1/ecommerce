@extends('layouts.ecommerce.app')
@section('content')
    <!-- Home slider -->
    <section class="pt-0 height-65">
        <div class="slider-animate home-slider">

            @foreach ($slides as $slide)
                <div>
                    <div class="home">
                        <img src="{{ asset($slide->media->path) }}" alt="" class="bg-img blur-up lazyload">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="slider-contain">
                                        <div>
                                            <h4 class="animated" data-animation-in="fadeInUp">
                                                {{ app()->getLocale() == 'ar' ? $slide->text_1_ar : $slide->text_1_en }}
                                            </h4>
                                            <h1 class="animated font-fraunces" data-animation-in="fadeInUp"
                                                data-delay-in="0.3">
                                                {{ app()->getLocale() == 'ar' ? $slide->text_2_ar : $slide->text_2_en }}
                                            </h1><a href="{{ $slide->url }}" class="btn btn-solid animated"
                                                data-animation-in="fadeInUp"
                                                data-delay-in="0.5">{{ app()->getLocale() == 'ar' ? $slide->button_text_ar : $slide->button_text_en }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </section>
    <!-- Home slider end -->


    <!-- collection banner -->
    <section class="pt-0 ratio3_2">
        <div class="container-fluid p-0">
            <div class="row m-0">
                @foreach (websiteSettingMultiple('categories') as $item)
                    <div class="col-lg-3 col-sm-6 p-0">
                        <a href="{{ route('ecommerce.products', ['category' => getCatFromSetting($item)->id]) }}">
                            <div class="collection-banner p-left">
                                <div class="img-part">
                                    <img src="{{ asset(getCatFromSetting($item)->media->path) }}"
                                        class="img-fluid blur-up lazyload bg-img">
                                </div>
                                <div class="contain-banner banner-4">
                                    <div>
                                        <h4>{{ app()->getLocale() == 'ar' ? getCatFromSetting($item)->subtitle_ar : getCatFromSetting($item)->subtitle_en }}
                                        </h4>
                                        <h2 class="text-dark">
                                            {{ app()->getLocale() == 'ar' ? getCatFromSetting($item)->name_ar : getCatFromSetting($item)->name_en }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- collection banner end -->


    <!-- Paragraph-->
    <div class="title6 section-t-space">
        <h2 class="font-fraunces">
            {{ app()->getLocale() == 'ar' ? websiteSettingAr('top_collection') : websiteSettingEn('top_collection') }}
        </h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="product-para">
                    <p class="text-center">
                        {{ app()->getLocale() == 'ar' ? websiteSettingDAr('top_collection') : websiteSettingDEn('top_collection') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Paragraph end -->


    <!-- product start -->
    <section class="bag-product pt-0 section-b-space ratio_square">
        <div class="container">
            <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gy-sm-4 gy-3">

                @foreach ($products->where('top_collection', 1) as $product)
                    <div class="product-box product-wrap product-style-3">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                        alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                        src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                        class="img-fluid blur-up lazyload bg-img"></a>
                            </div>
                            <div class="cart-detail"><a href="javascript:void(0)" class="add-fav" title="Add to Wishlist"
                                    data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                    data-product_id="{{ $product->id }}"><i
                                        style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                        class="fa fa-heart fav-{{ $product->id }} " aria-hidden="true"></i></a>



                                <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-{{ $product->id }}"
                                    title="Quick View"><i class="ti-search" aria-hidden="true"></i></a> <a
                                    href="compare.html" title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="">{!! getAverageRatingWithStars($product) !!}
                            </div>
                            <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
                                <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h6>
                            </a>
                            {!! getProductPrice($product) !!}

                            @if ($product->product_type != 'variable')
                                <div class="add-btn">
                                    <a href="javascript:void(0)" class="add-to-cart"
                                        data-url="{{ route('ecommerce.cart.store') }}"
                                        data-locale="{{ app()->getLocale() }}" data-product_id="{{ $product->id }}"
                                        data-image="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}">
                                        <div style="display: none; color: #999999; margin: 3px; padding: 6px;"
                                            class="spinner-border spinner-border-sm spinner spin-{{ $product->id }} "
                                            role="status">
                                        </div>
                                        <i class="fa fa-shopping-cart cart-icon-{{ $product->id }}  me-1"
                                            aria-hidden="true"></i>
                                        <span class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
                                        <span class="cart-added-{{ $product->id }}"
                                            style="display: none;">{{ __('Added to bag') }}</span>
                                    </a>
                                </div>
                            @endif


                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!-- product end -->


    <!-- Parallax banner -->
    <section class="p-0 product-vertical overflow-hidden">
        <div class="full-banner parallax text-center p-left bg-theme">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <div class="title6">
                            <h2 class="font-fraunces text-white">
                                {{ app()->getLocale() == 'ar' ? websiteSettingAr('best_selling') : websiteSettingEn('best_selling') }}
                            </h2>
                        </div>
                        <div class="product-para">
                            <p class="text-center text-white">
                                {{ app()->getLocale() == 'ar' ? websiteSettingDAr('best_selling') : websiteSettingDEn('best_selling') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="slide-3 no-arrow slick-default-margin full-box">

                            @foreach ($products->where('best_selling', 1) as $product)
                                <div class="theme-card center-align">
                                    <div class="offer-slider">
                                        <div class="sec-1">
                                            <div class="product-box2">
                                                <div class="media">
                                                    <a
                                                        href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                                            class="img-fluid blur-up lazyload"
                                                            src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                                            alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                                    <div class="media-body align-self-center">
                                                        <div class="">{!! getAverageRatingWithStars($product) !!}</div>
                                                        <a
                                                            href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
                                                            <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                            </h6>
                                                        </a>
                                                        {!! getProductPrice($product) !!}
                                                        @if ($product->product_type != 'variable')
                                                            <div class="add-btn">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Parallax banner end -->


    <!-- product slider start -->
    <section class="bag-product ratio_square">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-basic">
                        <h2 class="title font-fraunces"><i class="ti-bolt"></i>{{ __('Featured products') }}</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="slide-6-product product-m no-arrow">
                        @foreach ($products->where('is_featured', 1) as $product)
                            <div class="product-box product-wrap product-style-3">
                                <div class="img-wrapper">
                                    <div class="front">
                                        <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                                alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                                src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                                class="img-fluid blur-up lazyload bg-img"></a>
                                    </div>
                                    <div class="cart-detail"><a href="javascript:void(0)" class="add-fav"
                                            title="Add to Wishlist"
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
                                <div class="product-info">
                                    <div class="">{!! getAverageRatingWithStars($product) !!}
                                    </div>
                                    <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
                                        <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h6>
                                    </a>
                                    {!! getProductPrice($product) !!}
                                    @if ($product->product_type != 'variable')
                                        <div class="add-btn">
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
                        @endforeach

                    </div>
                </div>
                <div class="col-12 section-t-space">
                    <div class="title-basic">
                        <h2 class="title font-fraunces"><i class="ti-bolt"></i>{{ __('Offers and sales') }}</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="slide-6-product product-m no-arrow">
                        @foreach ($products->where('on_sale', 1) as $product)
                            <div class="product-box product-wrap product-style-3">
                                <div class="img-wrapper">
                                    <div class="front">
                                        <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                                alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                                                src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                                class="img-fluid blur-up lazyload bg-img"></a>
                                    </div>
                                    <div class="cart-detail"><a href="javascript:void(0)" class="add-fav"
                                            title="{{ __('Add to Wishlist') }}"
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
                                <div class="product-info">
                                    <div class="">{!! getAverageRatingWithStars($product) !!}
                                    </div>
                                    <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}">
                                        <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h6>
                                    </a>
                                    {!! getProductPrice($product) !!}
                                    @if ($product->product_type != 'variable')
                                        <div class="add-btn">
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
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product slider end -->


    <!-- two banner -->
    <section class="pb-0 ratio2_1">
        <div class="container">
            <div class="row partition2">
                @foreach (websiteSettingMultiple('categories_2') as $item)
                    <div class="col-md-6">
                        <a href="{{ route('ecommerce.products', ['category' => getCatFromSetting($item)->id]) }}">
                            <div class="collection-banner p-right text-center">
                                <div class="img-part">
                                    <img src="{{ asset(getCatFromSetting($item)->media->path) }}"
                                        class="img-fluid blur-up lazyload bg-img" alt="">
                                </div>
                                <div class="contain-banner">
                                    <div>
                                        <h4>{{ app()->getLocale() == 'ar' ? getCatFromSetting($item)->subtitle_ar : getCatFromSetting($item)->subtitle_en }}
                                        </h4>
                                        <h2 class="text-dark">
                                            {{ app()->getLocale() == 'ar' ? getCatFromSetting($item)->name_ar : getCatFromSetting($item)->name_en }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- two banner -->


    <!-- product slider -->
    <section class="section-b-space">
        <div class="container">
            <div class="row multiple-slider">
                <div class="col-lg-3 col-sm-6">
                    <div class="theme-card">
                        <h5 class="title-border">{{ __('Top collections') }}</h5>
                        <div class="offer-slider slide-1">


                            @foreach ($products->where('top_collection', 1) as $index => $product)
                                @if ($loop->first || $index % 3 == 0)
                                    <div>
                                @endif


                                <div class="media">
                                    <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                            class="img-fluid blur-up lazyload"
                                            src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                            alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                    <div class="media-body align-self-center">
                                        <div class="">{!! getAverageRatingWithStars($product) !!}</div>
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
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="theme-card">
                    <h5 class="title-border">{{ __('Best seller') }}</h5>
                    <div class="offer-slider slide-1">


                        @foreach ($products->where('best_selling', 1) as $index => $product)
                            @if ($loop->first || $index % 3 == 0)
                                <div>
                            @endif


                            <div class="media">
                                <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                        class="img-fluid blur-up lazyload"
                                        src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                        alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                <div class="media-body align-self-center">
                                    <div class="">{!! getAverageRatingWithStars($product) !!}
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
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="theme-card">
                <h5 class="title-border">{{ __('Featured products') }}</h5>
                <div class="offer-slider slide-1">


                    @foreach ($products->where('is_featured', 1) as $index => $product)
                        @if ($loop->first || $index % 3 == 0)
                            <div>
                        @endif


                        <div class="media">
                            <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                    class="img-fluid blur-up lazyload"
                                    src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                    alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                            <div class="media-body align-self-center">
                                <div class="">{!! getAverageRatingWithStars($product) !!}
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
                                            <span class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
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
        </div>


        <div class="col-lg-3 col-sm-6">
            <div class="theme-card">
                <h5 class="title-border">{{ __('Offers and sales') }}</h5>
                <div class="offer-slider slide-1">


                    @foreach ($products->where('on_sale', 1) as $index => $product)
                        @if ($loop->first || $index % 3 == 0)
                            <div>
                        @endif


                        <div class="media">
                            <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                                    class="img-fluid blur-up lazyload"
                                    src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                    alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                            <div class="media-body align-self-center">
                                <div class="">{!! getAverageRatingWithStars($product) !!}
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
                                            <span class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
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
        </div>

        </div>
        </div>
    </section>
    <!-- product slider end -->


    <!-- service section start -->
    <section class="service section-b-space bg-light">
        <div class="container">
            <div class="row partition4 ">
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_1')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_1') : websiteSettingEn('icon_1') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_1') : websiteSettingDEn('icon_1') }}
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_2')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_2') : websiteSettingEn('icon_2') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_2') : websiteSettingDEn('icon_2') }}
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_3')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_3') : websiteSettingEn('icon_3') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_3') : websiteSettingDEn('icon_3') }}
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_4')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_4') : websiteSettingEn('icon_4') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_4') : websiteSettingDEn('icon_4') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- service section end -->


    <!-- banner section -->
    {{-- <section class="pt-0 section-b-space">
        <div class="container">
            <div class="full-banner custom-space p-right text-end">
                <img src="{{ asset('e-assets/images/marketplace/banner/15.jpg') }}" alt=""
                    class="bg-img blur-up lazyload">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-11">
                            <div class="banner-contain custom-size">
                                <h2>2018</h2>
                                <h3>fashion trends</h3>
                                <h4>special offer</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- banner section end -->

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
                                    <div class="product-button">


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


                                        </a> <a href="#"
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
    <div class="added-notification cart-noty">
        <h3>{{ __('added to cart') }}</h3>
    </div>
    <!-- added to cart notification -->


    <!-- added to fav notification -->
    <div class="added-notification fav-noty">
        <h3>{{ __('added to wishlist') }}</h3>
    </div>
    <!-- added to fav notification -->
@endsection
