@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div style="height: 500px" class="product-slider" id="galleryTop">
                        @php
                            $count = productImagesCount($product);
                        @endphp
                        <div class="swiper-container theme-slider position-lg-absolute all-0"
                            data-swiper='{"spaceBetween":{{ $count }},"loop":true,"loopedSlides":{{ $count }},"thumb":{"spaceBetween":{{ $count }},"slidesPerView":5,"freeMode":true,"grabCursor":true,"loopedSlides":{{ $count }},"centeredSlides":true,"slideToClickedSlide":true,"watchSlidesVisibility":true,"watchSlidesProgress":true,"parent":"#galleryTop"},"slideToClickedSlide":true}'>
                            <div id="allImages" class="swiper-wrapper h-100">
                                @foreach ($product->images as $image)
                                    <div class="swiper-slide"><a class="d-block" href="#!"><img
                                                class="rounded-top img-fluid"
                                                src="{{ asset('storage/images/products/' . $image->image) }}"
                                                alt="" /></a></div>
                                @endforeach

                                @php
                                    $stocks = $product->stocks->unique('color_id');
                                @endphp

                                @foreach ($stocks as $stock)
                                    @if ($stock->image != null)
                                        <div class="swiper-slide" id="{{ 'slide-' . $stock->id }}">
                                            <a class="d-block" href="#!"><img class="rounded-top img-fluid"
                                                    src="{{ asset('storage/images/products/' . $stock->image) }}"
                                                    alt="" /></a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="swiper-nav">
                                <div class="swiper-button-next swiper-button-white"></div>
                                <div class="swiper-button-prev swiper-button-white"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h5>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h5>
                    @foreach ($product->categories as $category)
                        <a class="fs--1 mb-2"
                            href="{{ route('affiliate.products.category', ['category' => $category->id]) }}">
                            {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                        </a>
                    @endforeach
                    <br>
                    <span class="fs--1">SKU: <strong class="text-success">{{ $product->sku }}</strong></span>
                    <span class="fs--1 mr-1 ml-1">{{ __('Stock') }}: <strong
                            class="text-success">{{ __('Available') }}</strong></span>


                    <p class="mt-2">{{ __('Available Colors') }}</p>
                    <div class="col-12">

                        @php
                            $stocks = $product->stocks->unique('color_id');
                        @endphp

                        @foreach ($stocks as $index => $stock)
                            @if ($stock->image != null)
                                {{-- <div class="inline-block">
                                    <div>
                                        <input type="radio" id="option{{ $index + 1 }}" name="color-select"
                                            value="{{ $stock->id }}" data-product_id="{{ $product->id }}"
                                            data-color_id="{{ $stock->color_id }}" data-stock_id="{{ $stock->id }}"
                                            checked>
                                        <label for="option{{ $index + 1 }}">
                                            <span class="span">
                                                <img src="https://www.freepik.com/free-vector/white-vector-check-mark-tick-circle-conceptual_16305250.htm#query=check&position=7&from_view=keyword"
                                                    alt="Checked Icon" />
                                            </span>
                                        </label>
                                    </div>
                                </div> --}}

                                <input type="radio" class="btn btn-check color-select" value="{{ $stock->id }}"
                                    name="color-select" id="option{{ $index + 1 }}"
                                    data-product_id="{{ $product->id }}" data-color_id="{{ $stock->color_id }}"
                                    data-stock_id="{{ $stock->id }}">


                                <label style="position: relative" class=" btn-falcon-default rounded-circle"
                                    for="option{{ $index + 1 }}"><span style="color:{{ $stock->color->hex }}"
                                        class=" fas fa-solid fa-circle fa-2x"></span></label>
                                {{-- {{ app()->getLocale() == 'ar' ? $stock->color->color_ar : $stock->color->color_en }} --}}
                            @else
                                <input type="radio" class="btn-check rounded-circle color-select"
                                    value="{{ $stock->id }}" name="color-select" id="option{{ $index + 1 }}"
                                    data-stock_id="{{ $stock->id }}" data-color_id="{{ $stock->color_id }}"
                                    data-product_id="{{ $product->id }}">
                                <label style="position: relative" class="btn-falcon-default rounded-circle"
                                    for="option{{ $index + 1 }}"><span style="color:{{ $stock->color->hex }}"
                                        class="fas fa-solid fa-circle fa-2x"></span></label>
                            @endif
                        @endforeach

                    </div>

                    <p class="mt-2">{{ __('Available Sizes') }}</p>
                    <div class="col-12">
                        @foreach ($product->stocks as $index => $stock)
                            <input type="radio" class="btn-check stock-select" name="stock-select"
                                value="{{ $stock->id }}" id="options{{ $index + 1 }}"
                                data-product_id="{{ $product->id }}" data-locale="{{ app()->getLocale() }}"
                                data-limit={{ $product->unlimited != 0 ? 'unlimited' : 'limited' }}
                                data-quantity="{{ $stock->quantity }}" data-stock_id="{{ $stock->id }}">
                            <label
                                class="btn btn-falcon-default all-labels-{{ $product->id }} selected-labels-{{ $product->id }}-{{ $stock->color_id }}"
                                for="options{{ $index + 1 }}"
                                style="{{ $stock->color_id == $stocks[0]->color_id ? 'display:inline-block;' : 'display:none' }}"><span>{{ app()->getLocale() == 'ar' ? $stock->size->size_ar : $stock->size->size_en }}</span>

                                <span class="d-block">{{ __('Quantity:') }}<span
                                        class="av-qu-{{ $product->id }}-{{ $stock->id }}"></span></span></label>
                        @endforeach
                    </div>



                    <div class="row mt-3">
                        <div class="col-12">
                            <div>
                                <h4
                                    style="display: inline-block; {{ app()->getLocale() == 'ar' ? 'margin-left:12px' : 'margin-right:12px' }}">
                                    {{ __('Price:') }} </h4>

                                <input class="form-control d-inline text-center product-price" type="number" name="price"
                                    min="{{ $product->price }}" max="{{ $product->max_price }}"
                                    value="{{ priceWithCommission($product) }}" style="max-width: 200px"
                                    data-product_id="{{ $product->id }}" data-max="{{ $product->max_price }}"
                                    data-min="{{ $product->price }}" />

                            </div>
                        </div>
                    </div>
                    <h4 class="d-flex align-items-center mt-2">
                        <span
                            style="{{ app()->getLocale() == 'ar' ? 'margin-left:12px' : 'margin-right:12px' }}">{{ __('Profit:') }}</span>
                        <span class="text-warning me-2">
                            <span id="aff_comm{{ $product->id }}">
                                {{ priceWithCommission($product) - $product->price }}
                            </span>
                            {{ ' ' . $product->country->currency }}
                        </span>
                    </h4>


                    <div class="row">
                        <div class="col-auto pe-0">
                            <div class="input-group input-group-sm" data-quantity="data-quantity">
                                <button class="btn btn-sm btn-outline-secondary border-300" data-field="input-quantity"
                                    data-type="minus">-</button>
                                <input
                                    class="form-control text-center input-quantity input-spin-none quantity-{{ $product->id }}"
                                    type="number" name="quantity" min="1" max="10" value="1"
                                    aria-label="Amount (to the nearest dollar)" style="max-width: 50px" />
                                <button class="btn btn-sm btn-outline-secondary border-300" data-field="input-quantity"
                                    data-type="plus">+</button>
                            </div>
                        </div>
                        <div class="col-auto px-2 px-md-3"><button class="btn btn-sm btn-primary add-cart"
                                data-url="{{ route('cart.store') }}" data-locale="{{ app()->getLocale() }}"
                                data-product_id="{{ $product->id }}" data-product_price="{{ $product->price }}"
                                data-product_type="0" href="#!">
                                <div style="display: none" class="spinner-border text-info spinner-border-sm spinner"
                                    role="status">
                                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                                </div>
                                <span class="fas fa-cart-plus me-sm-2 cart-icon"></span>
                                <span class="d-none d-sm-inline-block">{{ __('Add To Cart') }}</span>
                            </button></div>

                        <div class="col-auto px-1 px-md-2"><button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#mystore-modal">
                                <span class=" d-none d-sm-inline-block">{{ __('Add To My Store') }}</span>
                            </button>
                        </div>

                        <div class="col-auto px-0"><a class="btn btn-sm btn-outline-danger border-300 add-fav"
                                href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Wish List"
                                data-id="{{ $product->id }}"
                                data-url="{{ route('favorite.add', ['product' => $product->id]) }}"><span
                                    class="{{ Auth::user()->fav()->where('product_id', $product->id)->where('user_id', Auth::id())->get()->count() == 0? 'far': 'fas' }} fa-heart me-1 {{ 'fav-' . $product->id }}"></span></a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-6 mt-4">
                    <button onclick="downloadAll()" class="btn btn-falcon-primary me-1 mb-1"
                        type="button">{{ __('Download all product images') }}
                    </button>
                </div>
                <div class="col-6 mt-4">
                    <div style="display:none !important"
                        class="alert alert-danger border-2 align-items-center alarm-{{ $product->id }}" role="alert">
                        <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                        </div>
                        <p class="mb-0 flex-1 alarm-text-{{ $product->id }}"></p>
                    </div>
                    <div style="display:none !important"
                        class="alert alert-success border-2 align-items-center alarm-success-{{ $product->id }}"
                        role="alert">
                        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span>
                        </div>
                        <p class="mb-0 flex-1 alarm-success-text-{{ $product->id }}"></p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="overflow-hidden mt-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active ps-0" id="description-tab"
                                    data-bs-toggle="tab" href="#tab-description" role="tab"
                                    aria-controls="tab-description" aria-selected="true">Description</a></li>
                            <li class="nav-item"><a class="nav-link px-2 px-md-3" id="reviews-tab" data-bs-toggle="tab"
                                    href="#tab-reviews" role="tab" aria-controls="tab-reviews"
                                    aria-selected="false">Reviews</a></li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div class="mt-3">
                                    {!! app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="row mt-3">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        @foreach ($product->reviews as $review)
                                            <div class="mb-1">

                                                {!! getRatingWithStars($review->rating) !!}

                                                <span
                                                    class="ms-3 text-dark fw-semi-bold">{{ $review->user->name }}</span>
                                            </div>
                                            <p class="fs--1 mb-2 text-600">{{ interval($review->created_at) }}</p>
                                            <p class="mb-0">{{ $review->review }}</p>
                                            <hr class="my-4" />
                                        @endforeach
                                        @if ($product->reviews->count() == 0)
                                            <p>{{ __('There are no reviews for the product') }}</p>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 ps-lg-5">
                                        <form method="POST"
                                            action="{{ route('reviews.affiliate.index', ['product' => $product->id]) }}">
                                            @csrf

                                            <h5 class="mb-3">Write your Review</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Ratting: </label>
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

                                            <div class="mb-3">
                                                <label class="form-label" for="review">Review:</label>
                                                <textarea class="form-control @error('review') is-invalid @enderror" id="review" rows="3" name="review"
                                                    required></textarea>
                                                @error('review')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- start bonus modal for each user -->
    <div class="modal fade" id="mystore-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('mystore.store', ['product' => $product->id]) }}">
                    @csrf
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">
                                {{ __('Add product to my store') }}
                            </h4>
                        </div>

                        <div class="alert alert-info m-2" role="alert">
                            {{ __('Add the price of the product that will be displayed on your store page.') }}</div>

                        <div class="p-4 pb-0">

                            <div class="mb-3">
                                <label class="form-label" for="store_price">{{ __('Suggested selling price') }}</label>
                                <input name="store_price"
                                    class="form-control product-price-store @error('store_price') is-invalid @enderror"
                                    value="{{ priceWithCommission($product) }}" type="number" autocomplete="on"
                                    id="store_price" min="{{ $product->price }}" max="{{ $product->max_price }}"
                                    data-product_id="{{ $product->id }}" data-max="{{ $product->max_price }}"
                                    data-min="{{ $product->price }}" autofocus required />
                                @error('store_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" style="display: none">

                                <input name="product_price"
                                    class="form-control @error('product_price') is-invalid @enderror"
                                    value="{{ $product->price }}" type="number" autocomplete="on" id="product_price"
                                    autofocus required />
                                @error('product_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <small style="font-size: 20px" class="text-warning me-2">{{ __('Profit:') }} <span
                                        id="aff_comm_store{{ $product->id }}">{{ priceWithCommission($product) - $product->price }}</span>
                                    {{ ' ' . $product->country->currency }} </small>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-primary" type="submit">{{ __('Add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end bonus modal for each user -->
@endsection
