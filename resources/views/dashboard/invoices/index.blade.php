@extends('layouts.dashboard.app')

@section('adminContent')



    <form id="bulk-form" method="POST" action="{{ route('sales.status.bulk') }}">
        @csrf

        @if (request()->has('order_id'))
            <div class="row g-3 mb-3">
                <div class="col">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <div class="card overflow-hidden" style="min-width: 12rem">
                                <div class="bg-holder bg-card"
                                    style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
                                </div>
                                <!--/.bg-holder-->

                                <div class="card-body position-relative">
                                    <h6>{{ __('Total order amount') }}</h6>
                                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-success">
                                        {{ $order->total_price + $order->shipping_amount . ' ' . $order->currency->symbol }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card overflow-hidden" style="min-width: 12rem">
                                <div class="bg-holder bg-card"
                                    style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);">
                                </div>
                                <!--/.bg-holder-->

                                @php
                                    $total_invoices = getOrderTotalInvoices($order);
                                @endphp

                                <div class="card-body position-relative">
                                    <h6>{{ __('Total invoices') }} <span class="badge badge-soft-info rounded-pill ms-2">
                                            @if ($order->total_price + $order->shipping_amount != 0)
                                                {{ ($total_invoices * 100) / ($order->total_price + $order->shipping_amount) }}%
                                            @else
                                                0%
                                            @endif
                                        </span>
                                    </h6>
                                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info">
                                        {{ $total_invoices . ' ' . $order->currency->symbol }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card overflow-hidden" style="min-width: 12rem">
                                <div class="bg-holder bg-card"
                                    style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);">
                                </div>
                                <!--/.bg-holder-->

                                @php
                                    $total_returnes = getOrderTotalReturnes($order);
                                @endphp

                                <div class="card-body position-relative">
                                    <h6>{{ $order->order_from == 'sales' ? __('Total credit notes') : __('Total debit notes') }}
                                    </h6>
                                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-danger">
                                        {{ $total_returnes . ' ' . $order->currency->symbol }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card overflow-hidden" style="min-width: 12rem">
                                <div class="bg-holder bg-card"
                                    style="background-image:url(../assets/img/icons/spot-illustrations/corner-4.png);">
                                </div>
                                <!--/.bg-holder-->

                                @php
                                    $total_returnes = getOrderTotalReturnes($order);
                                @endphp

                                <div class="card-body position-relative">
                                    <h6>{{ __('Total uninvoiced amount') }}
                                    </h6>
                                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning">
                                        {{ $order->total_price + $order->shipping_amount - ($total_invoices - $total_returnes) . ' ' . $order->currency->symbol }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        @endif

        <div class="card mb-3" id="customersTable"
            data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">



                            @if (request()->has('order_id'))
                                {{ __('invoices') . ' - ' . __('order serial') . ' : ' . $order->serial }}
                            @else
                                {{ __('invoices') }}
                            @endif


                        </h5>
                    </div>
                    <div class="col-8 col-sm-auto text-end ps-2">
                        <div class="d-none" id="table-customers-actions">


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
                                        <option value="invoice" {{ request()->status == 'invoice' ? 'selected' : '' }}>
                                            {{ __('invoice') }}</option>

                                        <option value="credit_note"
                                            {{ request()->status == 'credit_note' ? 'selected' : '' }}>
                                            {{ __('credit_note') }}</option>

                                        <option value="bill" {{ request()->status == 'bill' ? 'selected' : '' }}>
                                            {{ __('bill') }}</option>

                                        <option value="debit_note"
                                            {{ request()->status == 'debit_note' ? 'selected' : '' }}>
                                            {{ __('debit_note') }}</option>

                                    </select>
                                </div>

                                <div class="d-inline-block">
                                    <select name="payment_status" class="form-select form-select-sm sonoo-search"
                                        id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Payment Status') }}</option>
                                        <option value="pending"
                                            {{ request()->payment_status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>

                                        <option value="paid" {{ request()->payment_status == 'paid' ? 'selected' : '' }}>
                                            {{ __('paid') }}</option>

                                        <option value="partial"
                                            {{ request()->payment_status == 'partial' ? 'selected' : '' }}>
                                            {{ __('partial') }}</option>

                                    </select>
                                </div>

                            </form>


                            @if (auth()->user()->hasPermission('sales-create'))
                                <a href="{{ route('invoices.create', ['order_id' => request()->order_id]) }}"
                                    class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus"
                                        data-fa-transform="shrink-3 down-2"></span><span
                                        class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive scrollbar">
                    @if ($invoices->count() > 0)
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
                                        {{ __('invoice id') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="id">
                                        {{ __('order id') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('Name') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                        {{ __('document type') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Payment Status') }}
                                    </th>


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

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Due date') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Created At') }}</th>
                                    <th class="align-middle no-sort"></th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-customers-body">
                                @foreach ($invoices as $invoice)
                                    <tr class="btn-reveal-trigger">
                                        <td class="align-middle py-2" style="width: 28px;">
                                            <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                                <input name="selected_items[]" value="{{ $order->id }}"
                                                    class="form-check-input" type="checkbox" id="customer-0"
                                                    data-bulk-select-row="data-bulk-select-row" />
                                            </div>
                                        </td>
                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $invoice->serial }}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ __('Serial') . ': ' . $invoice->order->serial . ' - ' . __('ID') . ': ' . $invoice->order->id }}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            <a href="{{ route('users.show', ['user' => $invoice->customer_id]) }}">{{ $invoice->customer->name }}
                                            </a>
                                        </td>


                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {!! getInvoiceStatus($invoice) !!}
                                        </td>




                                        <td class="address align-middle white-space-nowrap py-2">
                                            {!! getInvoicePaymentStatus($invoice) !!}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $invoice->subtotal_price . ' ' . $invoice->currency->symbol }}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $invoice->discount_amount . ' ' . $invoice->currency->symbol }}
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            @foreach ($invoice->taxes as $tax)
                                                {{ getName($tax) . ': ' . $tax->pivot->amount . ' ' . $invoice->currency->symbol }}
                                                <br>
                                            @endforeach
                                        </td>

                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $invoice->shipping_amount . ' ' . $invoice->currency->symbol }}
                                        </td>


                                        <td class="address align-middle white-space-nowrap py-2">
                                            {{ $invoice->total_price + $invoice->shipping_amount . ' ' . $invoice->currency->symbol }}
                                        </td>

                                        <td class="joined align-middle py-2">{{ $invoice->due_date }} <br>
                                            {{ interval($invoice->due_date) }} </td>

                                        <td class="joined align-middle py-2">{{ $invoice->created_at }} <br>
                                            {{ interval($invoice->created_at) }} </td>



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

                                                        @if (auth()->user()->hasPermission('invoices-read'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('users.show', ['user' => $invoice->customer_id]) }}">{{ __('User Info') }}</a>

                                                            <a class="dropdown-item" target="_blank"
                                                                href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}">{{ __('Display ducument') }}</a>
                                                        @endif



                                                        @if (auth()->user()->hasPermission('payments-create') &&
                                                                ($invoice->status == 'pending' || $invoice->status == 'partial'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('payments.create', ['invoice' => $invoice->id]) }}"
                                                                target="_blank">{{ __('Make payment') }}</a>
                                                        @endif


                                                        @if (auth()->user()->hasPermission('payments-read'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('payments.create', ['invoice' => $invoice->id]) }}"
                                                                target="_blank">{{ __('payments') }}</a>
                                                        @endif



                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    @else
                        <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                    @endif
                </div>
            </div>


            <div class="card-footer d-flex align-items-center justify-content-center">
                {{ $invoices->appends(request()->query())->links() }}
            </div>

        </div>
    </form>

@endsection
