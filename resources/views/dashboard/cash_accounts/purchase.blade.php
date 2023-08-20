@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Purchase Asset') . ' - ' . getName($account) }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('assets.purchase', ['account' => $account->id]) }}"
                            enctype="multipart/form-data">
                            @csrf



                            <div style="display:none" class="div-data" data-url="{{ route('entries.accounts') }}"
                                data-locale="{{ app()->getLocale() }}"></div>

                            <div class="mb-3">
                                <label class="form-label" for="price">{{ __('Enter purchase price') }}</label>
                                <input name="price" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" min="1" step="0.01" type="number"
                                    autocomplete="on" id="price" autofocus required />
                                @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <label class="form-label" for="account">{{ __('select cash or bank account') }}</label>
                                <div class="field_wrapper">

                                    <select class="form-select from-account-select" aria-label="" name="accounts[]"
                                        required>
                                        <option value="">
                                            {{ __('select account') }}</option>
                                        @foreach ($assets_accounts as $acc)
                                            <option value="{{ $acc->id }}">
                                                {{ getName($acc) }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @error('bonus')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Purchase') . ' ' . __('asset') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
