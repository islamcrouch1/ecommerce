@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Stock Transfers') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('stock_transfers.store') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="warehouse_from">{{ __('warehouse from') }}</label>

                                        <select class="form-select @error('warehouse_from') is-invalid @enderror"
                                            aria-label="" name="warehouse_from" id="warehouse_from" required>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ old('warehouse_from') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ getName($warehouse) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warehouse_from')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="warehouse_to">{{ __('warehouse to') }}</label>

                                        <select class="form-select @error('warehouse_to') is-invalid @enderror"
                                            aria-label="" name="warehouse_to" id="warehouse_to" required>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ old('warehouse_from') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ getName($warehouse) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warehouse_to')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="ref">{{ __('reference number') }}</label>
                                        <input name="ref" class="form-control @error('ref') is-invalid @enderror"
                                            value="{{ old('ref') }}" type="text" autocomplete="on" id="ref" />
                                        @error('ref')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="notes">{{ __('notes') }}</label>
                                        <input name="notes" class="form-control @error('notes') is-invalid @enderror"
                                            value="{{ old('notes') }}" type="text" autocomplete="on" id="notes" />
                                        @error('notes')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="product">{{ __('Select product') }}</label>

                                <select data-url_com="{{ route('stock.management.com') }}"
                                    data-url="{{ route('stock.management.search') }}"
                                    data-locale="{{ app()->getLocale() }}"
                                    class="form-select product-select @error('product') is-invalid @enderror" aria-label=""
                                    name="product" id="product" required>

                                </select>
                                @error('product')
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
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('add') . ' ' . __('stock transfer') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
