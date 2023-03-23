@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('asset') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('assets.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_ar">{{ __('account name') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ old('name_ar') }}" type="text" autocomplete="on" id="name_ar" autofocus
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_en">{{ __('account name') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ old('name_en') }}" type="text" autocomplete="on" id="name_en" required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="code">{{ __('account code') }}</label>
                                <input name="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" type="text" autocomplete="on" id="code" required />
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label"
                                    for="dep_rate">{{ __('depreciation rate') . ' - ' . __('annually') }}</label>
                                <input name="dep_rate" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('dep_rate') }}" type="number" min="0" max="100"
                                    autocomplete="on" id="dep_rate" required />
                                @error('dep_rate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('asset') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
