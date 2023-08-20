@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Logs') }}
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

                            <div class="d-inline-block">
                                <select name="user_type" class="form-select form-select-sm sonoo-search"
                                    id="autoSizingSelect">
                                    <option value="" selected>{{ __('All uesr types') }}</option>
                                    <option value="admin" {{ request()->user_type == 'admin' ? 'selected' : '' }}>
                                        {{ __('admin') }}</option>
                                    <option value="affiliate" {{ request()->user_type == 'affiliate' ? 'selected' : '' }}>
                                        {{ __('affiliate') }}</option>
                                    <option value="vendor" {{ request()->user_type == 'vendor' ? 'selected' : '' }}>
                                        {{ __('vendor') }}</option>
                                </select>
                            </div>
                            <div class="d-inline-block">
                                <select name="log_type" class="form-select form-select-sm sonoo-search"
                                    id="autoSizingSelect">
                                    <option value="" selected>{{ __('All log types') }}</option>
                                    <option value="orders" {{ request()->log_type == 'orders' ? 'selected' : '' }}>
                                        {{ __('orders') }}</option>
                                    <option value="users" {{ request()->log_type == 'users' ? 'selected' : '' }}>
                                        {{ __('users') }}</option>
                                    <option value="products" {{ request()->log_type == 'products' ? 'selected' : '' }}>
                                        {{ __('products') }}</option>
                                    <option value="exports" {{ request()->log_type == 'exports' ? 'selected' : '' }}>
                                        {{ __('exports') }}</option>
                                    <option value="imports" {{ request()->log_type == 'imports' ? 'selected' : '' }}>
                                        {{ __('imports') }}</option>
                                    <option value="bonus" {{ request()->log_type == 'bonus' ? 'selected' : '' }}>
                                        {{ __('bonus') }}</option>
                                </select>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($logs->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('User name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('User Type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('Log Type') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Description') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($logs as $log)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>
                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $log->user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">

                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $log->user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">
                                                        {{ $log->user->name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </a>

                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        @if ($log->user_type == 'admin')
                                            <span class='badge badge-soft-warning'>{{ __($log->user_type) }}</span>
                                        @elseif ($log->user_type == 'affiliate')
                                            <span class='badge badge-soft-danger'>{{ __($log->user_type) }}</span>
                                        @elseif ($log->user_type == 'vendor')
                                            <span class='badge badge-soft-success'>{{ __($log->user_type) }}</span>
                                        @endif
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        @if ($log->log_type == 'orders')
                                            <span class='badge badge-soft-warning'>{{ __($log->log_type) }}</span>
                                        @elseif ($log->log_type == 'users')
                                            <span class='badge badge-soft-danger'>{{ __($log->log_type) }}</span>
                                        @elseif ($log->log_type == 'products')
                                            <span class='badge badge-soft-success'>{{ __($log->log_type) }}</span>
                                        @elseif ($log->log_type == 'exports')
                                            <span class='badge badge-soft-info'>{{ __($log->log_type) }}</span>
                                        @elseif ($log->log_type == 'imports')
                                            <span class='badge badge-soft-primary'>{{ __($log->log_type) }}</span>
                                        @elseif ($log->log_type == 'bonus')
                                            <span class='badge badge-soft-warning'>{{ __($log->log_type) }}</span>
                                        @endif
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ app()->getLocale() == 'ar' ? $log->description_ar : $log->description_en }}
                                    </td>
                                    <td class="joined align-middle py-2">{{ $log->created_at }} <br>
                                        {{ interval($log->created_at) }} </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h3 class="p-4">{{ __('No logs To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $logs->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
