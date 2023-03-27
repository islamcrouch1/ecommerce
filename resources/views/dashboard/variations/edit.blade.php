@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit') . ' ' . __('variation') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('variations.update', ['variation' => $variation->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ $variation->name_ar }}" type="text" autocomplete="on" id="name_ar"
                                    autofocus required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('title') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ $variation->name_en }}" type="text" autocomplete="on" id="name_en"
                                    required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            @if (in_array($variation->attribute->name_en, ['color', 'Color', 'colors', 'Colors'], true))
                                <div class="mb-3 color-hex">
                                    <label class="form-label" for="value">{{ __('color hex') }}</label>
                                    <div style="position: relative" class="colorpicker colorpicker-component">
                                        <input name="value" class="form-control @error('value') is-invalid @enderror"
                                            value="{{ $variation->value }}" type="text" autocomplete="on" id="value"
                                            required />
                                        <span class="input-group-addon"><i
                                                style="width:35px; height:35px; border-radius:10px; border:1px solid #ced4da; position: absolute; top:4px; {{ app()->getLocale() == 'ar' ? 'left:4px;' : 'right:4px;' }}"></i></span>

                                        @error('value')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Edit') . ' ' . __('variation') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
