@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New Category') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                            @csrf



                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name_ar">{{ __('category name - arabic') }}</label>
                                    <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                        value="{{ old('name_ar') }}" type="text" autocomplete="on" id="name_ar"
                                        autofocus required />
                                    @error('name_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name_en">{{ __('category name - english') }}</label>
                                    <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                        value="{{ old('name_en') }}" type="text" autocomplete="on" id="name_en"
                                        required />
                                    @error('name_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="category_slug">{{ __('category Slug') }}</label>
                                    <input name="category_slug"
                                        class="form-control @error('category_slug') is-invalid @enderror"
                                        value="{{ old('category_slug') }}" type="text" autocomplete="on"
                                        id="category_slug" />
                                    @error('category_slug')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="parent_id">{{ __('Parnet Category') }}</label>

                                    <select class="form-select @error('parent_id') is-invalid @enderror" aria-label=""
                                        name="parent_id" id="parent_id">
                                        <option value="">
                                            {{ __('Main Category') }}</option>
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
                                    @error('parent')
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



                                    <li class="nav-item"><a class="nav-link" id="status-tab" data-bs-toggle="tab"
                                            href="#tab-status" role="tab" aria-controls="tab-status"
                                            aria-selected="true">{{ __('status') }}</a>
                                    </li>


                                </ul>

                                <div class="tab-content border-x border-bottom p-3" id="myTabContent">


                                    <div class="tab-pane fade show active" id="tab-images" role="tabpanel"
                                        aria-labelledby="images-tab">



                                        <div class="mb-3">
                                            <label class="form-label" for="image">{{ __('Category image') }}</label>
                                            <input name="image"
                                                class="img form-control @error('image') is-invalid @enderror"
                                                type="file" id="image" accept="image/*" />
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

                                    </div>



                                    <div class="tab-pane fade show " id="tab-description" role="tabpanel"
                                        aria-labelledby="description-tab">

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="description_ar">{{ __('category description - arabic') }}</label>
                                            <input name="description_ar"
                                                class="form-control @error('description_ar') is-invalid @enderror"
                                                value="{{ old('description_ar') }}" type="text" autocomplete="on"
                                                id="description_ar" />
                                            @error('description_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="description_en">{{ __('category description - english') }}</label>
                                            <input name="description_en"
                                                class="form-control @error('description_en') is-invalid @enderror"
                                                value="{{ old('description_en') }}" type="text" autocomplete="on"
                                                id="description_en" />
                                            @error('description_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>



                                    </div>

                                    <div class="tab-pane fade show " id="tab-website" role="tabpanel"
                                        aria-labelledby="website-tab">

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="subtitle_ar">{{ __('subtitle') . ' ' . __('arabic') }}</label>
                                            <input name="subtitle_ar"
                                                class="form-control @error('subtitle_ar') is-invalid @enderror"
                                                value="{{ old('subtitle_ar') }}" type="text" autocomplete="on"
                                                id="subtitle_ar" />
                                            @error('subtitle_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="subtitle_en">{{ __('subtitle') . ' ' . __('english') }}</label>
                                            <input name="subtitle_en"
                                                class="form-control @error('subtitle_en') is-invalid @enderror"
                                                value="{{ old('subtitle_en') }}" type="text" autocomplete="on"
                                                id="subtitle_en" />
                                            @error('subtitle_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="country">{{ __('Country') }}</label>

                                            <select class="form-select @error('country') is-invalid @enderror"
                                                aria-label="" name="country" id="country" required>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country') == $country->id ? 'selected' : '' }}>
                                                        {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>


                                    <div class="tab-pane fade show " id="tab-seo" role="tabpanel"
                                        aria-labelledby="seo-tab">



                                    </div>

                                    <div class="tab-pane fade show " id="tab-affiliate" role="tabpanel"
                                        aria-labelledby="affiliate-tab">



                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="profit">{{ __('Category Profit for affiliate %') }}</label>
                                            <input name="profit"
                                                class="form-control @error('profit') is-invalid @enderror"
                                                value="{{ old('profit') }}" type="number" min="0"
                                                autocomplete="on" id="profit" />
                                            @error('profit')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="vendor_profit">{{ __('Category Profit for vendors %') }}</label>
                                            <input name="vendor_profit"
                                                class="form-control @error('vendor_profit') is-invalid @enderror"
                                                value="{{ old('vendor_profit') }}" type="number" min="0"
                                                autocomplete="on" id="vendor_profit" />
                                            @error('vendor_profit')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>



                                    </div>



                                    <div class="tab-pane fade show" id="tab-status" role="tabpanel"
                                        aria-labelledby="status-tab">


                                        <div class="mb-3">
                                            <label class="form-label" for="sort_order">{{ __('Sort Order') }}</label>
                                            <input name="sort_order"
                                                class="form-control @error('sort_order') is-invalid @enderror"
                                                value="{{ old('sort_order') }}" type="number" min="0"
                                                autocomplete="on" id="sort_order" />
                                            @error('sort_order')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" for="status">{{ __('status') }}</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                aria-label="" name="status" id="status" required>
                                                <option value="active">
                                                    {{ __('Active') }}
                                                </option>
                                                <option value="inactive">
                                                    {{ __('Inactive') }}
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
                                    name="submit">{{ __('Add New Category') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
