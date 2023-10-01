@extends('layouts.dashboard.app')

@section('adminContent')

    <form id="bulk-form" method="POST" action="{{ route('products.status.bulk') }}">
        @csrf

        <div class="card mb-3" id="customersTable"
            data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>



            <div class="card-header no-print">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                            @if ($products->count() > 0 && $products[0]->trashed())
                                {{ __('Products trash') }}
                            @else
                                {{ __('Products') }}
                            @endif
                        </h5>
                    </div>
                    <div class="col-8 col-sm-auto text-end ps-2">
                        <div class="d-none" id="table-customers-actions">
                            <div class="d-flex">
                                <select name="selected_status" class="form-select form-select-sm" aria-label="Bulk actions"
                                    required>
                                    <option value="">{{ __('Change status') }}</option>
                                    <option value="pending">
                                        {{ __('Pending') }}</option>
                                    <option value="active">
                                        {{ __('Active') }}</option>
                                    <option value="rejected">
                                        {{ __('Rejected') }}</option>
                                    <option value="pause">
                                        {{ __('pause') }}</option>
                                </select>

                                <button class="btn btn-falcon-default btn-sm ms-2"
                                    type="submit">{{ __('Apply') }}</button>
                            </div>
                        </div>
                        <form action=""></form>
                        <div id="table-customers-replace-element">


                            <a href="" data-bs-toggle="modal" data-bs-target="#filter-modal"
                                class="btn btn-falcon-default btn-sm"><span class="fas fa-filter"
                                    data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Filter') }}</span></a>



                            <form style="display: inline-block" action="{{ route('products.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input class="form-control form-control-sm sonoo-search" type="file" name="file"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                    data-buttonText="{{ __('Import') }}" required />

                                {{-- <button class="btn btn-falcon-default btn-sm" type="submit"><span
                                    class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Import') }}</span></button> --}}
                            </form>

                            @if (auth()->user()->hasPermission('products-create') && !isset($is_vendors))
                                <a href="{{ route('products.create') }}" class="btn btn-falcon-default btn-sm"
                                    type="button"><span class="fas fa-plus"
                                        data-fa-transform="shrink-3 down-2"></span><span
                                        class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>
                            @endif
                            <a href="{{ route('products.trashed') }}" class="btn btn-falcon-default btn-sm"
                                type="button"><span class="fas fa-trash" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Trash ') }}</span></a>
                            <a href="{{ route('products.export', ['data' => request()->all(), 'is_vendors' => $is_vendors ?? null]) }}"
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
                    @if ($products->count() > 0)
                        <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                            <thead class="bg-200 text-900">
                                <tr>
                                    <th class="no-print">
                                        <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                            <input class="form-check-input" id="checkbox-bulk-customers-select"
                                                type="checkbox"
                                                data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}' />
                                        </div>
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('ID') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                        {{ __('Product Name') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                        {{ __('SKU - ID') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('sale price') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('discount price') }}
                                    </th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('product type') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Quantity') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                        {{ __('Status') }}</th>
                                    <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                        data-sort="joined">{{ __('Created at') }}</th>
                                    @if ($products->count() > 0 && $products[0]->trashed())
                                        <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                            data-sort="joined">{{ __('Deleted at') }}</th>
                                    @endif
                                    <th class="align-middle no-sort no-print"></th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-customers-body">
                                @foreach ($products as $product)
                                    <tr class="btn-reveal-trigger">
                                        <td class="align-middle py-2 no-print" style="width: 28px;">
                                            <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                                <input name="selected_items[]" value="{{ $product->id }}"
                                                    class="form-check-input" type="checkbox" id="customer-0"
                                                    data-bulk-select-row="data-bulk-select-row" />
                                            </div>
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $product->id }}</td>
                                        <td class="name align-middle py-2">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle" src="{{ getProductImage($product) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">
                                                        {{-- {{ $product->images->count() }} --}}
                                                        {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="phone align-middle  py-2">
                                            {{ $product->sku }}</td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $product->sale_price . ' ' . $product->country->currency }}</td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $product->discount_price . ' ' . $product->country->currency }}</td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ __($product->product_type) }}</td>
                                        <td class="phone align-middle white-space-nowrap py-2">



                                            @if (!$product->trashed())
                                                @if ($product->vendor_id == null)
                                                    {{ productQuantity($product->id, null, null, $user->hasPermission('branches-read') ? null : $user->branch->warehouses) . ' ' . getName(getUnitByID($product->unit_id)) }}
                                                @else
                                                    {{ productQuantity($product->id, null, null, null) . ' ' . getName(getUnitByID($product->unit_id)) }}
                                                @endif
                                            @endif

                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            @switch($product->status)
                                                @case('pending')
                                                    <span class='badge badge-soft-info'>{{ __('Pending') }}</span>
                                                @break

                                                @case('active')
                                                    <span class='badge badge-soft-success'>{{ __('Active') }}</span>
                                                @break

                                                @case('rejected')
                                                    <span class='badge badge-soft-danger'>{{ __('Rejected') }}</span>
                                                @break

                                                @case('pause')
                                                    <span class='badge badge-soft-warning'>{{ __('pause') }}</span>
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td class="joined align-middle py-2">{{ $product->created_at }} <br>
                                            {{ interval($product->created_at) }} </td>
                                        @if ($product->trashed())
                                            <td class="joined align-middle py-2">{{ $product->deleted_at }} <br>
                                                {{ interval($product->deleted_at) }} </td>
                                        @endif
                                        <td class="align-middle white-space-nowrap py-2 text-end no-print">
                                            <div class="dropdown font-sans-serif position-static">
                                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                    type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                    data-boundary="window" aria-haspopup="true"
                                                    aria-expanded="false"><span
                                                        class="fas fa-ellipsis-h fs--1"></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0"
                                                    aria-labelledby="customer-dropdown-0">
                                                    <div class="bg-white py-2">
                                                        @if (
                                                            $product->trashed() &&
                                                                auth()->user()->hasPermission('products-restore'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('products.restore', ['product' => $product->id]) }}">{{ __('Restore') }}</a>
                                                        @elseif(auth()->user()->hasPermission('products-update'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('products.edit', ['product' => $product->id]) }}">{{ __('Edit') }}</a>
                                                            <a href="" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#status-modal-{{ $product->id }}">{{ __('Change Status') }}</a>
                                                            @if ($product->product_type == 'simple' || $product->product_type == 'variable')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('products.variables.create', ['product' => $product->id]) }}">{{ __('Edit Variables') }}</a>
                                                            @endif

                                                            @if ($product->vendor_id != null)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('users.show', ['user' => $product->vendor_id]) }}">{{ __('Vendor Info') }}</a>
                                                            @endif

                                                            @if ($product->updated_by != null)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('users.show', ['user' => $product->updated_by]) }}">{{ __('Admin Info') }}</a>
                                                            @endif

                                                            @if ($product->created_by != null && $product->vendor_id == null)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('users.show', ['user' => $product->created_by]) }}">{{ __('Created By') }}</a>
                                                            @endif
                                                        @endif

                                                        @if (auth()->user()->hasPermission('add_stock-update'))
                                                            @if ($product->product_type == 'simple' || $product->product_type == 'variable')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('products.stock.create', ['product' => $product->id]) }}">{{ __('Edit Stock') }}</a>
                                                            @endif
                                                        @endif



                                                        <a class="dropdown-item"
                                                            href="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}"
                                                            target="_blank">{{ __('show product') }}</a>

                                                        @if (auth()->user()->hasPermission('products-create'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('products.duplicate', ['product' => $product->id]) }}">{{ __('duplicate') }}</a>
                                                        @endif
                                                        @if (auth()->user()->hasPermission('products-delete') ||
                                                                auth()->user()->hasPermission('products-trash'))
                                                            <form method="POST"
                                                                action="{{ route('products.destroy', ['product' => $product->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="dropdown-item text-danger"
                                                                    type="submit">{{ $product->trashed() ? __('Delete') : __('Trash ') }}</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if (auth()->user()->hasPermission('products-update'))
                                        <!-- start change status modal for each order -->
                                        <div class="modal fade" id="status-modal-{{ $product->id }}" tabindex="-1"
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
                                                        action="{{ route('products.status', ['product' => $product->id]) }}">
                                                        @csrf
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">
                                                                    {{ __('Change status - product ID') . ' - #' . $product->id }}
                                                                </h4>
                                                            </div>
                                                            <div class="p-4 pb-0">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="bonus">{{ __('Change product status') }}</label>
                                                                    <select
                                                                        class="form-control @error('status') is-invalid @enderror"
                                                                        name="status" required>
                                                                        <option value="pending"
                                                                            {{ $product->status == 'pending' ? 'selected' : '' }}>
                                                                            {{ __('Pending') }}</option>
                                                                        <option value="active"
                                                                            {{ $product->status == 'active' ? 'selected' : '' }}>
                                                                            {{ __('Active') }}</option>
                                                                        <option value="rejected"
                                                                            {{ $product->status == 'rejected' ? 'selected' : '' }}>
                                                                            {{ __('Rejected') }}</option>
                                                                        <option value="pause"
                                                                            {{ $product->status == 'pause' ? 'selected' : '' }}>
                                                                            {{ __('pause') }}</option>
                                                                    </select>
                                                                    @error('status')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <button class="btn btn-primary"
                                                                type="submit">{{ __('Save') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end change status modal for each user -->
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    @else
                        <h3 class="p-4">{{ __('No products To Show') }}</h3>
                    @endif
                </div>
            </div>


            <div class="card-footer d-flex align-items-center justify-content-center">
                {{ $products->appends(request()->query())->links() }}
            </div>

        </div>

    </form>



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
                                <div class="col-md-12 mb-3">
                                    <select class="form-select model-search" data-url="{{ route('model.search') }}"
                                        data-locale="{{ app()->getLocale() }}" data-parent="" data-type="products_all"
                                        data-field_type="search" name="search">
                                        <option value="">
                                            {{ __('products search') }}</option>

                                    </select>
                                </div>

                                {{-- <div class="col-md-6 mb-3">
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
                                </div> --}}

                                <div class="col-md-3 mb-3">
                                    <select name="category_id" class="form-select form-select-sm" id="autoSizingSelect">
                                        <option value="">
                                            {{ __('All Categories') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                            </option>

                                            @if ($category->children->count() > 0)
                                                @foreach ($category->children as $subCat)
                                                    @include('dashboard.categories._category_options', [
                                                        'category' => $subCat,
                                                    ])
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <select name="status" class="form-select form-select-sm sonoo-search"
                                        id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Status') }}</option>
                                        <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                            {{ __('Active') }}</option>
                                        <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('Pending') }}</option>
                                        <option value="rejected" {{ request()->status == 'rejected' ? 'selected' : '' }}>
                                            {{ __('Rejected') }}</option>
                                        <option value="pause" {{ request()->status == 'pause' ? 'selected' : '' }}>
                                            {{ __('pause') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-3  mb-3">
                                    <select name="country_id" class="form-select form-select-sm sonoo-search"
                                        id="autoSizingSelect">
                                        <option value="" selected>{{ __('All Countries') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
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
