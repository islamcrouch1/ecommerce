@extends('layouts.dashboard.app')

@section('adminContent')



    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>



        <div class="card-header no-print">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if ($posts->count() > 0 && $posts[0]->trashed())
                            {{ __('posts') . ' ' . __('trash') }}
                        @else
                            {{ __('posts') }}
                        @endif
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
                    <div id="table-customers-replace-element">
                        @if (auth()->user()->hasPermission('posts-create'))
                            <a href="{{ route('posts.create') }}" class="btn btn-falcon-default btn-sm" type="button"><span
                                    class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                        @endif
                        <a href="{{ route('posts.trashed') }}" class="btn btn-falcon-default btn-sm" type="button"><span
                                class="fas fa-trash" data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('Trash ') }}</span></a>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($posts->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="no-print">
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                        <input class="form-check-input" id="checkbox-bulk-customers-select" type="checkbox"
                                            data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                    </div>
                                </th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('ID') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('title') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>
                                @if ($posts->count() > 0 && $posts[0]->trashed())
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Deleted at') }}</th>
                                @endif
                                <th class="align-middle no-sort no-print"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($posts as $post)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle py-2 no-print" style="width: 28px;">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input name="selected_items[]" value="{{ $post->id }}"
                                                class="form-check-input" type="checkbox" id="customer-0"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $post->id }}</td>
                                    <td class="name align-middle py-2">
                                        <div class="d-flex d-flex align-items-center">
                                            <div class="avatar avatar-xl me-2">
                                                <img class="rounded-circle" src="{{ getProductImage($post) }}"
                                                    alt="" />
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="mb-0 fs--1">
                                                    {{-- {{ $post->images->count() }} --}}
                                                    {{ app()->getLocale() == 'ar' ? $post->name_ar : $post->name_en }}
                                                </h5>
                                            </div>
                                        </div>
                                    </td>


                                    <td class="joined align-middle py-2">{{ $post->created_at }} <br>
                                        {{ interval($post->created_at) }} </td>
                                    @if ($post->trashed())
                                        <td class="joined align-middle py-2">{{ $post->deleted_at }} <br>
                                            {{ interval($post->deleted_at) }} </td>
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
                                                        $post->trashed() &&
                                                            auth()->user()->hasPermission('posts-restore'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('posts.restore', ['post' => $post->id]) }}">{{ __('Restore') }}</a>
                                                    @elseif(auth()->user()->hasPermission('posts-update'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('posts.edit', ['post' => $post->id]) }}">{{ __('Edit') }}</a>
                                                    @endif

                                                    @if (auth()->user()->hasPermission('posts-delete') ||
                                                            auth()->user()->hasPermission('posts-trash'))
                                                        <form method="POST"
                                                            action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ $post->trashed() ? __('Delete') : __('Trash ') }}</button>
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
            {{ $posts->appends(request()->query())->links() }}
        </div>

    </div>


@endsection
