@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit') . ' ' . __('current account') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('cash_accounts.update', ['cash_account' => $account->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ $account->name_ar }}" type="text" autocomplete="on" id="name_ar"
                                    autofocus required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('title') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ $account->name_en }}" type="text" autocomplete="on" id="name_en"
                                    autofocus required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="code">{{ __('account code') }}</label>
                                <input name="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ $account->code }}" type="text" autocomplete="on" id="code" required />
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
                                        <option value="{{ $user->id }}"
                                            {{ $account->users()->where('user_id', $user->id)->count() != 0? 'selected': '' }}>
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
                                        <option value="{{ $branch->id }}"
                                            {{ $branch->id == $account->branch_id ? 'selected' : '' }}>
                                            {{ getName($branch) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Edit') . ' ' . __('current account') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
