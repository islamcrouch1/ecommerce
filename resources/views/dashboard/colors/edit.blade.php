@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Edit Color</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('colors.update', ['color' => $color->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="color_ar">{{ __('color name - arabic') }}</label>
                                <input name="color_ar" class="form-control @error('color_ar') is-invalid @enderror"
                                    value="{{ $color->color_ar }}" type="text" autocomplete="on" id="color_ar" autofocus
                                    required />
                                @error('color_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="color_en">{{ __('color name - english') }}</label>
                                <input name="color_en" class="form-control @error('color_en') is-invalid @enderror"
                                    value="{{ $color->color_en }}" type="text" autocomplete="on" id="color_en"
                                    required />
                                @error('color_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="hex">{{ __('color hex') }}</label>
                                <div style="position: relative" class="colorpicker colorpicker-component">
                                    <input name="hex" class="form-control @error('hex') is-invalid @enderror"
                                        value="{{ $color->hex }}" type="text" autocomplete="on" id="hex"
                                        required />
                                    <span class="input-group-addon"><i
                                            style="width:35px; height:35px; border-radius:10px; border:1px solid #ced4da; position: absolute; top:4px; {{ app()->getLocale() == 'ar' ? 'left:4px;' : 'right:4px;' }}"></i></span>

                                    @error('hex')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Edit
                                                                                                                                                color') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
