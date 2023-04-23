@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('edit') . ' ' . __('testimonial') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('testimonials.update', ['testimonial' => $testimonial->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')



                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ $testimonial->name_ar }}" type="text" autocomplete="on" id="name_ar"
                                    autofocus required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('title') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ $testimonial->name_en }}" type="text" autocomplete="on" id="name_en"
                                    autofocus required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="rating">{{ __('rating stars') }}</label>
                                <input name="rating" class="form-control @error('rating') is-invalid @enderror"
                                    value="{{ $testimonial->rating }}" type="number" min="0" max="5"
                                    autocomplete="on" id="rating" required />
                                @error('rating')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="title_ar">{{ __('job title') . ' ' . __('arabic') }}</label>
                                <input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror"
                                    value="{{ $testimonial->title_ar }}" type="text" autocomplete="on" id="title_ar" />
                                @error('title_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="title_en">{{ __('job title') . ' ' . __('english') }}</label>
                                <input name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                                    value="{{ $testimonial->title_en }}" type="text" autocomplete="on" id="title_en" />
                                @error('title_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label"
                                    for="description_ar">{{ __('description') . ' ' . __('arabic') }}</label>
                                <input name="description_ar"
                                    class="form-control @error('description_ar') is-invalid @enderror"
                                    value="{{ $testimonial->description_ar }}" type="text" autocomplete="on"
                                    id="description_ar" autofocus required />
                                @error('description_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="description_en">{{ __('description') . ' ' . __('english') }}</label>
                                <input name="description_en"
                                    class="form-control @error('description_ar') is-invalid @enderror"
                                    value="{{ $testimonial->description_ar }}" type="text" autocomplete="on"
                                    id="description_en" autofocus required />
                                @error('description_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="country_id">{{ __('Country') }}</label>

                                <select class="form-select @error('country_id') is-invalid @enderror" aria-label=""
                                    name="country_id" id="country_id" required>
                                    @foreach ($countries as $country)
                                        <option data-country_id="{{ $country->id }}" value="{{ $country->id }}"
                                            {{ $testimonial->country_id == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="media">{{ __('image') . '( 250 * 250 )' }}</label>
                                <input name="media" class="img form-control @error('media') is-invalid @enderror"
                                    type="file" id="media" />
                                @error('media')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">

                                <div class="col-md-10">
                                    <img src="{{ asset($testimonial->media->path) }}"
                                        style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                </div>

                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('edit') . ' ' . __('testimonial') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
