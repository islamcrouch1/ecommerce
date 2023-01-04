@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Add Product Stock</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('vendor-products.stock.store', ['product' => $product->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="vendor_id">Add Product Stock</label>

                                <div class="table-responsive scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Color</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Quantity</th>
                                                <th class="text-end" scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->stocks as $stock)
                                                <tr>
                                                    <td>{{ app()->getLocale() == 'ar' ? $stock->color->color_ar : $stock->color->color_en }}
                                                    </td>
                                                    <td>{{ app()->getLocale() == 'ar' ? $stock->size->size_ar : $stock->size->size_en }}
                                                    </td>
                                                    <td>
                                                        <input name="stock[]"
                                                            class="form-control @error('stock') is-invalid @enderror"
                                                            min="0" value="{{ $stock->quantity }}" type="number"
                                                            autocomplete="on" id="stock" required />
                                                        @error('stock')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="text-end">
                                                        <div>
                                                            <a href="{{ route('vendor-products.color.destroy', ['stock' => $stock->id]) }}"
                                                                class="btn p-0 ms-2" type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Delete"><span
                                                                    class="text-500 fas fa-trash-alt"></span></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <a href="{{ route('vendor-products.color.create', ['product' => $product->id]) }}"
                                                        class="btn btn-falcon-primary me-1 mb-1">Add new color & size
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="name_ar">Colors Images</label>
                            </div>

                            @foreach ($product->stocks as $stock)
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
                            @endforeach
                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
