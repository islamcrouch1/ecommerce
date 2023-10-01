@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('create record') }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('attendances.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="employee">{{ __('select employee') }}</label>
                                <select
                                    class="form-select employee-field model-search @error('employee') is-invalid @enderror"
                                    data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                    data-user_type="employees" data-type="admins" name="employee">
                                    <option value="">
                                        {{ __('select employee') }}</option>

                                </select>
                                @error('employee')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('type') }}</label>
                                <select class="form-select @error('type') is-invalid @enderror" name="type">
                                    <option value="attendance" {{ old('type' == 'attendance' ? 'selected' : '') }}>
                                        {{ __('attendance') }}</option>
                                    <option value="leave" {{ old('type' == 'leave' ? 'selected' : '') }}>
                                        {{ __('leave') }}</option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="date">{{ __('date & time') }}</label>
                                <input type="datetime-local" id="date" name="date"
                                    class="form-control @error('date') is-invalid @enderror" step="1"
                                    value="{{ old('date') }}" required>

                                @error('date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Save') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
