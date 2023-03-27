@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit Product') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_ar">{{ __('product name') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ $product->name_ar }}" type="text" autocomplete="on" id="name_ar"
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_en">{{ __('product name') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ $product->name_en }}" type="text" autocomplete="on" id="name_en"
                                    required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="product_slug">{{ __('slug') }}</label>
                                <input name="product_slug" class="form-control @error('product_slug') is-invalid @enderror"
                                    value="{{ $product->product_slug }}" type="text" autocomplete="on"
                                    id="product_slug" />
                                @error('product_slug')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="sku">{{ __('SKU') }}</label>
                                <input name="sku" class="form-control @error('sku') is-invalid @enderror"
                                    value="{{ $product->sku }}" type="text" autocomplete="on" id="sku" required />
                                @error('sku')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="description_ar">{{ __('product description') . ' ' . __('arabic') }}</label>
                                <textarea id="description_ar" class="form-control tinymce d-none @error('description_ar') is-invalid @enderror"
                                    name="description_ar">{!! $product->description_ar !!}</textarea>
                                @error('description_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="description_en">{{ __('product description') . ' ' . __('english') }}</label>
                                <textarea id="description_en" class="form-control tinymce d-none @error('description_en') is-invalid @enderror"
                                    name="description_en">{!! $product->description_en !!}</textarea>
                                @error('description_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="sale_price">{{ __('product price') }}</label>
                                <input name="sale_price" class="form-control @error('sale_price') is-invalid @enderror"
                                    value="{{ $product->sale_price }}" type="number" min="0" step="0.01"
                                    autocomplete="on" id="sale_price" required />
                                @error('sale_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="discount_price">{{ __('discount price') }}</label>
                                <input name="discount_price"
                                    class="form-control @error('discount_price') is-invalid @enderror"
                                    value="{{ $product->discount_price }}" type="number" min="0" step="0.01"
                                    autocomplete="on" id="discount_price" required />
                                @error('discount_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="category">{{ __('Select main category') }}</label>

                                <select class="form-select @error('category') is-invalid @enderror" name="category"
                                    id="category" required>
                                    <option value="">
                                        {{ __('Select main category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category->id == $category->id ? 'selected' : '' }}>
                                            {{ getName($category) }}
                                        </option>

                                        @if ($category->children->count() > 0)
                                            @foreach ($category->children as $subCat)
                                                @include(
                                                    'dashboard.categories._category_options_product_edit',
                                                    [
                                                        'scategory' => $subCat,
                                                    ]
                                                )
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="categories">{{ __('Select more categories') }}</label>

                                <select class="form-select js-choice @error('categories') is-invalid @enderror"
                                    {{ $product->vendor_id == null ? 'multiple="multiple"' : '' }} name="categories[]"
                                    id="categories" data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">
                                        {{ __('Select Categories') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->categories()->where('category_id', $category->id)->first()? 'selected': '' }}>
                                            {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                        </option>

                                        @if ($category->children->count() > 0)
                                            @foreach ($category->children as $subCat)
                                                @include(
                                                    'dashboard.categories._category_options_product_edit',
                                                    [
                                                        'scategory' => $subCat,
                                                        'product' => $product,
                                                    ]
                                                )
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                                @error('categories')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="brands">{{ __('brands') }}</label>

                                <select class="form-select js-choice @error('brands') is-invalid @enderror"
                                    aria-label="" multiple="multiple" name="brands[]" id="brands"
                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            @foreach ($product->brands as $product_brand)
                                                {{ $product_brand->id == $brand->id ? 'selected' : '' }} @endforeach>
                                            {{ app()->getLocale() == 'ar' ? $brand->name_ar : $brand->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brands')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($product->product_type == 'variable')
                                <div class="mb-3 product-attributes">
                                    <label class="form-label" for="attributes">{{ __('product attributes') }}</label>
                                    <select
                                        class="form-select product-attribute-select js-choice @error('attributes') is-invalid @enderror"
                                        name="attributes[]" multiple="multiple"
                                        data-options='{"removeItemButton":true,"placeholder":true}'>
                                        <option value="">
                                            {{ __('select attributes') }}</option>
                                        @foreach ($product->attributes as $attribute)
                                            <option value="{{ $attribute->id }}"
                                                {{ $product->attributes()->where('attribute_id', $attribute->id)->first()? 'selected': '' }}>
                                                {{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('attributes')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                @foreach ($product->attributes as $attribute)
                                    <div class="mb-3 p-variation product-variations-{{ $attribute->id }}"
                                        style=" {{ $product->attributes()->where('attribute_id', $attribute->id)->first()? '': 'display:none' }} ">
                                        <label class="form-label"
                                            for="variations">{{ __('product variations') . ' - ' . getName($attribute) }}</label>
                                        <select class="form-select js-choice @error('variations') is-invalid @enderror"
                                            name="variations-{{ $attribute->id }}[]" multiple="multiple"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">
                                                {{ __('select variations') }}</option>
                                            @foreach ($attribute->variations as $variation)
                                                <option value="{{ $variation->id }}"
                                                    {{ $product->variations()->where('variation_id', $variation->id)->first()? 'selected': '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $variation->name_ar : $variation->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('variations')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            @endif


                            @if ($product->product_type == 'simple' || $product->product_type == 'variable')
                                <div class="row product-weight">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="product_weight">{{ __('product weight') }}</label>
                                            <input name="product_weight"
                                                class="form-control @error('product_weight') is-invalid @enderror"
                                                value="{{ $product->product_weight }}" type="number" step="0.01"
                                                min="0" autocomplete="on" id="product_weight" />
                                            @error('product_weight')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="product_length">{{ __('product length') }}</label>
                                            <input name="product_length"
                                                class="form-control @error('product_length') is-invalid @enderror"
                                                value="{{ $product->product_length }}" type="number" step="0.01"
                                                min="0" autocomplete="on" id="product_length" />
                                            @error('product_length')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="product_width">{{ __('product width') }}</label>
                                            <input name="product_width"
                                                class="form-control @error('product_width') is-invalid @enderror"
                                                value="{{ $product->product_width }}" type="number" step="0.01"
                                                min="0" autocomplete="on" id="product_width" />
                                            @error('product_width')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="product_height">{{ __('product height') }}</label>
                                            <input name="product_height"
                                                class="form-control @error('product_height') is-invalid @enderror"
                                                value="{{ $product->product_height }}" type="number" step="0.01"
                                                min="0" autocomplete="on" id="product_height" />
                                            @error('product_height')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="shipping_method">{{ __('special shipping method') }}</label>
                                            <select class="form-select @error('shipping_method') is-invalid @enderror"
                                                aria-label="" name="shipping_method" id="shipping_method">
                                                <option value="">
                                                    {{ __('default shipping method') }}
                                                </option>
                                                @foreach ($shipping_methods as $method)
                                                    <option value="{{ $method->id }}"
                                                        {{ $product->shipping_method_id == $method->id ? 'selected' : '' }}>
                                                        {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('shipping_method')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="shipping_amount">{{ __('extra fee for shipping') }}</label>
                                            <input name="shipping_amount"
                                                class="form-control @error('shipping_amount') is-invalid @enderror"
                                                value="{{ $product->shipping_amount }}" type="number" step="0.01"
                                                min="0" autocomplete="on" id="shipping_amount" />
                                            @error('shipping_amount')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            @endif

                            @if ($product->product_type == 'digital' || $product->product_type == 'service')
                                <div class="mb-3 cost">
                                    <label class="form-label" for="cost">{{ __('service cost') }}</label>
                                    <input name="cost" class="form-control @error('cost') is-invalid @enderror"
                                        value="{{ $product->cost }}" type="number" min="0" autocomplete="on"
                                        id="cost" />
                                    @error('cost')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            @if ($product->product_type == 'digital')
                                <div class="mb-3 digital-file">
                                    <label class="form-label" for="digital_file">{{ __('digital file') }}</label>
                                    <input class="form-control form-control-sm sonoo-search" type="file"
                                        name="digital_file" accept="application/pdf"
                                        data-buttonText="{{ __('Import') }}" />
                                    @error('digital_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="col-md-12" id="gallery">
                                        <a href="{{ route('ecommerce.download', ['product_file' => $product->digital_file]) }}"
                                            class="btn btn-falcon-primary me-1 mb-1"
                                            type="button">{{ __('Download file') }}
                                        </a>
                                    </div>
                                </div>
                            @endif




                            {{-- <div class="mb-3">
                                <label class="form-label" for="colors">Product Colors</label>
                                <select class="form-select js-choice @error('colors') is-invalid @enderror" name="colors[]"
                                    multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'
                                    required>
                                    <option value="">
                                        {{ __('Select Colors') }}</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">
                                            {{ app()->getLocale() == 'ar' ? $color->color_ar : $color->color_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('colors')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="sizes">Product Sizes</label>
                                <select class="form-select js-choice @error('sizes') is-invalid @enderror" name="sizes[]"
                                    multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'
                                    required>
                                    <option value="">
                                        {{ __('Select Sizes') }}</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">
                                            {{ app()->getLocale() == 'ar' ? $size->size_ar : $size->size_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sizes')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}


                            <div class="mb-3">
                                <label class="form-label" for="status">{{ __('Product Status') }}</label>
                                <select class="form-select @error('status') is-invalid @enderror" aria-label=""
                                    name="status" id="status" required>
                                    <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>
                                        {{ __('Pending') }}
                                    </option>
                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>
                                        {{ __('Active') }}
                                    </option>
                                    <option value="rejected" {{ $product->status == 'rejected' ? 'selected' : '' }}>
                                        {{ __('Rejected') }}
                                    </option>
                                    <option value="pause" {{ $product->status == 'pause' ? 'selected' : '' }}>
                                        {{ __('pause') }}
                                    </option>
                                </select>
                                @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="extra_fee">{{ __('Extra fee') . ' ' . __('special for affiliate') }}</label>
                                <input name="extra_fee" class="form-control @error('extra_fee') is-invalid @enderror"
                                    type="number" min="0" value="{{ $product->extra_fee }}" autocomplete="on"
                                    id="extra_fee" />
                                @error('extra_fee')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="limited">{{ __('Unlimited Quantity') . ' ' . __('special for affiliate') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="limited" class="form-control @error('limited') is-invalid @enderror"
                                            name="limited" type="checkbox"
                                            {{ $product->unlimited == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('limited')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="video_url">{{ __('video url') }}</label>
                                <input name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                                    value="{{ $product->video_url }}" type="text" autocomplete="on"
                                    id="name_en" />
                                @error('video_url')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="product_min_order">{{ __('product min order') }}</label>
                                <input name="product_min_order"
                                    class="form-control @error('product_min_order') is-invalid @enderror"
                                    value="{{ $product->product_min_order }}" type="number" min="1"
                                    autocomplete="on" id="product_min_order" required />
                                @error('product_min_order')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="product_max_order">{{ __('product max order') }}</label>
                                <input name="product_max_order"
                                    class="form-control @error('product_max_order') is-invalid @enderror"
                                    value="{{ $product->product_max_order }}" type="number" min="1"
                                    autocomplete="on" id="product_max_order" required />
                                @error('product_max_order')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="is_featured">{{ __('is featured') }}</label>
                                    <div>
                                        <label class="switch">
                                            <input id="is_featured"
                                                class="form-control @error('limited') is-invalid @enderror"
                                                name="is_featured" type="checkbox"
                                                {{ $product->is_featured == 1 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('is_featured')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="on_sale">{{ __('on sale') }}</label>
                                    <div>
                                        <label class="switch">
                                            <input id="on_sale"
                                                class="form-control @error('on_sale') is-invalid @enderror"
                                                name="on_sale" type="checkbox"
                                                {{ $product->on_sale == 1 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('on_sale')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="top_collection">{{ __('top collection') }}</label>
                                    <div>
                                        <label class="switch">
                                            <input id="top_collection"
                                                class="form-control @error('limited') is-invalid @enderror"
                                                name="top_collection" type="checkbox"
                                                {{ $product->top_collection == 1 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('top_collection')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="best_selling">{{ __('best selling') }}</label>
                                    <div>
                                        <label class="switch">
                                            <input id="best_selling"
                                                class="form-control @error('best_selling') is-invalid @enderror"
                                                name="best_selling" type="checkbox"
                                                {{ $product->best_selling == 1 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('best_selling')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>





                            <div class="mb-3">
                                <label class="form-label" for="image">{{ __('Product images') }}</label>
                                <input name="images[]" class="imgs form-control @error('image') is-invalid @enderror"
                                    type="file" accept="image/*" id="image" multiple />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="col-md-12" id="gallery">
                                    @foreach ($product->images as $image)
                                        <img src="{{ asset($image->media->path) }}"
                                            style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                    @endforeach

                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Edit Product') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
