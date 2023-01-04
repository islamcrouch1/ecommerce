@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add Product Stock') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('products.stock.store', ['product' => $product->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            @if ($product->product_type == 'variable')
                                <div class="mb-3">
                                    <div class="table-responsive scrollbar">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('variant product') }}</th>
                                                    <th scope="col">{{ __('warehouse') }}</th>
                                                    <th scope="col">{{ __('SKU') }}</th>
                                                    <th scope="col">{{ __('stock status') }}</th>
                                                    <th scope="col">{{ __('Quantity') }}</th>
                                                    <th scope="col">{{ __('Purchase price') }}</th>
                                                    <th scope="col">{{ __('sale price') }}</th>
                                                    <th scope="col">{{ __('discount price') }}</th>
                                                    <th scope="col">{{ __('stock limit') }}</th>
                                                    <th scope="col">{{ __('variation image') }}</th>
                                                    {{-- <th class="text-end" scope="col">{{ __('Actions') }}</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                            {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                            {{ '( ' }}
                                                            @foreach ($combination->variations as $variation)
                                                                {{ app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en }}
                                                                {{ '-' }}
                                                            @endforeach
                                                            {{ ' )' }}
                                                        </td>

                                                        <td>
                                                            <select
                                                                class="form-select @error('warehouse_id') is-invalid @enderror"
                                                                aria-label="" name="warehouse_id[]" id="warehouse_id">
                                                                @foreach ($warehouses as $warehouse)
                                                                    <option value="">
                                                                        {{ __('select warehouse') }}
                                                                    </option>
                                                                    <option value="{{ $warehouse->id }}">
                                                                        {{ app()->getLocale() == 'ar' ? $warehouse->name_ar : $warehouse->name_en }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('warehouse_id')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
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
                                                            <select
                                                                class="form-select @error('stock_status') is-invalid @enderror"
                                                                aria-label="" name="stock_status[]" id="stock_status"
                                                                required>
                                                                <option value="IN">
                                                                    {{ __('IN') }}
                                                                </option>
                                                                <option value="OUT">
                                                                    {{ __('OUT') }}
                                                                </option>
                                                            </select>
                                                            @error('stock_status')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>



                                                        <td>
                                                            <input name="qty[]"
                                                                class="form-control @error('qty') is-invalid @enderror"
                                                                min="0" value="0" type="number"
                                                                autocomplete="on" id="qty" required />
                                                            @error('qty')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>

                                                        <td>
                                                            <input name="purchase_price[]"
                                                                class="form-control @error('purchase_price') is-invalid @enderror"
                                                                min="0" value="0" type="number"
                                                                autocomplete="on" id="purchase_price" required />
                                                            @error('purchase_price')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>

                                                        <td>
                                                            <input name="sale_price[]"
                                                                class="form-control @error('sale_price') is-invalid @enderror"
                                                                min="0" value="{{ $combination->sale_price }}"
                                                                type="number" autocomplete="on" id="sale_price" required />
                                                            @error('sale_price')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>

                                                        <td>
                                                            <input name="discount_price[]"
                                                                class="form-control @error('discount_price') is-invalid @enderror"
                                                                min="0" max="{{ $combination->sale_price - 1 }}"
                                                                value="{{ $combination->discount_price }}" type="number"
                                                                autocomplete="on" id="discount_price" required />
                                                            @error('discount_price')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input name="limit[]"
                                                                class="form-control @error('limit') is-invalid @enderror"
                                                                min="0" value="{{ $combination->limit }}"
                                                                type="number" autocomplete="on" id="limit" required />
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
                                                        {{-- <td class="text-end">
                                                        <div>
                                                            <a href="#" class="btn p-0 ms-2" type="button"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Delete"><span
                                                                    class="text-500 fas fa-trash-alt"></span></a>
                                                        </div>
                                                    </td> --}}
                                                    </tr>
                                                @endforeach
                                                {{-- <tr>
                                                <td>
                                                    <a href="{{ route('products.color.create', ['product' => $product->id]) }}"
                                                        class="btn btn-falcon-primary me-1 mb-1">{{ __('Add new color & size') }}
                                                    </a>
                                                </td>
                                            </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @elseif($product->product_type == 'simple')
                                <div class="mb-3">
                                    <div class="table-responsive scrollbar">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('product') }}</th>
                                                    <th scope="col">{{ __('warehouse') }}</th>
                                                    <th scope="col">{{ __('stock status') }}</th>
                                                    <th scope="col">{{ __('Quantity') }}</th>
                                                    <th scope="col">{{ __('Purchase price') }}</th>
                                                    <th scope="col">{{ __('stock limit') }}</th>
                                                    {{-- <th class="text-end" scope="col">{{ __('Actions') }}</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                    </td>

                                                    <td>
                                                        <select
                                                            class="form-select @error('warehouse_id') is-invalid @enderror"
                                                            aria-label="" name="warehouse_id" id="warehouse_id"
                                                            required>
                                                            @foreach ($warehouses as $warehouse)
                                                                <option value="">
                                                                    {{ __('select warehouse') }}
                                                                </option>
                                                                <option value="{{ $warehouse->id }}">
                                                                    {{ app()->getLocale() == 'ar' ? $warehouse->name_ar : $warehouse->name_en }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('warehouse_id')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>


                                                    <td>
                                                        <select
                                                            class="form-select @error('stock_status') is-invalid @enderror"
                                                            aria-label="" name="stock_status" id="stock_status"
                                                            required>
                                                            <option value="IN">
                                                                {{ __('IN') }}
                                                            </option>
                                                            <option value="OUT">
                                                                {{ __('OUT') }}
                                                            </option>
                                                        </select>
                                                        @error('stock_status')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>



                                                    <td>
                                                        <input name="qty"
                                                            class="form-control @error('qty') is-invalid @enderror"
                                                            min="0" value="0" type="number"
                                                            autocomplete="on" id="qty" required />
                                                        @error('qty')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>

                                                    <td>
                                                        <input name="purchase_price"
                                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                                            min="0" value="0" type="number"
                                                            autocomplete="on" id="purchase_price" required />
                                                        @error('purchase_price')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>


                                                    <td>
                                                        <input name="limit"
                                                            class="form-control @error('limit') is-invalid @enderror"
                                                            min="0" value="0" type="number"
                                                            autocomplete="on" id="limit" required />
                                                        @error('limit')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>



                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif




                            {{-- <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('Colors Images') }}</label>
                            </div> --}}

                            {{-- @foreach ($product->stocks as $stock)
                                @php
                                    $stocks = $product->stocks->unique('color_id');
                                @endphp
                            @endforeach

                            @foreach ($stocks as $stock)
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="image">{{ app()->getLocale() == 'ar' ? $stock->color->color_ar : $stock->color->color_en }}
                                        {{ 'Image' }}</label>
                                    <input name="image[{{ $stock->id }}][]"
                                        class="img form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" />
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($stock->image != null)
                                    <div class="mb-3">
                                        <div class="col-md-10">
                                            <img src="{{ asset('storage/images/products/' . $stock->image) }}"
                                                style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                        </div>
                                    </div>
                                @endif
                            @endforeach --}}
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
