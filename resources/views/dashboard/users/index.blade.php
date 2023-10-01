@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header no-print">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if ($users->count() > 0 && $users[0]->trashed())
                            {{ __('Users trash') }}
                        @else
                            {{ __('Users') }}
                        @endif
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-customers-actions">
                        <div class="d-flex">
                            <select class="form-select form-select-sm" aria-label="Bulk actions">
                                {{--  {{-- <option selected="">{{ __('Bulk actions') }}</option>
                                <option value="Refund">{{ __('Refund') }}</option>
                                <option value="Delete">{{ __('Delete') }}</option>
                                <option value="Archive">{{ __('Archive') }}</option> --}}
                            </select>
                            <button class="btn btn-falcon-default btn-sm ms-2" type="button">{{ __('Apply') }}</button>
                        </div>
                    </div>
                    <div id="table-customers-replace-element">

                        <a href="" data-bs-toggle="modal" data-bs-target="#filter-modal"
                            class="btn btn-falcon-default btn-sm"><span class="fas fa-filter"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Filter') }}</span></a>


                        @if (auth()->user()->hasPermission('users-create'))
                            <a href="{{ route('users.create') }}" class="btn btn-falcon-default btn-sm" type="button"><span
                                    class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                        @endif

                        <a href="{{ route('users.trashed') }}" class="btn btn-falcon-default btn-sm" type="button"><span
                                class="fas fa-trash" data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Trash ') }}</span></a>

                        <a href="{{ route('users.export', ['data' => request()->all()]) }}"
                            class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Export') }}</span></a>
                        <button onclick="printInvoice();" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"
                            type="button"><span class="fas fa-print me-1"> </span>{{ __('Print') }}</button>
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
                                <th class="no-print">
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('Name') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">{{ __('Phone') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('User Type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Status') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Joined') }}</th>
                                @if ($users->count() > 0 && $users[0]->trashed())
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Deleted at') }}</th>
                                @endif
                                <th class="align-middle no-sort no-print"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($users as $user)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2 no-print" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>
                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $user->name }} <br>
                                                        @if ($user->hasRole('administrator|superadministrator') && $user->branch_id != null)
                                                            <span
                                                                class="badge badge-soft-primary">{{ __('branch') . ': ' . getName($user->branch) }}
                                                            </span>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </a></td>
                                    <td class="phone align-middle white-space-nowrap py-2"><a
                                            href="tel:{{ $user->phone }}">{{ $user->phone }}</a></td>
                                    <td class="address align-middle white-space-nowrap py-2">
                                        @foreach ($user->roles as $role)
                                            <div style="display: inline-block">
                                                <span class="badge badge-soft-primary">{{ __($role->name) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">

                                        @if (hasVerifiedPhone($user))
                                            <span class='badge badge-soft-success'>{{ __('Active') }}</span>
                                        @elseif (!hasVerifiedPhone($user))
                                            <span class='badge badge-soft-danger'>{{ __('Inactive') }}</span>
                                        @endif
                                        @if ($user->status == 1)
                                            <span class='badge badge-soft-danger'>{{ __('blocked') }}</span>
                                        @endif
                                    </td>
                                    <td class="joined align-middle py-2">{{ $user->created_at }} <br>
                                        {{ interval($user->created_at) }} </td>
                                    @if ($user->trashed())
                                        <td class="joined align-middle py-2">{{ $user->deleted_at }} <br>
                                            {{ interval($user->deleted_at) }} </td>
                                    @endif
                                    <td class="align-middle white-space-nowrap py-2 text-end no-print">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">
                                                    @if (
                                                        $user->trashed() &&
                                                            auth()->user()->hasPermission('users-restore'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.restore', ['user' => $user->id]) }}">{{ __('Restore') }}</a>
                                                    @elseif(auth()->user()->hasPermission('users-update'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.edit', ['user' => $user->id]) }}">{{ __('Edit') }}</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.activate', ['user' => $user->id]) }}">{{ hasVerifiedPhone($user) ? __('Deactivate') : __('Activate') }}</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.block', ['user' => $user->id]) }}">{{ $user->status == 0 ? __('Block') : __('Unblock') }}</a>
                                                        <a href="" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#bonus-modal-{{ $user->id }}">{{ __('Add bonus') }}</a>
                                                    @endif
                                                    @if (auth()->user()->hasPermission('users-delete') ||
                                                            auth()->user()->hasPermission('users-trash'))
                                                        <form method="POST"
                                                            action="{{ route('users.destroy', ['user' => $user->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ $user->trashed() ? __('Delete') : __('Trash ') }}</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- start bonus modal for each user -->
                                <div class="modal fade" id="bonus-modal-{{ $user->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document"
                                        style="max-width: 500px">
                                        <div class="modal-content position-relative">
                                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                <button
                                                    class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST"
                                                action="{{ route('users.bonus', ['user' => $user->id]) }}">
                                                @csrf
                                                <div class="modal-body p-0">
                                                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                        <h4 class="mb-1" id="modalExampleDemoLabel">
                                                            {{ __('Add bonus') . ' - ' . $user->name }}</h4>
                                                    </div>
                                                    <div class="p-4 pb-0">

                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="bonus">{{ __('Enter bonus amount') }}</label>
                                                            <input name="bonus"
                                                                class="form-control @error('bonus') is-invalid @enderror"
                                                                value="{{ old('bonus') }}" type="number"
                                                                autocomplete="on" id="bonus" autofocus required />
                                                            @error('bonus')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                    <button class="btn btn-primary"
                                                        type="submit">{{ __('Add') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end bonus modal for each user -->
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h3 class="p-4">{{ __('No Users To Show') }}</h3>
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
