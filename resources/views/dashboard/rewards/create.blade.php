@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('Rewards and penalties') }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('rewards.store') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="mb-3">
                                <label class="form-label" for="user_id">{{ __('employee') }}</label>
                                <select class="form-select model-search" data-url="{{ route('model.search') }}"
                                    data-locale="{{ app()->getLocale() }}" data-parent="" data-type="admins" name="user_id">
                                    <option value="">
                                        {{ __('employees search') }}</option>

                                </select>
                                @error('user_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('type') }}</label>
                                <select class="form-select offer-type @error('type') is-invalid @enderror" aria-label=""
                                    name="type" id="type" required>
                                    <option value="">
                                        {{ __('Select the type') }}
                                    </option>
                                    <option value="reward">
                                        {{ __('reward') }}
                                    </option>
                                    <option value="penalty">
                                        {{ __('penalty') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="amount">{{ __('amount') }}</label>
                                <input name="amount" class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" type="number" step="0.01" min="0"
                                    autocomplete="on" id="amount" required />
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="note">{{ __('note') }}</label>
                                <textarea name="note" rows="5" class="form-control @error('note') is-invalid @enderror" type="text"
                                    autocomplete="on" id="note" required>{{ old('note') }}</textarea>
                                @error('note')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('save') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
