@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Stocks Limits') }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($stocks->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Product Name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('SKU - ID') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Color') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Size') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('Quantity') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('quantity limit') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>

                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($stocks as $stock)
                                @if ($stock->product != null)
                                    <tr class="btn-reveal-trigger">

                                        <td class="name align-middle white-space-nowrap py-2">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/products/' . ($stock->product->images->count() == 0 ? 'place-holder.png' : $stock->product->images[0]->image)) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">
                                                        {{ $stock->product->images->count() }}
                                                        {{ app()->getLocale() == 'ar' ? $stock->product->name_ar : $stock->product->name_en }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $stock->product->sku . ' - ' . $stock->product->id }}</td>


                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ app()->getLocale() == 'ar' ? $stock->color->color_ar : $stock->color->color_en }}
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ app()->getLocale() == 'ar' ? $stock->size->size_ar : $stock->size->size_en }}
                                        </td>

                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $stock->quantity }}
                                        </td>
                                        <td class="phone align-middle white-space-nowrap py-2">
                                            {{ $stock->limit }}
                                        </td>

                                        <td class="joined align-middle py-2">{{ $stock->created_at }} <br>
                                            {{ interval($stock->created_at) }} </td>


                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $stocks->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
