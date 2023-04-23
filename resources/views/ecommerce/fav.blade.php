@extends('layouts.ecommerce.app', ['page_title' => 'Wishlist'])
@section('content')


@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('Wishlist') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Wishlist') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->



    <!--section start-->
    <section class="wishlist-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 table-responsive-xs">
                    <table class="table cart-table">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">{{ __('image') }}</th>
                                <th scope="col">{{ __('product') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        @foreach (getFavs() as $fav)
                            <tbody>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset($fav->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $fav->product->images[0]->media->path) }}"
                                                class="blur-up lazyloaded" alt="">
                                        </a>
                                    </td>
                                    <td><a
                                            href="{{ route('ecommerce.product', ['product' => $fav->product->id]) }}">{{ app()->getLocale() == 'ar' ? $fav->product->name_ar : $fav->product->name_en }}</a>
                                        <div class="mobile-cart-content row">
                                            <div class="col">
                                                <p></p>
                                            </div>
                                            <div class="col">
                                                <h2 class="td-color"></h2>
                                            </div>
                                            <div class="col">
                                                <h2 class="td-color"><a
                                                        href="{{ route('ecommerce.fav.add', ['product' => $fav->product->id]) }}"
                                                        class="icon me-1"><i class="ti-close"></i>
                                                    </a>
                                                    {{-- <a href="#" class="cart"><i
                                                            class="ti-shopping-cart"></i></a> --}}
                                                </h2>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h2></h2>
                                    </td>
                                    <td>
                                        <p></p>
                                    </td>
                                    <td><a href="{{ route('ecommerce.fav.add', ['product' => $fav->product->id]) }}"
                                            class="icon me-3"><i class="ti-close"></i> </a>
                                        {{-- <a href="#" class="cart"><i class="ti-shopping-cart"></i></a> --}}
                                    </td>

                                </tr>
                            </tbody>
                        @endforeach


                    </table>
                </div>
            </div>
            {{-- <div class="row wishlist-buttons">
                <div class="col-12"><a href="#" class="btn btn-solid">continue shopping</a> <a href="#"
                        class="btn btn-solid">check out</a></div>
            </div> --}}
        </div>
    </section>
    <!--section end-->

@endsection
