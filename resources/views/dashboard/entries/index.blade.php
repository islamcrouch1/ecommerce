@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if (isset(request()->account_id))
                            {{ __('Account statement') . ': ' . getName(getAccount(request()->account_id)) }}
                        @else
                            {{ __('entries') }}
                        @endif
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
                            @if (isset(request()->account_id))
                                <div style="display: none">
                                    <input type="text" name="account_id" value="{{ request()->account_id }}"
                                        id="">
                                </div>
                            @endif

                        </form>

                        @if (!isset(request()->account_id))
                            @if (auth()->user()->hasPermission('entries-create'))
                                <a href="{{ route('entries.create', ['parent_id' => request()->parent_id]) }}"
                                    class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus"
                                        data-fa-transform="shrink-3 down-2"></span><span
                                        class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                            @endif
                        @endif
                        {{-- <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Export') }}</span></button> --}}
                    </div>
                </div>
            </div>
        </div>

        @if (isset(request()->account_id))
            <div class="card py-3 mb-3">
                <div class="card-body py-3">
                    <div class="row g-0">
                        <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                            <h6 class="pb-1 text-700">{{ __('cr') }} </h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ getAccountBalance(request()->account_id, 'cr', request()->from, request()->to) }}
                            </p>
                        </div>
                        <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                            <h6 class="pb-1 text-700">{{ __('dr') }}</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ getAccountBalance(request()->account_id, 'dr', request()->from, request()->to) }}</p>
                        </div>
                        <div class="col-4 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                            <h6 class="pb-1 text-700">{{ __('Trial Balance') . ' : ' . __('cr') }} </h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ getTrialBalance(request()->account_id, request()->from, request()->to)['cr'] }}
                            </p>
                        </div>
                        <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                            <h6 class="pb-1 text-700">{{ __('Trial Balance') . ' : ' . __('dr') }}</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ getTrialBalance(request()->account_id, request()->from, request()->to)['dr'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($accounts as $index => $account)
                <div class="card">
                    <div class="card-header">
                        <div class="row flex-between-center">
                            <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                                    {{ __('Account statement') . ': ' . getName($account) }}
                                </h5>
                            </div>

                        </div>
                    </div>
                    <div class="card py-3 mb-3">
                        <div class="card-body py-3">
                            <div class="row g-0">
                                <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('cr') }} </h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ getAccountBalance($account->id, 'cr', request()->from, request()->to) }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('dr') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ getAccountBalance($account->id, 'dr', request()->from, request()->to) }}</p>
                                </div>
                                <div class="col-4 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('Trial Balance') . ' : ' . __('cr') }} </h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ getTrialBalance($account->id, request()->from, request()->to)['cr'] }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('Trial Balance') . ' : ' . __('dr') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ getTrialBalance($account->id, request()->from, request()->to)['dr'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif



        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($entries->count() > 0)
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
                                    {{ __('ID') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('entry description') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('account name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('cr') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('dr') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>

                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($entries as $entry)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">{{ $entry->id }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">{{ $entry->description }}
                                    </td>
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <div class="d-flex d-flex align-items-center">

                                            <div class="flex-1">
                                                <h5 class="mb-0 fs--1">
                                                    {{ getName(getAccount($entry->account_id)) }}
                                                </h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ round($entry->cr_amount, 2) }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ round($entry->dr_amount, 2) }}
                                    </td>

                                    <td class="joined align-middle py-2">{{ $entry->created_at }} <br>
                                        {{ interval($entry->created_at) }} </td>


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
            {{ $entries->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
