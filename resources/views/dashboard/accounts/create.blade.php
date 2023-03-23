@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('account') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('accounts.store') }}" enctype="multipart/form-data">
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
                                <label class="form-label" for="branches">{{ __('branches') }}</label>

                                <select class="form-select js-choice @error('branches') is-invalid @enderror" aria-label=""
                                    multiple="multiple" name="branches[]" id="branches"
                                    data-options='{"removeItemButton":true,"placeholder":true}' required>

                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">
                                            {{ getName($branch) }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('branches')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="account_type">{{ __('account type') }}</label>

                                <select class="form-select @error('account_type') is-invalid @enderror" aria-label=""
                                    name="account_type" id="account_type" required>
                                    @if (isset(request()->parent_id))
                                        <option value="assets"
                                            {{ getAccount(request()->parent_id)->account_type == 'assets' ? 'selected' : '' }}>
                                            {{ __('assets') }}</option>
                                        <option value="expenses"
                                            {{ getAccount(request()->parent_id)->account_type == 'expenses' ? 'selected' : '' }}>
                                            {{ __('expenses') }}</option>
                                        <option value="liability"
                                            {{ getAccount(request()->parent_id)->account_type == 'liability' ? 'selected' : '' }}>
                                            {{ __('liability') }}</option>
                                        <option value="revenue"
                                            {{ getAccount(request()->parent_id)->account_type == 'revenue' ? 'selected' : '' }}>
                                            {{ __('revenue') }}</option>
                                    @else
                                        <option value="assets">
                                            {{ __('assets') }}</option>
                                        <option value="expenses">
                                            {{ __('expenses') }}</option>
                                        <option value="liability">
                                            {{ __('liability') }}</option>
                                        <option value="revenue">
                                            {{ __('revenue') }}</option>
                                    @endif

                                </select>
                                @error('account_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="parent_id">{{ __('parent account') }}</label>

                                <select class="form-select @error('parent_id') is-invalid @enderror" aria-label=""
                                    name="parent_id" id="parent_id">
                                    <option value="">
                                        {{ __('Main account') }}</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ request()->parent_id == $account->id ? 'selected' : '' }}>
                                            {{ getName($account) }}
                                        </option>

                                        @if ($account->accounts->count() > 0)
                                            @foreach ($account->accounts as $subAccount)
                                                @include('dashboard.accounts._account_options', [
                                                    'account' => $subAccount,
                                                ])
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- <div class="mb-3">
                                <label class="form-label" for="status">{{ __('status') }}</label>
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
                            </div> --}}



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('account') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
