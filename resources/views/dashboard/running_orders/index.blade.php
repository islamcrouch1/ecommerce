@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-2 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('running orders') }}
                    </h5>
                </div>

                <div class="col-10 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">

                        <form id="filter-form" style="display: inline-block" action="">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="">
                                        <select name="warehouse_id" class="form-select form-select-sm sonoo-search"
                                            id="autoSizingSelect">
                                            <option value="">
                                                {{ __('all warehouses') }}</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ request()->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $warehouse->name_ar : $warehouse->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="">
                                        <select name="stock_status" class="form-select form-select-sm sonoo-search"
                                            id="autoSizingSelect">
                                            <option value="">{{ __('Select Stock Status') }}</option>
                                            <option value="IN" {{ request()->stock_status == 'IN' ? 'selected' : '' }}>
                                                {{ __('IN') }}</option>
                                            <option value="OUT" {{ request()->stock_status == 'OUT' ? 'selected' : '' }}>
                                                {{ __('OUT') }}</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="">
                                        <select name="status" class="form-select form-select-sm sonoo-search"
                                            id="autoSizingSelect">
                                            <option value="">{{ __('Select Status') }}</option>
                                            <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                                {{ __('pending') }}</option>
                                            <option value="partial" {{ request()->status == 'partial' ? 'selected' : '' }}>
                                                {{ __('partial qty') }}</option>
                                            <option value="completed"
                                                {{ request()->status == 'completed' ? 'selected' : '' }}>
                                                {{ __('completed') }}</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="">
                                        <select data-url="{{ route('stock.management.search') }}"
                                            data-locale="{{ app()->getLocale() }}"
                                            class="form-select product-search @error('product') is-invalid @enderror"
                                            aria-label="" name="product" id="product"
                                            data-options='{"removeItemButton":true,"placeholder":true ,addItems: true}'>
                                            <option value="">
                                                {{ __('all products') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>






                            {{-- <div class="d-inline-block">
                                <select name="country_id" class="form-select form-select-sm sonoo-search"
                                    id="autoSizingSelect">
                                    <option value="" selected>{{ __('All Countries') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}


                        </form>


                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($orders->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Product Name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('SKU - ID') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Warehouse') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Stock Status') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Requested Quantity') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Approved Quantity') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Returned Quantity') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Status') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($orders as $stock)
                                @if ($stock->product != null)
                                    <tr class="btn-reveal-trigger">

                                        <td class="name align-middle white-space-nowrap py-2">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset($stock->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $stock->product->images[0]->media->path) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">
                                                        {{ getProductName($stock->product, getCombination($stock->product_combination_id)) }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ getCombination($stock->product_combination_id)->sku . ' - ' . $stock->product->id }}
                                        </td>


                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ getName($stock->warehouse) }}
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ __($stock->stock_status) }}
                                        </td>

                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $stock->requested_qty }}
                                        </td>

                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $stock->approved_qty }}
                                        </td>

                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $stock->returned_qty }}
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {!! getRunningStatus($stock->status) !!}

                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ __($stock->stock_type) }}
                                        </td>

                                        <td class="joined align-middle py-2">{{ $stock->created_at }} <br>
                                            {{ interval($stock->created_at) }} </td>

                                        <td class="align-middle white-space-nowrap py-2 text-end">
                                            <div class="dropdown font-sans-serif position-static">
                                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                    type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                    data-boundary="window" aria-haspopup="true"
                                                    aria-expanded="false"><span
                                                        class="fas fa-ellipsis-h fs--1"></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0"
                                                    aria-labelledby="customer-dropdown-0">
                                                    <div class="bg-white py-2">
                                                        @if (auth()->user()->hasPermission('running_orders-update'))
                                                            <a class="dropdown-item" target="_blank"
                                                                href="{{ route('running_orders.edit', ['running_order' => $stock->id]) }}">{{ __('quantity validate') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $orders->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
