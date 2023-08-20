@extends('layouts.dashboard.app')

@section('adminContent')



    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('installment requests') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
                    {{-- <div class="d-none" id="table-customers-actions">
                            <div class="d-flex">
                                <select name="selected_status" class="form-select form-select-sm" aria-label="Bulk actions"
                                    required>
                                    <option value="">{{ __('Change status') }}</option>
                                    <option value="pending">
                                        {{ __('pending') }}</option>
                                    <option value="confirmed">
                                        {{ __('confirmed') }}</option>
                                    <option value="on the way">
                                        {{ __('on the way') }}</option>
                                    <option value="in the mandatory period">
                                        {{ __('in the mandatory period') }}</option>
                                    <option value="delivered">
                                        {{ __('delivered') }}</option>
                                    <option value="canceled">
                                        {{ __('canceled') }}</option>
                                    <option value="returned">
                                        {{ __('returned') }}</option>
                                    <option value="RTO">
                                        {{ __('RTO') }}</option>
                                </select>
                                <button class="btn btn-falcon-default btn-sm ms-2"
                                    type="submit">{{ __('Apply') }}</button>
                            </div>

                        </div> --}}

                    <form action=""></form>

                    <div id="table-customers-replace-element">
                        <form style="display: inline-block" action="">


                            {{-- <div class="d-inline-block">
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
                                </div> --}}

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

                            {{-- <div class="d-inline-block">
                                    <select name="status" class="form-select form-select-sm sonoo-search"
                                        id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Status') }}</option>
                                        <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>
                                        <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                            {{ __('confirmed') }}</option>
                                        <option value="on the way"
                                            {{ request()->status == 'on the way' ? 'selected' : '' }}>
                                            {{ __('on the way') }}</option>
                                        <option value="in the mandatory period"
                                            {{ request()->status == 'in the mandatory period' ? 'selected' : '' }}>
                                            {{ __('in the mandatory period') }}</option>
                                        <option value="delivered" {{ request()->status == 'delivered' ? 'selected' : '' }}>
                                            {{ __('delivered') }}</option>
                                        <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                            {{ __('canceled') }}</option>
                                        <option value="returned" {{ request()->status == 'returned' ? 'selected' : '' }}>
                                            {{ __('returned') }}</option>
                                        <option value="RTO" {{ request()->status == 'RTO' ? 'selected' : '' }}>
                                            {{ __('RTO') }}</option>
                                    </select>
                                </div> --}}

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


                        </form>

                        {{-- <a href="{{ route('installment_requests.mandatory') }}" class="btn btn-falcon-default btn-sm"
                                type="button"><span class="fas fa-receipt" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Mandatory') }}</span></a>
                            <a href="{{ route('installment_requests.refunds') }}" class="btn btn-falcon-default btn-sm"
                                type="button"><span class="fas fa-backward"
                                    data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Refunds Requsets') }}</span></a> --}}
                        {{-- <a href="{{ route('installment_requests.export', ['status' => request()->status, 'from' => request()->from, 'to' => request()->to]) }}"
                                class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                    data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Export') }}</span></a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($installment_requests->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="id">
                                    {{ __('ID') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="id">
                                    {{ __('product') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Customer Name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">
                                    {{ __('installment company') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('product price') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('admin expenses') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('installment period') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('advanced amount') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('installment amount') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created At') }}</th>
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($installment_requests as $installment_request)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input name="selected_items[]" value="{{ $installment_request->id }}"
                                                class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <div class="d-flex d-flex align-items-center">
                                            <div class="flex-1">
                                                <h5 class="mb-0 fs--1">{{ $installment_request->id }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="name align-middle py-2">
                                        <div class="d-flex d-flex align-items-center">
                                            <div class="avatar avatar-xl me-2">
                                                <img class="rounded-circle"
                                                    src="{{ getProductImage($installment_request->product) }}"
                                                    alt="" />
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="mb-0 fs--1">
                                                    {{-- {{ $product->images->count() }} --}}
                                                    {{ getProductName($installment_request->product, getCombination($installment_request->product_combination_id)) }}
                                                </h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="address align-middle white-space-nowrap py-2">
                                        {{ $installment_request->name }}
                                    </td>

                                    <td class="address align-middle white-space-nowrap py-2">
                                        {{ getName($installment_request->installment_company) }}
                                    </td>

                                    <td class="address align-middle white-space-nowrap py-2">
                                        {{ $installment_request->product_price . ' ' . $installment_request->country->currency }}
                                    </td>

                                    <td class="address align-middle white-space-nowrap py-2">
                                        {{ $installment_request->admin_expenses . ' ' . $installment_request->country->currency }}
                                    </td>

                                    <td class="address align-middle white-space-nowrap py-2">
                                        {{ $installment_request->months }}
                                    </td>

                                    <td class="address align-middle white-space-nowrap py-2">
                                        {{ $installment_request->advanced_amount . ' ' . $installment_request->country->currency }}
                                    </td>

                                    <td class="address align-middle white-space-nowrap py-2">
                                        {{ $installment_request->installment_amount . ' ' . $installment_request->country->currency }}
                                    </td>




                                    <td class="joined align-middle py-2">{{ $installment_request->created_at }} <br>
                                        {{ interval($installment_request->created_at) }} </td>
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end binstallment_request py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">


                                                    @if (auth()->user()->hasPermission('installment_requests-read'))
                                                        <a href="" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#show-address-{{ $installment_request->id }}">{{ __('show address') }}</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>


                    @foreach ($installment_requests as $installment_request)
                        <div class="modal fade" id="show-address-{{ $installment_request->id }}" tabindex="-1"
                            role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                <div class="modal-content position-relative">
                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                            <h4 class="mb-1" id="modalExampleDemoLabel">
                                                {{ __('address') . ': ' . $installment_request->id }}
                                            </h4>
                                        </div>
                                        <div class="p-4 pb-0">

                                            <div class="table-responsive scrollbar">
                                                <table class="table table-bordered overflow-hidden">
                                                    <colgroup>
                                                        <col class="bg-soft-primary" />
                                                        <col />
                                                    </colgroup>

                                                    <tbody>

                                                        @if ($installment_request->phone)
                                                            {{ __('Phone:') . ' ' }} <a
                                                                href="tel:{{ $installment_request->phone }}">{{ $installment_request->phone }}</a><br>
                                                        @endif
                                                        @if ($installment_request->country_id)
                                                            {{ __('Country:') . ' ' . getName($installment_request->country) }}<br>
                                                        @endif
                                                        @if ($installment_request->state_id)
                                                            {{ __('State:') . ' ' . getName($installment_request->state) }}<br>
                                                        @endif
                                                        @if ($installment_request->city_id)
                                                            {{ __('City:') . ' ' . getName($installment_request->city) }}<br>
                                                        @endif
                                                        @if ($installment_request->block)
                                                            {{ __('Block:') . $installment_request->block }}<br>
                                                        @endif
                                                        @if ($installment_request->avenue)
                                                            {{ __('Avenue:') . $installment_request->avenue }}<br>
                                                        @endif
                                                        @if ($installment_request->house)
                                                            {{ __('House:') . $installment_request->house }}<br>
                                                        @endif
                                                        @if ($installment_request->floor_no)
                                                            {{ __('Floor Number:') . $installment_request->floor_no }}<br>
                                                        @endif
                                                        @if ($installment_request->special_mark)
                                                            {{ __('Special Mark:') . $installment_request->special_mark }}<br>
                                                        @endif
                                                        @if ($installment_request->delivery_time)
                                                            {{ __('Delivery Time:') . $installment_request->delivery_time }}<br>
                                                        @endif
                                                        @if ($installment_request->phone2)
                                                            {{ __('Alternate Phone:') . $installment_request->phone2 }}<br>
                                                        @endif
                                                        @if ($installment_request->notes)
                                                            {{ __('Notes:') . $installment_request->notes }}<br>
                                                        @endif


                                                    </tbody>
                                                </table>
                                            </div>



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
                    <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $installment_requests->appends(request()->query())->links() }}
        </div>

    </div>

@endsection
