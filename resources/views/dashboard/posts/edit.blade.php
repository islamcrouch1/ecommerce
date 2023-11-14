@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('edit') . ' ' . __('post') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')




                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"
                                        for="name_ar">{{ __('post title') . ' ' . __('arabic') }}</label>
                                    <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                        value="{{ $post->name_ar }}" type="text" autocomplete="on" id="name_ar"
                                        required />
                                    @error('name_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"
                                        for="name_en">{{ __('post title') . ' ' . __('english') }}</label>
                                    <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                        value="{{ $post->name_en }}" type="text" autocomplete="on" id="name_en"
                                        required />
                                    @error('name_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="category_id">{{ __('select category') }}</label>

                                    <select class="form-select js-choice @error('category_id') is-invalid @enderror"
                                        name="category_id" id="category_id" required>
                                        <option value="">
                                            {{ __('select category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $post->website_category_id == $category->id ? 'selected' : '' }}>
                                                {{ getName($category) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sort_order">{{ __('post sort order') }}</label>
                                    <input name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                        value="{{ $post->sort_order }}" type="number" min="0" autocomplete="on"
                                        id="sort_order" />
                                    @error('sort_order')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

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


                                    <li class="nav-item"><a class="nav-link " id="seo-tab" data-bs-toggle="tab"
                                            href="#tab-seo" role="tab" aria-controls="tab-website"
                                            aria-selected="true">{{ __('seo') }}</a>
                                    </li>


                                </ul>

                                <div class="tab-content border-x border-bottom p-3" id="myTabContent">


                                    <div class="tab-pane fade show active" id="tab-images" role="tabpanel"
                                        aria-labelledby="images-tab">

                                        <div class="mb-3">
                                            <label class="form-label" for="image">{{ __('main image') }}</label>
                                            <input name="image"
                                                class="img form-control @error('image') is-invalid @enderror" type="file"
                                                id="image" />
                                            @error('image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">

                                            <div class="col-md-10">
                                                @if ($post->media != null)
                                                    <img src="{{ asset($post->media->path) }}"
                                                        style="width:100px; border: 1px solid #999"
                                                        class="img-thumbnail img-prev">
                                                @endif
                                            </div>

                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" for="images">{{ __('Product images') }}</label>
                                            <input name="images[]"
                                                class="imgs form-control @error('images') is-invalid @enderror"
                                                type="file" accept="image/*" id="images" multiple />
                                            @error('images')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="col-md-12" id="gallery">


                                            </div>

                                            <div class="product-images row">



                                                @foreach ($post->images as $image)
                                                    <div style="width:150px; border: 1px solid #999"
                                                        class="hoverbox rounded-3 text-center m-1 product-image-{{ $image->media->id }}">
                                                        <img class="img-fluid" src="{{ asset($image->media->path) }}"
                                                            alt="" />
                                                        <div class="light hoverbox-content bg-dark p-5 flex-center">
                                                            <div>
                                                                <a class="btn btn-light btn-sm mt-1 delete-media"
                                                                    href="#"
                                                                    data-url="{{ route('posts.delete.media', ['image_id' => $image->id]) }}"
                                                                    data-media_id="{{ $image->media->id }}">{{ __('Delete') }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>


                                    <div class="tab-pane fade show " id="tab-description" role="tabpanel"
                                        aria-labelledby="description-tab">

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="extra_fee">{{ __('post description') . ' ' . __('arabic') }}</label>
                                            <textarea id="description_ar" class="form-control tinymce d-none @error('description_ar') is-invalid @enderror"
                                                name="description_ar">{!! $post->description_ar !!}</textarea>
                                            @error('description_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="extra_fee">{{ __('post description') . ' ' . __('english') }}</label>
                                            <textarea id="description_en" class="form-control tinymce d-none @error('description_en') is-invalid @enderror"
                                                name="description_en">{!! $post->description_en !!}</textarea>
                                            @error('description_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>



                                    </div>

                                    <div class="tab-pane fade show " id="tab-seo" role="tabpanel"
                                        aria-labelledby="seo-tab">


                                        <div class="mb-3">
                                            <label class="form-label" for="seo_meta_tag">{{ __('seo_keywords') }}</label>
                                            <input name="seo_meta_tag"
                                                class="form-control @error('seo_meta_tag') is-invalid @enderror"
                                                value="{{ $post->seo_meta_tag }}" type="text" autocomplete="on"
                                                id="seo_meta_tag" />
                                            @error('seo_meta_tag')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" for="seo_desc">{{ __('seo_desc') }}</label>
                                            <input name="seo_desc"
                                                class="form-control @error('seo_desc') is-invalid @enderror"
                                                value="{{ $post->seo_desc }}" type="text" autocomplete="on"
                                                id="seo_desc" />
                                            @error('seo_desc')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>



                                    </div>

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
