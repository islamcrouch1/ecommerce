@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('petty cash') }}
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
                                <select class="form-select model-search sonoo-search" data-url="{{ route('model.search') }}"
                                    data-locale="{{ app()->getLocale() }}" data-parent="" data-type="admins" name="user_id">
                                    <option value="">
                                        {{ __('employees search') }}</option>

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
                @if ($sheets->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('name') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('petty cash amount') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('status') }}
                                </th>


                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>

                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($sheets as $sheet)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>

                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $sheet->user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $sheet->user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $sheet->user->name }} <br>
                                                        @if ($sheet->user->hasRole('administrator|superadministrator') && $sheet->branch_id != null)
                                                            <span
                                                                class="badge badge-soft-primary">{{ __('branch') . ': ' . getName($sheet->branch) }}
                                                            </span>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </a></td>



                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $sheet->amount }}
                                    </td>


                                    <td class="phone align-middle white-space-nowrap py-2">
                                        @if ($sheet->admin_id == null)
                                            <span class='badge badge-soft-danger'>{{ __('unreviewed') }}</span>
                                        @else
                                            <span class='badge badge-soft-success'>{{ __('reviewed') }}</span>
                                        @endif

                                        @if ($sheet->status == 'pending')
                                            <span class='badge badge-soft-danger'>{{ __('pending') }}</span>
                                        @else
                                            <span class='badge badge-soft-success'>{{ __('confirmed') }}</span>
                                        @endif

                                    </td>


                                    <td class="joined align-middle py-2">{{ $sheet->created_at }} <br>
                                        {{ interval($sheet->created_at) }} </td>

                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">

                                                    @if ($sheet->admin_id != null)
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.show', ['user' => $sheet->admin_id]) }}"
                                                            target="_blank">{{ __('reviewer info') }}</a>
                                                    @endif


                                                    <a class="dropdown-item"
                                                        href="{{ route('petty_cash.show', ['petty_cash' => $sheet->id]) }}">{{ __('review petty cash sheet settlement') }}</a>


                                                    @if (auth()->user()->hasPermission('petty_cash-update') && $sheet->status == 'pending')
                                                        <a class="dropdown-item"
                                                            href="{{ route('petty_cash.review', ['petty_cash' => $sheet->id]) }}">

                                                            @if ($sheet->admin_id == null)
                                                                {{ __('confirm review') }}
                                                            @else
                                                                {{ __('cancel review') }}
                                                            @endif



                                                        </a>
                                                    @endif

                                                    @if (auth()->user()->hasPermission('petty_cash-delete') ||
                                                            auth()->user()->hasPermission('petty_cash-trash'))
                                                        <form method="POST"
                                                            action="{{ route('petty_cash.destroy', ['petty_cash' => $sheet->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ __('Delete') }}</button>
                                                        </form>
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
                    <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $sheets->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
