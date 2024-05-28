<div class="product-box product-wrap product-style-3">
    <div class="img-wrapper">

        @if (getOffers('product_page_sticker', $product)->count() > 0)
            @php
                $offer = getOffers('product_page_sticker', $product)->first();
            @endphp

            <div class="lable-block">
                <span class="lable3">{{ getName($offer) }}</span>
                {{-- <span class="lable4">on sale</span> --}}
            </div>
        @endif




        <div class="front">
            <a
                href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}"><img
                    alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"
                    src="{{ getProductImage($product) }}" class="img-fluid blur-up lazyload bg-img"></a>
        </div>
        <div class="back">
            <a
                href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}"><img
                    src="{{ getProductImage2($product) }}" class="img-fluid blur-up lazyload bg-img"
                    alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}"></a>
        </div>
        <div class="cart-detail">
            <a href="javascript:void(0)" class="add-fav" title="{{ __('Add to Wishlist') }}"
                data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                data-product_id="{{ $product->id }}"><i
                    style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                    class="fa fa-heart fav-{{ $product->id }} " aria-hidden="true"></i></a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-{{ $product->id }}"
                title="{{ __('Quick View') }}"><i class="ti-search" aria-hidden="true"></i></a>
            {{-- <a href="compare.html" title="Compare"><i class="ti-reload"
                aria-hidden="true"></i></a> --}}
        </div>
    </div>
    <div class="product-info">
        @if (
            $product->vendor_id != null &&
                getUserInfo($product->vendor) != null &&
                getUserInfo($product->vendor)->store_name != null &&
                checkUserInfo($product->vendor))
            <a
                href="{{ route('store.show', ['user' => $product->vendor->id, 'store_name' => getUserInfo($product->vendor)->store_name]) }}">
                <span class="badge badge-grey-color">{{ getUserInfo($product->vendor)->store_name }}</span>
            </a>
        @endif
        <div class="">{!! getAverageRatingWithStars($product) !!}
        </div>
        <a
            href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}">
            <h6>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
            </h6>
        </a>
        {!! getProductPrice($product) !!}
        @if ($product->product_type != 'variable' && $product->can_rent == null)
            <div class="add-btn">
                <a href="javascript:void(0)" class="add-to-cart" data-url="{{ route('ecommerce.cart.store') }}"
                    data-locale="{{ app()->getLocale() }}" data-product_id="{{ $product->id }}"
                    data-image="{{ getProductImage($product) }}">
                    <div style="display: none; color: #999999; margin: 3px; padding: 6px;"
                        class="spinner-border spinner-border-sm spinner spin-{{ $product->id }}" role="status">
                    </div>
                    <i class="fa fa-shopping-cart cart-icon-{{ $product->id }} me-1" aria-hidden="true"></i>
                    <span class="cart-text-{{ $product->id }}">{{ __('add to cart') }}</span>
                    <span class="cart-added-{{ $product->id }}"
                        style="display: none;">{{ __('Added to bag') }}</span>
                </a>
            </div>
        @else
            <div class="add-btn">
                <a href="3" data-bs-toggle="modal" data-bs-target="#quick-view-{{ $product->id }}">
                    <i class="fa fa-shopping-cart cart-icon-{{ $product->id }} me-1" aria-hidden="true"></i>
                    <span>{{ __('add to cart') }}</span>
                </a>
            </div>
        @endif
    </div>
</div>
