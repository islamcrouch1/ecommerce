@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-xl-12">
            <div class="card py-3 mb-3">
                <div class="card-body py-3">
                    <div class="row g-0">
                        <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                            <h6 class="pb-1 text-700">{{ __('Available balance') }} </h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ ($user->balance->available_balance < 0 ? 0 : $user->balance->available_balance) . ' ' . $user->country->currency }}
                            </p>
                        </div>
                        <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                            <h6 class="pb-1 text-700">{{ __('Bonus balance') }}</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ $user->balance->bonus . ' ' . $user->country->currency }}</p>
                        </div>
                        <div
                            class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-4 pt-4 pt-md-0 ps-md-3">
                            <h6 class="pb-1 text-700">{{ __('Outstanding balance') }}</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ $user->balance->outstanding_balance . ' ' . $user->country->currency }}</p>
                        </div>
                        <div
                            class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-bottom-0 border-md-end pt-4 pb-md-0 ps-3 ps-md-0">
                            <h6 class="pb-1 text-700">{{ __('Pending withdrawal requests') }}</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ $user->balance->pending_withdrawal_requests . ' ' . $user->country->currency }}</p>
                        </div>
                        <div class="col-6 col-md-4 border-200 border-md-bottom-0 border-end pt-4 pb-md-0 ps-md-3">
                            <h6 class="pb-1 text-700">{{ __('Completed withdrawal requests') }}</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">
                                {{ $user->balance->completed_withdrawal_requests . ' ' . $user->country->currency }}</p>
                        </div>
                        <div class="col-6 col-md-4 pb-0 pt-4 ps-3">
                            <button class="btn btn-primary mb-1" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight"
                                aria-controls="offcanvasRight">{{ __('Withdrawal Request') }}</button>
                            <div class="offcanvas offcanvas-end" id="offcanvasRight" tabindex="-1"
                                aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasRightLabel">{{ __('New Withdrawal Request') }}</h5>
                                    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <div class="alert alert-warning" role="alert">
                                        {{ __('Minimum withdrawal amount: ') . ($user->hasrole('affiliate') ? setting('affiliate_limit') : setting('vender_limit')) . $user->country->currency }}
                                    </div>
                                    <div class="alert alert-primary" role="alert">
                                        {{ __('Available balance for withdrawal in your account : ') . ($user->balance->available_balance + $user->balance->bonus) . ' ' . $user->country->currency }}
                                    </div>
                                    <div class="card mb-3" id="customersTable"
                                        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
                                        <div class="card-body p-0">
                                            <div class="row g-0 h-100">
                                                <div class="col-md-12 d-flex flex-center">
                                                    <div class="p-4 flex-grow-1">
                                                        <form method="POST"
                                                            action="{{ route('withdrawals.user.store') }}">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="amount">{{ __('Amount') }}</label>
                                                                <input name="amount"
                                                                    class="form-control @error('amount') is-invalid @enderror"
                                                                    value="{{ $user->hasrole('affiliate') ? setting('affiliate_limit') : setting('vender_limit') }}"
                                                                    type="number"
                                                                    max="{{ $user->balance->available_balance + $user->balance->bonus }}"
                                                                    min="{{ $user->hasrole('affiliate') ? setting('affiliate_limit') : setting('vender_limit') }}"
                                                                    autocomplete="on" id="amount" required />
                                                                @error('amount')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="type">{{ __('Payment Type') }}</label>

                                                                <select
                                                                    class="form-select @error('type') is-invalid @enderror"
                                                                    aria-label="" name="type" id="type" required>
                                                                    <option value="1" selected>
                                                                        {{ __('Vodafone Cash') }}
                                                                    </option>
                                                                </select>
                                                                @error('type')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="data">{{ __('Wallet Number') }}</label>
                                                                <input name="data"
                                                                    class="form-control @error('data') is-invalid @enderror"
                                                                    placeholder="{{ __('write your wallet information') }}"
                                                                    value="{{ old('data') }}" type="text"
                                                                    autocomplete="on" id="data" required />
                                                                @error('data')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label" for="code"><button
                                                                        id="send-conf"
                                                                        class="btn btn-falcon-default btn-sm me-1 mb-1"
                                                                        type="button"
                                                                        data-url="{{ route('send.conf') }}">
                                                                        <div style="display: none"
                                                                            class="spinner-border text-info spinner-border-sm spinner"
                                                                            role="status">
                                                                            <span class="visually-hidden">Loading...</span>
                                                                        </div>
                                                                        <span class="fas fa-plus me-1"
                                                                            data-fa-transform="shrink-3"></span>
                                                                        {{ __('Send Confirmation Code') }}<span
                                                                            class="counter_down1"></span>
                                                                    </button>
                                                                </label>
                                                                <input name="code"
                                                                    class="form-control @error('code') is-invalid @enderror"
                                                                    placeholder="{{ __('enter the confirmation code') }}"
                                                                    value="{{ old('code') }}" type="text"
                                                                    autocomplete="on" id="code" autofocus required />
                                                                @error('code')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>


                                                            <div class="mb-3">
                                                                <button class="btn btn-primary d-block w-100 mt-3"
                                                                    type="submit"
                                                                    name="submit">{{ __('Send') }}</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Withdrawals Requests') }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($withdrawals->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Withdrawal ID') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('Amount') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('status') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($withdrawals as $withdrawal)
                                <tr class="btn-reveal-trigger">
                                    <td class="phone align-middle white-space-nowrap py-2">{{ '# ' . $withdrawal->id }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $withdrawal->amount . ' ' . $user->country->currency }}</td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        @switch($withdrawal->status)
                                            @case('pending')
                                                <span
                                                    class="badge badge-soft-primary ">{{ __('Awaiting review from management') }}</span>
                                            @break

                                            @case('recieved')
                                                <span
                                                    class="badge badge-soft-info ">{{ __('Your request has been received and is being reviewed for a deposit') }}</span>
                                            @break

                                            @case('confirmed')
                                                <span
                                                    class="badge badge-soft-success ">{{ __('The amount has been deposited into your account') }}</span>
                                            @break

                                            @case('canceled')
                                                <span
                                                    class="badge badge-soft-danger ">{{ __('Request rejected Please contact customer service to find out the reason') }}</span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>

                                    <td class="joined align-middle py-2">{{ $withdrawal->created_at }} <br>
                                        {{ interval($withdrawal->created_at) }} </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h6 class="p-3">{{ __('No Withdrawal Requests To Show') }}</h6>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $withdrawals->appends(request()->query())->links() }}
        </div>

    </div>

    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Financial Operations Archive') }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($requests->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Process ID') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('Process') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Order ID') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Amount') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Process Date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($requests as $request)
                                <tr class="btn-reveal-trigger">
                                    <td class="phone align-middle white-space-nowrap py-2">{{ '# ' . $request->id }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ app()->getLocale() == 'ar' ? $request->request_ar : $request->request_en }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $request->order_id == 0 ? __('none') : '# ' . $request->order_id }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $request->balance . ' ' . $user->country->currency }}
                                    </td>

                                    <td class="joined align-middle py-2">{{ $request->created_at }} <br>
                                        {{ interval($request->created_at) }} </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h6 class="p-3">{{ __('There are no previous transactions performed on your balance') }}
                    </h6>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $requests->appends(request()->query())->links() }}
        </div>

    </div>

@endsection
