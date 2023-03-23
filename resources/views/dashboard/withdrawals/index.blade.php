@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Withdrawals Requests') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-customers-actions">
                        <div class="d-flex">
                            <select class="form-select form-select-sm" aria-label="Bulk actions">
                                <option selected="">{{ __('Bulk actions') }}</option>
                                <option value="Refund">{{ __('Refund') }}</option>
                                <option value="Delete">{{ __('Delete') }}</option>
                                <option value="Archive">{{ __('Archive') }}</option>
                            </select>
                            <button class="btn btn-falcon-default btn-sm ms-2" type="button">{{ __('Apply') }}</button>
                        </div>
                    </div>
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
                                    <option value="recieved"
                                        {{ request()->status == 'confirmrecieveded' ? 'selected' : '' }}>
                                        {{ __('recieved') }}</option>
                                    <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                        {{ __('confirmed') }}</option>
                                    <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                        {{ __('canceled') }}</option>
                                </select>
                            </div>

                        </form>

                        <a href="{{ route('withdrawals.export', ['status' => request()->status, 'from' => request()->from, 'to' => request()->to]) }}"
                            class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">Export</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($withdrawals->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('User Name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('User Type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Payment Type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Payment data') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Amount') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Status') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">Created at</th>
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($withdrawals as $withdrawal)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>
                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $withdrawal->user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $withdrawal->user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">
                                                        {{ $withdrawal->user->name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $withdrawal->user->HasRole('affiliate') ? __('Affiliate') : __('Vendor') }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        @if ($withdrawal->type == '1')
                                            {{ __('Vodafone Cash') }}
                                        @endif
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">{{ $withdrawal->data }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $withdrawal->amount . ' ' . $withdrawal->user->country->currency }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2"> @switch($withdrawal->status)
                                            @case('pending')
                                                <span
                                                    class="badge badge-soft-primary">{{ __('Awaiting review from management') }}</span>
                                            @break

                                            @case('recieved')
                                                <span
                                                    class="badge badge-soft-info">{{ __('Your request has been received and is being reviewed for a deposit') }}</span>
                                            @break

                                            @case('confirmed')
                                                <span
                                                    class="badge badge-soft-success">{{ __('The amount has been deposited into your account') }}</span>
                                            @break

                                            @case('canceled')
                                                <span
                                                    class="badge badge-soft-danger">{{ __('Request rejected Please contact customer service to find out the reason') }}</span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>

                                    <td class="joined align-middle py-2">{{ $withdrawal->created_at }} <br>
                                        {{ interval($withdrawal->created_at) }} </td>
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">
                                                    @if (auth()->user()->hasPermission('withdrawals-update'))
                                                        <a href="" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#withdrawal-modal-{{ $withdrawal->id }}">{{ __('Change Request Status') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if (auth()->user()->hasPermission('withdrawals-update'))
                                    <!-- start change status modal for each order -->
                                    <div class="modal fade" id="withdrawal-modal-{{ $withdrawal->id }}" tabindex="-1"
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
                                                    action="{{ route('withdrawals.update', ['withdrawal' => $withdrawal->id]) }}">
                                                    @csrf
                                                    <div class="modal-body p-0">
                                                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                            <h4 class="mb-1" id="modalExampleDemoLabel">
                                                                {{ __('Change Request Status for - ') . $withdrawal->user->name }}
                                                            </h4>
                                                        </div>
                                                        <div class="p-4 pb-0">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="bonus">{{ __('Select Status') }}</label>
                                                                <select
                                                                    class="form-control @error('status') is-invalid @enderror"
                                                                    name="status" required>
                                                                    <option value="pending"
                                                                        {{ $withdrawal->status == 'pending' ? 'selected' : '' }}>
                                                                        {{ __('pending') }}</option>
                                                                    <option value="recieved"
                                                                        {{ $withdrawal->status == 'recieved' ? 'selected' : '' }}>
                                                                        {{ __('recieved') }}</option>
                                                                    <option value="confirmed"
                                                                        {{ $withdrawal->status == 'confirmed' ? 'selected' : '' }}>
                                                                        {{ __('confirmed') }}</option>
                                                                    <option value="canceled"
                                                                        {{ $withdrawal->status == 'canceled' ? 'selected' : '' }}>
                                                                        {{ __('canceled') }}</option>
                                                                </select>
                                                                @error('status')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="account_id">{{ __('select cash account') }}</label>

                                                                <select
                                                                    class="form-select @error('account_id') is-invalid @enderror"
                                                                    aria-label="" name="account_id" id="account_id">

                                                                    <option value="">{{ __('select cash account') }}
                                                                    </option>

                                                                    @foreach ($cash_accounts->accounts as $account)
                                                                        <option value="{{ $account->id }}">
                                                                            {{ getName($account) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('account_id')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button class="btn btn-primary"
                                                            type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h3 class="p-4">{{ __('No withdrawals To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $withdrawals->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
