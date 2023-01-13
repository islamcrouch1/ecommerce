@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New Slide') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('slides.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="slider_id">{{ __('select slider') }}</label>

                                <select class="form-select select-slider @error('slider_id') is-invalid @enderror"
                                    aria-label="" name="slider_id" id="slider_id" required>
                                    <option value="">
                                        {{ __('select slider') }}
                                    </option>
                                    <option value="3" {{ old('slider_id') == 3 ? 'selected' : '' }}>
                                        {{ __('home page Slider') }}
                                    </option>
                                </select>
                                @error('slider_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="url">{{ __('Slide URL') }}</label>
                                <input name="url" class="form-control @error('url') is-invalid @enderror"
                                    value="{{ old('url') }}" type="text" autocomplete="on" id="url" autofocus
                                    required />
                                @error('url')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 text-1-ar" style="display:none">
                                <label class="form-label" for="text_1_ar">{{ __('text 1') . ' ' . __('arabic') }}</label>
                                <input name="text_1_ar" class="form-control @error('text_1_ar') is-invalid @enderror"
                                    value="{{ old('text_1_ar') }}" type="text" autocomplete="on" id="text_1_ar" />
                                @error('text_1_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-1-en" style="display:none">
                                <label class="form-label" for="text_1_en">{{ __('text 1') . ' ' . __('english') }}</label>
                                <input name="text_1_en" class="form-control @error('text_1_en') is-invalid @enderror"
                                    value="{{ old('text_1_en') }}" type="text" autocomplete="on" id="text_1_en" />
                                @error('text_1_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-2-ar" style="display:none">
                                <label class="form-label" for="text_2_ar">{{ __('text 2') . ' ' . __('arabic') }}</label>
                                <input name="text_2_ar" class="form-control @error('text_2_ar') is-invalid @enderror"
                                    value="{{ old('text_2_ar') }}" type="text" autocomplete="on" id="text_2_ar" />
                                @error('text_2_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-2-en" style="display:none">
                                <label class="form-label" for="text_2_en">{{ __('text 2') . ' ' . __('english') }}</label>
                                <input name="text_2_en" class="form-control @error('text_2_en') is-invalid @enderror"
                                    value="{{ old('text_2_en') }}" type="text" autocomplete="on" id="text_2_en" />
                                @error('text_2_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 text-button-ar" style="display:none">
                                <label class="form-label"
                                    for="button_text_ar">{{ __('button text') . ' ' . __('arabic') }}</label>
                                <input name="button_text_ar"
                                    class="form-control @error('button_text_ar') is-invalid @enderror"
                                    value="{{ old('button_text_ar') }}" type="text" autocomplete="on"
                                    id="button_text_ar" />
                                @error('button_text_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-button-en" style="display:none">
                                <label class="form-label"
                                    for="button_text_en">{{ __('button text') . ' ' . __('english') }}</label>
                                <input name="button_text_en"
                                    class="form-control @error('button_text_en') is-invalid @enderror"
                                    value="{{ old('button_text_en') }}" type="text" autocomplete="on"
                                    id="button_text_en" />
                                @error('button_text_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="sort_order">{{ __('Sort Order') }}</label>
                                <input name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order') }}" type="number" min="0" autocomplete="on"
                                    id="sort_order" />
                                @error('sort_order')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label"
                                    for="image">{{ __('Slide image') . ' ' . '(1370 * 510)' }}</label>
                                <input name="image" class="img form-control @error('image') is-invalid @enderror"
                                    type="file" id="image" required />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">

                                <div class="col-md-10">
                                    <img src="" style="width:300px; border: 1px solid #999"
                                        class="img-thumbnail img-prev">
                                </div>

                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New Slide') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
