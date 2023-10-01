@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('sales') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('sales.store', ['order_from' => 'sales', 'returned' => 'false']) }}"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="order_type">{{ __('select order status') }}</label>

                                        <select class="form-select @error('order_type') is-invalid @enderror" aria-label=""
                                            name="order_type" id="order_type" required>

                                            <option value="Q">
                                                {{ __('quotation') }}
                                            </option>

                                            <option value="SO">
                                                {{ __('sales order') }}
                                            </option>
                                        </select>
                                        @error('order_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="warehouse_id">{{ __('warehouse') }}</label>

                                        <select class="form-select @error('warehouse_id') is-invalid @enderror"
                                            aria-label="" name="warehouse_id" id="warehouse_id" required>
                                            <option value="">{{ __('select warehouse') }}</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ getName($warehouse) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warehouse_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="user_id">{{ __('customer') }}</label>

                                        <select class="form-select js-choice @error('user_id') is-invalid @enderror"
                                            aria-label="" name="user_id" id="user_id" required>
                                            <option value="">{{ __('select customer') }}</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="expected_delivery">{{ __('expected delivery time') }}</label>

                                        <input type="datetime-local" id="expected_delivery" name="expected_delivery"
                                            class="form-control @error('expected_delivery') is-invalid @enderror"
                                            value="{{ old('expected_delivery') }}">
                                        @error('expected_delivery')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="currency_id">{{ __('select currency') }}</label>
                                        <select class="form-select currency @error('currency_id') is-invalid @enderror"
                                            aria-label="" name="currency_id" id="currency_id" required>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ isset(getDefaultCurrency()->id) && getDefaultCurrency()->id == $currency->id ? 'selected' : '' }}>
                                                    {{ getName($currency) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('currency_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                            </div>


                            <div style="display:none" class="data"
                                data-products_search_url="{{ route('products.search') }}"
                                data-locale="{{ app()->getLocale() }}"
                                data-get_combinations_url="{{ route('combinations.get') }}"
                                data-get_units="{{ route('units.get') }}"
                                data-calculate_total="{{ route('total.calculate') }}"></div>



                            <div class="mb-3">
                                <label class="form-label" for="products">{{ __('Select product') }}</label>

                                <select multiple="multiple"
                                    class="form-select product-select @error('products') is-invalid @enderror"
                                    aria-label="" name="products[]" id="products" required>

                                </select>
                                @error('products')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="display: none" class="mb-3 combinations-select">
                                <label class="form-label" for="combinations">{{ __('Select combination') }}</label>

                                <select multiple="multiple"
                                    class="form-select com-select @error('combinations') is-invalid @enderror"
                                    aria-label="" name="combinations[]" id="combinations">

                                </select>
                                @error('combinations')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row combinations-div">


                            </div>



                            <div class="row">


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="discount">{{ __('discount') }}</label>
                                        <input name="discount"
                                            class="form-control discount @error('discount') is-invalid @enderror"
                                            value="{{ old('discount') ? old('discount') : 0 }}" type="number"
                                            min="0" step="0.01" autocomplete="on" id="discount" />

                                        @error('discount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="shipping">{{ __('shipping fees') }}</label>
                                        <input name="shipping"
                                            class="form-control shipping @error('shipping') is-invalid @enderror"
                                            value="{{ old('shipping') ? old('shipping') : 0 }}" type="number"
                                            min="0" step="0.01" autocomplete="on" id="shipping" />

                                        @error('shipping')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="taxes">{{ __('taxes') }}</label>

                                        <select
                                            class="form-select tax-select js-choice @error('taxes') is-invalid @enderror"
                                            aria-label="" name="taxes[]" id="taxes" multiple>

                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}"
                                                    {{ is_array(old('taxes')) && in_array($tax->id, old('taxes')) ? 'selected' : '' }}>
                                                    {{ getName($tax) . ' ' . ($tax->type == 'plus' ? '+' : '-') . $tax->tax_rate . '%' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('taxes')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>



                            <div class="row justify-content-start mt-3">
                                <div class="col-auto">
                                    <table class="table table-sm table-borderless fs--1 text-start taxes-table">
                                        <tr>
                                            <th class="text-900">{{ __('total without tax:') }}</th>
                                            <td class="fw-semi-bold subtotal">0</td>
                                        </tr>

                                        <div class="taxes">



                                        </div>

                                        <tr>
                                            <th class="text-900">{{ __('shipping fees') . ':' }}</th>
                                            <td class="fw-semi-bold shipping-value">0</td>
                                        </tr>
                                        <tr>
                                            <th class="text-900">{{ __('discount') . ':' }}</th>
                                            <td class="fw-semi-bold discount-value">0</td>
                                        </tr>
                                        <tr class="border-top">
                                            <th class="text-900">{{ __('Total:') }}</th>
                                            <td class="fw-semi-bold total">0</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            <div class="mb-3 mt-3">
                                <label class="form-label mb-2" for="notes">{{ __('notes and conditions') }}</label>

                                <textarea id="notes" class="form-control tinymce d-none @error('notes') is-invalid @enderror" name="notes">{!! old('notes') ? old('notes') : setting('sales_terms_' . app()->getLocale()) !!}</textarea>


                                @error('notes')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('add') . ' ' . __('sales') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
