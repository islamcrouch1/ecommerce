@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit Shipping Rate') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('shipping_rates.update', ['shipping_rate' => $shipping_rate->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="city_ar">{{ __('City name - arabic') }}</label>
                                <input name="city_ar" class="form-control @error('city_ar') is-invalid @enderror"
                                    value="{{ $shipping_rate->city_ar }}" type="text" autocomplete="on" id="city_ar"
                                    autofocus required />
                                @error('city_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="city_en">{{ __('City name - english') }}</label>
                                <input name="city_en" class="form-control @error('city_en') is-invalid @enderror"
                                    value="{{ $shipping_rate->city_en }}" type="text" autocomplete="on" id="city_en"
                                    autofocus required />
                                @error('city_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="cost">{{ __('Cost') }}</label>
                                <input name="cost" class="form-control @error('cost') is-invalid @enderror"
                                    value="{{ $shipping_rate->cost }}" type="number" min="0" autocomplete="on"
                                    id="cost" required />
                                @error('cost')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="country">{{ __('Country') }}</label>

                                <select class="form-select @error('country') is-invalid @enderror" aria-label=""
                                    name="country" id="country" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $shipping_rate->country_id == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Edit
                                                                                                                                                Shipping Rate') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
