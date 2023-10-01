@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if ($permissions->count() > 0 && $permissions[0]->trashed())
                            {{ __('permissions trash') }}
                        @else
                            {{ __('vacations & permissions') }}
                        @endif
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-customers-actions">
                        <div class="d-flex">
                            <select class="form-select form-select-sm" aria-label="Bulk actions">
                                {{-- <option selected="">{{ __('Bulk actions') }}</option>
                                <option value="Refund">{{ __('Refund') }}</option>
                                <option value="Delete">{{ __('Delete') }}</option>
                                <option value="Archive">{{ __('Archive') }}</option> --}}
                            </select>
                            <button class="btn btn-falcon-default btn-sm ms-2" type="button">{{ __('Apply') }}</button>
                        </div>
                    </div>
                    <div id="table-customers-replace-element">




                        <a href="{{ route('permissions.create') }}" class="btn btn-falcon-default btn-sm"
                            type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>





                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($permissions->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('Name') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">{{ __('type') }}
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

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">{{ __('Status') }}
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                                @if ($permissions->count() > 0 && $permissions[0]->trashed())
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Deleted at') }}</th>
                                @endif
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($permissions as $permission)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>

                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $permission->user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $permission->user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $permission->user->name }} <br>
                                                        @if ($permission->user->hasRole('administrator|superadministrator') && $permission->branch_id != null)
                                                            <span
                                                                class="badge badge-soft-primary">{{ __('branch') . ': ' . getName($permission->branch) }}
                                                            </span>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </a>
                                    </td>


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
                                        @if ($permission->status == 'pending')
                                            <span class='badge badge-soft-info'>{{ __('pending') }}</span>
                                        @elseif ($permission->status == 'confirmed')
                                            <span class='badge badge-soft-success'>{{ __('confirmed') }}</span>
                                        @elseif ($permission->status == 'rejected')
                                            <span class='badge badge-soft-danger'>{{ __('rejected') }}</span>
                                        @endif
                                    </td>


                                    <td class="joined align-middle py-2">{{ $permission->created_at }} <br>
                                        {{ interval($permission->created_at) }} </td>
                                    @if ($permission->trashed())
                                        <td class="joined align-middle py-2">{{ $permission->deleted_at }} <br>
                                            {{ interval($permission->deleted_at) }} </td>
                                    @endif
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">

                                                    @if ($permission->media_id != null)
                                                        <a class="dropdown-item"
                                                            href="{{ asset($permission->media->path) }}" target="_blank">
                                                            {{ __('show image') }}
                                                        </a>
                                                    @endif

                                                    @if (
                                                        $permission->trashed() &&
                                                            auth()->user()->hasPermission('permissions-restore'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('permissions.restore', ['permission' => $permission->id]) }}">{{ __('Restore') }}</a>
                                                    @elseif(auth()->user()->hasPermission('permissions-update'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('permissions.edit', ['permission' => $permission->id]) }}">{{ __('Edit') }}</a>
                                                    @endif

                                                    @if ($permission->status == 'pending')
                                                        <a class="dropdown-item"
                                                            href="{{ route('permissions.edit', ['permission' => $permission->id]) }}">{{ __('Edit') }}</a>

                                                        <form method="POST"
                                                            action="{{ route('permissions.destroy', ['permission' => $permission->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ $permission->trashed() ? __('Delete') : __('Trash ') }}</button>
                                                        </form>
                                                    @endif

                                                    @if (auth()->user()->hasPermission('permissions-delete') ||
                                                            auth()->user()->hasPermission('permissions-trash'))
                                                        <form method="POST"
                                                            action="{{ route('permissions.destroy', ['permission' => $permission->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ $permission->trashed() ? __('Delete') : __('Trash ') }}</button>
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
            {{ $permissions->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
