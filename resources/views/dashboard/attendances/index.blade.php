@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('attendances') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">

                        @if (auth()->user()->hasPermission('attendances-create'))
                            <a href="{{ route('attendances.create') }}" class="btn btn-falcon-default btn-sm"
                                type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                        @endif

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
                                <select class="form-select model-search sonoo-search" data-url="{{ route('model.search') }}"
                                    data-locale="{{ app()->getLocale() }}" data-parent="" data-type="admins" name="user_id">
                                    <option value="">
                                        {{ __('employees search') }}</option>

                                </select>
                            </div>


                            <div class="d-inline-block">
                                <select name="status" class="form-select sonoo-search" id="autoSizingSelect">
                                    <option value="" selected>{{ __('All Status') }}</option>
                                    <option value="attendance" {{ request()->status == 'attendance' ? 'selected' : '' }}>
                                        {{ __('attendance') }}</option>
                                    <option value="leave" {{ request()->status == 'leave' ? 'selected' : '' }}>
                                        {{ __('leave') }}</option>
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



                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($attendances->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('ID') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('record type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('ip') }}</th>

                                {{-- <th class="sort pe-1 align-middle " data-sort="email">
                                    {{ __('device') }}</th> --}}
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('city name') }}
                                </th>



                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('record date') }}</th>


                                {{-- <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th> --}}

                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($attendances as $attendance)
                                <tr class="btn-reveal-trigger">


                                    <td class="phone align-middle white-space-nowrap py-2">{{ $attendance->user_id }}
                                    </td>

                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $attendance->user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $attendance->user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $attendance->user->name }} <br>
                                                        @if ($attendance->user->hasRole('administrator|superadministrator') && $attendance->user->branch_id != null)
                                                            <span
                                                                class="badge badge-soft-primary">{{ __('branch') . ': ' . getName($attendance->user->branch) }}
                                                            </span>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </a></td>



                                    <td class="phone align-middle white-space-nowrap py-2">
                                        @if ($attendance->attendance_date != null)
                                            <span class="badge badge-soft-primary">{{ __('attendance record') }}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger">{{ __('leave record') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $attendance->ip }}
                                    </td>

                                    {{-- <td class="phone align-middle py-2">
                                        {{ $attendance->device }}
                                    </td> --}}

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $attendance->city_name }}
                                    </td>

                                    @if ($attendance->attendance_date != null)
                                        <td class="joined align-middle py-2">{{ $attendance->attendance_date }} <br>
                                            {{ interval($attendance->attendance_date) }}

                                            @if (getLateTimeForAttendance($attendance) > 0)
                                                <span
                                                    class="badge badge-soft-danger">{{ __('late attendance') . ': ' . getLateTimeForAttendance($attendance) . ' ' . __('Minute') }}
                                                </span>
                                            @endif



                                        </td>
                                    @else
                                        <td class="joined align-middle py-2">{{ $attendance->leave_date }} <br>
                                            {{ interval($attendance->leave_date) }}
                                            @if (getEarlyTimeForLeave($attendance) > 0)
                                                <span
                                                    class="badge badge-soft-danger">{{ __('early leave') . ': ' . getEarlyTimeForLeave($attendance) . ' ' . __('Minute') }}
                                                </span>
                                            @endif

                                            @if (getOverTimeForLeave($attendance) > 0)
                                                <span
                                                    class="badge badge-soft-success">{{ __('over time') . ': ' . getOverTimeForLeave($attendance) . ' ' . __('Minute') }}
                                                </span>
                                            @endif

                                        </td>
                                    @endif


                                    {{-- <td class="joined align-middle py-2">{{ $attendance->created_at }} <br>
                                        {{ interval($attendance->created_at) }} </td> --}}






                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">
                                                    @if (auth()->user()->hasPermission('attendances-update'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('attendances.edit', ['attendance' => $attendance->id]) }}">{{ __('Edit') }}</a>
                                                    @endif

                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#attendance-{{ $attendance->id }}"
                                                        href="">{{ __('map view') }}</a>

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
            {{ $attendances->appends(request()->query())->links() }}
        </div>

    </div>

    @foreach ($attendances as $attendance)
        <div class="modal fade" id="attendance-{{ $attendance->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">
                                {{ __('map view') }}
                            </h4>
                        </div>
                        <div class="p-4 pb-0">
                            <iframe width="100%" height="400" frameborder="0" style="border:0"
                                src="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}&output=embed"
                                allowfullscreen></iframe>

                            <br>

                            <p>
                                {{ __('device') . ' - ' . $attendance->device }}
                            </p>

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

@endsection
