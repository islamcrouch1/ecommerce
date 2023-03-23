@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Stock Transfers') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">

                        {{-- <form style="display: inline-block" action="">

                            <div class="d-inline-block">
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
                            </div>

                        </form> --}}

                        @if (auth()->user()->hasPermission('stock_transfers-create'))
                            <a href="{{ route('stock_transfers.create') }}" class="btn btn-falcon-default btn-sm"
                                type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($transfers->count() > 0)
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
                                    {{ __('Refrence No') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('From Warehouse') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('To Warehouse') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">{{ __('Notes') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>

                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($transfers as $transfer)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <div class="d-flex d-flex align-items-center">

                                            <div class="flex-1">
                                                <h5 class="mb-0 fs--1">
                                                    {{ $transfer->reference_no }}
                                                </h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ getName($transfer->fw) }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ getName($transfer->tw) }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $transfer->notes }}
                                    </td>

                                    <td class="joined align-middle py-2">{{ $transfer->created_at }} <br>
                                        {{ interval($transfer->created_at) }} </td>


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
            {{ $transfers->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
