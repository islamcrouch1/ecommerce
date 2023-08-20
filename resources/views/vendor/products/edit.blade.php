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
                        <form method="POST"
                            action="{{ route('vendor-products.update', ['vendor_product' => $product->id]) }}"
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

                            {{-- <div class="mb-3">
                                <label class="form-label" for="product_slug">{{ __('slug') }}</label>
                                <input name="product_slug" class="form-control @error('product_slug') is-invalid @enderror"
                                    value="{{ $product->product_slug }}" type="text" autocomplete="on"
                                    id="product_slug" />
                                @error('product_slug')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}

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
                                    value="{{ $product->sale_price }}" type="number" min="0" autocomplete="on"
                                    id="sale_price" required />
                                @error('sale_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="discount_price">{{ __('discount price') }}</label>
                                <input name="discount_price"
                                    class="form-control @error('discount_price') is-invalid @enderror"
                                    value="{{ $product->discount_price }}" type="number" min="0" autocomplete="on"
                                    id="discount_price" required />
                                @error('discount_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <label class="form-label" for="category">{{ __('Select Category') }}</label>

                                <select class="form-select js-choice @error('category') is-invalid @enderror"
                                    name="category" id="category"
                                    data-options='{"removeItemButton":true,"placeholder":true}' required>
                                    <option value="">
                                        {{ __('Select Category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
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






                            @if ($product->product_type == 'simple' || $product->product_type == 'variable')
                                <div class="row product-weight">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="product_weight">{{ __('product weight') }}</label>
                                            <input name="product_weight"
                                                class="form-control @error('product_weight') is-invalid @enderror"
                                                value="{{ $product->product_weight }}" type="number" min="0"
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
                                                value="{{ $product->product_length }}" type="number" min="0"
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
                                                value="{{ $product->product_width }}" type="number" min="0"
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
                                                value="{{ $product->product_height }}" type="number" min="0"
                                                autocomplete="on" id="product_height" />
                                            @error('product_height')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>




                                </div>
                            @endif














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
                                <label class="form-label" for="image">{{ __('main image') }}</label>
                                <input name="image" class="img form-control @error('image') is-invalid @enderror"
                                    type="file" id="image" />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">

                                <div class="col-md-10">
                                    @if ($product->media != null)
                                        <img src="{{ asset($product->media->path) }}"
                                            style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                    @endif
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


                                </div>

                                <div class="product-images row">

                                    @foreach ($product->images as $image)
                                        <div style="width:150px; border: 1px solid #999"
                                            class="hoverbox rounded-3 text-center m-1 product-image-{{ $image->media->id }}">
                                            <img class="img-fluid" src="{{ asset($image->media->path) }}"
                                                alt="" />
                                            <div class="light hoverbox-content bg-dark p-5 flex-center">
                                                <div>
                                                    <a class="btn btn-light btn-sm mt-1 delete-media" href="#"
                                                        data-url="{{ route('products.delete.media', ['image_id' => $image->id]) }}"
                                                        data-media_id="{{ $image->media->id }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
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
