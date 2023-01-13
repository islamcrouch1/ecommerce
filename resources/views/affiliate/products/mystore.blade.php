@extends('layouts.dashboard.app')

@section('adminContent')






    <div class="card mb-3">

        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('My Store Products') }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">

                @if ($products->count() == 0)
                    <div class="col-md-12">
                        <p>{{ __('There are currently no products to display in this section... Please check back later') }}
                        </p>
                    </div>
                @else
                    <h6 class="alert alert-info" role="alert">
                        {{ __('The prices shown on the products are the prices that will be shown to your customers on your sale page and the commission that you will get when selling') }}
                    </h6>

                    @foreach ($products as $product)
                        <div class="mb-4 col-md-6 col-lg-3">
                            <div class="border rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                                <div class="overflow-hidden">
                                    <div class="position-relative rounded-top overflow-hidden">
                                        <div style="height: 180px" class="swiper-container theme-slider"
                                            data-swiper='{"autoplay":true,"autoHeight":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"navigation":{"nextEl":".swiper-button-next","prevEl":".swiper-button-prev"}}'>
                                            <div class="swiper-wrapper">

                                                @foreach ($product->product->images as $image)
                                                    <div class="swiper-slide"><a class="d-block"
                                                            href="{{ route('affiliate.products.product', ['product' => $product->product->id]) }}"><img
                                                                class="rounded-top img-fluid"
                                                                src="{{ asset('storage/images/products/' . $image->image) }}"
                                                                alt="" /></a></div>
                                                @endforeach

                                                @php
                                                    $stocks = $product->product->stocks->unique('color_id');
                                                @endphp

                                                @foreach ($stocks as $stock)
                                                    @if ($stock->image != null)
                                                        <div class="swiper-slide"><a class="d-block"
                                                                href="{{ route('affiliate.products.product', ['product' => $product->product->id]) }}"><img
                                                                    class="rounded-top img-fluid"
                                                                    src="{{ asset('storage/images/products/' . $stock->image) }}"
                                                                    alt="" /></a></div>
                                                    @endif
                                                @endforeach

                                            </div>
                                            <div class="swiper-nav">
                                                <div class="swiper-button-next swiper-button-white"></div>
                                                <div class="swiper-button-prev swiper-button-white"></div>
                                            </div>
                                        </div><span
                                            class="badge rounded-pill bg-success position-absolute mt-2 me-2 z-index-2 top-0 end-0">{{ 'SKU: ' . $product->product->sku }}</span>
                                    </div>
                                    <div class="p-3">
                                        <h5 class="fs-0"><a class="text-dark"
                                                href="{{ route('affiliate.products.product', ['product' => $product->product->id]) }}">
                                                {{ app()->getLocale() == 'ar' ? $product->product->name_ar : $product->product->name_en }}
                                            </a></h5>
                                        <p class="fs--1 mb-3">
                                            @foreach ($product->product->categories as $category)
                                                <a class="text-500"
                                                    href="{{ route('affiliate.products.category', ['category' => $category->id]) }}">
                                                    {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                                </a>
                                            @endforeach
                                        </p>
                                        <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3">
                                            {{ $product->store_price }}
                                            {{ ' ' . $product->product->country->currency }}
                                        </h5>
                                        <p class="fs--1 mb-1">Profit:
                                            <strong>{{ $product->store_price - $product->product_price }}
                                                {{ ' ' . $product->product->country->currency }}</strong>
                                        </p>
                                        <p class="fs--1 mb-1">{{ __('Stock:') }} <strong
                                                class="text-success">{{ __('Available') }}</strong>
                                        </p>
                                        {{-- <p class="fs--1 mb-1">Stock: <strong class="text-danger">Sold-Out</strong> --}}

                                    </div>
                                </div>
                                <div class="d-flex flex-between-center px-3">
                                    {{-- <div>

                                        {!! getAverageRatingWithStars($product->product) !!}

                                        <span class="ms-1">({{ getRatingCount($product->product) }})</span>


                                    </div> --}}
                                    <div>
                                        <a class="btn btn-sm btn-falcon-default me-2 add-fav" href="#!"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Wish List"
                                            data-id="{{ $product->product->id }}"
                                            data-url="{{ route('favorite.add', ['product' => $product->product->id]) }}">
                                            <span
                                                class="{{ Auth::user()->fav()->where('product_id', $product->product->id)->where('user_id', Auth::id())->get()->count() == 0? 'far': 'fas' }} fa-heart {{ 'fav-' . $product->product->id }}"></span>
                                        </a>
                                        <a class="btn btn-sm btn-falcon-default me-2"
                                            href="{{ route('affiliate.products.product', ['product' => $product->product->id]) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View Product">
                                            <span class="fas fa-eye"></span>
                                        </a>

                                        <a class="btn btn-sm btn-falcon-default me-2"
                                            href="{{ route('mystore.destroy', ['product' => $product->id]) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View Product">
                                            <span class="fas fa-trash"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="px-3 mt-2">

                                    {!! getAverageRatingWithStars($product->product) !!}

                                    <span class="ms-1">({{ getRatingCount($product->product) }})</span>


                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>



@endsection
