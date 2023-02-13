@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">

                        {{ __('Income statement') }}
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
                        </form>
                    </div>
                </div>
            </div>





            <div class="card-body">
                <div class="row g-0">
                    <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                        <h6 class="pb-1 pt-2 text-700">{{ __('Sales') }} </h6>
                        <p class="font-sans-serif lh-1 mb-1 fs-2">
                            {{ $revenue . ' ' . getCurrency() }}
                        </p>
                    </div>
                    <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                        <h6 class="pb-1 pt-2 text-700">{{ __('Expenses') }} </h6>
                        <p class="font-sans-serif lh-1 mb-1 fs-2">
                            {{ $expenses . ' ' . getCurrency() }}
                        </p>
                    </div>

                    <div class="col-6 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                        <h6 class="pb-1 pt-2 text-700">{{ __('Cost Of Sales') }} </h6>
                        <p class="font-sans-serif lh-1 mb-1 fs-2">
                            {{ $sales_cost . ' ' . getCurrency() }}
                        </p>
                    </div>
                    <div class="col-md-12">
                        <h3 class="p-4">{{ __('Gross Profit') }}</h3>
                        <h3>
                            {{ __('Sales') . '(' . $revenue . ')' }} {{ ' - ' }}
                            {{ __('Expenses') . '(' . $expenses . ')' }} {{ ' - ' }}
                            {{ __('Cost Of Sales') . '(' . $sales_cost . ')' }} {{ ' = ' }}
                            {{ $gross_profit }} {{ ' ' . getCurrency() }}
                        </h3>
                    </div>

                    <div class="col-6 pt-2 col-md-3 border-200 border-md-200 border-bottom border-end pb-4 ps-3">
                        <h6 class="pb-1 pt-2 text-700">{{ __('Incom Tax') }} </h6>
                        <p class="font-sans-serif lh-1 mb-1 fs-2">
                            {{ $income_tax . getCurrency() }}
                            {{ ' - ' . $income_tax_rate . '%' }}
                        </p>
                    </div>

                    <div class="col-md-12">
                        <h3 class="p-4">
                            @if ($gross_profit < 0)
                                {{ __('Loss') }}
                            @else
                                {{ __('Net Profit') }}
                            @endif
                        </h3>
                        <h3>
                            {{ __('Gross Profit') . '(' . $gross_profit . ')' }} {{ ' - ' }}
                            {{ __('Incom Tax') . '(' . $income_tax . ')' }} {{ ' = ' }}
                            {{ $net_profit }} {{ ' ' . getCurrency() }}
                        </h3>
                    </div>

                </div>
            </div>




        </div>
    </div>
@endsection
