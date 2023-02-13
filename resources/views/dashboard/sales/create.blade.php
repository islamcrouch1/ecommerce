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
                        <form method="POST" action="{{ route('sales.store') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
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

                                        <select class="form-select @error('user_id') is-invalid @enderror" aria-label=""
                                            name="user_id" id="user_id" required>
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

                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="products">{{ __('Select product') }}</label>

                                <select data-url_com="{{ route('sales.combinations') }}"
                                    data-url_cal="{{ route('sales.combinations.cal') }}"
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



                            <div class="mb-3">
                                <label class="form-label" for="notes">{{ __('notes') }}</label>
                                <textarea name="notes" rows="5" class="form-control @error('notes') is-invalid @enderror" id="notes"></textarea>
                                @error('notes')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">





                                <div class="form-check">
                                    <input name="tax[]"
                                        class="form-check-input sale-tax @error('tax') is-invalid @enderror"
                                        id="flexCheckDefault" type="checkbox" value="vat-from" />
                                    <label class="form-check-label"
                                        for="flexCheckDefault">{{ __('added value tax') . ' ' . __('(from sale price)') }}</label>
                                </div>

                                <div class="form-check">
                                    <input name="tax[]"
                                        class="form-check-input sale-tax @error('tax') is-invalid @enderror"
                                        id="flexCheckDefault" type="checkbox" value="vat-on" />
                                    <label class="form-check-label"
                                        for="flexCheckDefault">{{ __('added value tax') . ' ' . __('(on sale price)') }}</label>
                                </div>
                                <div class="form-check">
                                    <input name="tax[]"
                                        class="form-check-input sale-tax @error('tax') is-invalid @enderror"
                                        id="flexCheckChecked" type="checkbox" value="wht" />
                                    <label class="form-check-label"
                                        for="flexCheckChecked">{{ __('withholding at source tax') }}</label>
                                </div>

                                @error('tax')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="row justify-content-start">
                                <div class="col-auto">
                                    <table class="table table-sm table-borderless fs--1 text-start">
                                        <tr>
                                            <th class="text-900">{{ __('total without tax:') }}</th>
                                            <td class="fw-semi-bold subtotal">0</td>
                                        </tr>
                                        <tr>
                                            <th class="text-900">{{ __('added value tax') . ':' }}</th>
                                            <td class="fw-semi-bold vat-amount">0</td>
                                        </tr>
                                        <tr>
                                            <th class="text-900">{{ __('withholding at source tax') . ':' }}</th>
                                            <td class="fw-semi-bold wht-amount">0</td>
                                        </tr>
                                        <tr class="border-top">
                                            <th class="text-900">{{ __('Total:') }}</th>
                                            <td class="fw-semi-bold total">0</td>
                                        </tr>
                                    </table>
                                </div>
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
