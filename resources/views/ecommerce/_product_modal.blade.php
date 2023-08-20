<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view-{{ $product->id }}" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div style="background: #ffffff" class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="{{ getProductImage($product) }}" alt=""
                                class="img-fluid blur-up lazyload"></div>
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
                            <div class="product-description border-product product-attributes-{{ $product->id }}">
                                @if ($product->product_type == 'variable')
                                    @foreach ($product->attributes as $attribute)
                                        @if (
                                            $attribute->name_en == 'color' ||
                                                $attribute->name_en == 'colors' ||
                                                $attribute->name_en == 'Color' ||
                                                $attribute->name_en == 'Colors')
                                            <div class="row">
                                                <div class="col-md-3 d-flex justify-content-center align-items-center">
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
                                                                data-currency="{{ $product->country->currency }}"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="{{ getName($variation->variation) }}">
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                                    <h4>{{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                                    </h4>

                                                </div>
                                                <div class="col-md-9">
                                                    <div class="size-box attribute-box-{{ $attribute->id }}">

                                                        @if ($attribute->type == 'select')
                                                            <select>

                                                                <option value="">
                                                                    {{ __('Select') . ' ' . getName($attribute) }}
                                                                </option>
                                                                @foreach ($product->variations->where('attribute_id', $attribute->id) as $index => $variation)
                                                                    <option class="attribute-select"
                                                                        data-attribute-id="{{ $attribute->id }}"
                                                                        data-variation-id="{{ $variation->variation->id }}"
                                                                        data-product-id="{{ $product->id }}"
                                                                        data-url="{{ route('ecommerce.product.price') }}"
                                                                        data-locale="{{ app()->getLocale() }}"
                                                                        data-currency="{{ $product->country->currency }}">
                                                                        {{ app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en }}
                                                                    </option>
                                                                @endforeach


                                                            </select>
                                                        @else
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
                                                        @endif

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
                                            <button type="button" class="btn quantity-left-minus" data-type="minus"
                                                data-field=""><i
                                                    class="ti-angle-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity"
                                            class="form-control qty-input input-number" value="1"
                                            data-min="{{ $product->product_min_order }}"
                                            data-max="{{ $product->product_max_order }}" disabled>
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus"
                                                data-field=""><i
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
                                    data-locale="{{ app()->getLocale() }}" data-product_id="{{ $product->id }}"
                                    data-image="{{ getProductImage($product) }}">

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


                                </a>

                                <a style="display: none" href="{{ route('ecommerce.checkout') }}"
                                    class="btn btn-solid pay-now"><i class="fa fa-money fz-16 me-2"
                                        aria-hidden="true"></i>{{ __('pay now') }}</a>

                                <a href="#"
                                    data-url="{{ route('ecommerce.fav.add', ['product' => $product->id]) }}"
                                    data-product_id="{{ $product->id }}" class="btn btn-solid btn-sm add-fav"><i
                                        style="{{ getFavs()->where('product_id', $product->id)->count() == 0? '': 'color:#f01c1c;' }}"
                                        class="fa fa-heart fav-{{ $product->id }} fz-16 me-2"
                                        aria-hidden="true"></i>{{ __('wishlist') }}</a>


                                <a href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}"
                                    class="btn btn-solid btn-sm">{{ __('view detail') }}</a>


                            </div>

                            <div class="col-6 mt-4">
                                <div style="display:none !important"
                                    class="alert alert-danger border-2 align-items-center alarm-{{ $product->id }}"
                                    role="alert">
                                    <div class="bg-danger me-3 icon-item"><i
                                            class="fa fa-exclamation-circle text-white fs-3"></i>
                                    </div>
                                    <p class="mb-0 flex-1 alarm-text-{{ $product->id }}"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
