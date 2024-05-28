@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('running order') . ' - ' . getProductName($running_order->product, getCombination($running_order->product_combination_id)) . ' - ' . __($running_order->stock_status) }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('running_orders.update', ['running_order' => $running_order->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label"
                                    for="account">{{ __('requested quantity') . ': ' . $running_order->requested_qty . ' ' . getName(getUnitByID($running_order->unit_id)) }}
                                    <br>
                                    {{ __('approved quantity') . ': ' . $running_order->approved_qty . ' ' . getName(getUnitByID($running_order->unit_id)) }}
                                    <br>
                                    {{ __('returned quantity') . ': ' . $running_order->returned_qty . ' ' . getName(getUnitByID($running_order->unit_id)) }}
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="approved_qty">{{ __('Enter the quantity required for approval') }}</label>
                                <input name="approved_qty" class="form-control @error('approved_qty') is-invalid @enderror"
                                    value="{{ $running_order->requested_qty - $running_order->approved_qty - $running_order->returned_qty }}"
                                    min="0" type="number" autocomplete="on" id="approved_qty" autofocus required />
                                @error('approved_qty')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label" for="returned_qty">{{ __('returned quantity') }}</label>
                                <input name="returned_qty" class="form-control @error('returned_qty') is-invalid @enderror"
                                    value="{{ $running_order->returned_qty }}" min="0" type="number"
                                    autocomplete="on" id="returned_qty" autofocus required />
                                @error('returned_qty')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label" for="notes">{{ __('notes') }}</label>
                                <textarea name="notes" rows="5" class="form-control @error('notes') is-invalid @enderror" type="text"
                                    autocomplete="on" id="notes">{{ $running_order->notes }}</textarea>
                                @error('notes')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="mb-3 mt-5">
                                    <label class="form-label" for="serials">{{ __('Add product serials') }}</label><br>
                                    <button href="javascript:void(0);"
                                        class="btn btn-outline-primary btn-sm add_serial me-1 mb-1 mt-1"
                                        type="button">{{ __('add serial') }}
                                    </button>
                                    <div class="serial_wrapper">

                                    </div>

                                </div>
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('validate') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
