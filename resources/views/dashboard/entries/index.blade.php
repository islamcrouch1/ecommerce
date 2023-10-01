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

                            @if (auth()->user()->hasPermission('quick_entries-create'))
                                <a href="{{ route('entries.quick.create', ['parent_id' => request()->parent_id]) }}"
                                    class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus"
                                        data-fa-transform="shrink-3 down-2"></span><span
                                        class="d-none d-sm-inline-block ms-1">{{ __('New quick entry') }}</span></a>
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
            <div class="card mb-3">
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
                            <h6 class="pb-1 text-700">{{ __('Balance') }} </h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ getTrialBalance(request()->account_id, request()->from, request()->to) }}
                            </p>
                        </div>

                        <div class="col-4 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                            <h6 class="pb-1 text-700">{{ __('Total Balance') }} </h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">

                                {{ getTrialBalance(request()->account_id, null, null) }}
                            </p>
                        </div>




                    </div>
                </div>
            </div>

            @foreach ($accounts as $index => $account)
                <div class="card">
                    <div class="card-header">
                        <div class="row flex-between-center">
                            <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                                <h3 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                                    {{ __('Account statement') . ': ' . getName($account) }}
                                </h3>
                            </div>

                        </div>
                    </div>
                    <div class="card mb-3">
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
                                    <h6 class="pb-1 text-700">{{ __('Balance') }} </h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ getTrialBalance($account->id, request()->from, request()->to) }}
                                    </p>
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

                                {{-- <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('ID') }}
                                </th> --}}

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('branch') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('entry description') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('entry amount') }}</th>


                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('document number') }}</th>


                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                                <th class="align-middle no-sort"></th>

                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($entries as $entry)
                                <tr class="btn-reveal-trigger">


                                    {{-- <td class="phone align-middle white-space-nowrap py-2">{{ $entry->id }}
                                    </td> --}}

                                    <td class="phone align-middle white-space-nowrap py-2">{{ getName($entry->branch) }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $entry->description . ($entry->due_date ? ' - ' . __('due date: ') . $entry->due_date : '') }}
                                    </td>


                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ getEntryAmount($entry) . ' ' . $entry->currency->symbol }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $entry->doc_num }}
                                    </td>


                                    <td class="joined align-middle py-2">{{ $entry->created_at }} <br>
                                        {{ interval($entry->created_at) }} </td>
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">

                                                    @if ($entry->media_id != null)
                                                        <a class="dropdown-item" href="{{ asset($entry->media->path) }}"
                                                            target="_blank">{{ __('document image') }}</a>
                                                    @endif

                                                    @if (auth()->user()->hasPermission('entries-read'))
                                                        <a href="" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#show-entries-{{ $entry->id }}">{{ __('show entry') }}</a>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>

                    </table>



                    @foreach ($entries as $entry)
                        <div class="modal fade" id="show-entries-{{ $entry->id }}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%">
                                <div class="modal-content position-relative">
                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                            <h4 class="mb-1" id="modalExampleDemoLabel">
                                                {{ __('show entry') . ': ' . $entry->description }}
                                            </h4>
                                        </div>
                                        <div class="p-4 pb-0">

                                            <div class="table-responsive scrollbar">

                                                <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                                                    <thead class="bg-200 text-900">
                                                        <tr>

                                                            <th class="sort pe-1 align-middle white-space-nowrap"
                                                                data-sort="name">
                                                                {{ __('ID') }}
                                                            </th>



                                                            <th class="sort pe-1 align-middle white-space-nowrap"
                                                                data-sort="phone">
                                                                {{ __('entry description') }}</th>
                                                            <th class="sort pe-1 align-middle white-space-nowrap"
                                                                data-sort="email">
                                                                {{ __('account name') }}</th>

                                                            <th class="sort pe-1 align-middle white-space-nowrap"
                                                                data-sort="email">
                                                                {{ __('document number') }}</th>
                                                            <th class="sort pe-1 align-middle white-space-nowrap"
                                                                data-sort="email">
                                                                {{ __('dr') }}</th>
                                                            <th class="sort pe-1 align-middle white-space-nowrap"
                                                                data-sort="email">
                                                                {{ __('cr') }}</th>




                                                        </tr>
                                                    </thead>
                                                    <tbody class="list" id="table-customers-body">
                                                        @foreach (getEntryDetailsCr($entry) as $entry)
                                                            <tr class="btn-reveal-trigger">

                                                                <td class="phone align-middle white-space-nowrap py-2">
                                                                    {{ $entry->id }}
                                                                </td>


                                                                <td class="phone align-middle white-space-nowrap py-2">
                                                                    {{ $entry->description . ($entry->due_date ? ' - ' . __('due date: ') . $entry->due_date : '') }}
                                                                </td>
                                                                <td class="name align-middle white-space-nowrap py-2">
                                                                    <div class="d-flex d-flex align-items-center">

                                                                        <div class="flex-1">
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('entries.index', ['account_id' => $entry->account_id]) }}">
                                                                                <h5 class="mb-0 fs--1">
                                                                                    {{ getName(getAccount($entry->account_id)) }}
                                                                                </h5>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="phone align-middle white-space-nowrap py-2">
                                                                    {{ $entry->doc_num }}
                                                                </td>
                                                                <td class="phone align-middle white-space-nowrap py-2 ltr">
                                                                    {{ round($entry->dr_amount, 2) . ' ' . $entry->currency->symbol }}
                                                                    {{ getEntryAmountInCurrency($entry, 'dr') }}
                                                                </td>
                                                                <td class="phone align-middle white-space-nowrap py-2 ltr">
                                                                    {{ round($entry->cr_amount, 2) . ' ' . $entry->currency->symbol }}
                                                                    {{ getEntryAmountInCurrency($entry, 'cr') }}
                                                                </td>




                                                            </tr>
                                                        @endforeach
                                                        @foreach (getEntryDetailsDr($entry) as $entry)
                                                            <tr class="btn-reveal-trigger">

                                                                <td class="phone align-middle white-space-nowrap py-2">
                                                                    {{ $entry->id }}
                                                                </td>


                                                                <td class="phone align-middle white-space-nowrap py-2">
                                                                    {{ $entry->description . ($entry->due_date ? ' - ' . __('due date: ') . $entry->due_date : '') }}
                                                                </td>
                                                                <td class="name align-middle white-space-nowrap py-2">
                                                                    <div class="d-flex d-flex align-items-center">

                                                                        <div class="flex-1">
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('entries.index', ['account_id' => $entry->account_id]) }}">
                                                                                <h5 class="mb-0 fs--1">
                                                                                    {{ getName(getAccount($entry->account_id)) }}
                                                                                </h5>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="phone align-middle white-space-nowrap py-2">
                                                                    {{ $entry->doc_num }}
                                                                </td>
                                                                <td class="phone align-middle white-space-nowrap py-2 ltr">
                                                                    {{ round($entry->dr_amount, 2) . ' ' . $entry->currency->symbol }}
                                                                    {{ getEntryAmountInCurrency($entry, 'dr') }}
                                                                </td>
                                                                <td class="phone align-middle white-space-nowrap py-2 ltr">
                                                                    {{ round($entry->cr_amount, 2) . ' ' . $entry->currency->symbol }}
                                                                    {{ getEntryAmountInCurrency($entry, 'cr') }}
                                                                </td>




                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>

                                            </div>

                                            @if ($entry->media_id)
                                                <div class="m-3">
                                                    <div class="col-md-12" id="gallery">

                                                        <a class="dropdown-item" href="{{ asset($entry->media->path) }}"
                                                            target="_blank"> <img src="{{ asset($entry->media->path) }}"
                                                                style="width:500px; border: 1px solid #999"
                                                                class="img-thumbnail img-prev">
                                                        </a>


                                                    </div>
                                                </div>
                                            @endif




                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">{{ __('Close') }}</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
