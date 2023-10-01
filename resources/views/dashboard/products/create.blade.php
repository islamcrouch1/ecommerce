@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New Product') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"
                                        for="name_ar">{{ __('product name') . ' ' . __('arabic') }}</label>
                                    <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                        value="{{ old('name_ar') }}" type="text" autocomplete="on" id="name_ar"
                                        required />
                                    @error('name_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"
                                        for="name_en">{{ __('product name') . ' ' . __('english') }}</label>
                                    <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                        value="{{ old('name_en') }}" type="text" autocomplete="on" id="name_en"
                                        required />
                                    @error('name_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="product_slug">{{ __('slug') }}</label>
                                    <input name="product_slug"
                                        class="form-control @error('product_slug') is-invalid @enderror"
                                        value="{{ old('product_slug') }}" type="text" autocomplete="on"
                                        id="product_slug" />
                                    @error('product_slug')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="code">{{ __('product code') }}</label>
                                    <input name="code" class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code') }}" type="text" autocomplete="on" id="code" />
                                    @error('code')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sku">SKU</label>
                                    <input name="sku" class="form-control @error('sku') is-invalid @enderror"
                                        value="{{ old('sku') }}" type="text" autocomplete="on" id="sku" />
                                    @error('sku')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="unit_id">{{ __('unit of measure') }}</label>

                                    <select class="form-select js-choice @error('unit_id') is-invalid @enderror"
                                        name="unit_id" id="unit_id" required>
                                        <option value="">
                                            {{ __('Select unit of measure') }}</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">
                                                {{ getName($unit) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <hr class="my-4">


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sale_price">{{ __('product price') }}</label>
                                    <input name="sale_price" class="form-control @error('sale_price') is-invalid @enderror"
                                        value="{{ old('sale_price') ? old('sale_price') : 0 }}" type="number"
                                        min="0" step="0.01" autocomplete="on" id="sale_price" required />
                                    @error('sale_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="discount_price">{{ __('discount price') }}</label>
                                    <input name="discount_price"
                                        class="form-control @error('discount_price') is-invalid @enderror"
                                        value="{{ old('discount_price') ? old('discount_price') : 0 }}" type="number"
                                        min="0" step="0.01" autocomplete="on" id="discount_price" />
                                    @error('discount_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-4">




                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="can_sold">{{ __('can be sold') }}</label>
                                    <div>
                                        <label class="switch">
                                            <input id="can_sold"
                                                class="form-control @error('limited') is-invalid @enderror"
                                                name="can_sold" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        @error('can_sold')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="can_purchased">{{ __('can be purchased') }}</label>
                                    <div>
                                        <label class="switch">
                                            <input id="can_purchased"
                                                class="form-control @error('limited') is-invalid @enderror"
                                                name="can_purchased" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        @error('can_purchased')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-3">
                                    <label class="form-label"
                                        for="can_manufactured">{{ __('can be manufactured') }}</label>
                                    <div>
                                        <label class="switch">
                                            <input id="can_manufactured"
                                                class="form-control @error('limited') is-invalid @enderror"
                                                name="can_manufactured" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        @error('can_manufactured')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <hr class="my-4">



                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="category">{{ __('Select main category') }}</label>

                                    <select class="form-select js-choice @error('category') is-invalid @enderror"
                                        name="category" id="category" required>
                                        <option value="">
                                            {{ __('Select main category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                            </option>

                                            @if ($category->children->count() > 0)
                                                @foreach ($category->children as $subCat)
                                                    @include('dashboard.categories._category_options', [
                                                        'category' => $subCat,
                                                    ])
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="categories">{{ __('Select more categories') }}</label>

                                    <select class="form-select js-choice @error('categories') is-invalid @enderror"
                                        multiple="multiple" name="categories[]" id="categories"
                                        data-options='{"removeItemButton":true,"placeholder":true}'>
                                        <option value="">
                                            {{ __('Select Categories') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                            </option>

                                            @if ($category->children->count() > 0)
                                                @foreach ($category->children as $subCat)
                                                    @include('dashboard.categories._category_options', [
                                                        'category' => $subCat,
                                                    ])
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <hr class="my-4">



                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="product_type">{{ __('Product type') }}</label>
                                    <select class="form-select product-type @error('product_type') is-invalid @enderror"
                                        aria-label="" name="product_type" id="product_type" required>
                                        <option value="">
                                            {{ __('select product type') }}
                                        </option>
                                        <option value="simple">
                                            {{ __('simple') }}
                                        </option>
                                        <option value="variable">
                                            {{ __('variable') }}
                                        </option>
                                        <option value="digital">
                                            {{ __('digital') }}
                                        </option>
                                        <option value="service">
                                            {{ __('service') }}
                                        </option>
                                    </select>
                                    @error('product_type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="row product-weight" style="display:none">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="product_weight">{{ __('product weight') }}</label>
                                            <input name="product_weight"
                                                class="form-control @error('product_weight') is-invalid @enderror"
                                                value="0" type="number" min="0" step="0.01"
                                                autocomplete="on" id="product_weight" />
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
                                                value="0" type="number" min="0" step="0.01"
                                                autocomplete="on" id="product_length" />
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
                                                value="0" type="number" min="0" step="0.01"
                                                autocomplete="on" id="product_width" />
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
                                                value="0" type="number" min="0" step="0.01"
                                                autocomplete="on" id="product_height" />
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
                                                    <option value="{{ $method->id }}">
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
                                                value="0" type="number" min="0" step="0.01"
                                                autocomplete="on" id="shipping_amount" />
                                            @error('shipping_amount')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>


                                <div class="mb-3 cost" style="display:none">
                                    <label class="form-label" for="cost">{{ __('service cost') }}</label>
                                    <input name="cost" class="form-control @error('cost') is-invalid @enderror"
                                        value="0" type="number" min="0" autocomplete="on"
                                        id="cost" />
                                    @error('cost')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 digital-file" style="display:none">
                                    <label class="form-label" for="digital_file">{{ __('digital file') }}</label>
                                    <input class="form-control form-control-sm sonoo-search" type="file"
                                        name="digital_file" accept="application/pdf"
                                        data-buttonText="{{ __('Import') }}" />
                                    @error('digital_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 product-attributes" style="display:none">
                                    <label class="form-label" for="attributes">{{ __('product attributes') }}</label>
                                    <select
                                        class="form-select product-attribute-select js-choice @error('attributes') is-invalid @enderror"
                                        name="attributes[]" multiple="multiple"
                                        data-options='{"removeItemButton":true,"placeholder":true}'>
                                        <option value="">
                                            {{ __('select attributes') }}</option>
                                        @foreach ($attributes as $attribute)
                                            <option value="{{ $attribute->id }}">
                                                {{ app()->getLocale() == 'ar' ? $attribute->name_ar : $attribute->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('attributes')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                @foreach ($attributes as $index => $attribute)
                                    <div class="mb-3 p-variation product-variations-{{ $attribute->id }}"
                                        style="display:none">
                                        <label class="form-label"
                                            for="variations">{{ __('product variations') . ' - ' . getName($attribute) }}</label>
                                        <select class="form-select model-search @error('variations') is-invalid @enderror"
                                            data-url="{{ route('model.search') }}"
                                            data-locale="{{ app()->getLocale() }}" data-parent="{{ $attribute->id }}"
                                            data-type="variations" name="variations-{{ $attribute->id }}[]"
                                            multiple="multiple"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">
                                                {{ __('select variations') }}</option>
                                            @foreach ($attribute->variations as $variation)
                                                <option value="{{ $variation->id }}">
                                                    {{ app()->getLocale() == 'ar' ? $variation->name_ar : $variation->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('variations')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach


                                <hr class="my-4">



                                <ul class="nav nav-tabs" id="myTab" role="tablist">


                                    <li class="nav-item"><a class="nav-link active" id="images-tab" data-bs-toggle="tab"
                                            href="#tab-images" role="tab" aria-controls="tab-images"
                                            aria-selected="true">{{ __('images') }}</a>
                                    </li>

                                    <li class="nav-item"><a class="nav-link " id="description-tab" data-bs-toggle="tab"
                                            href="#tab-description" role="tab" aria-controls="tab-description"
                                            aria-selected="true">{{ __('description') }}</a>
                                    </li>

                                    <li class="nav-item"><a class="nav-link " id="website-tab" data-bs-toggle="tab"
                                            href="#tab-website" role="tab" aria-controls="tab-website"
                                            aria-selected="true">{{ __('website') }}</a>
                                    </li>

                                    <li class="nav-item"><a class="nav-link " id="seo-tab" data-bs-toggle="tab"
                                            href="#tab-seo" role="tab" aria-controls="tab-website"
                                            aria-selected="true">{{ __('seo') }}</a>
                                    </li>

                                    <li class="nav-item"><a class="nav-link " id="affiliate-tab" data-bs-toggle="tab"
                                            href="#tab-affiliate" role="tab" aria-controls="tab-affiliate"
                                            aria-selected="true">{{ __('affiliate') }}</a>
                                    </li>

                                    <li class="nav-item"><a class="nav-link " id="installment-tab" data-bs-toggle="tab"
                                            href="#tab-installment" role="tab" aria-controls="tab-installment"
                                            aria-selected="true">{{ __('installment') }}</a>
                                    </li>

                                    <li class="nav-item"><a class="nav-link" id="status-tab" data-bs-toggle="tab"
                                            href="#tab-status" role="tab" aria-controls="tab-status"
                                            aria-selected="true">{{ __('product status') }}</a>
                                    </li>


                                </ul>

                                <div class="tab-content border-x border-bottom p-3" id="myTabContent">


                                    <div class="tab-pane fade show active" id="tab-images" role="tabpanel"
                                        aria-labelledby="images-tab">

                                        <div class="mb-3">
                                            <label class="form-label" for="image">{{ __('main image') }}</label>
                                            <input name="image"
                                                class="img form-control @error('image') is-invalid @enderror"
                                                type="file" id="image" />
                                            @error('image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <div class="col-md-10">
                                                <img src="" style="width:100px; border: 1px solid #999"
                                                    class="img-thumbnail img-prev">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="image">{{ __('Photo Gallery') }}</label>
                                            <input name="images[]"
                                                class="imgs form-control @error('image') is-invalid @enderror"
                                                type="file" accept="image/*" id="image" multiple />
                                            @error('image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="col-md-12" id="gallery">
                                            </div>
                                        </div>

                                    </div>



                                    <div class="tab-pane fade show " id="tab-description" role="tabpanel"
                                        aria-labelledby="description-tab">

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="extra_fee">{{ __('product description') . ' ' . __('arabic') }}</label>
                                            <textarea id="description_ar" class="form-control tinymce d-none @error('description_ar') is-invalid @enderror"
                                                name="description_ar">{{ old('description_ar') }}</textarea>
                                            @error('description_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="extra_fee">{{ __('product description') . ' ' . __('english') }}</label>
                                            <textarea id="description_en" class="form-control tinymce d-none @error('description_en') is-invalid @enderror"
                                                name="description_en">{{ old('description_en') }}</textarea>
                                            @error('description_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>



                                    </div>

                                    <div class="tab-pane fade show " id="tab-website" role="tabpanel"
                                        aria-labelledby="website-tab">

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="brands">{{ __('brands') }}</label>

                                            <select class="form-select js-choice @error('brands') is-invalid @enderror"
                                                aria-label="" multiple="multiple" name="brands[]" id="brands"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="">
                                                    {{ __('Select brands') }}</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ old('brands') == $brand->id ? 'selected' : '' }}>
                                                        {{ app()->getLocale() == 'ar' ? $brand->name_ar : $brand->name_en }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brands')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                for="product_min_order">{{ __('product min order') }}</label>
                                            <input name="product_min_order"
                                                class="form-control @error('product_min_order') is-invalid @enderror"
                                                value="1" type="number" min="1" autocomplete="on"
                                                id="product_min_order" required />
                                            @error('product_min_order')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                for="product_max_order">{{ __('product max order') }}</label>
                                            <input name="product_max_order"
                                                class="form-control @error('product_max_order') is-invalid @enderror"
                                                value="5" type="number" min="1" autocomplete="on"
                                                id="product_max_order" required />
                                            @error('product_max_order')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label"
                                                    for="is_featured">{{ __('is featured') }}</label>
                                                <div>
                                                    <label class="switch">
                                                        <input id="is_featured"
                                                            class="form-control @error('limited') is-invalid @enderror"
                                                            name="is_featured" type="checkbox">
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
                                                            name="on_sale" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    @error('on_sale')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label"
                                                    for="top_collection">{{ __('top collection') }}</label>
                                                <div>
                                                    <label class="switch">
                                                        <input id="top_collection"
                                                            class="form-control @error('top_collection') is-invalid @enderror"
                                                            name="top_collection" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    @error('top_collection')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="mb-3 col-md-3">
                                                <label class="form-label"
                                                    for="best_selling">{{ __('best selling') }}</label>
                                                <div>
                                                    <label class="switch">
                                                        <input id="best_selling"
                                                            class="form-control @error('best_selling') is-invalid @enderror"
                                                            name="best_selling" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    @error('best_selling')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" for="video_url">{{ __('video url') }}</label>
                                            <input name="video_url"
                                                class="form-control @error('video_url') is-invalid @enderror"
                                                value="{{ old('video_url') }}" type="text" autocomplete="on"
                                                id="name_en" />
                                            @error('video_url')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>


                                    <div class="tab-pane fade show " id="tab-seo" role="tabpanel"
                                        aria-labelledby="seo-tab">


                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="seo_meta_tag">{{ __('seo_keywords') }}</label>
                                            <input name="seo_meta_tag"
                                                class="form-control @error('seo_meta_tag') is-invalid @enderror"
                                                value="{{ old('seo_meta_tag') }}" type="text" autocomplete="on"
                                                id="seo_meta_tag" />
                                            @error('seo_meta_tag')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" for="seo_desc">{{ __('seo_desc') }}</label>
                                            <input name="seo_desc"
                                                class="form-control @error('seo_desc') is-invalid @enderror"
                                                value="{{ old('seo_desc') }}" type="text" autocomplete="on"
                                                id="seo_desc" />
                                            @error('seo_desc')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>



                                    </div>

                                    <div class="tab-pane fade show " id="tab-affiliate" role="tabpanel"
                                        aria-labelledby="affiliate-tab">


                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="extra_fee">{{ __('Extra fee') . ' ' . __('special for affiliate') }}</label>
                                            <input name="extra_fee"
                                                class="form-control @error('extra_fee') is-invalid @enderror"
                                                type="number" min="0" value="0" autocomplete="on"
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
                                                    <input id="limited"
                                                        class="form-control @error('limited') is-invalid @enderror"
                                                        name="limited" type="checkbox">
                                                    <span class="slider round"></span>
                                                </label>
                                                @error('limited')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                    </div>

                                    <div class="tab-pane fade show " id="tab-installment" role="tabpanel"
                                        aria-labelledby="installment-tab">


                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="installment_companies">{{ __('select installment company') }}</label>
                                            <select
                                                class="form-select js-choice @error('installment_companies') is-invalid @enderror"
                                                aria-label="" name="installment_companies[]" multiple
                                                id="shipping_method">

                                                <option value="">
                                                    {{ __('select installment company') }}
                                                </option>
                                                @foreach ($installment_companies as $company)
                                                    <option value="{{ $company->id }}">
                                                        {{ getName($company) . ': ' . ' ' . __('admin expenses') . ' : ' . $company->admin_expenses . ' ' . __($company->type) . ' - ' . __('monthly interest') . ': ' . $company->amount . ' %' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('installment_companies')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>



                                    </div>

                                    <div class="tab-pane fade show" id="tab-status" role="tabpanel"
                                        aria-labelledby="status-tab">


                                        <div class="mb-3">
                                            <label class="form-label" for="status">{{ __('Product Status') }}</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                aria-label="" name="status" id="status" required>
                                                <option value="pending">
                                                    {{ __('Pending') }}
                                                </option>
                                                <option value="active">
                                                    {{ __('Active') }}
                                                </option>
                                                <option value="rejected">
                                                    {{ __('Rejected') }}
                                                </option>
                                                <option value="pause">
                                                    {{ __('pause') }}
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>


                            </div>





                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
