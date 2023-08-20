@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('purchases') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('orders.store.new', ['order_from' => 'addpurchase', 'returned' => 'false']) }}"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="row">


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="order_type">{{ __('select order status') }}</label>

                                        <select class="form-select @error('order_type') is-invalid @enderror" aria-label=""
                                            name="order_type" id="order_type" required>

                                            <option value="RFQ">
                                                {{ __('request for quotation') }}
                                            </option>

                                            <option value="PO">
                                                {{ __('purchase order') }}
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

                                        <select class="form-select  @error('warehouse_id') is-invalid @enderror"
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
                                        <label class="form-label" for="user_id">{{ __('supplier') }}</label>

                                        <select class="form-select js-choice @error('user_id') is-invalid @enderror"
                                            aria-label="" name="user_id" id="user_id" required>
                                            <option value="">{{ __('select supplier') }}</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('user_id') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
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

                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="products">{{ __('Select product') }}</label>

                                <select data-url_com="{{ route('purchases.combinations') }}"
                                    data-url_cal="{{ route('purchases.combinations.cal') }}"
                                    data-url="{{ route('stock.management.search') }}"
                                    data-locale="{{ app()->getLocale() }}" multiple="multiple"
                                    class="form-select product-select @error('products') is-invalid @enderror"
                                    aria-label="" name="products[]" id="products" required>



                                </select>
                                @error('products')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="display: none" class="mb-3 combinations-select">
                                <label class="form-label" for="combinations">{{ __('Select combination') }}</label>

                                <select data-url="{{ route('stock.management.search') }}"
                                    data-locale="{{ app()->getLocale() }}" multiple="multiple"
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
                                            value="0" type="number" min="0" step="0.01" autocomplete="on"
                                            id="discount" />

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
                                            value="0" type="number" min="0" step="0.01"
                                            autocomplete="on" id="shipping" />

                                        @error('shipping')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="taxes">{{ __('taxes') }}</label>

                                        <select
                                            class="form-select purchase-tax js-choice @error('taxes') is-invalid @enderror"
                                            aria-label="" name="taxes[]" id="taxes" multiple>

                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}">
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



                            {{--
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input name="tax[]"
                                            class="form-check-input purchase-tax @error('tax') is-invalid @enderror"
                                            id="flexCheckDefault" type="checkbox" value="vat" />
                                        <label class="form-check-label"
                                            for="flexCheckDefault">{{ __('added value tax') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="tax[]"
                                            class="form-check-input purchase-tax @error('tax') is-invalid @enderror"
                                            id="flexCheckChecked" type="checkbox" value="wht" />
                                        <label class="form-check-label"
                                            for="flexCheckChecked">{{ __('withholding and collect tax') }}</label>
                                    </div>

                                    @error('tax')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}


                            <div class="row justify-content-start mt-3">
                                <div class="col-auto">
                                    <table class="table table-sm table-borderless fs--1 text-start taxes-table">
                                        <tr>
                                            <th class="text-900">{{ __('total without tax:') }}</th>
                                            <td class="fw-semi-bold subtotal">0</td>
                                        </tr>

                                        <div class="taxes">
                                            {{-- <tr>
                                                <th class="text-900">{{ __('added value tax') . ':' }}</th>
                                                <td class="fw-semi-bold vat-amount">0</td>
                                            </tr>
                                            <tr>
                                                <th class="text-900">{{ __('withholding and collect tax') . ':' }}</th>
                                                <td class="fw-semi-bold wht-amount">0</td>
                                            </tr> --}}
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

                                <textarea id="notes" class="form-control tinymce d-none @error('notes') is-invalid @enderror" name="notes">{!! app()->getLocale() == 'ar' ? setting('purchases_terms_ar') : setting('purchases_terms_en') !!}</textarea>


                                @error('notes')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('save') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
