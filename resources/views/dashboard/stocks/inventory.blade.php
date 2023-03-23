@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-2 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Stock Inventory') }}
                    </h5>
                </div>

                <div class="col-10 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">

                        <form id="filter-form" style="display: inline-block" action="">

                            <div class="row">
                                <div class="col-md-5">
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

                                <div class="col-md-7">
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

                        </form>


                    </div>
                </div>

            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($combinations->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Product Name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('SKU') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Quantity') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>

                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($combinations as $com)
                                @if ($com->product != null)
                                    <tr class="btn-reveal-trigger">

                                        <td class="name align-middle white-space-nowrap py-2">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset($com->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $com->product->images[0]->media->path) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">
                                                        {{ $com->product->images->count() }}
                                                        {{ getProductName($com->product, $com) }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $com->sku }}
                                        </td>


                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ productQuantity($com->product_id, $com->id, request()->warehouse_id, $user->hasPermission('branches-read') ? null : $user->branch->warehouses) }}
                                        </td>


                                        <td class="joined align-middle py-2">{{ $com->created_at }} <br>
                                            {{ interval($com->created_at) }} </td>


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
            {{ $combinations->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
