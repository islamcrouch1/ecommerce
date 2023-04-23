@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
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

                    <div id="table-customers-replace-element">

                        <form style="display: inline-block" action="">
                            <div class="d-inline-block">
                                <select name="category_id" class="form-select form-select-sm sonoo-search"
                                    id="autoSizingSelect">
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
                            <div class="d-inline-block">
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




                        </form>

                        {{-- <form style="display: inline-block" action="{{ route('vendor-products.import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input class="form-control form-control-sm sonoo-search" type="file" name="file"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                data-buttonText="{{ __('Import') }}" required />


                        </form> --}}

                        <a href="{{ route('vendor-products.create') }}" class="btn btn-falcon-default btn-sm"
                            type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">{{ __('New') }}</span></a>

                        {{-- <a href="{{ route('vendor-products.export', ['status' => request()->status, 'category_id' => request()->category_id]) }}"
                            class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                                data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">Export</span></a> --}}
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
                                    {{ __('platform commission') }}
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
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($products as $product)
                                <tr class="btn-reveal-trigger">
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <div class="d-flex d-flex align-items-center">
                                            <div class="avatar avatar-xl me-2">
                                                <img class="rounded-circle"
                                                    src="{{ asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path) }}"
                                                    alt="" />
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="mb-0 fs--1">
                                                    {{ $product->images->count() }}
                                                    {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                </h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $product->sku . ' - ' . $product->id }}</td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $product->sale_price . ' ' . $product->country->currency }}</td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $product->discount_price . ' ' . $product->country->currency }}</td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $product->category->vendor_profit . ' %' }}</td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ __($product->product_type) }}</td>
                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ productQuantity($product->id) }}
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
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">
                                                    @if ($product->status != 'active')
                                                        <a class="dropdown-item"
                                                            href="{{ route('vendor-products.edit', ['vendor_product' => $product->id]) }}">{{ __('Edit') }}</a>


                                                        <form method="POST"
                                                            action="{{ route('vendor-products.destroy', ['vendor_product' => $product->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                type="submit">{{ $product->trashed() ? __('Delete') : __('Trash') }}</button>
                                                        </form>
                                                    @endif
                                                    <a class="dropdown-item"
                                                        href="{{ route('vendor-products.stock.create', ['product' => $product->id]) }}">{{ __('Edit Stock') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
@endsection
