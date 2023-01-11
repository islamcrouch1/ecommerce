@extends('layouts.ecommerce.app')
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
                    <nav style="direction: ltr; float:{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                        aria-label="breadcrumb" class="theme-breadcrumb">
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
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card dashboard-table mt-0">
                        <div class="card-body table-responsive-sm">

                            <div class="table-responsive-xl">
                                <table class="table cart-table wishlist-table">
                                    <thead>
                                        <tr class="table-head">
                                            <th scope="col">{{ __('image') }}</th>
                                            <th scope="col">{{ __('product') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (getFavs() as $fav)
                                            <tr>
                                                <td style="text-align: center">
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset($fav->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $fav->product->images[0]->media->path) }}"
                                                            class="blur-up lazyloaded" alt="">
                                                    </a>
                                                </td>

                                                <td style="text-align: center">
                                                    <span>{{ app()->getLocale() == 'ar' ? $fav->product->name_ar : $fav->product->name_en }}
                                                    </span>
                                                </td>

                                                <td style="text-align: center">
                                                    <a href="{{ route('ecommerce.product', ['product' => $fav->product->id]) }}"
                                                        class="btn btn-xs btn-solid">
                                                        {{ __('View') }}
                                                    </a>

                                                    <a href="{{ route('ecommerce.fav.add', ['product' => $fav->product->id]) }}"
                                                        class="btn btn-xs  btn-danger">
                                                        {{ __('remove') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach




                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>



@endsection
