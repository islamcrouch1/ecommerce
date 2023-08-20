@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('employee data') . ' - ' . $user->name }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('employees.update', ['employee' => $employee->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')




                            <div class="mb-3">
                                <label class="form-label" for="address">{{ __('address') }}</label>
                                <input name="address" class="form-control @error('address') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->address : '' }}"
                                    type="text" autocomplete="on" id="address" />
                                @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="job_title">{{ __('job title') }}</label>
                                <input name="job_title" class="form-control @error('job_title') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->job_title : '' }}"
                                    type="text" autocomplete="on" id="job_title" />
                                @error('job_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="branch_id">{{ __('branch') }}</label>

                                <select class="form-select @error('branch_id') is-invalid @enderror" name="branch_id"
                                    id="branch_id">

                                    <option value="">{{ __('select branch') }}</option>

                                    @foreach (getbranches() as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ getEmployeeInfo($user) != null && getEmployeeInfo($user)->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ getName($branch) }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('branch_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="national_id">{{ __('national ID') }}</label>
                                <input name="national_id" class="form-control @error('national_id') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->national_id : '' }}"
                                    type="text" autocomplete="on" id="national_id" />
                                @error('national_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="basic_salary">{{ __('basic salary') }}</label>
                                <input name="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->basic_salary : '0' }}"
                                    type="number" min="0" step="0.01" autocomplete="on" id="basic_salary" />

                                @error('basic_salary')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="variable_salary">{{ __('variable salary') }}</label>
                                <input name="variable_salary" class="form-control @error('salary') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->variable_salary : '0' }}"
                                    type="number" min="0" step="0.01" autocomplete="on" id="variable_salary" />

                                @error('variable_salary')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="work_hours">{{ __('working hours') }}</label>
                                <input name="work_hours" class="form-control @error('work_hours') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->work_hours : '0' }}"
                                    type="number" min="0" step="0.01" autocomplete="on" id="work_hours" />

                                @error('work_hours')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="start_time">{{ __('start time') }}</label>
                                <div class="d-inline-block">
                                    <input type="time" id="start_time" name="start_time" class="form-control"
                                        value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->start_time : null }}">
                                </div>

                                @error('start_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <label class="form-label" for="Weekend_days">{{ __('Weekend days') }}</label>
                                <select class="form-select js-choice @error('Weekend_days') is-invalid @enderror"
                                    aria-label="" name="Weekend_days[]" multiple="multiple"
                                    data-options='{"removeItemButton":true,"placeholder":true}' id="Weekend_days">



                                    @if (getEmployeeInfo($user) != null &&
                                            getEmployeeInfo($user)->Weekend_days &&
                                            is_array(unserialize(getEmployeeInfo($user)->Weekend_days)))
                                        <option value="Mon"
                                            {{ in_array('Mon', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Mon') }}</option>
                                        <option value="Tue"
                                            {{ in_array('Tue', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Tue') }}</option>
                                        <option value="Wed"
                                            {{ in_array('Wed', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Wed') }}</option>
                                        <option value="Thu"
                                            {{ in_array('Thu', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Thu') }}</option>
                                        <option value="Fri"
                                            {{ in_array('Fri', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Fri') }}</option>
                                        <option value="Sat"
                                            {{ in_array('Sat', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Sat') }}</option>
                                        <option value="Sun"
                                            {{ in_array('Sun', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Sun') }}</option>
                                    @else
                                        <option value="Mon">{{ __('Mon') }}</option>
                                        <option value="Tue">{{ __('Tue') }}</option>
                                        <option value="Wed">{{ __('Wed') }}</option>
                                        <option value="Thu">{{ __('Thu') }}</option>
                                        <option value="Fri">{{ __('Fri') }}</option>
                                        <option value="Sat">{{ __('Sat') }}</option>
                                        <option value="Sun">{{ __('Sun') }}</option>
                                    @endif

                                </select>
                                @error('Weekend_days')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>





                            <div class="mb-3">
                                <label class="form-label" for="image">{{ __('employee docs') }}</label>
                                <input name="images[]" class="imgs form-control @error('image') is-invalid @enderror"
                                    type="file" accept="image/*" id="image" multiple />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <div class="col-md-12" id="gallery">


                                </div>

                                <div class="product-images row">

                                    @if (getEmployeeInfo($user))
                                        @foreach (getEmployeeInfo($user)->images as $image)
                                            <div style="width:150px; height:150px; border: 1px solid #999"
                                                class="hoverbox rounded-3 text-center m-1 product-image-{{ $image->media->id }}">
                                                <img class="img-fluid" src="{{ asset($image->media->path) }}"
                                                    alt="" />
                                                <div class="light hoverbox-content bg-dark p-5 flex-center">
                                                    <div>
                                                        <a class="btn btn-light btn-sm mt-1"href="{{ asset($image->media->path) }}"
                                                            target="_blank"
                                                            data-url="{{ route('employee.delete.media', ['image_id' => $image->id]) }}"
                                                            data-media_id="{{ $image->media->id }}">{{ __('show') }}</a>

                                                        @if (auth()->user()->hasPermission('employees-update'))
                                                            <a class="btn btn-light btn-sm mt-1 " href=""
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-modal-{{ $image->id }}">{{ __('Delete') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="delete-modal-{{ $image->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document"
                                                    style="max-width: 500px">
                                                    <div class="modal-content position-relative">
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                            <button
                                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-0">

                                                            <div class="p-4 pb-0">

                                                                <div style=" border: 1px solid #999"
                                                                    class="hoverbox rounded-3 text-center m-1">
                                                                    <img class="img-fluid"
                                                                        src="{{ asset($image->media->path) }}"
                                                                        alt="" />

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <a class="btn btn-primary delete-media"
                                                                data-url="{{ route('employee.delete.media', ['image_id' => $image->id]) }}"
                                                                data-media_id="{{ $image->media->id }}"
                                                                data-bs-dismiss="modal">{{ __('Delete') }}</a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif



                                </div>
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
