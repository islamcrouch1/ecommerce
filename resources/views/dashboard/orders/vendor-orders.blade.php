@extends('layouts.dashboard.app')

@section('adminContent')
    <form id="bulk-form" method="POST" action="{{ route('orders.vendor.status.bulk') }}">
        @csrf
        <div class="card mb-3" id="customersTable"
            data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                            {{ __('Vendors Orders') }}
                        </h5>
                    </div>
                    <div class="col-8 col-sm-auto text-end ps-2">
                        <div class="d-none" id="table-customers-actions">
                            <div class="d-flex">
                                <select name="selected_status" class="form-select form-select-sm" aria-label="Bulk actions"
                                    required>
                                    <option value="">{{ __('Change status') }}</option>
                                    <option value="delivered">
                                        {{ __('delivered') }}</option>
                                </select>
                                <button class="btn btn-falcon-default btn-sm ms-2"
                                    type="submit">{{ __('Apply') }}</button>
                            </div>
                        </div>

                        <form action=""></form>

                        <div id="table-customers-replace-element">
                            <form style="display: inline-block" action="">

                                <div class="d-inline-block">
                                    {{-- <label class="form-label" for="from">{{ __('From') }}</label> --}}
                                    <input type="date" id="from" name="from" class="form-control form-select-sm"
                                        value="{{ request()->from }}">
                                </div>

                                <div class="d-inline-block">
                                    {{-- <label class="form-label" for="to">{{ __('To') }}</label> --}}
                                    <input type="date" id="to" name="to"
                                        class="form-control form-select-sm sonoo-search" value="{{ request()->to }}">
                                </div>

                                <div class="d-inline-block">
                                    <select name="status" class="form-select form-select-sm sonoo-search"
                                        id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Status') }}</option>
                                        <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>
                                        <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                            {{ __('confirmed') }}</option>
                                        <option value="on the way"
                                            {{ request()->status == 'on the way' ? 'selected' : '' }}>
                                            {{ __('on the way') }}</option>
                                        <option value="in the mandatory period"
                                            {{ request()->status == 'in the mandatory period' ? 'selected' : '' }}>
                                            {{ __('in the mandatory period') }}</option>
                                        <option value="Waiting for the order amount to be released"
                                            {{ request()->status == 'Waiting for the order amount to be released' ? 'selected' : '' }}>
                                            {{ __('Waiting for the order amount to be released') }}</option>
                                        <option value="delivered" {{ request()->status == 'delivered' ? 'selected' : '' }}>
                                            {{ __('delivered') }}</option>
                                        <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                            {{ __('canceled') }}</option>
                                        <option value="returned" {{ request()->status == 'returned' ? 'selected' : '' }}>
                                            {{ __('returned') }}</option>
                                    </select>
                                </div>

                                <div class="d-inline-block">
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
                                </div>


                            </form>

                            <a href="{{ route('orders.vendor.mandatory') }}" class="btn btn-falcon-default btn-sm"
                                type="button"><span class="fas fa-receipt" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Mandatory') }}</span></a>
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
                                    <th>
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" id="checkbox-bulk-customers-select"
                                                type="checkbox"
                                                data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                        </div>
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="id">
                                        {{ __('Order ID') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('Vendor Name') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('Product') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                        {{ __('Status') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('Item Price') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('Quantity') }}</th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Total') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Platform Commission') }}
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Created At') }}</th>
                                    <th class="align-middle no-sort"></th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-customers-body">
                                @foreach ($orders as $order)
                                    <tr class="btn-reveal-trigger">
                                        <td class="align-middle py-2" style="width: 28px;">
                                            <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                                <input name="selected_items[]" value="{{ $order->id }}"
                                                    class="form-check-input" type="checkbox" id="customer-0"
                                                    data-bulk-select-row="data-bulk-select-row" />
                                            </div>
                                        </td>
                                        <td class="name align-middle white-space-nowrap py-2">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $order->id }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="address align-middle white-space-nowrap py-2">
                                            <a href="{{ route('users.show', ['user' => $order->user_id]) }}">{{ $order->user_name }}
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-nowrap">
                                                {{ getProductName($order->products()->first(), getCombination($order->products()->first()->pivot->product_combination_id)) }}
                                            </h6>
                                            <span class="badge badge-soft-info">
                                                SKU:{{ getCombination($order->products()->first()->pivot->product_combination_id)->sku }}
                                            </span>
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            @switch($order->status)
                                                @case('pending')
                                                    <span class="badge badge-soft-warning">{{ __('pending') }}</span>
                                                @break

                                                @case('confirmed')
                                                    <span class="badge badge-soft-primary">{{ __('confirmed') }}</span>
                                                @break

                                                @case('on the way')
                                                    <span class="badge badge-soft-info">{{ __('on the way') }}</span>
                                                @break

                                                @case('delivered')
                                                    <span class="badge badge-soft-success">{{ __('delivered') }}</span>
                                                @break

                                                @case('canceled')
                                                    <span class="badge badge-soft-danger">{{ __('canceled') }}</span>
                                                @break

                                                @case('in the mandatory period')
                                                    <span
                                                        class="badge badge-soft-danger">{{ __('in the mandatory period') }}</span>
                                                @break

                                                @case('returned')
                                                    <span class="badge badge-soft-danger">{{ __('returned') }}</span>
                                                @break

                                                @case('Waiting for the order amount to be released')
                                                    <span
                                                        class="badge badge-soft-info">{{ __('Waiting for the order amount to be released') }}</span>
                                                @break

                                                @case('RTO')
                                                    <span class="badge badge-soft-danger">{{ __('RTO') }}</span>
                                                @break

                                                @default
                                            @endswitch



                                        </td>
                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->products()->first()->pivot->product_price . ' ' . $order->country->currency }}
                                        </td>
                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->products()->first()->pivot->qty }}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->total_price . ' ' . $order->country->currency }}
                                        </td>
                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->total_commission . ' ' . $order->country->currency }}
                                        </td>
                                        <td class="joined align-middle py-2">{{ $order->created_at }} <br>
                                            {{ interval($order->created_at) }} </td>
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

                                                        @if (auth()->user()->hasPermission('orders-read'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('users.show', ['user' => $order->user_id]) }}">{{ __('Vendor Info') }}</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('orders.show', ['order' => $order->order_id]) }}">{{ __('Show Main Order') }}</a>
                                                        @endif

                                                        @if (auth()->user()->hasPermission('orders-update') && $order->status == 'Waiting for the order amount to be released')
                                                            <a href="" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#status-modal-{{ $order->id }}">{{ __('Change Status') }}</a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @if (auth()->user()->hasPermission('orders-update') && $order->status == 'Waiting for the order amount to be released')
                                        <!-- start change status modal for each order -->
                                        <div class="modal fade" id="status-modal-{{ $order->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document"
                                                style="max-width: 500px">
                                                <div class="modal-content position-relative">
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                        <button
                                                            class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST"
                                                        action="{{ route('orders.vendor.status', ['vendor_order' => $order->id]) }}">
                                                        @csrf
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">
                                                                    {{ __('Change status - order ID') . ' - #' . $order->id }}
                                                                </h4>
                                                            </div>
                                                            <div class="p-4 pb-0">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="bonus">{{ __('Change order status') }}</label>
                                                                    <select
                                                                        class="form-control @error('status') is-invalid @enderror"
                                                                        name="status" required>
                                                                        <option value="delivered"
                                                                            {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                                            {{ __('delivered') }}</option>
                                                                    </select>
                                                                    @error('status')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <button class="btn btn-primary"
                                                                type="submit">{{ __('Save') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end change status modal for each user -->
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    @else
                        <h3 class="p-4">{{ __('No orders To Show') }}</h3>
                    @endif
                </div>
            </div>


            <div class="card-footer d-flex align-items-center justify-content-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>

        </div>
    </form>
@endsection
