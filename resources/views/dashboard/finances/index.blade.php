@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card-white mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Finances') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
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
        </div>
        <div class="card-body p-0">

            <div class="row g-3 mb-3">
                <div class="col-xxl-6 col-xl-12">
                    <div class="card py-3 mb-3">
                        <div class="card-body py-3">
                            <div class="row g-0">
                                <h3>{{ __('Marketers - total balances') }}</h3>
                                <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                                    <h6 class="pb-1 text-700">{{ __('Available balance') }} </h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('affiliate', 'available_balance') . ' EGP' }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('Bonus balance') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('affiliate', 'bonus') . ' EGP' }}</p>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-4 pt-4 pt-md-0 ps-md-3">
                                    <h6 class="pb-1 text-700">{{ __('Outstanding balance') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('affiliate', 'outstanding_balance') . ' EGP' }}</p>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-bottom-0 border-md-end pt-4 pb-md-0 ps-3 ps-md-0">
                                    <h6 class="pb-1 text-700">{{ __('Pending withdrawal requests') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('affiliate', 'pending_withdrawal_requests') . ' EGP' }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-4 border-200 border-md-bottom-0 border-end pt-4 pb-md-0 ps-md-3">
                                    <h6 class="pb-1 text-700">{{ __('Completed withdrawal requests') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('affiliate', 'completed_withdrawal_requests') . ' EGP' }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-4 pb-0 pt-4 ps-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-xxl-6 col-xl-12">
                    <div class="card py-3 mb-3">
                        <div class="card-body py-3">
                            <div class="row g-0">
                                <h3>{{ __('Vendors - total balances') }}</h3>
                                <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                                    <h6 class="pb-1 text-700">{{ __('Available balance') }} </h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('vendor', 'available_balance') . ' EGP' }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('Bonus balance') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('vendor', 'bonus') . ' EGP' }}</p>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-4 pt-4 pt-md-0 ps-md-3">
                                    <h6 class="pb-1 text-700">{{ __('Outstanding balance') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('vendor', 'outstanding_balance') . ' EGP' }}</p>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-bottom-0 border-md-end pt-4 pb-md-0 ps-3 ps-md-0">
                                    <h6 class="pb-1 text-700">{{ __('Pending withdrawal requests') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('vendor', 'pending_withdrawal_requests') . ' EGP' }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-4 border-200 border-md-bottom-0 border-end pt-4 pb-md-0 ps-md-3">
                                    <h6 class="pb-1 text-700">{{ __('Completed withdrawal requests') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalBalance('vendor', 'completed_withdrawal_requests') . ' EGP' }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-4 pb-0 pt-4 ps-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-xxl-6 col-xl-12">
                    <div class="card py-3 mb-3">
                        <div class="card-body py-3">
                            <div class="row g-0">
                                <h3>{{ __('Total orders by case') }}</h3>
                                <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                                    <h6 class="pb-1 text-700">{{ __('Total pending orders') }} </h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('pending') . ' EGP' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('pending') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('Total confirmed orders') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('confirmed') . ' EGP' }}</p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('confirmed') }}
                                        </h6>
                                    </div>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-4 pt-4 pt-md-0 ps-md-3">
                                    <h6 class="pb-1 text-700">{{ __('Total orders being delivered') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('on the way') . ' EGP' }}</p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('on the way') }}
                                        </h6>
                                    </div>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200  border-bottom border-end border-md-200 border-md-end pb-4 pt-4 pb-md-0 ps-3 ps-md-0">
                                    <h6 class="pb-1 text-700">{{ __('Total requests in the mandatory period') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('in the mandatory period') . ' EGP' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('in the mandatory period') }}
                                        </h6>
                                    </div>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-4 pt-4 pb-md-0 ps-md-3">
                                    <h6 class="pb-1 text-700">{{ __('Total orders delivered') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('delivered') . ' EGP' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('delivered') }}
                                        </h6>
                                    </div>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-4 pt-4 ps-3">
                                    <h6 class="pb-1 text-700">{{ __('Total canceled orders') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('canceled') . ' EGP' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('canceled') }}
                                        </h6>
                                    </div>
                                </div>
                                <div
                                    class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-bottom-0 border-md-end pt-4 pb-md-0 ps-3 ps-md-0">
                                    <h6 class="pb-1 text-700">{{ __('Total Returns') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('returned') . ' EGP' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('returned') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 border-200 border-md-bottom-0 border-end pt-4 pb-md-0 ps-md-3">
                                    <h6 class="pb-1 text-700">{{ __('Total RTO') }}</h6>
                                    <p class="font-sans-serif lh-1 mb-1 fs-2">
                                        {{ CalculateTotalOrder('RTO') . ' EGP' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="fs--1 text-500 mb-0">{{ __('Orders Count:') }}</h6>
                                        <h6 class="fs--2 ps-3 mb-0 text-primary"><span
                                                class="me-1 fas fa-caret-up"></span>{{ ordersCount('RTO') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 pb-0 pt-4 ps-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection
