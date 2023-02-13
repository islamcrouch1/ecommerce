@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('entry') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('entries.store') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="from-account">
                                <div class="mb-3">
                                    <label class="form-label" for="from_account">{{ __('From Account') }}</label>

                                    <select
                                        class="form-select from-account-select @error('from_account') is-invalid @enderror"
                                        aria-label="" name="from_account" id="from_account"
                                        data-url="{{ route('entries.accounts') }}" data-level="1"
                                        data-locale="{{ app()->getLocale() }}" required>
                                        <option value="">{{ __('select account') }}</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ getName($account) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('from_account')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="to-account">
                                <div class="mb-3">
                                    <label class="form-label" for="to_account">{{ __('To Account') }}</label>

                                    <select class="form-select to-account-select @error('to_account') is-invalid @enderror"
                                        aria-label="" name="to_account" id="to_account"
                                        data-url="{{ route('entries.accounts') }}" data-level="1"
                                        data-locale="{{ app()->getLocale() }}" required>
                                        <option value="">{{ __('select account') }}</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ getName($account) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('to_account')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="amount">{{ __('entry amount') }}</label>
                                <input name="amount" class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" type="number" autocomplete="on" id="amount" required />
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">{{ __('entry description') }}</label>
                                <input name="description" class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}" type="text" autocomplete="on" id="description"
                                    required />
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>









                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('entry') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
