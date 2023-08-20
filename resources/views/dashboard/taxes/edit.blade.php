@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit') . ' ' . __('tax') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('taxes.update', ['tax' => $tax->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('tax name') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ $tax->name_ar }}" type="text" autocomplete="on" id="name_ar" autofocus
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('tax name') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ $tax->name_en }}" type="text" autocomplete="on" id="name_en" autofocus
                                    required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="description">{{ __('description') }}</label>
                                <input name="description" class="form-control @error('description') is-invalid @enderror"
                                    value="{{ $tax->description }}" type="text" autocomplete="on" id="description"
                                    required />
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="tax_rate">{{ __('tax rate') . '%' }}</label>
                                <input name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror"
                                    value="{{ $tax->tax_rate }}" type="number" autocomplete="on" id="tax_rate"
                                    required />
                                @error('tax_rate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('tax type') }}</label>

                                <select class="form-select @error('type') is-invalid @enderror" aria-label=""
                                    name="type" id="type" required>

                                    <option value="plus" {{ $tax->type == 'plus' ? 'selected' : '' }}>
                                        {{ __('plus') }}
                                    </option>

                                    <option value="minus" {{ $tax->type == 'minus' ? 'selected' : '' }}>
                                        {{ __('minus') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="status">{{ __('status') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="status" class="form-control @error('status') is-invalid @enderror"
                                            name="status" type="checkbox" {{ $tax->status == 'active' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Edit') . ' ' . __('tax') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
