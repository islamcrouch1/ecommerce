@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('add') . ' ' . __('coupon') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('coupons.store') }}" enctype="multipart/form-data">
                            @csrf



                            <div class="mb-3">
                                <label class="form-label" for="code">{{ __('code') }}</label>
                                <input name="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" type="text" autocomplete="on" id="code" autofocus
                                    required />
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="amount">{{ __('coupon amount') }}</label>
                                <input name="amount" class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" min="1" step="0.01" type="number"
                                    autocomplete="on" id="amount" required />
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="max_value">{{ __('max value for discount') }}</label>
                                <input name="max_value" class="form-control @error('max_value') is-invalid @enderror"
                                    value="{{ old('max_value') }}" min="1" step="0.01" type="number"
                                    autocomplete="on" id="max_value" required />
                                @error('max_value')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="min_value">{{ __('min value for invoice') }}</label>
                                <input name="min_value" class="form-control @error('min_value') is-invalid @enderror"
                                    value="{{ old('min_value') }}" min="1" step="0.01" type="number"
                                    autocomplete="on" id="min_value" required />
                                @error('min_value')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="free_shipping">{{ __('free shipping') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="free_shipping"
                                            class="form-control @error('free_shipping') is-invalid @enderror"
                                            name="free_shipping" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    @error('free_shipping')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('type') }}</label>

                                <select class="form-select country-select @error('type') is-invalid @enderror"
                                    aria-label="" name="type" id="type" required>
                                    <option value="percentage">
                                        {{ __('percentage') }}
                                    </option>
                                    <option value="amount">
                                        {{ __('amount') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="user_frequency">{{ __('user frequency') }}</label>
                                <input name="user_frequency"
                                    class="form-control @error('user_frequency') is-invalid @enderror"
                                    value="{{ old('user_frequency') }}" min="1" type="user_frequency"
                                    autocomplete="on" id="user_frequency" required />
                                @error('user_frequency')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="all_frequency">{{ __('all frequency') }}</label>
                                <input name="all_frequency"
                                    class="form-control @error('all_frequency') is-invalid @enderror"
                                    value="{{ old('all_frequency') }}" min="1" type="all_frequency"
                                    autocomplete="on" id="all_frequency" required />
                                @error('all_frequency')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 p-variation product-variations-">
                                <label class="form-label" for="products">{{ __('products') }}</label>
                                <select class="form-select model-search @error('products') is-invalid @enderror"
                                    data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                    data-parent="" data-type="products" name="products[]" multiple="multiple"
                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">
                                        {{ __('select products') }}</option>

                                </select>
                                @error('products')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 p-variation product-variations-">
                                <label class="form-label" for="categories">{{ __('categories') }}</label>
                                <select class="form-select model-search @error('categories') is-invalid @enderror"
                                    data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                    data-parent="" data-type="categories" name="categories[]" multiple="multiple"
                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">
                                        {{ __('select categories') }}</option>

                                </select>
                                @error('categories')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="ended_at">{{ __('end date') }}</label>

                                <input type="datetime-local" id="ended_at" name="ended_at"
                                    class="form-control @error('ended_at') is-invalid @enderror" value="" required>

                                @error('ended_at')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="country_id">{{ __('Country') }}</label>

                                <select class="form-select @error('country_id') is-invalid @enderror" aria-label=""
                                    name="country_id" id="country_id" required>
                                    @foreach ($countries as $country)
                                        <option data-country_id="{{ $country->id }}" value="{{ $country->id }}"
                                            {{ old('country') == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>





                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('add') . ' ' . __('coupon') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
