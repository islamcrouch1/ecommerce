@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header no-print">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if ($accounts->count() > 0 && $accounts[0]->trashed())
                            {{ __('accounts') . ' ' . __('trash') }}
                        @elseif(request()->parent_id == null)
                            {{ __('accounts') }}
                        @else
                            {{ __('subaccounts') . ': ' . getName(getAccount(request()->parent_id)) }}
                        @endif
                    </h5>
                </div>
                <div class="col-8  text-end ps-2">
                    <div class="d-none" id="table-customers-actions">
                        <div class="d-flex">
                            <select class="form-select form-select-sm" aria-label="Bulk actions">
                                {{-- <option selected="">{{ __('Bulk actions') }}</option>
                                <option value="Refund">{{ __('Refund') }}</option>
                                <option value="Delete">{{ __('Delete') }}</option>
                                <option value="Archive">{{ __('Archive') }}</option> --}}
                            </select>
                            <button class="btn btn-falcon-default btn-sm ms-2" type="button">{{ __('Apply') }}</button>
                        </div>
                    </div>
                    <div id="table-customers-replace-element">

                        <form style="display: inline-block; width:60%" action="">

                            <div style="width: 60%;" class="d-inline-block">
                                <select class="form-select model-search sonoo-search" data-url="{{ route('model.search') }}"
                                    data-locale="{{ app()->getLocale() }}" data-parent="" data-type="accounts"
                                    name="account_id">
                                    <option value="">
                                        {{ __('accounts search') }}</option>

                                </select>
                            </div>


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



                        </form>

                        @if (request()->parent_id != null)
                            <a href="{{ route('accounts.index', ['parent_id' => getAccount(request()->parent_id)->parent_id, 'branch_id' => request()->branch_id]) }}"
                                class="btn btn-falcon-default btn-sm" type="button"><span
                                    class="fa fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                    data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Back') }}</span></a>
                        @endif

                        @if (auth()->user()->hasPermission('accounts-create'))
                            <a href="{{ route('accounts.create', ['parent_id' => request()->parent_id]) }}"
                                class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus"
                                    data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                        @endif
                        <a href="{{ route('accounts.trashed', ['parent_id' => request()->parent_id]) }}"
                            class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-trash"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Trash ') }}</span></a>
                        <a href="{{ route('accounts.export', ['data' => request()->all()]) }}"
                            class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Export') }}</span></a>

                        <button onclick="printInvoice();" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"
                            type="button"><span class="fas fa-print me-1"> </span>{{ __('Print') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($accounts->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="no-print">
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('ID') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('branch') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('code') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('account type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap no-print" data-sort="email">
                                    {{ __('sub accounts') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                                @if ($accounts->count() > 0 && $accounts[0]->trashed())
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Deleted at') }}</th>
                                @endif
                                <th class="align-middle no-sort no-print"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($accounts as $account)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2 no-print" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">{{ $account->id }}
                                    </td>
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <div class="d-flex d-flex align-items-center">

                                            <div class="flex-1">
                                                <a class="dropdown-item"
                                                    href="{{ route('entries.index', ['account_id' => $account->id]) }}">
                                                    <h5 class="mb-0 fs--1">
                                                        {{ getName($account) }}
                                                    </h5>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">{{ getName($account->branch) }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">{{ $account->code }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ __($account->account_type) }} </td>
                                    <td class="phone align-middle white-space-nowrap py-2 no-print"><a
                                            href="{{ route('accounts.index', ['parent_id' => $account->id, 'branch_id' => request()->branch_id]) }}"
                                            class="btn btn-falcon-primary btn-sm me-1 mb-1">{{ __('sub accounts') }}
                                        </a></td>
                                    <td class="joined align-middle py-2">{{ $account->created_at }} <br>
                                        {{ interval($account->created_at) }} </td>
                                    @if ($account->trashed())
                                        <td class="joined align-middle py-2">{{ $account->deleted_at }} <br>
                                            {{ interval($account->deleted_at) }} </td>
                                    @endif
                                    <td class="align-middle white-space-nowrap py-2 text-end no-print">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">
                                                    @if (
                                                        $account->trashed() &&
                                                            auth()->user()->hasPermission('accounts-restore'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('accounts.restore', ['account' => $account->id]) }}">{{ __('Restore') }}</a>
                                                    @elseif(auth()->user()->hasPermission('accounts-update'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('accounts.edit', ['account' => $account->id]) }}">{{ __('Edit') }}</a>
                                                    @endif
                                                    @if (auth()->user()->hasPermission('accounts-read'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('entries.index', ['account_id' => $account->id]) }}">{{ __('Account statement') }}</a>
                                                    @endif

                                                    @if (auth()->user()->hasPermission('accounts-delete') ||
                                                            auth()->user()->hasPermission('accounts-trash'))
                                                        <form method="POST"
                                                            action="{{ route('accounts.destroy', ['account' => $account->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ $account->trashed() ? __('Delete') : __('Trash ') }}</button>
                                                        </form>
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
                    <h3 class="p-4">{{ __('No data to show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $accounts->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
