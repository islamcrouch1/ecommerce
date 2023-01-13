@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Add New Stock -
                        {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('vendor-products.color.store', ['product' => $product->id]) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name_ar">Color</label>
                                <select class=" form-control @error('color') is-invalid @enderror" id="color"
                                    name="color" value="{{ old('color') }}" required autocomplete="color">
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">
                                            {{ app()->getLocale() == 'ar' ? $color->color_ar : $color->color_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('color')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name_ar">Size</label>
                                <select class=" form-control @error('size') is-invalid @enderror" id="size"
                                    name="size" value="{{ old('size') }}" required autocomplete="size">
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">
                                            {{ app()->getLocale() == 'ar' ? $size->size_ar : $size->size_en }}</option>
                                    @endforeach
                                </select>
                                @error('size')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Add New
                                    Stock</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
