@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('add') . ' ' . __('country') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('countries.store') }}" enctype="multipart/form-data">
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
                                <label class="form-label" for="code">{{ __('Country Code') }}</label>
                                <input name="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" type="text" autocomplete="on" id="code" autofocus
                                    required />
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone_digits">{{ __('phone digits') }}</label>
                                <input name="phone_digits" class="form-control @error('phone_digits') is-invalid @enderror"
                                    value="{{ old('phone_digits') }}" type="number" min="0" autocomplete="on"
                                    id="phone_digits" autofocus required />
                                @error('phone_digits')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="currency">{{ __('Country Currency') }}</label>
                                <input name="currency" class="form-control @error('currency') is-invalid @enderror"
                                    value="{{ old('currency') }}" type="text" autocomplete="on" id="currency"
                                    required />
                                @error('currency')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="shipping_amount">{{ __('shipping amount') }}</label>
                                <input name="shipping_amount"
                                    class="form-control @error('shipping_amount') is-invalid @enderror"
                                    value="{{ old('shipping_amount') }}" type="number" step="0.01" min="0"
                                    autocomplete="on" id="shipping_amount" required />
                                @error('shipping_amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="status">{{ __('Status') }}</label>
                                <select class="form-select @error('status') is-invalid @enderror" aria-label=""
                                    name="status" id="status" required>
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


                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="is_default">{{ __('Is Default') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="is_default"
                                            class="form-control @error('is_default') is-invalid @enderror" name="is_default"
                                            type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    @error('is_default')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="media">{{ __('Country flag') }}</label>
                                <input name="media" class="img form-control @error('media') is-invalid @enderror"
                                    type="file" id="media" required />
                                @error('media')
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
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('add') . ' ' . __('country') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
