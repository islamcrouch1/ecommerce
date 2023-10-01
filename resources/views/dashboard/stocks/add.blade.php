@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add Stock') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('products.stock.add') }}" enctype="multipart/form-data">
                            @csrf



                            <div class="mb-3">
                                <label class="form-label" for="product">{{ __('Select product') }}</label>

                                <select data-url="{{ route('products.search') }}" data-locale="{{ app()->getLocale() }}"
                                    class="form-select product-select @error('product') is-invalid @enderror" aria-label=""
                                    name="product" id="product"
                                    data-options='{"removeItemButton":true,"placeholder":true ,addItems: true}' required>

                                </select>
                                @error('product')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add Stock') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
