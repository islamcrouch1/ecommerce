@extends('layouts.ecommerce.app')
@section('content')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New Size') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="https://1c49-156-205-41-95.eu.ngrok.io/ecommerce/payment-callback"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="order_id">{{ __('size name - arabic') }}</label>
                                <input name="order_id" class="form-control @error('order_id') is-invalid @enderror"
                                    value="92427818" type="text" autocomplete="on" id="order_id" autofocus />
                                @error('order_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="size_en">{{ __('size name - english') }}</label>
                                <input name="size_en" class="form-control @error('size_en') is-invalid @enderror"
                                    value="{{ old('size_en') }}" type="text" autocomplete="on" id="size_en" />
                                @error('size_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New Size') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
