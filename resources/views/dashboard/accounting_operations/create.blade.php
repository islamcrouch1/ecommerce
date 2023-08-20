@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('accounting operation') }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('accounting_operations.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_ar">{{ __('operation name') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ old('name_ar') }}" type="text" autocomplete="on" id="name_ar" autofocus
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_en">{{ __('operation name') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ old('name_en') }}" type="text" autocomplete="on" id="name_en" required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="code">{{ __('select account') }}</label>
                                <select class="form-select model-search" data-url="{{ route('model.search') }}"
                                    data-locale="{{ app()->getLocale() }}" multiple data-parent="" data-type="acc-accounts"
                                    name="accounts[]" required>
                                    <option value="">
                                        {{ __('select account') }}</option>

                                </select>
                            </div>


                            {{-- <div class="mb-3 col-md-3">
                                <label class="form-label" for="cash">{{ __('cash') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="cash" class="form-control @error('cash') is-invalid @enderror"
                                            name="cash" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    @error('cash')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="bank">{{ __('bank transfer') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="bank" class="form-control @error('bank') is-invalid @enderror"
                                            name="bank" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    @error('bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="check">{{ __('check') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="check" class="form-control @error('check') is-invalid @enderror"
                                            name="check" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    @error('check')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}


                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="status">{{ __('operation status') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="status" class="form-control @error('status') is-invalid @enderror"
                                            name="status" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('accounting operation') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
