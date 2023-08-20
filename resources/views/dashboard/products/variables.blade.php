@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit product variables') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('products.variables.store', ['product' => $product->id]) }}"
                            enctype="multipart/form-data">
                            @csrf




                            <div class="mb-3">
                                <div class="table-responsive scrollbar">
                                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('product') }}</th>
                                                <th scope="col">{{ __('SKU') }}</th>
                                                <th scope="col">{{ __('sale price') }}</th>
                                                <th scope="col">{{ __('discount price') }}</th>
                                                <th scope="col">{{ __('stock limit') }}</th>
                                                <th scope="col">{{ __('images') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('adjust all') }}</td>
                                                <td>-</td>
                                                <td>
                                                    <input class="form-control stock-sale_price" min="0"
                                                        step="0.01" value="0" type="number" />
                                                </td>
                                                <td>
                                                    <input class="form-control stock-discount_price" min="0"
                                                        step="0.01" value="0" type="number" />
                                                </td>
                                                <td>
                                                    <input class="form-control stock-limit" min="0" value="0"
                                                        type="number" />
                                                </td>
                                                <td>-</td>

                                            </tr>

                                            @foreach ($product->combinations as $combination)
                                                <tr>
                                                    <td>
                                                        @if ($combination->media != null)
                                                            <div class="avatar avatar-xl me-2">
                                                                <img class="rounded-circle"
                                                                    src="{{ asset($combination->media->path) }}"
                                                                    alt="" />
                                                            </div>
                                                        @endif
                                                        {{ getProductName($product, $combination) }}
                                                    </td>
                                                    <td>
                                                        <input name="sku[]"
                                                            class="form-control @error('sku') is-invalid @enderror"
                                                            value="{{ $combination->sku }}" type="text"
                                                            autocomplete="on" id="sku" required />
                                                        @error('sku')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>

                                                    <td>
                                                        <input name="sale_price[]"
                                                            class="form-control sale_price sale_price-{{ $combination->id }} @error('sale_price') is-invalid @enderror"
                                                            min="0" step="0.01"
                                                            value="{{ $combination->sale_price }}" type="number"
                                                            autocomplete="on" id="sale_price" required />
                                                        @error('sale_price')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>

                                                    <td>
                                                        <input name="discount_price[]"
                                                            class="form-control discount_price discount_price-{{ $combination->id }} @error('discount_price') is-invalid @enderror"
                                                            min="0" step="0.01"
                                                            value="{{ $combination->discount_price }}" type="number"
                                                            autocomplete="on" id="discount_price" required />
                                                        @error('discount_price')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>



                                                    <td>
                                                        <input name="limit[]"
                                                            class="form-control limit @error('limit') is-invalid @enderror"
                                                            min="0" value="{{ $combination->limit }}" type="number"
                                                            autocomplete="on" id="limit" required />
                                                        @error('limit')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>



                                                    <td>
                                                        <input name="images[{{ $combination->id }}][]"
                                                            class="img form-control @error('image') is-invalid @enderror"
                                                            type="file" id="image" />
                                                        @error('image')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Save') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
