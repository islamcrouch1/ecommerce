@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        @if ($attendance->attendance_date != null)
                            {{ __('attendance record') }}
                        @else
                            {{ __('leave record') }}
                        @endif
                        {{ ' - ' . $user->name }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('attendances.update', ['attendance' => $attendance->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')



                            <div class="mb-3">
                                <label class="form-label" for="date">{{ __('edit time') }}</label>

                                <input type="datetime-local" id="date" name="date"
                                    class="form-control @error('date') is-invalid @enderror" step="1"
                                    value="{{ $attendance->attendance_date ? $attendance->attendance_date : $attendance->leave_date }}"
                                    required>

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
