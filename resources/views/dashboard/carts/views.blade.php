@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-2 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('website traffic') }}
                    </h5>
                </div>

                <div class="col-10 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">

                        <form id="filter-form" style="display: inline-block" action="">

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
                @if ($views->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('User Name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('Page Path') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('country') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('city') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('ip') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created At') }}</th>



                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($views as $view)
                                <tr class="btn-reveal-trigger">


                                    <td class="name align-middle white-space-nowrap py-2">
                                        @if ($view->user_id != null)
                                            <a href="{{ route('users.show', ['user' => $view->user->id]) }}">
                                                <div class="d-flex d-flex align-items-center">
                                                    <div class="avatar avatar-xl me-2">
                                                        <img class="rounded-circle"
                                                            src="{{ asset('storage/images/users/' . $view->user->profile) }}"
                                                            alt="" />
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="mb-0 fs--1">{{ $view->user->name }} <br>

                                                        </h5>

                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            {{ __('guest') }}
                                        @endif

                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        <a class="text-primary fw-semi-bold" href="{{ $view->full_url }}"
                                            target="_blank">{{ $view->full_url }}</a>
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $view->country_name }}
                                    </td>

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $view->city_name }}
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $view->ip }}
                                    </td>

                                    <td class="joined align-middle py-2">{{ $view->created_at }} <br>
                                        {{ interval($view->created_at) }} </td>

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
            {{ $views->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
