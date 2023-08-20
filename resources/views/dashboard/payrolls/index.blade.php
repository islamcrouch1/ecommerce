@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('payrolls') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">

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
                                <input type="month" id="date" name="date"
                                    class="form-control form-select-sm sonoo-search" value="{{ request()->date }}">
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($employees->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('ID') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('name') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('job title') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('salary') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('salary per day') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('absence days') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('total absence') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('penalties') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('loans') }}</th>


                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('total deduction') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('rewards') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('net salary') }}</th>






                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($employees as $employee)
                                <tr class="btn-reveal-trigger">


                                    <td class="phone align-middle white-space-nowrap py-2">{{ $employee->user_id }}
                                    </td>

                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $employee->user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $employee->user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $employee->user->name }} <br>
                                                        @if ($employee->user->hasRole('administrator|superadministrator') && $employee->branch_id != null)
                                                            <span
                                                                class="badge badge-soft-primary">{{ __('branch') . ': ' . getName($employee->branch) }}
                                                            </span>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </a></td>


                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $employee->job_title }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ getUserSalary($employee->user) }}
                                    </td>



                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $day_salary = getUserDaySalary($employee->user) }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $absence_days = getUserAbsenceDays($employee->user, request()->date) }}
                                    </td>



                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $total_absence = $absence_days * $day_salary }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $penalties_amount = getUserPenalties($employee->user, request()->date) }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $loans = getUserLoans($employee->user) }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $total_deduction = $total_absence + $penalties_amount + $loans }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $rewards_amount = getUserRewards($employee->user, request()->date) }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $net_salary = getUserSalary($employee->user) - $total_absence - $penalties_amount - $loans + $rewards_amount }}
                                    </td>








                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">

                                                    @if (auth()->user()->hasPermission('payroll-create'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('payroll.create', ['user' => $employee->user_id, 'date' => request()->date]) }}">{{ __('create salary card') }}</a>
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
                    <h3 class="p-4">{{ __('No data to show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $employees->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
