@extends('layouts.ecommerce.app')

@section('content')
    <!-- Home slider -->
    <section class="pt-0 height-65">
        <div class="slider-animate home-slider">

            @foreach ($slides as $slide)
                <div>
                    <div class="home">
                        <img src="{{ getImageAsset($slide) }}" alt="" class="bg-img blur-up lazyload">
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
                    @if (getCatFromSetting($item))
                        <div class="col-lg-6 col-sm-6 p-0">
                            <a href="{{ route('ecommerce.products', ['category' => getCatFromSetting($item)->id]) }}">
                                <div class="collection-banner p-left">

                                    <h2 class="text-dark text-bbb">
                                        {{ app()->getLocale() == 'ar' ? getCatFromSetting($item)->name_ar : getCatFromSetting($item)->name_en }}
                                    </h2>

                                    <div class="img-part">
                                        <img src="{{ asset(getImage(getCatFromSetting($item))) }}"
                                            class="img-fluid blur-up lazyload bg-img">
                                    </div>

                                    <div class="contain-banner banner-4">
                                        <div>
                                            <h4>{{ app()->getLocale() == 'ar' ? getCatFromSetting($item)->subtitle_ar : getCatFromSetting($item)->subtitle_en }}
                                            </h4>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!-- collection banner end -->


    @if (getOffers('home_page_offer')->count() > 0)
        @foreach (getOffers('home_page_offer') as $offer)
            @php
                $products = getOfferProducts($offer);
            @endphp

            <!-- product deal section start -->
            <section class="ratio_square">
                <div class="container">
                    <div class="row">


                        <div class="col-12">
                            <div class="title-basic">
                                <h2 class="title"><i class="ti-bolt"></i> {{ getName($offer) }}</h2>
                                <div class="timer" data-locale="{{ app()->getLocale() }}"
                                    data-ended_at="{{ $offer->ended_at }}">
                                    <p id="demo"></p>
                                </div>
                            </div>
                            <div class="slide-6-product product-m no-arrow">
                                @foreach ($products as $product)
                                    @include('ecommerce._product_div', [
                                        'product' => $product,
                                    ])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- product deal section start -->

            @foreach ($products as $product)
                @include('ecommerce._product_modal', [
                    'product' => $product,
                ])
            @endforeach
        @endforeach
    @endif



    @if ($top_collections->count() > 0)
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

        <!-- product slider start -->
        <section class="bag-product ratio_square pt-0 section-b-space">
            <div class="container">
                <div class="row">

                    <div class="col-12">
                        <div class="slide-6-product product-m no-arrow">
                            @foreach ($top_collections as $product)
                                @include('ecommerce._product_div', [
                                    'product' => $product,
                                ])
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product slider end -->
    @endif

    @if ($best_selling->count() > 0)
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

                                @foreach ($best_selling as $product)
                                    <div class="theme-card center-align">
                                        <div class="offer-slider">
                                            <div class="sec-1">
                                                <div class="product-box2">
                                                    <div class="media">
                                                        <a
                                                            href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}"><img
                                                                class="img-fluid blur-up lazyload"
                                                                src="{{ getProductImage($product) }}"
                                                                alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
                                                        <div class="media-body align-self-center">
                                                            <div class="">{!! getAverageRatingWithStars($product) !!}</div>
                                                            <a
                                                                href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}">
                                                                <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                                </h6>
                                                            </a>
                                                            {!! getProductPrice($product) !!}
                                                            @if ($product->product_type != 'variable' && $product->can_rent == null)
                                                                <div class="add-btn">
                                                                    <a href="javascript:void(0)" class="add-to-cart"
                                                                        data-url="{{ route('ecommerce.cart.store') }}"
                                                                        data-locale="{{ app()->getLocale() }}"
                                                                        data-product_id="{{ $product->id }}"
                                                                        data-image="{{ getProductImage($product) }}">
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
    @endif







    <!-- product slider start -->
    <section class="bag-product ratio_square">
        <div class="container">
            <div class="row">

                @if ($is_featured->count() > 0)
                    <div class="col-12">
                        <div class="title-basic">
                            <h2 class="title font-fraunces"><i class="ti-bolt"></i>{{ __('Featured products') }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="slide-6-product product-m no-arrow">
                            @foreach ($is_featured as $product)
                                @include('ecommerce._product_div', [
                                    'product' => $product,
                                ])
                            @endforeach

                        </div>
                    </div>
                @endif

                @if ($on_sale->count() > 0)
                    <div class="col-12 section-t-space">
                        <div class="title-basic">
                            <h2 class="title font-fraunces"><i class="ti-bolt"></i>{{ __('Offers and sales') }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="slide-6-product product-m no-arrow">
                            @foreach ($on_sale as $product)
                                @include('ecommerce._product_div', [
                                    'product' => $product,
                                ])
                            @endforeach

                        </div>
                    </div>
                @endif


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
                        @if (getCatFromSetting($item))
                            <a href="{{ route('ecommerce.products', ['category' => getCatFromSetting($item)->id]) }}">
                                <div class="collection-banner p-right text-center">
                                    <div class="img-part">
                                        <img src="{{ getimageAsset(getCatFromSetting($item)) }}"
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
                        @endif
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
                    @if ($top_collections->count() > 0)
                        @include('ecommerce._products_slider', [
                            'products' => $top_collections,
                            'type' => 'Top collections',
                        ])
                    @endif
                </div>

                <div class="col-lg-3 col-sm-6">
                    @if ($best_selling->count() > 0)
                        @include('ecommerce._products_slider', [
                            'products' => $best_selling,
                            'type' => 'Best seller',
                        ])
                    @endif
                </div>

                <div class="col-lg-3 col-sm-6">
                    @if ($is_featured->count() > 0)
                        @include('ecommerce._products_slider', [
                            'products' => $is_featured,
                            'type' => 'Featured products',
                        ])
                    @endif
                </div>

                <div class="col-lg-3 col-sm-6">
                    @if ($on_sale->count() > 0)
                        @include('ecommerce._products_slider', [
                            'products' => $on_sale,
                            'type' => 'Offers and sales',
                        ])
                    @endif
                </div>


            </div>
        </div>
    </section>
    <!-- product slider end -->


    @if ($testimonials->count() > 0)
        <!--Testimonial start-->

        <div class="title6 section-t-space">
            <h2 class="font-fraunces">
                {{ __('Testimonials') }}
            </h2>
        </div>

        <section class="testimonial small-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="slide-3 testimonial-slider no-arrow">

                            @foreach ($testimonials as $testimonial)
                                <div>
                                    <div class="media d-flex justify-content-center">
                                        <div class="text-center">
                                            <img src="{{ asset($testimonial->media->path) }}" alt="#">
                                            <h5>{{ getName($testimonial) }}</h5>
                                            <h6>{{ app()->getLocale() == 'ar' ? $testimonial->title_ar : $testimonial->title_en }}
                                            </h6>
                                        </div>
                                        <div style="width:100;" class="media-body text-center">
                                            <p>{{ app()->getLocale() == 'ar' ? $testimonial->description_ar : $testimonial->description_en }}
                                            </p>
                                            <div class="rating">
                                                {!! getTistimonialStars($testimonial) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Testimonial ends-->
    @endif


    <!-- service section start -->
    <section class="service section-b-space bg-light">
        <div class="container">
            <div class="row partition4 ">
                @if (websiteSettingAr('icon_1') || websiteSettingEN('icon_1'))
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img src="{{ asset(websiteSettingMedia('icon_1')) }}" alt="">
                        <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_1') : websiteSettingEn('icon_1') }}
                        </h4>
                        <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_1') : websiteSettingDEn('icon_1') }}
                        </p>
                    </div>
                @endif
                @if (websiteSettingAr('icon_2') || websiteSettingEN('icon_2'))
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img src="{{ asset(websiteSettingMedia('icon_2')) }}" alt="">
                        <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_2') : websiteSettingEn('icon_2') }}
                        </h4>
                        <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_2') : websiteSettingDEn('icon_2') }}
                        </p>
                    </div>
                @endif

                @if (websiteSettingAr('icon_3') || websiteSettingEN('icon_3'))
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img src="{{ asset(websiteSettingMedia('icon_3')) }}" alt="">
                        <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_3') : websiteSettingEn('icon_3') }}
                        </h4>
                        <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_3') : websiteSettingDEn('icon_3') }}
                        </p>
                    </div>
                @endif

                @if (websiteSettingAr('icon_4') || websiteSettingEN('icon_4'))
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img src="{{ asset(websiteSettingMedia('icon_4')) }}" alt="">
                        <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_4') : websiteSettingEn('icon_4') }}
                        </h4>
                        <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_4') : websiteSettingDEn('icon_4') }}
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!-- service section end -->


    @if (websiteSettingDAr('seller_section_des') && websiteSettingDEn('seller_section_des'))
        <!-- start selling section start -->
        <section class="start-selling section-b-space">
            <div class="container">
                <div class="col">
                    <div>
                        <h4>{{ __('start selling') }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('seller_section_des') : websiteSettingDEn('seller_section_des') }}
                        </p>

                        <a href="{{ route('register') }}" target="_blank"
                            class="btn btn-solid btn-sm">{{ __('register as a seller') }}</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- start selling section end -->
    @endif




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

    @foreach ($top_collections as $product)
        @include('ecommerce._product_modal', [
            'product' => $product,
        ])
    @endforeach

    @foreach ($best_selling as $product)
        @include('ecommerce._product_modal', [
            'product' => $product,
        ])
    @endforeach

    @foreach ($is_featured as $product)
        @include('ecommerce._product_modal', [
            'product' => $product,
        ])
    @endforeach

    @foreach ($on_sale as $product)
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


    <!-- added to fav notification -->
    <div class="added-notification fav-noty">
        <h3>{{ __('added to wishlist') }}</h3>
    </div>
    <!-- added to fav notification -->

    @if (Auth::check())
        @if (session('modal_auth_count') == null)
            @php
                session(['modal_auth_count' => 1]);
            @endphp
        @else
            @php
                session(['modal_auth_count' => session('modal_auth_count') + 1]);
            @endphp
        @endif
    @else
        @if (session('modal_count') == null)
            @php
                session(['modal_count' => 1]);
            @endphp
        @else
            @php
                session(['modal_count' => session('modal_count') + 1]);
            @endphp
        @endif
    @endif

    @if ((Auth::check() && session('modal_auth_count') < 4) || (!Auth::check() && session('modal_count') < 4))
        @include('layouts.ecommerce._modal', [
            'type' => Auth::check() ? 'front_auth' : 'front',
        ])
    @endif



@endsection
