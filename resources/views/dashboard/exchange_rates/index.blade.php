@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if ($exchange_rates->count() > 0 && $exchange_rates[0]->trashed())
                            {{ __('exchange rates') . ' ' . __('trash') }}
                        @else
                            {{ __('exchange rates') }}
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

                        @if (auth()->user()->hasPermission('exchange_rates-create'))
                            <a href="{{ route('exchange_rates.create') }}" class="btn btn-falcon-default btn-sm"
                                type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                        @endif
                        <a href="{{ route('exchange_rates.trashed') }}" class="btn btn-falcon-default btn-sm"
                            type="button"><span class="fas fa-trash" data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Trash ') }}</span></a>
                        <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Export') }}</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($exchange_rates->count() > 0)
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
                                    {{ __('default currency') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">{{ __('currency') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('exchange rate') }}</th>


                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                                @if ($exchange_rates->count() > 0 && $exchange_rates[0]->trashed())
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Deleted at') }}</th>
                                @endif
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($exchange_rates as $exchange_rate)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ getName($exchange_rate->default_currency) }}</td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ getName($exchange_rate->currency) }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $exchange_rate->rate }}
                                    </td>


                                    <td class="joined align-middle py-2">{{ $exchange_rate->created_at }} <br>
                                        {{ interval($exchange_rate->created_at) }} </td>
                                    @if ($exchange_rate->trashed())
                                        <td class="joined align-middle py-2">{{ $exchange_rate->deleted_at }} <br>
                                            {{ interval($exchange_rate->deleted_at) }} </td>
                                    @endif
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">
                                                    @if (
                                                        $exchange_rate->trashed() &&
                                                            auth()->user()->hasPermission('exchange_rates-restore'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('exchange_rates.restore', ['exchange_rate' => $exchange_rate->id]) }}">{{ __('Restore') }}</a>
                                                    @elseif(auth()->user()->hasPermission('exchange_rates-update'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('exchange_rates.edit', ['exchange_rate' => $exchange_rate->id]) }}">{{ __('Edit') }}</a>
                                                    @endif
                                                    @if (auth()->user()->hasPermission('exchange_rates-delete') ||
                                                            auth()->user()->hasPermission('exchange_rates-trash'))
                                                        <form method="POST"
                                                            action="{{ route('exchange_rates.destroy', ['exchange_rate' => $exchange_rate->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ $exchange_rate->trashed() ? __('Delete') : __('Trash ') }}</button>
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
                    <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $exchange_rates->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
