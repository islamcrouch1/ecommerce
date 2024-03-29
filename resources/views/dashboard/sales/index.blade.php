@extends('layouts.dashboard.app')

@section('adminContent')



    <form id="bulk-form" method="POST" action="{{ route('sales.status.bulk') }}">
        @csrf

        <div class="card mb-3" id="customersTable"
            data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">

                            @if (Route::is('sales.index'))
                                {{ __('sales') }}
                            @else
                                {{ __('quotaions') }}
                            @endif


                        </h5>
                    </div>
                    <div class="col-8 col-sm-auto text-end ps-2">
                        <div class="d-none" id="table-customers-actions">
                            <div class="d-flex">
                                <select name="selected_status" class="form-select form-select-sm" aria-label="Bulk actions"
                                    required>
                                    <option value="">{{ __('Change status') }}</option>
                                    <option value="completed">
                                        {{ __('completed') }}</option>

                                    <option value="returned">
                                        {{ __('returned') }}</option>

                                </select>
                                <button class="btn btn-falcon-default btn-sm ms-2"
                                    type="submit">{{ __('Apply') }}</button>
                            </div>

                        </div>

                        <form action=""></form>

                        <div id="table-customers-replace-element">
                            <form style="display: inline-block" action="">

                                <div class="d-inline-block">
                                    <select name="branch_id" class="form-select form-select-sm sonoo-search"
                                        id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Branches') }}</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ request()->branch_id == $branch->id ? 'selected' : '' }}>
                                                {{ getName($branch) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

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
                                        <option value="completed" {{ request()->status == 'completed' ? 'selected' : '' }}>
                                            {{ __('completed') }}</option>

                                        <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                            {{ __('canceled') }}</option>

                                    </select>
                                </div>

                                <div class="d-inline-block">
                                    <select name="invoice_status" class="form-select form-select-sm sonoo-search"
                                        id="autoSizingSelect">
                                        <option value="" selected>{{ __('All invoice status') }}</option>
                                        <option value="invoiced"
                                            {{ request()->invoice_status == 'invoiced' ? 'selected' : '' }}>
                                            {{ __('fully invoiced') }}</option>

                                        <option value="uninvoiced"
                                            {{ request()->invoice_status == 'uninvoiced' ? 'selected' : '' }}>
                                            {{ __('uninvoiced') }}</option>

                                        <option value="partial"
                                            {{ request()->invoice_status == 'partial' ? 'selected' : '' }}>
                                            {{ __('partially invoiced') }}</option>

                                    </select>
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


                            @if (auth()->user()->hasPermission('sales-create'))
                                <a href="{{ route('sales.create') }}" class="btn btn-falcon-default btn-sm"
                                    type="button"><span class="fas fa-plus"
                                        data-fa-transform="shrink-3 down-2"></span><span
                                        class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                                {{-- <a href="{{ route('sales.create.return') }}" class="btn btn-falcon-default btn-sm"
                                    type="button"><span class="fas fa-plus"
                                        data-fa-transform="shrink-3 down-2"></span><span
                                        class="d-none d-sm-inline-block ms-1">{{ __('Add return') }}</span></a> --}}


                                {{-- <a href="{{ route('sales.refunds') }}" class="btn btn-falcon-default btn-sm"
                                    type="button"><span class="fas fa-backward"
                                        data-fa-transform="shrink-3 down-2"></span><span
                                        class="d-none d-sm-inline-block ms-1">{{ __('Refunds Requsets') }}</span></a> --}}
                            @endif

                            {{-- <a href="{{ route('orders.export', ['status' => request()->status, 'from' => request()->from, 'to' => request()->to]) }}"
                                class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                    data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Export') }}</span></a> --}}
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
                                        {{ __('Order ID') }}
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('Customer Name') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                        {{ __('Status') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Invoice Status') }}
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                        {{ __('warehouse') }}</th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Total Without Tax') }}
                                    </th>



                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('discount') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('taxes') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('shipping fees') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Total') }}
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
                                                    <h5 class="mb-0 fs--1">
                                                        {{ __('Serial') . ': ' . $order->serial }} <br>
                                                        {{ __('ID') . ': ' . $order->id }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="address align-middle white-space-nowrap py-2">
                                            <a href="{{ route('users.show', ['user' => $order->customer_id]) }}">{{ $order->customer->name }}
                                            </a>


                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {!! getOrderHistory($order->status) !!}

                                            @if ($order->order_type == 'Q')
                                                <span class="badge badge-soft-info">{{ __('Quotation') }}</span>
                                            @elseif($order->order_type == 'SO')
                                                <span class="badge badge-soft-info">{{ __('SO') }}</span>
                                            @endif

                                            @if ($order->refunds->count() > 0 && $order->status != 'returned')
                                                @foreach ($order->refunds as $refund)
                                                    @if ($refund->status == 'pending')
                                                        <br><span
                                                            class="badge badge-soft-danger ">{{ __('There is a refund request') }}</span>
                                                    @elseif ($order->refund->status == 1)
                                                        <br><span
                                                            class="badge badge-soft-danger ">{{ __('Return request denied') }}</span>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </td>
                                        <td class="address align-middle white-space-nowrap py-2">
                                            {!! getOrderInvoiceStatus($order) !!}
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">



                                            {{ getName($order->warehouse) }}

                                        </td>


                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->subtotal_price . ' ' . $order->currency->symbol }}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->discount_amount . ' ' . $order->currency->symbol }}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            @foreach ($order->taxes as $tax)
                                                {{ getName($tax) . ': ' . $tax->pivot->amount . ' ' . $order->currency->symbol }}
                                                <br>
                                            @endforeach
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->shipping_amount . ' ' . $order->currency->symbol }}
                                        </td>


                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $order->total_price + $order->shipping_amount . ' ' . $order->currency->symbol }}
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

                                                        @if (auth()->user()->hasPermission('sales-update'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('users.show', ['user' => $order->customer_id]) }}">{{ __('Customer Info') }}</a>
                                                            @if ($order->affiliate_id != null)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('users.show', ['user' => $order->affiliate_id]) }}">{{ __('Affiliate Info') }}</a>
                                                            @endif
                                                            <a class="dropdown-item" target="_blank"
                                                                href="{{ route('sales.show', ['sale' => $order->id]) }}">{{ __('Display order') }}</a>


                                                            @if ($order->order_type == 'SO' && $order->status != 'returned')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('sales.create.return', ['order' => $order->id]) }}">{{ __('Add return') }}</a>
                                                            @endif



                                                            @if ($order->order_type == 'SO')
                                                                <a href="" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#status-modal-{{ $order->id }}">{{ __('Change Status') }}</a>
                                                            @endif


                                                            <a class="dropdown-item"
                                                                href="{{ route('sales.edit', ['sale' => $order->id]) }}">{{ __('Edit') }}</a>


                                                            @if ($order->refunds->count() > 0)
                                                                <a href="" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#refund-modal-{{ $order->id }}">{{ __('show refund requests') }}</a>
                                                            @endif
                                                            <a href="" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#track-modal-{{ $order->id }}">{{ __('Track order') }}</a>
                                                        @endif

                                                        @if (auth()->user()->hasPermission('invoices-read') &&
                                                                $order->status == 'completed' &&
                                                                $order->order_type == 'SO')
                                                            <a class="dropdown-item"
                                                                href="{{ route('invoices.index', ['order_id' => $order->id]) }}"
                                                                target="_blank">{{ __('invoices') }}</a>
                                                        @endif



                                                        @if (auth()->user()->hasPermission('orders_notes-read'))
                                                            <a href="" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#notes-modal-{{ $order->id }}">{{ __('Order Notes') }}</a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @if (auth()->user()->hasPermission('sales-update'))
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
                                                        action="{{ route('sales.status', ['order' => $order->id]) }}">
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
                                                                        <option value="">
                                                                            {{ __('select status') }}</option>

                                                                        <option value="canceled"
                                                                            {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                                                            {{ __('canceled') }}</option>
                                                                        <option value="completed"
                                                                            {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                                            {{ __('completed') }}</option>
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
                                        <!-- start order track modal for each order -->
                                        <div class="modal fade" id="track-modal-{{ $order->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document"
                                                style="max-width: 500px">
                                                <div class="modal-content position-relative">
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                        <button
                                                            class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-0">
                                                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                            <h4 class="mb-1" id="modalExampleDemoLabel">
                                                                {{ __('Track your order') . ' #' . $order->id }}
                                                            </h4>
                                                        </div>
                                                        <div class="m-2">
                                                            <div class="timeline-vertical">
                                                                <div class="timeline-item timeline-item-start">
                                                                    <div
                                                                        class="timeline-icon icon-item icon-item-lg text-primary border-300">
                                                                        <span class="fs-1 fas fa-check"></span>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6 timeline-item-time">
                                                                            <div>
                                                                                <p class="fs--1 mb-0 fw-semi-bold">
                                                                                    {{ $order->created_at }}</p>
                                                                                <p class="fs--2 text-600">
                                                                                    <span
                                                                                        class="badge badge-soft-light">{{ interval($order->created_at) }}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="timeline-item-content">
                                                                                <div style="padding: 10px"
                                                                                    class="timeline-item-card">
                                                                                    <span
                                                                                        class="badge badge-soft-success ">{{ __('Order created') }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @foreach ($order->histories as $history)
                                                                    <div class="timeline-item timeline-item-start">
                                                                        <div
                                                                            class="timeline-icon icon-item icon-item-lg text-primary border-300">
                                                                            <span class="fs-1 fas fa-check"></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 timeline-item-time">
                                                                                <div>
                                                                                    <p class="fs--1 mb-0 fw-semi-bold">
                                                                                        {{ $history->created_at }}</p>
                                                                                    <p class="fs--2 text-600">
                                                                                        <span
                                                                                            class="badge badge-soft-light">{{ interval($history->created_at) }}</span>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="timeline-item-content">
                                                                                    <div style="padding: 10px"
                                                                                        class="timeline-item-card">
                                                                                        {!! getOrderHistory($history->status) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        @if ($order->refunds->count() > 0)
                                            <!-- start order refund modal for each order -->
                                            <div class="modal fade" id="refund-modal-{{ $order->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document"
                                                    style="max-width: 600px">
                                                    <div class="modal-content position-relative">
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                            <button
                                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        {{-- <form method="POST"
                                                            action="{{ route('orders.refund.reject', ['order' => $order->id]) }}">
                                                            @csrf --}}
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">
                                                                    {{ __('refund requests') . ' #' . $order->id }}
                                                                </h4>
                                                            </div>
                                                            <div class="m-2">
                                                                <ul class="list-group">

                                                                    @foreach ($order->refunds as $refund)
                                                                        <li class="list-group-item">
                                                                            <div class="row">
                                                                                <div class="col-md-4">

                                                                                    <div
                                                                                        class="d-flex d-flex align-items-center">
                                                                                        <div class="avatar avatar-xl me-2">
                                                                                            <img class="rounded-circle"
                                                                                                src="{{ asset($refund->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $refund->product->images[0]->media->path) }}"
                                                                                                alt="" />
                                                                                        </div>
                                                                                        <div class="flex-1">
                                                                                            <h5 class="mb-0 fs--1">
                                                                                                {{ getProductName($refund->product, $refund->combination) }}
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                {{-- <div class="col-md-3">
                                                                                    {{ productPrice($item->product, $item->product_combination_id, 'vat') . $user->country->currency }}
                                                                                </div> --}}
                                                                                <div class="col-md-2">
                                                                                    {{ __('refund quantity') . ' :' . $refund->qty }}
                                                                                </div>
                                                                                {{-- <div class="col-md-3">
                                                                                    {{ productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty . $user->country->currency }}
                                                                                </div> --}}

                                                                                <div class="col-md-3">
                                                                                    {{ __('refund reason') . ' :' . $refund->reason }}
                                                                                </div>

                                                                                <div class="col-md-3">

                                                                                    <a
                                                                                        href="{{ route('users.show', ['user' => $refund->user_id]) }}">{{ $refund->user->name }}
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            {{-- @if (auth()->user()->hasPermission('orders-update'))
                                                                    <button class="btn btn-primary"
                                                                        type="submit">{{ __('Reject the return request') }}</button>
                                                                @endif --}}
                                                        </div>
                                                        {{-- </form> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end order refund modal for each user -->
                                        @endif
                                    @endif


                                    @if (auth()->user()->hasPermission('orders_notes-read'))
                                        <!-- start order notes modal for each order -->
                                        <div class="modal fade" id="notes-modal-{{ $order->id }}" tabindex="-1"
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
                                                        action="{{ route('orders.note', ['order' => $order->id]) }}">
                                                        @csrf
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">
                                                                    {{ __('Order Notes') . ' #' . $order->id }}
                                                                </h4>
                                                            </div>
                                                            <div class="mb-2">
                                                                @if ($order->order_notes->count() > 0)
                                                                    @foreach ($order->order_notes as $note)
                                                                        <div class="d-flex mt-3">
                                                                            <div class="avatar avatar-xl">
                                                                                <a
                                                                                    href="{{ route('users.show', ['user' => $note->user->id]) }}">
                                                                                    <img class="rounded-circle"
                                                                                        src="{{ asset('storage/images/users/' . $note->user->profile) }}"
                                                                                        alt="" />
                                                                                </a>
                                                                            </div>
                                                                            <div class="flex-1 ms-2 fs--1">
                                                                                <p class="mb-1 bg-200 rounded-3 p-2">
                                                                                    {{ $note->note }}
                                                                                </p>
                                                                                <div class="px-2">
                                                                                    {{ $note->created_at }}
                                                                                    <span class="badge badge-soft-info">
                                                                                        {{ interval($note->created_at) }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <p class="m-2">
                                                                        {{ __('There are currently no notes for this order') }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <div class="p-4 pb-0">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="note">{{ __('Note') }}</label>
                                                                    <input name="note"
                                                                        class="form-control @error('note') is-invalid @enderror"
                                                                        type="text" id="note" required />
                                                                    @error('note')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            @if (auth()->user()->hasPermission('orders_notes-update'))
                                                                <button class="btn btn-primary"
                                                                    type="submit">{{ __('Save') }}</button>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end order notes modal for each user -->
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
