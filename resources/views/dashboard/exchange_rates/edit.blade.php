@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('edit') . ' ' . __('exchange rate') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('exchange_rates.update', ['exchange_rate' => $exchange_rate->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_ar">{{ __('default currency') . ' ' . getName($exchange_rate->default_currency) }}</label>

                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="currency_id">{{ __('select currency') }}</label>
                                <select class="form-select @error('currency_id') is-invalid @enderror" aria-label=""
                                    name="currency_id" id="currency_id" required>
                                    @foreach ($currencies as $currency)
                                        @if (getDefaultCurrency() && getDefaultCurrency()->id != $currency->id)
                                            <option value="{{ $currency->id }}"
                                                {{ $exchange_rate->currency_id == $currency->id ? 'selected' : '' }}>
                                                {{ getName($currency) }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="rate">{{ __('exchange rate') }}</label>
                                <input name="rate" class="form-control @error('rate') is-invalid @enderror"
                                    value="{{ $exchange_rate->rate }}" type="number" min="0" step="0.0001"
                                    autocomplete="on" id="rate" />
                                @error('rate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('edit') . ' ' . __('exchange rate') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
