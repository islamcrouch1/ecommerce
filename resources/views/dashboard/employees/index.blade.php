@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('employees') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">


                        <a href="" data-bs-toggle="modal" data-bs-target="#filter-modal"
                            class="btn btn-falcon-default btn-sm"><span class="fas fa-filter"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Filter') }}</span></a>


                        @if (auth()->user()->hasPermission('employees-create'))
                            <a href="{{ route('users.create') }}" class="btn btn-falcon-default btn-sm" type="button"><span
                                    class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($users->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('ID') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('phone') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('job title') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('working hours') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('start time') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Weekend days') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('basic salary') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('variable salary') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>

                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($users as $user)
                                <tr class="btn-reveal-trigger">

                                    @php
                                        $employee = getEmployeeInfo($user);
                                    @endphp

                                    <td class="phone align-middle white-space-nowrap py-2">{{ $employee->user_id }}
                                    </td>

                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('employees.show', ['employee' => $employee->id]) }}">
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
                                        {{ $employee->user->phone }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $employee->job_title }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $employee->work_hours }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $employee->start_time }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        @if ($employee->Weekend_days && is_array(unserialize($employee->Weekend_days)))
                                            @foreach (unserialize($employee->Weekend_days) as $day)
                                                <span class="badge badge-soft-primary">{{ __($day) }}
                                                </span>
                                            @endforeach
                                        @endif

                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $employee->basic_salary }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $employee->variable_salary }}
                                    </td>









                                    <td class="joined align-middle py-2">{{ $employee->user->created_at }} <br>
                                        {{ interval($employee->user->created_at) }} </td>

                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">
                                                    @if (auth()->user()->hasPermission('employees-update'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('employees.edit', ['employee' => $employee->id]) }}">{{ __('Edit') }}</a>

                                                        <a class="dropdown-item"
                                                            href="{{ route('users.activate', ['user' => $employee->user->id]) }}">{{ hasVerifiedPhone($user) ? __('Deactivate') : __('Activate') }}</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.block', ['user' => $employee->user->id]) }}">{{ $user->status == 0 ? __('Block') : __('Unblock') }}</a>
                                                    @endif




                                                    {{-- @if (auth()->user()->hasPermission('payroll-create'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('payroll.create', ['user' => $employee->user->id]) }}">{{ __('payroll preparation') }}</a>
                                                    @endif --}}

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
            {{ $users->appends(request()->query())->links() }}
        </div>

    </div>



    <!-- start filter modal -->
    <div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60%">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="">
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">
                                {{ __('search filters') }}</h4>
                        </div>
                        <div class="p-4 pb-0">

                            <div class="row">


                                {{-- <div class="col-md-12 mb-3">
                                        <input class="form-control search-input fuzzy-search" type="search"
                                            value="{{ request()->search }}" name="search" autofocus
                                            placeholder="{{ __('Search...') }}" />
                                    </div> --}}


                                <div class="col-md-12 mb-3">
                                    <select class="form-select model-search" data-url="{{ route('model.search') }}"
                                        data-locale="{{ app()->getLocale() }}" data-parent="" data-field_type="search"
                                        data-type="users" name="search">
                                        <option value="">
                                            {{ __('users') . ' ' . 'search' }}</option>

                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="input-group"><span class="input-group-text"
                                            id="from">{{ __('From') }}</span>
                                        <input type="date" id="from" name="from" class="form-control"
                                            value="{{ request()->from }}">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="input-group"><span class="input-group-text"
                                            id="to">{{ __('To') }}</span>
                                        <input type="date" id="to" name="to" class="form-control"
                                            value="{{ request()->to }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <select name="role_id" class="form-select" id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Roles') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ request()->role_id == $role->id ? 'selected' : '' }}>
                                                {{ __($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <select name="status" class="form-select" id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Status') }}</option>
                                        <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                            {{ __('active') }}</option>
                                        <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>
                                            {{ __('inactive') }}</option>
                                        <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>
                                            {{ __('blocked') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-3  mb-3">
                                    <select name="country_id" class="form-select" id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Countries') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                                {{ getName($country) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3  mb-3">
                                    <select name="branch_id" class="form-select" id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Branches') }}</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ request()->branch_id == $branch->id ? 'selected' : '' }}>
                                                {{ getName($branch) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-primary" type="submit">{{ __('Apply') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end filter modal -->


@endsection
