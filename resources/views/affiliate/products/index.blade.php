@extends('layouts.dashboard.app')

@section('adminContent')
    @if ($slides1->count() != 0)
        <div class="row mb-3">
            <div class="col-lg-12 mb-4 mb-lg-0">
                <div class="swiper-container theme-slider"
                    data-swiper='{"autoplay":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"slideToClickedSlide":true}'>
                    <div class="swiper-wrapper">
                        @foreach ($slides1 as $slide)
                            <div class="swiper-slide">
                                <a href="{{ $slide->url }}" target="_blank">
                                    <img class="rounded-1 img-fluid"
                                        src="{{ asset('storage/images/slides/' . $slide->image) }}" alt="" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-nav">
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"> </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



    @if ($categories->count() > 0)
        <div class="card mb-3">
            <div class="card-body">
                <h5 style="color:#344050" class="text-center mb-3">{{ __('Categories') }}</h5>
                <div class="container">
                    <div class="row sonoo">
                        @foreach ($categories as $category)
                            <div class="mb-2 col-md-2 col-sm-4 col-3">
                                <div style="text-align: center">
                                    <a href="{{ route('affiliate.products.category', ['category' => $category->id]) }}">
                                        <img style="width:100%;"
                                            src="{{ asset('storage/images/categories/' . $category->image) }}"
                                            alt="{{ app()->getLocale() == 'ar' ? $category->description_ar : $category->description_en }}"
                                            class=" p-2 img-responsive center-block d-block mx-auto"></a>

                                    <div class="cat-title">
                                        <div style="text-align: center" class="mb-1">
                                            <a
                                                href="{{ route('affiliate.products.category', ['category' => $category->id]) }}">{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if ($products->count() > 0)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-sm-auto mb-2 mb-sm-0">
                        <h6 class="mb-0">
                            {{ __('Showing 1-') }}{{ $products->count() }}{{ __('of Products') }} </h6>
                    </div>
                    <div class="col-sm-auto">
                        <div class="row gx-2 align-items-center">
                            <div class="col-auto">
                                <form class="row gx-2">
                                    <div class="col-auto"><small>{{ __('Sort by:') }}</small></div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions">
                                            <option selected="">{{ __('Best Match') }}</option>
                                            <option value="Refund">{{ __('Newest') }}</option>
                                            <option value="Delete">{{ __('Price') }}</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="col-auto pe-0"> <a class="text-600 px-1"
                                href="../../../app/e-commerce/product/product-list.html" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Product List"><span class="fas fa-list-ul"></span></a></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="card mb-3">
        <div class="card-body">
            <div class="row">

                @if ($products->count() == 0)
                    <div class="col-md-12">
                        <p>{{ __('There are currently no products to display in this section... Please check back later') }}
                        </p>
                    </div>
                @else
                    @foreach ($products as $product)
                        <div class="mb-4 col-md-6 col-lg-3">
                            <div class="border rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                                <div class="overflow-hidden">
                                    <div class="position-relative rounded-top overflow-hidden">
                                        <div style="height: 180px" class="swiper-container theme-slider"
                                            data-swiper='{"autoplay":true,"autoHeight":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"navigation":{"nextEl":".swiper-button-next","prevEl":".swiper-button-prev"}}'>
                                            <div class="swiper-wrapper">

                                                @foreach ($product->images as $image)
                                                    <div class="swiper-slide"><a class="d-block"
                                                            href="{{ route('affiliate.products.product', ['product' => $product->id]) }}"><img
                                                                class="rounded-top img-fluid"
                                                                src="{{ asset('storage/images/products/' . $image->image) }}"
                                                                alt="" /></a></div>
                                                @endforeach

                                                @php
                                                    $stocks = $product->stocks->unique('color_id');
                                                @endphp

                                                @foreach ($stocks as $stock)
                                                    @if ($stock->image != null)
                                                        <div class="swiper-slide"><a class="d-block"
                                                                href="{{ route('affiliate.products.product', ['product' => $product->id]) }}"><img
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
                                            class="badge rounded-pill bg-success position-absolute mt-2 me-2 z-index-2 top-0 end-0">{{ 'SKU: ' . $product->sku }}</span>
                                    </div>
                                    <div class="p-3">
                                        <h5 class="fs-0"><a class="text-dark"
                                                href="{{ route('affiliate.products.product', ['product' => $product->id]) }}">
                                                {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                            </a></h5>
                                        <p class="fs--1 mb-3">
                                            @foreach ($product->categories as $category)
                                                <a class="text-500"
                                                    href="{{ route('affiliate.products.category', ['category' => $category->id]) }}">
                                                    {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                                </a>
                                            @endforeach
                                        </p>
                                        <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3">
                                            {{ priceWithCommission($product) }}
                                            {{ ' ' . $product->country->currency }}
                                        </h5>
                                        <p class="fs--1 mb-1">Profit:
                                            <strong>{{ priceWithCommission($product) - $product->price }}
                                                {{ ' ' . $product->country->currency }}</strong>
                                        </p>
                                        <p class="fs--1 mb-1">{{ __('Stock:') }} <strong
                                                class="text-success">{{ __('Available') }}</strong>
                                        </p>
                                        {{-- <p class="fs--1 mb-1">Stock: <strong class="text-danger">Sold-Out</strong> --}}

                                    </div>
                                </div>
                                <div class="d-flex flex-between-center px-3">
                                    <div>

                                        {!! getAverageRatingWithStars($product) !!}

                                        <span class="ms-1">({{ getRatingCount($product) }})</span>


                                    </div>
                                    <div>
                                        <a class="btn btn-sm btn-falcon-default me-2 add-fav" href="#!"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Wish List"
                                            data-id="{{ $product->id }}"
                                            data-url="{{ route('favorite.add', ['product' => $product->id]) }}">
                                            <span
                                                class="{{ Auth::user()->fav()->where('product_id', $product->id)->where('user_id', Auth::id())->get()->count() == 0? 'far': 'fas' }} fa-heart {{ 'fav-' . $product->id }}"></span>
                                        </a>
                                        <a class="btn btn-sm btn-falcon-default"
                                            href="{{ route('affiliate.products.product', ['product' => $product->id]) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View Product">
                                            <span class="fas fa-eye"></span>
                                        </a>
                                    </div>
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



    @if ($slides2->count() != 0)
        <div class="row mb-3">
            <div class="col-lg-12 mb-4 mb-lg-0">
                <div class="swiper-container theme-slider"
                    data-swiper='{"autoplay":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"slideToClickedSlide":true}'>
                    <div class="swiper-wrapper">
                        @foreach ($slides2 as $slide)
                            <div class="swiper-slide">
                                <a href="{{ $slide->url }}" target="_blank">
                                    <img class="rounded-1 img-fluid"
                                        src="{{ asset('storage/images/slides/' . $slide->image) }}" alt="" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-nav">
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"> </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Modal -->
    <div style="{{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }}" class="modal fade"
        id="affiliateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ setting('affiliate_modal_title') }}</h5>
                    <button style="{{ app()->getLocale() == 'ar' ? 'margin:0' : '' }}" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    {{ setting('affiliate_modal_body') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection
