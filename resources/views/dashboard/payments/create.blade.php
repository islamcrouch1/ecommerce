@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Payments') . ' - ' . __($invoice->status) . ': ' . $invoice->serial }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">

                <div class="col-md-6 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <div class="list-group">
                            <a class="list-group-item list-group-item-action disabled" href="#">
                                {{ __($invoice->status) }}
                            </a>
                            <a class="list-group-item list-group-item-action"
                                href="{{ route('users.show', ['user' => $invoice->customer_id]) }}" target="_blank">

                                @if ($invoice->status == 'invoice' || $invoice->status == 'credit_note')
                                    {{ __('Customer Name') . ': ' . $invoice->customer->name }}
                                @else
                                    {{ __('Supplier Name') . ': ' . $invoice->customer->name }}
                                @endif


                            </a>
                            <a class="list-group-item list-group-item-action"
                                href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}" target="_blank">
                                {{ __('ducument serial') . ': ' . $invoice->serial }}
                            </a>
                            <a class="list-group-item list-group-item-action disabled"
                                href="#">{{ __('The total document amount') . ': ' . getInvoiceTotalAmount($invoice) . ' ' . $invoice->currency->symbol }}</a>
                            <a class="list-group-item list-group-item-action disabled"
                                href="#">{{ __('The total amount due') . ': ' . (getInvoiceTotalAmount($invoice) - (getInvoiceTotalPayments($invoice) - getInvoiceTotalReturns($invoice))) . ' ' . $invoice->currency->symbol }}</a>
                        </div>


                    </div>
                </div>

                {{-- <div class="col-md-6 d-flex flex-center">

                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('payments.store', ['order' => $order->id]) }}"
                            enctype="multipart/form-data">
                            @csrf



                            <div style="display:none" class="div-data" data-url="{{ route('entries.accounts') }}"
                                data-locale="{{ app()->getLocale() }}"></div>



                            <div class="mb-3">
                                <label class="form-label" for="amount">{{ __('Enter amount') }}</label>
                                <input name="amount" class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" type="number" step="0.01" autocomplete="on"
                                    id="amount" autofocus required />
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="account_id">{{ __('select cash account') }}</label>

                                <select class="form-select @error('account_id') is-invalid @enderror" aria-label=""
                                    name="account_id" id="account_id">

                                    <option value="">{{ __('select cash account') }}
                                    </option>

                                    @foreach (getCashAccounts() as $account)
                                        <option value="{{ $account->id }}">
                                            {{ getName($account) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('account_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Make payment') }}</button>
                            </div>
                        </form>

                    </div>
                </div> --}}
            </div>

        </div>
    </div>


    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if ($invoice->status == 'invoice' || $invoice->status == 'credit_note')
                            {{ __('Previous receipts') }}
                        @else
                            {{ __('Previous payment receipts') }}
                        @endif
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">

                        <div class="table-responsive scrollbar">
                            @if ($invoice->payments->count() > 0)
                                <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                                    <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="id">
                                                {{ __('ID') }}
                                            </th>
                                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                                @if ($invoice->status == 'invoice' || $invoice->status == 'credit_note')
                                                    {{ __('Customer Name') }}
                                                @else
                                                    {{ __('Supplier Name') }}
                                                @endif
                                            </th>
                                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                                {{ __('From account') }}</th>
                                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                                {{ __('To account') }}
                                            </th>
                                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                                {{ __('Amount') }}</th>

                                            <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                                data-sort="joined">{{ __('Created At') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="table-customers-body">
                                        @foreach ($invoice->payments as $payment)
                                            <tr class="btn-reveal-trigger">

                                                <td class="name align-middle white-space-nowrap py-2">
                                                    <div class="d-flex d-flex align-items-center">
                                                        <div class="flex-1">
                                                            <h5 class="mb-0 fs--1">{{ $payment->id }}</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="address align-middle white-space-nowrap py-2">
                                                    <a href="{{ route('users.show', ['user' => $payment->user_id]) }}"
                                                        target="_blank">{{ $payment->user->name }}
                                                    </a>
                                                </td>
                                                <td class="phone align-middle white-space-nowrap py-2">
                                                    <a href="{{ route('entries.index', ['account_id' => $payment->from_account]) }}"
                                                        target="_blank">{{ getName($payment->from) }}
                                                    </a>

                                                </td>
                                                <td class="address align-middle white-space-nowrap py-2">
                                                    <a href="{{ route('entries.index', ['account_id' => $payment->to_account]) }}"
                                                        target="_blank">
                                                        {{ getName($payment->to) }}
                                                    </a>

                                                </td>
                                                <td class="phone align-middle white-space-nowrap py-2">
                                                    {{ $payment->amount . ' ' . $invoice->currency->symbol }}
                                                </td>


                                                <td class="joined align-middle py-2">{{ $payment->created_at }} <br>
                                                    {{ interval($payment->created_at) }} </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
