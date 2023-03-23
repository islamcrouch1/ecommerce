@extends('layouts.dashboard.app')

@section('adminContent')
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
                                    <option value="on the way" {{ request()->status == 'on the way' ? 'selected' : '' }}>
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
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="id">{{ __('Order ID') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('Product') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                    {{ __('Status') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Item Price') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('Quantity') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">{{ __('Total') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Platform Commission') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created At') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($orders as $order)
                                <tr class="btn-reveal-trigger">
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <div class="d-flex d-flex align-items-center">
                                            <div class="flex-1">
                                                <h5 class="mb-0 fs--1">{{ $order->id }}</h5>
                                            </div>
                                        </div>
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
                                                <span class="badge badge-soft-danger">{{ __('in the mandatory period') }}</span>
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
                                </tr>
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
@endsection
