@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Previews') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">

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

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($previews->count() > 0)
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
                                    {{ __('preview id') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('Name') }}
                                </th>


                                @if (auth()->user()->hasPermission('previews_score-create'))
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('completed stages') }}
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('score') }}
                                    </th>
                                @endif


                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Joined') }}</th>
                                @if ($previews->count() > 0 && $previews[0]->trashed())
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Deleted at') }}</th>
                                @endif
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($previews as $preview)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>

                                    <td class="joined align-middle py-2">{{ $preview->id }} </td>
                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('previews_clients.show', ['previews_client' => $preview->user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $preview->user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $preview->user->name }}</h5>
                                                </div>
                                            </div>
                                        </a></td>


                                    @if (auth()->user()->hasPermission('previews_score-create'))
                                        @php
                                            $score = 0;
                                        @endphp
                                        @foreach ($stages as $stage)
                                            @php
                                                $score += $stage->total_score;
                                            @endphp
                                        @endforeach


                                        <td class="joined align-middle py-2">{{ $preview->stage_count }} </td>
                                        <td class="joined align-middle py-2">{{ $preview->total_score }}
                                            <br> {{ ($preview->total_score / $score) * 100 . ' %' }}
                                        </td>
                                    @endif


                                    <td class="joined align-middle py-2">{{ $preview->user->created_at }} <br>
                                        {{ interval($preview->user->created_at) }} </td>
                                    @if ($preview->trashed())
                                        <td class="joined align-middle py-2">{{ $preview->user->deleted_at }} <br>
                                            {{ interval($preview->user->deleted_at) }} </td>
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


                                                    @if (auth()->user()->hasPermission('previews-create'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('previews.create', ['user' => $preview->user->id, 'preview' => $preview->id]) }}">{{ __('Edit or view') }}</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('previews.create', ['user' => $preview->user->id]) }}">{{ __('Start Preview') }}</a>
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
                    <h3 class="p-4">{{ __('No Clinets To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $previews->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
