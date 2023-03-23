@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('add') . ' ' . __('stage') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('stages.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ old('name_ar') }}" type="text" autocomplete="on" id="name_ar" autofocus
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('title') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ old('name_en') }}" type="text" autocomplete="on" id="name_en" autofocus
                                    required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="score">{{ __('score to pass this stage') }}</label>
                                <input name="score" class="form-control @error('score') is-invalid @enderror"
                                    value="0" min="0" type="number" autocomplete="on" id="score" autofocus
                                    required />
                                @error('score')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 mt-5">
                                <label class="form-label" for="select_type">{{ __('please add stage fields') }}</label><br>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-select select_type" aria-label="" name="select_type"
                                        id="select_type" required>
                                        <option value="name">
                                            {{ __('name') }}
                                        </option>
                                        <option value="text">
                                            {{ __('text') }}
                                        </option>
                                        <option value="photo">
                                            {{ __('photo') }}
                                        </option>
                                        <option value="number">
                                            {{ __('number') }}
                                        </option>
                                        <option value="checkbox">
                                            {{ __('checkbox') }}
                                        </option>
                                        <option value="radio">
                                            {{ __('radio') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button href="javascript:void(0);" data-locale="{{ app()->getLocale() }}"
                                        class="btn btn-outline-primary btn-sm add_field me-1 mb-1 mt-1"
                                        type="button">{{ __('add field') }}
                                    </button>
                                </div>
                            </div>



                            <div class="field_wrapper">






                            </div>








                            <div class="mb-3">
                                <button class="btn btn-primary submit-form d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('add') . ' ' . __('stage') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
