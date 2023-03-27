@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('edit') . ' ' . __('coupon') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('coupons.update', ['coupon' => $coupon->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')




                            <div class="mb-3">
                                <label class="form-label" for="code">{{ __('code') }}</label>
                                <input name="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ $coupon->code }}" type="text" autocomplete="on" id="code" autofocus
                                    required />
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="amount">{{ __('coupon amount') }}</label>
                                <input name="amount" class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ $coupon->amount }}" min="1" step="0.01" type="number"
                                    autocomplete="on" id="amount" required />
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="max_value">{{ __('max value') }}</label>
                                <input name="max_value" class="form-control @error('max_value') is-invalid @enderror"
                                    value="{{ $coupon->max_value }}" min="1" step="0.01" type="number"
                                    autocomplete="on" id="max_value" required />
                                @error('max_value')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('type') }}</label>

                                <select class="form-select country-select @error('type') is-invalid @enderror"
                                    aria-label="" name="type" id="type" required>
                                    <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>
                                        {{ __('percentage') }}
                                    </option>
                                    <option value="amount" {{ $coupon->type == 'amount' ? 'selected' : '' }}>
                                        {{ __('amount') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="frequency">{{ __('frequency of use') }}</label>
                                <input name="frequency" class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ $coupon->frequency }}" min="1" type="frequency" autocomplete="on"
                                    id="frequency" required />
                                @error('frequency')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="ended_at">{{ __('end date') }}</label>

                                <input type="datetime-local" id="ended_at" name="ended_at"
                                    class="form-control @error('ended_at') is-invalid @enderror"
                                    value="{{ $coupon->ended_at }}" required>

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
                                            {{ $coupon->country_id == $country->id ? 'selected' : '' }}>
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
                                    name="submit">{{ __('edit') . ' ' . __('coupon') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
