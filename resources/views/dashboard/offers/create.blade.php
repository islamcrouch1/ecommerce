@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('add') . ' ' . __('offer') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('offers.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('offers type') }}</label>
                                <select class="form-select offer-type @error('type') is-invalid @enderror" aria-label=""
                                    name="type" id="type" required>
                                    <option value="">
                                        {{ __('Select offer type') }}
                                    </option>
                                    <option value="home_page_offer">
                                        {{ __('Countdown timer on home page') }}
                                    </option>
                                    <option value="product_page_offer">
                                        {{ __('Countdown timer on product page') }}
                                    </option>
                                    <option value="product_quantity_discount">
                                        {{ __('Quantity discount on product page') }}
                                    </option>
                                    <option value="product_page_sticker">
                                        {{ __('Stickers on product page') }}
                                    </option>
                                    <option value="bundles_offer">
                                        {{ __('bundles offer') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="display:none" class="mb-3 amount">
                                <label class="form-label " for="amount">{{ __('offer amount %') }}</label>
                                <input name="amount"
                                    class="form-control amount-field @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" min="0.1" step="0.01" type="number"
                                    id="amount" />
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="display:none" class="mb-3 qty">
                                <label class="form-label "
                                    for="qty">{{ __('product quantity to apply the discount') }}</label>
                                <input name="qty" class="form-control qty-field @error('qty') is-invalid @enderror"
                                    value="{{ old('qty') }}" min="1" type="number" id="qty" />
                                @error('qty')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


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
                                    name="submit">{{ __('add') . ' ' . __('offer') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
