@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('current account') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('cash_accounts.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_ar">{{ __('account name') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ old('name_ar') }}" type="text" autocomplete="on" id="name_ar" autofocus
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="name_en">{{ __('account name') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ old('name_en') }}" type="text" autocomplete="on" id="name_en" required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="code">{{ __('account code') }}</label>
                                <input name="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" type="text" autocomplete="on" id="code" required />
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="users">{{ __('users') }}</label>

                                <select class="form-select js-choice @error('users') is-invalid @enderror" aria-label=""
                                    multiple="multiple" name="users[]" id="users"
                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="branch_id">{{ __('select branch') }}</label>

                                <select class="form-select @error('branch_id') is-invalid @enderror" aria-label=""
                                    name="branch_id" id="branch_id">
                                    <option value="">
                                        {{ __('select branch') }}
                                    </option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">
                                            {{ getName($branch) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('account type') }}</label>

                                <select class="form-select @error('type') is-invalid @enderror" aria-label=""
                                    name="type" id="type">
                                    <option value="">
                                        {{ __('select account type') }}
                                    </option>
                                    <option value="cash_accounts">
                                        {{ __('cash account') }}
                                    </option>
                                    <option value="bank_accounts">
                                        {{ __('bank') }}
                                    </option>
                                    <option value="receipt_notes">
                                        {{ __('receipt notes') }}
                                    </option>
                                    <option value="payment_notes">
                                        {{ __('payment notes') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('current accountt') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
