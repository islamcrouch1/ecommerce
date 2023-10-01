@extends('layouts.dashboard.app')
@section('adminContent')
    <div class="row g-3 mb-3">
        <div class="col-lg-7 col-xxl-8">
            <form style="display: inline-block" action="">

                <div class="d-inline-block">
                    {{-- <label class="form-label" for="from">{{ __('From') }}</label> --}}
                    <input type="date" id="from" name="from" class="form-control form-select-sm"
                        value="{{ request()->from }}">
                </div>

                <div class="d-inline-block">
                    {{-- <label class="form-label" for="to">{{ __('To') }}</label> --}}
                    <input type="date" id="to" name="to" class="form-control form-select-sm sonoo-search"
                        value="{{ request()->to }}">
                </div>
            </form>
        </div>
    </div>


    @if (Auth::user()->hasRole('administrator'))



        @if (isMobileDevice())
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Attendance and leave') }}
                        </div>
                        <div class="card-body">

                            @if (getUserAttendance())
                                <div class="notification-body">
                                    <p class="mb-1">{{ __('Your attendance has been registered') }}</p>
                                    <span class="notification-time"><span class="me-2" role="img"
                                            aria-label="Emoji">📢</span>
                                        {{ getUserAttendance()->attendance_date }}
                                        <span
                                            class="badge badge-soft-info ">{{ interval(getUserAttendance()->attendance_date) }}</span>

                                    </span>
                                </div>

                                <hr class="hr hr-blurry" />
                            @endif


                            @if (getUserLeave())
                                <div class="notification-body">
                                    <p class="mb-1">{{ __('Your leave has been registered') }}</p>
                                    <span class="notification-time"><span class="me-2" role="img"
                                            aria-label="Emoji">📢</span>
                                        {{ getUserLeave()->leave_date }}
                                        <span
                                            class="badge badge-soft-info ">{{ interval(getUserLeave()->leave_date) }}</span>

                                    </span>
                                </div>

                                <hr class="hr hr-blurry" />
                            @endif


                            @if (!getUserAttendance() || !getUserLeave())

                                <form method="POST"
                                    action="{{ route('employee.attendance.store', ['user' => $user->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="password">{{ __('enter your password') }}</label>
                                        <input class="form-control  @error('password') is-invalid @enderror" type="password"
                                            autocomplete="on" id="password" name="password" required />
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <input style="display:none" class="form-control latitude-input" type="text"
                                        id="latitude" name="latitude" required />

                                    <input style="display:none" class="form-control longitude-input" type="text"
                                        id="longitude" name="longitude" required />

                                    <div class="mb-3">
                                        <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">
                                            @if (getUserAttendance() == null)
                                                {{ __('Save attendance record') }}
                                            @else
                                                @if (getUserLeave() == null)
                                                    {{ __('Save leave record') }}
                                                @endif
                                            @endif
                                        </button>
                                    </div>

                                </form>

                            @endif






                        </div>
                    </div>
                </div>
            </div>
        @endif




        @php
            $account = getItemAccount(Auth::id(), null, 'petty_cash_account', Auth::user()->branch_id);
            $petty_amount = getTrialBalance($account->id, null, null);
            $settlement_amount = getSettlementAmount(Auth::user());

        @endphp

        @if ($petty_amount > 0)
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Petty cash settlement') }}
                        </div>
                        <div class="card-body">

                            <div class="notification-body">
                                <p class="mb-1"><span class="notification-time"><span class="me-2" role="img"
                                            aria-label="Emoji">📢</span>

                                        <span style="font-size:15px"
                                            class="badge badge-soft-info ">{{ __('your petty cash amount') . ' : ' . $petty_amount . ' - ' . __('remaining amount') . ' : ' . getPettyRemainingAmount($user) }}</span>
                                </p>


                                </span>
                            </div>
                            <hr class="hr hr-blurry" />


                            @if ($settlement_amount > 0)
                                @foreach (Auth::user()->sheets->where('admin_id', null) as $sheet)
                                    <div class="notification-body">
                                        <a href="{{ route('employee.settlement.create', ['sheet' => $sheet->id]) }}"
                                            class="btn btn-primary d-block w-100 mt-3">
                                            {{ __('Add expenses to petty cash sheet settlement') . ' - ' . __('petty cash amount') . ' : ' . $sheet->amount }}
                                        </a>
                                    </div>
                                    <hr class="hr hr-blurry" />
                                @endforeach
                            @endif








                            @if ($settlement_amount < $petty_amount)
                                <form method="POST" action="{{ route('employee.settlement.sheet_create') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label"
                                            for="amount">{{ __('Enter the amount of the petty cash to be settled') }}</label>
                                        <input class="form-control @error('amount') is-invalid @enderror" type="numbet"
                                            id="amount" name="amount" min="0" step="0.01"
                                            value="{{ $petty_amount - $settlement_amount }}" required />
                                        @error('amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">
                                            {{ __('Preparing the settlement sheet') }}
                                        </button>
                                    </div>

                                </form>
                            @endif








                        </div>
                    </div>
                </div>
            </div>
        @endif





    @endif


    @if (Auth::user()->hasRole('superadministrator|administrator') &&
            auth()->user()->hasPermission('website_traffic-read'))
        <div class="row g-3 mb-3">
            <div class="col-lg-7 col-xxl-8">
                <div class="card h-100" id="table"
                    data-list='{"valueNames":["path","views","time","exitRate"],"page":8,"pagination":true,"fallback":"pages-table-fallback"}'>
                    <div class="card-header">
                        <div class="row flex-between-center">
                            <div class="col-auto col-sm-6 col-lg-7">
                                <h6 class="mb-0 text-nowrap py-2 py-xl-0">{{ __('Most viewed pages') }}</h6>
                            </div>
                            {{-- <div class="col-auto col-sm-6 col-lg-5">
                                <div class="h-100">
                                    <form>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm shadow-none search" type="search"
                                                placeholder="Search for a page" aria-label="search" />
                                            <div class="input-group-text bg-transparent"><span
                                                    class="fa fa-search fs--1 text-600"></span></div>
                                        </div>
                                    </form>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <div class="table-responsive scrollbar">
                            <table class="table fs--1 mb-0 overflow-hidden scroll">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="path">
                                            {{ __('Page Path') }}
                                        </th>
                                        <th class="sort pe-1 align-middle white-space-nowrap " data-sort="views">
                                            {{ __('Page Views') }}
                                        </th>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="time">
                                            {{ __('action') }}</th>
                                        {{-- <th class="sort pe-card align-middle white-space-nowrap text-end"
                                            data-sort="exitRate">Exit
                                            Rate</th>  --}}
                                    </tr>
                                </thead>


                                <tbody class="list">

                                    @if ($views->count() > 0)
                                        @foreach ($views as $view)
                                            <tr class="btn-reveal-trigger">
                                                <td class="align-middle path"><a class="text-primary fw-semi-bold"
                                                        href="{{ $view->full_url }}"
                                                        target="_blank">{{ $view->full_url }}</a>
                                                </td>
                                                <td class="align-middle white-space-nowrap views">{{ $view->total }}
                                                </td>
                                                <td class="align-middle white-space-nowrap time">
                                                    <a class="btn btn-falcon-default me-1 mb-1"
                                                        href="{{ route('admin.views', ['full_url' => $view->full_url]) }}"
                                                        type="button">{{ __('details') }}
                                                    </a>
                                                </td>
                                                {{-- <td class="align-middle text-end exitRate text-end pe-card">20.4%</td> --}}
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr col="3">
                                            <td>
                                                <p class="fw-bold fs-1 mt-3">{{ __('No Data To Show') }}</p>
                                            </td>
                                        </tr>
                                    @endif



                                </tbody>
                            </table>

                            <div class="card-footer d-flex align-items-center justify-content-center">
                                {{ $views->appends(request()->query())->links() }}
                            </div>
                        </div>

                    </div>
                    {{-- <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="pagination d-none"></div>
                            <div class="col">
                                <p class="mb-0 fs--1"><span class="d-none d-sm-inline-block me-2"
                                        data-list-info="data-list-info"></span></p>
                            </div>
                            <div class="col-auto d-flex">
                                <button class="btn btn-sm btn-primary" type="button"
                                    data-list-pagination="prev"><span>Previous</span></button>
                                <button class="btn btn-sm btn-primary px-4 ms-2" type="button"
                                    data-list-pagination="next"><span>Next</span></button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    @endif

    {{-- <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-xl-12">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card bg-transparent-50 overflow-hidden">
                        <div class="card-header position-relative">
                            <div class="bg-holder d-none d-md-block bg-card z-index-1"
                                style="background-image:url(../assets/img/illustrations/ecommerce-bg.png);background-size:230px;background-position:right bottom;z-index:-1;">
                            </div>
                            <!--/.bg-holder-->

                            <div class="position-relative z-index-2">
                                <div>
                                    <h3 class="text-primary mb-1">Hi, {{ $user->name }}!</h3>
                                    <p>{{ __('Here’s what happening with your Dashboard today') }} </p>
                                </div>
                                <div class="d-flex py-3">
                                    <div class="pe-3">
                                        <p class="text-600 fs--1 fw-medium">Today's visit </p>
                                        <h4 class="text-800 mb-0">14,209</h4>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-600 fs--1">Today’s total sales </p>
                                        <h4 class="text-800 mb-0">$21,349.29 </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="mb-0 list-unstyled">
                                <li class="alert mb-0 rounded-0 py-3 px-card alert-warning border-x-0 border-top-0">
                                    <div class="row flex-between-center">
                                        <div class="col">
                                            <div class="d-flex">
                                                <div class="fas fa-circle mt-1 fs--2"></div>
                                                <p class="fs--1 ps-2 mb-0"><strong>5 products</strong> didn’t publish to
                                                    your Facebook page</p>
                                            </div>
                                        </div>
                                        <div class="col-auto d-flex align-items-center"><a
                                                class="alert-link fs--1 fw-medium" href="#!">{{ __('View products') }}<i
                                                    class="fas fa-chevron-right ms-1 fs--2"></i></a></div>
                                    </div>
                                </li>
                                <li
                                    class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top border-x-0 border-top-0">
                                    <div class="row flex-between-center">
                                        <div class="col">
                                            <div class="d-flex">
                                                <div class="fas fa-circle mt-1 fs--2 text-primary"></div>
                                                <p class="fs--1 ps-2 mb-0"><strong>7 orders</strong> have payments that need
                                                    to be captured</p>
                                            </div>
                                        </div>
                                        <div class="col-auto d-flex align-items-center"><a
                                                class="alert-link fs--1 fw-medium" href="#!">View payments<i
                                                    class="fas fa-chevron-right ms-1 fs--2"></i></a></div>
                                    </div>
                                </li>
                                <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                                    <div class="row flex-between-center">
                                        <div class="col">
                                            <div class="d-flex">
                                                <div class="fas fa-circle mt-1 fs--2 text-primary"></div>
                                                <p class="fs--1 ps-2 mb-0"><strong>50+ orders</strong> need to be fulfilled
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-auto d-flex align-items-center"><a
                                                class="alert-link fs--1 fw-medium" href="#!">View orders<i
                                                    class="fas fa-chevron-right ms-1 fs--2"></i></a></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @if (Auth::user()->hasRole('affiliate'))
            <div class="col-xxl-6 col-xl-12">
                <div class="card py-3 mb-3">
                    <div class="card-body py-3">
                        <div class="row g-0">
                            <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                                <h6 class="pb-1 text-700">Orders </h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">15,450 </p>
                                <div class="d-flex align-items-center">
                                    <h6 class="fs--1 text-500 mb-0">13,675 </h6>
                                    <h6 class="fs--2 ps-3 mb-0 text-primary"><span class="me-1 fas fa-caret-up"></span>21.8%
                                    </h6>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                                <h6 class="pb-1 text-700">Items sold </h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">1,054 </p>
                                <div class="d-flex align-items-center">
                                    <h6 class="fs--1 text-500 mb-0">13,675 </h6>
                                    <h6 class="fs--2 ps-3 mb-0 text-warning"><span class="me-1 fas fa-caret-up"></span>21.8%
                                    </h6>
                                </div>
                            </div>
                            <div
                                class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-4 pt-4 pt-md-0 ps-md-3">
                                <h6 class="pb-1 text-700">Refunds </h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">$145.65 </p>
                                <div class="d-flex align-items-center">
                                    <h6 class="fs--1 text-500 mb-0">13,675 </h6>
                                    <h6 class="fs--2 ps-3 mb-0 text-success"><span class="me-1 fas fa-caret-up"></span>21.8%
                                    </h6>
                                </div>
                            </div>
                            <div
                                class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-bottom-0 border-md-end pt-4 pb-md-0 ps-3 ps-md-0">
                                <h6 class="pb-1 text-700">Gross sale </h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">$100.26 </p>
                                <div class="d-flex align-items-center">
                                    <h6 class="fs--1 text-500 mb-0">$109.65 </h6>
                                    <h6 class="fs--2 ps-3 mb-0 text-danger"><span class="me-1 fas fa-caret-up"></span>21.8%
                                    </h6>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-md-bottom-0 border-end pt-4 pb-md-0 ps-md-3">
                                <h6 class="pb-1 text-700">Shipping </h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">$365.53 </p>
                                <div class="d-flex align-items-center">
                                    <h6 class="fs--1 text-500 mb-0">13,675 </h6>
                                    <h6 class="fs--2 ps-3 mb-0 text-success"><span class="me-1 fas fa-caret-up"></span>21.8%
                                    </h6>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 pb-0 pt-4 ps-3">
                                <h6 class="pb-1 text-700">Processing </h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">861 </p>
                                <div class="d-flex align-items-center">
                                    <h6 class="fs--1 text-500 mb-0">13,675 </h6>
                                    <h6 class="fs--2 ps-3 mb-0 text-info"><span class="me-1 fas fa-caret-up"></span>21.8%
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-md-100 ecommerce-card-min-width">
                            <div class="card-header pb-0">
                                <h6 class="mb-0 mt-2 d-flex align-items-center">Weekly Sales<span class="ms-1 text-400"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Calculated according to last week's sales"><span
                                            class="far fa-question-circle" data-fa-transform="shrink-1"></span></span>
                                </h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-end">
                                <div class="row">
                                    <div class="col">
                                        <p class="font-sans-serif lh-1 mb-1 fs-2">$47K</p><span
                                            class="badge badge-soft-success rounded-pill fs--2">+3.5%</span>
                                    </div>
                                    <div class="col-auto ps-0">
                                        <div class="echart-bar-weekly-sales h-100 echart-bar-weekly-sales-smaller-width">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card product-share-doughnut-width">
                            <div class="card-header pb-0">
                                <h6 class="mb-0 mt-2 d-flex align-items-center">Product Share</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-end">
                                <div class="row align-items-end">
                                    <div class="col">
                                        <p class="font-sans-serif lh-1 mb-1 fs-2">34.6%</p><span
                                            class="badge badge-soft-success rounded-pill"><span
                                                class="fas fa-caret-up me-1"></span>3.5%</span>
                                    </div>
                                    <div class="col-auto ps-0">
                                        <canvas class="my-n5" id="marketShareDoughnut" width="112"
                                            height="112"></canvas>
                                        <p class="mb-0 text-center fs--2 mt-4 text-500">Target: <span
                                                class="text-800">55%</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-md-100 h-100">
                            <div class="card-body">
                                <div class="row h-100 justify-content-between g-0">
                                    <div class="col-5 col-sm-6 col-xxl pe-2">
                                        <h6 class="mt-1">Market Share</h6>
                                        <div class="fs--2 mt-3">
                                            <div class="d-flex flex-between-center mb-1">
                                                <div class="d-flex align-items-center"><span
                                                        class="dot bg-primary"></span><span
                                                        class="fw-semi-bold">Falcon</span></div>
                                                <div class="d-xxl-none">57%</div>
                                            </div>
                                            <div class="d-flex flex-between-center mb-1">
                                                <div class="d-flex align-items-center"><span
                                                        class="dot bg-info"></span><span
                                                        class="fw-semi-bold">Sparrow</span></div>
                                                <div class="d-xxl-none">20%</div>
                                            </div>
                                            <div class="d-flex flex-between-center mb-1">
                                                <div class="d-flex align-items-center"><span
                                                        class="dot bg-warning"></span><span
                                                        class="fw-semi-bold">Phoenix</span></div>
                                                <div class="d-xxl-none">22%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto position-relative">
                                        <div class="echart-product-share"></div>
                                        <div class="position-absolute top-50 start-50 translate-middle text-dark fs-2">
                                            26M</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h6 class="mb-0 mt-2 d-flex align-items-center">Total Order</h6>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-end">
                                    <div class="col">
                                        <p class="font-sans-serif lh-1 mb-1 fs-2">58.4K</p>
                                        <div class="badge badge-soft-primary rounded-pill fs--2"><span
                                                class="fas fa-caret-up me-1"></span>13.6%</div>
                                    </div>
                                    <div class="col-auto ps-0">
                                        <div class="total-order-ecommerce"
                                            data-echarts='{"series":[{"type":"line","data":[110,100,250,210,530,480,320,325]}],"grid":{"bottom":"-10px"}}'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div> --}}


    @if (Auth::user()->hasRole('affiliate') || Auth::user()->hasRole('vendor'))
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
                                    {{ $user->balance->completed_withdrawal_requests . ' ' . $user->country->currency }}
                                </p>
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
                                            {{ __('Minimum withdrawal amount: ') . ($user->hasrole('affiliate') ? setting('affiliate_limit') : setting('vendor_limit')) . $user->country->currency }}
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
                                                                        value="{{ $user->hasrole('affiliate') ? setting('affiliate_limit') : setting('vendor_limit') }}"
                                                                        type="number"
                                                                        max="{{ $user->balance->available_balance + $user->balance->bonus }}"
                                                                        min="{{ $user->hasrole('affiliate') ? setting('affiliate_limit') : setting('vendor_limit') }}"
                                                                        autocomplete="on" id="amount" required />
                                                                    @error('amount')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="type">{{ __('Payment Type') }}</label>

                                                                    <select
                                                                        class="form-select @error('type') is-invalid @enderror"
                                                                        aria-label="" name="type" id="type"
                                                                        required>
                                                                        <option value="1" selected>
                                                                            {{ __('Vodafone Cash') }}
                                                                        </option>
                                                                    </select>
                                                                    @error('type')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
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
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
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
                                                                                <span
                                                                                    class="visually-hidden">Loading...</span>
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
                                                                        autocomplete="on" id="code" autofocus
                                                                        required />
                                                                    @error('code')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
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




        @if (!checkUserInfo(Auth::user()))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-info" role="alert">
                        {{ __('Please complete your account information to use this service!') }}</div>
                </div>
            </div>
            <div class="card mb-3">
                <form method="POST" action="{{ route('user.store.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header position-relative min-vh-25 mb-7">

                        <div class="cover-image">
                            <div class="bg-holder rounded-3 rounded-bottom-0 img-prev-cover"
                                style="background-image:url({{ getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->store_cover != null ? getMediaPath(getUserInfo(Auth::user())->store_cover) : asset('assets/img/store_cover.jpg') }});">
                            </div>
                            <!--/.bg-holder-->

                            <input name="store_cover" class="d-none cover" id="upload-cover-image" type="file" />
                            <label class="cover-image-file-input" for="upload-cover-image"><span
                                    class="fas fa-camera me-2"></span><span>{{ __('Change cover photo') }}</span></label>
                        </div>
                        <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img
                                    src="{{ getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->store_profile != null ? getMediaPath(getUserInfo(Auth::user())->store_profile) : asset('storage/images/users/' . $user->profile) }}"
                                    width="200" alt="" data-dz-thumbnail="data-dz-thumbnail"
                                    class="img-prev" />
                                <input name="store_profile" class="d-none img" id="profile-image" type="file" />
                                <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image"><span
                                        class="bg-holder overlay overlay-0"></span><span
                                        class="z-index-1 text-white dark__text-white text-center fs--1"><span
                                            class="fas fa-camera"></span><span
                                            class="d-block">Update</span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="mb-3">
                                    <label class="form-label" for="store_name">{{ __('Your store name') }}</label>
                                    <input name="store_name"
                                        class="form-control @error('store_name') is-invalid @enderror"
                                        value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->store_name : '' }}"
                                        type="text" autocomplete="on" id="store_name" />
                                    @error('store_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label"
                                        for="store_description">{{ __('Your store description') }}</label>
                                    <textarea name="store_description" class="form-control @error('store_description') is-invalid @enderror"
                                        type="text" id="store_description">{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->store_description : '' }}</textarea>
                                    @error('store_description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label class="form-label"
                                        for="commercial_record">{{ __('commercial record photo') }}</label>
                                    <input name="commercial_record"
                                        class=" form-control @error('commercial_record') is-invalid @enderror"
                                        type="file" id="commercial_record" />
                                    @error('commercial_record')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->commercial_record != null)
                                    <div class="mb-3">
                                        <div class="col-md-10">
                                            <a href="{{ getMediaPath(getUserInfo(Auth::user())->commercial_record) }}"
                                                target="_blank">
                                                <img src="{{ getMediaPath(getUserInfo(Auth::user())->commercial_record) }}"
                                                    style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                @endif



                                <div class="mb-3">
                                    <label class="form-label" for="tax_card">{{ __('tax card photo') }}</label>
                                    <input name="tax_card" class=" form-control @error('tax_card') is-invalid @enderror"
                                        type="file" id="tax_card" />
                                    @error('tax_card')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->tax_card != null)
                                    <div class="mb-3">
                                        <div class="col-md-10">
                                            <a href="{{ getMediaPath(getUserInfo(Auth::user())->tax_card) }}"
                                                target="_blank">
                                                <img src="{{ getMediaPath(getUserInfo(Auth::user())->tax_card) }}"
                                                    style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label" for="id_card_front">{{ __('ID card front') }}</label>
                                    <input name="id_card_front"
                                        class=" form-control @error('id_card_front') is-invalid @enderror" type="file"
                                        id="id_card_front" />
                                    @error('id_card_front')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->id_card_front != null)
                                    <div class="mb-3">
                                        <div class="col-md-10">
                                            <a href="{{ getMediaPath(getUserInfo(Auth::user())->id_card_front) }}"
                                                target="_blank">
                                                <img src="{{ getMediaPath(getUserInfo(Auth::user())->id_card_front) }}"
                                                    style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label" for="id_card_back">{{ __('ID card back') }}</label>
                                    <input name="id_card_back"
                                        class=" form-control @error('id_card_back') is-invalid @enderror" type="file"
                                        id="id_card_back" />
                                    @error('id_card_back')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->id_card_back != null)
                                    <div class="mb-3">
                                        <div class="col-md-10">
                                            <a href="{{ getMediaPath(getUserInfo(Auth::user())->id_card_back) }}"
                                                target="_blank">
                                                <img src="{{ getMediaPath(getUserInfo(Auth::user())->id_card_back) }}"
                                                    style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label" for="bank_account">{{ __('bank account number') }}</label>
                                    <input name="bank_account"
                                        class="form-control @error('bank_account') is-invalid @enderror"
                                        value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->bank_account : '' }}"
                                        type="text" autocomplete="on" id="bank_account" />
                                    @error('bank_account')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="company_address">{{ __('company address') }}</label>
                                    <input name="company_address"
                                        class="form-control @error('company_address') is-invalid @enderror"
                                        value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->company_address : '' }}"
                                        type="text" autocomplete="on" id="company_address" />
                                    @error('company_address')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="website">{{ __('website') }}</label>
                                    <input name="website" class="form-control @error('website') is-invalid @enderror"
                                        value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->website : '' }}"
                                        type="text" autocomplete="on" id="website" />
                                    @error('website')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="facebook_page">{{ __('facebook page') }}</label>
                                    <input name="facebook_page"
                                        class="form-control @error('facebook_page') is-invalid @enderror"
                                        value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->facebook_page : '' }}"
                                        type="text" autocomplete="on" id="facebook_page" />
                                    @error('facebook_page')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>




                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        @endif
    @endif

    @if (checkUserInfo(Auth::user()))
        @if (Auth::user()->hasRole('affiliate'))
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{ __('New feature from Sonoo!') }}
                            <span class="badge badge-soft-warning">New</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Products listing page for affiliate:') }}</h5>
                            <p class="card-text pt-2">
                                {{ __('You can now choose your list of products and display them on a sale page ready to complete the order directly from your customers, a new feature that enables you to market in an easier way without the need to create a website or a landing page for products, all you need now is to choose the products and create your advertising campaigns and get profits') }}
                            </p>
                            <a href="{{ route('store.show', ['user' => Auth::id()]) }}" target="_blank"
                                class="btn btn-primary">{{ __('Visit your page') }}</a>
                            <button id="copy" class="btn btn-info">{{ __('Copy link') }}</button>
                            <input style="display: none" type="text"
                                value="{{ route('store.show', ['user' => Auth::id()]) }}" id="page-link">

                            <input style="display: none" type="text" value="{{ app()->getLocale() }}"
                                id="locale">


                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->hasRole('vendor'))
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            {{ __('your store is active') }}
                            {{-- <span class="badge badge-soft-warning">New</span> --}}
                        </div>
                        <div class="card-body">
                            @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->store_name != null)
                                <a href="{{ route('store.show', ['user' => Auth::id(), 'store_name' => getUserInfo(Auth::user())->store_name]) }}"
                                    target="_blank" class="btn btn-primary">{{ __('Visit your page') }}</a>
                                <button id="copy" class="btn btn-info">{{ __('Copy link') }}</button>
                                <input style="display: none" type="text"
                                    value="{{ route('store.show', ['user' => Auth::id(), 'store_name' => getUserInfo(Auth::user())->store_name]) }}"
                                    id="page-link">

                                <input style="display: none" type="text" value="{{ app()->getLocale() }}"
                                    id="locale">
                            @endif




                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif



    @if (Auth::user()->hasRole('vendor'))
        <!-- Modal -->
        <div style="{{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }}" class="modal fade"
            id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ setting('vendor_modal_title') }}</h5>
                        <button style="{{ app()->getLocale() == 'ar' ? 'margin:0' : '' }}" type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        {{ setting('vendor_modal_body') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if (Auth::user()->hasRole('affiliate'))
        <!-- Modal -->
        <div style="{{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }}" class="modal fade"
            id="affiliateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ setting('affiliate_modal_title') }}</h5>
                        <button style="{{ app()->getLocale() == 'ar' ? 'margin:0' : '' }}" type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        {{ setting('affiliate_modal_body') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
