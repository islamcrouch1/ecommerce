@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">


                    @php
                        $salary_card = getSalaryCard($user, request()->date);
                    @endphp

                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">

                        @if ($salary_card)
                            {{ __('The salary card was previously prepared for this employee') . ' - ' . $user->name . ' ' . __('by') . ' ' }}
                            <a href="{{ route('users.show', ['user' => $salary_card->created_by]) }}"
                                target="_blank">{{ $salary_card->admin->name }}</a>
                        @else
                            {{ __('card salary preparation') . ' - ' . $user->name }}
                        @endif


                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">



            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">

                        <form style="display: inline-block" action="">

                            <div class="d-inline-block">
                                <label class="form-label" for="date">{{ __('select date') }}</label>
                                <input type="month" id="date" name="date"
                                    class="form-control form-select-sm sonoo-search" value="{{ request()->date }}">
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            @if ($permissions->count() > 0)
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                            <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                                {{ __('vacations & permissions') }}
                            </h5>
                        </div>

                    </div>
                </div>

                <div class="card-body p-0 m-3">
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                            <thead class="bg-200 text-900">
                                <tr>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                        {{ __('type') }}
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                        {{ __('permission reason') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                        {{ __('permission start date') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                        {{ __('permission end date') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                        {{ __('reviewer info') }}
                                    </th>

                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                        {{ __('Status') }}
                                    </th>


                                </tr>
                            </thead>
                            <tbody class="list" id="table-customers-body">
                                @foreach ($permissions as $permission)
                                    <tr class="btn-reveal-trigger">



                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ __($permission->type) }}
                                        </td>

                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $permission->reason }}
                                        </td>


                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $permission->start_date }}
                                        </td>

                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $permission->end_date }}
                                        </td>



                                        <td class="phone align-middle white-space-nowrap py-2">
                                            @if ($permission->admin_id != null)
                                                <a href="{{ route('users.show', ['user' => $permission->admin_id]) }}"
                                                    target="_blank">{{ $permission->admin->name }}</a>
                                            @endif
                                        </td>

                                        <td class="phone align-middle white-space-nowrap py-2">
                                            @if ($permission->status == 'pending')
                                                <span class='badge badge-soft-info'>{{ __('pending') }}</span>
                                            @elseif ($permission->status == 'confirmed')
                                                <span class='badge badge-soft-success'>{{ __('confirmed') }}</span>
                                            @elseif ($permission->status == 'rejected')
                                                <span class='badge badge-soft-danger'>{{ __('rejected') }}</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            @endif


            <div class="row m-3">
                <div class="col-md-4">
                    <div class="alert alert-danger" role="alert">
                        {{ __('late attendance') . ': ' . getAllLateTime($user, request()->date) . ' ' . __('Minute') }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="alert alert-danger" role="alert">
                        {{ __('early leave') . ': ' . getAllEarlyTime($user, request()->date) . ' ' . __('Minute') }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="alert alert-success" role="alert">
                        {{ __('over time') . ': ' . getAllOverTime($user, request()->date) . ' ' . __('Minute') }}
                    </div>
                </div>
            </div>

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('employees.payroll.store', ['user' => $user->id, 'date' => request()->date]) }}">
                            @csrf


                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="salary">{{ __('salary') }}</label>
                                    <input name="salary"
                                        class="form-control salary_filed @error('salary') is-invalid @enderror"
                                        value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->basic_salary + getEmployeeInfo($user)->variable_salary : '0' }}"
                                        type="number" min="0" step="0.01" autocomplete="on" id="salary"
                                        disabled />

                                    @error('salary')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="day_salary">{{ __('salary per day') }}</label>
                                    <input name="day_salary" class="form-control @error('day_salary') is-invalid @enderror"
                                        value="{{ $day_salary }}" type="number" min="0" step="0.01"
                                        autocomplete="on" id="day_salary" disabled />

                                    @error('day_salary')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="absence_days">{{ __('absence days') }}</label>
                                    <input name="absence_days"
                                        class="form-control @error('absence_days') is-invalid @enderror"
                                        value="{{ $absence_days }}" type="number" min="0" step="1"
                                        autocomplete="on" id="absence_days" disabled />

                                    @error('absence_days')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="total_absence">{{ __('total absence') }}</label>
                                    <input name="total_absence"
                                        class="form-control total_absence @error('total_absence') is-invalid @enderror"
                                        value="{{ $total_absence }}" type="number" min="0" step="0.01"
                                        autocomplete="on" id="total_absence" disabled />

                                    @error('total_absence')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="penalties_amount">{{ __('penalties') }}</label>
                                    <input name="penalties_amount"
                                        class="form-control penalties_amount @error('penalties_amount') is-invalid @enderror"
                                        value="{{ $salary_card ? $salary_card->penalties : $penalties_amount }}"
                                        type="number" min="0" step="0.01" autocomplete="on"
                                        id="penalties_amount" />

                                    @error('penalties_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="insurance">{{ __('insurance') }}</label>
                                    <input name="insurance"
                                        class="form-control insurance @error('insurance') is-invalid @enderror"
                                        value="{{ $salary_card ? $salary_card->insurance : 0 }}" type="number"
                                        min="0" step="0.01" autocomplete="on" id="insurance" />

                                    @error('insurance')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="loans">{{ __('loans') }}</label>
                                    <input name="loans" class="form-control loans @error('loans') is-invalid @enderror"
                                        value="{{ $salary_card ? $salary_card->loans : $loans }}" type="number"
                                        min="0" step="0.01" autocomplete="on" id="loans" />

                                    @error('loans')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="total_deduction">{{ __('total deduction') }}</label>
                                    <input name="total_deduction"
                                        class="form-control total_deduction @error('total_deduction') is-invalid @enderror"
                                        value="{{ $salary_card ? $salary_card->total_deduction : $total_deduction }}"
                                        type="number" min="0" step="0.01" autocomplete="on"
                                        id="total_deduction" disabled />

                                    @error('total_deduction')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="rewards_amount">{{ __('rewards') }}</label>
                                    <input name="rewards_amount"
                                        class="form-control rewards_amount @error('rewards_amount') is-invalid @enderror"
                                        value="{{ $salary_card ? $salary_card->rewards : $rewards_amount }}"
                                        type="number" min="0" step="0.01" autocomplete="on"
                                        id="rewards_amount" />

                                    @error('rewards_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="net_salary">{{ __('net salary') }}</label>
                                    <input name="net_salary"
                                        class="form-control net_salary @error('net_salary') is-invalid @enderror"
                                        value="{{ $salary_card ? $salary_card->net_salary : $net_salary }}"
                                        type="number" min="0" step="0.01" autocomplete="on" id="net_salary"
                                        disabled />

                                    @error('net_salary')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>


                            @if (($salary_card && $salary_card->status == 'unconfirmed') || $salary_card == null)
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">

                                        @if ($salary_card)
                                            {{ __('Edit salary card') }}
                                        @else
                                            {{ __('Save') }}
                                        @endif



                                    </button>
                                </div>
                            @endif

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
