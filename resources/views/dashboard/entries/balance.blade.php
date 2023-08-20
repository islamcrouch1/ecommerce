@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">

                        {{ __('Balance sheet') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
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
                        </form>
                        <button onclick="printInvoice();" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0 no-print"
                            type="button"><span class="fas fa-print me-1"> </span>{{ __('Print') }}</button>
                    </div>
                </div>
            </div>





            <div class="card-body">
                <div class="row g-0">



                    <div class="table-responsive scrollbar">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">{{ __('Account Name') }}</th>
                                    <th class="text-end" scope="col">{{ __('Balance') }}</th>
                                </tr>
                            </thead>
                            <tbody>



                                {{-- <tr class="table-primary">
                                    <td>{{ __('Gross Profit') }}</td>
                                    <td class="text-end">{{ $cs - $services_cost . ' ' . getCurrency() }}</td>
                                </tr> --}}



                                @foreach ($all_accounts as $account)
                                    @php
                                        $balance = getTrialBalance($account->id, request()->from, request()->to);
                                        $count = 0;
                                    @endphp

                                    <tr class="table-primary">
                                        <td class="no-print">
                                            @if ($account->accounts->count() > 0)
                                                <a class="btn btn-falcon-primary" data-bs-toggle="collapse"
                                                    href="#col-{{ $account->id }}" role="button" aria-expanded="false"
                                                    aria-controls="collapseExample">
                                                    <span class="fas fa-plus">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="dropdown-item" target="_blank"
                                                href="{{ route('entries.index', ['account_id' => $account->id]) }}">
                                                {{ getName($account) }}
                                            </a>
                                        </td>
                                        <td class="text-end">{{ $balance . ' ' . getCurrency() }}</td>
                                    </tr>

                                    @php
                                        $accounts = getSubAccounts($account->id);
                                    @endphp

                                    @if ($account->accounts->count() > 0)
                                        @foreach ($account->accounts as $subAccount)
                                            @php
                                                $balance = getTrialBalance($subAccount->id, request()->from, request()->to);
                                                $count = 2;
                                            @endphp

                                            <tr class="collapse  table-success" id="col-{{ $account->id }}">
                                                <td class="no-print">
                                                    @if ($subAccount->accounts->count() > 0)
                                                        <a class="btn btn-falcon-primary" data-bs-toggle="collapse"
                                                            href="#col-{{ $subAccount->id }}" role="button"
                                                            aria-expanded="false"
                                                            aria-controls="col-{{ $subAccount->id }}">
                                                            <span class="fas fa-plus">
                                                        </a>
                                                    @endif

                                                </td>
                                                <td>

                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('entries.index', ['account_id' => $subAccount->id]) }}">
                                                        {{ getName($subAccount) }}
                                                    </a>
                                                </td>
                                                <td class="text-end">{{ $balance . ' ' . getCurrency() }}</td>
                                            </tr>


                                            @include('dashboard.entries._balance_account', [
                                                'account' => $subAccount,
                                                'count' => $count,
                                            ])
                                        @endforeach
                                    @endif
                                @endforeach


                            </tbody>
                        </table>
                    </div>


                </div>
            </div>




        </div>
    </div>
@endsection
