@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('edit') . ' ' . __('permit') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('permissions.update', ['permission' => $permission->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('permission type') }}</label>

                                <select class="form-select @error('type') is-invalid @enderror" aria-label=""
                                    name="type" id="type" required>
                                    <option value="">
                                        {{ __('select type') }}
                                    </option>
                                    <option value="vacation" {{ $permission->type == 'vacation' ? 'selected' : '' }}>
                                        {{ __('vacation') }}
                                    </option>
                                    <option value="early_leave" {{ $permission->type == 'early_leave' ? 'selected' : '' }}>
                                        {{ __('early leave') }}
                                    </option>
                                    <option value="late_attendance"
                                        {{ $permission->type == 'late_attendance' ? 'selected' : '' }}>
                                        {{ __('late attendance') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="date">{{ __('permission date') }}</label>
                                <input type="datetime-local" id="date" name="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ $permission->date }}" required>
                                @error('date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="reason">{{ __('permission reason') }}</label>
                                <input name="reason" class="form-control @error('reason') is-invalid @enderror"
                                    value="{{ $permission->reason }}" type="text" autocomplete="on" id="reason"
                                    required />
                                @error('reason')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="media">{{ __('image') }}</label>
                                <input name="media" class="img form-control @error('media') is-invalid @enderror"
                                    type="file" id="media" />
                                @error('media')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            @if ($permission->media_id != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <img src="{{ asset($permission->media->path) }}"
                                            style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                    </div>
                                </div>
                            @endif


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('edit') . ' ' . __('permit') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
