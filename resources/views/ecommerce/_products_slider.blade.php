<div class="theme-card">
    <h5 class="title-border">{{ __($type) }}</h5>
    <div class="offer-slider slide-1">


        @php
            $i = 0;
        @endphp

        @foreach ($products as $index => $product)
            @if ($i % 3 === 0)
                <div>
            @endif

            <div class="media">
                <a href="{{ route('ecommerce.product', ['product' => $product->id]) }}"><img
                        class="img-fluid blur-up lazyload"
                        src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : getImage($product->images[0])) }}"
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
                                data-url="{{ route('ecommerce.cart.store') }}" data-locale="{{ app()->getLocale() }}"
                                data-product_id="{{ $product->id }}"
                                data-image="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : getImage($product->images[0])) }}">
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

            @if ($i % 3 === 2)
    </div>
    @endif
    @php
        $i++;
    @endphp
    @endforeach

    @if ($i % 3 !== 0)
</div>
@endif


</div>
</div>
