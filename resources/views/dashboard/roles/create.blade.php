@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New role') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('roles.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">{{ __('role name') }}</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" type="text" autocomplete="on" id="name"
                                        autofocus required />
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="description">{{ __('role description') }}</label>
                                    <input name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        value="{{ old('description') }}" type="text" autocomplete="on" id="description"
                                        autofocus required />
                                    @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                @foreach ($data['models'] as $key => $model)
                                    <hr class="my-4">

                                    <div class="mb-3">
                                        <h5>{{ __($key) }}</h5>
                                    </div>

                                    @include('dashboard.roles._select_input', [
                                        'models' => $data['models'][$key],
                                        'permissions' => $data['permissions'],
                                    ])
                                @endforeach

                                <hr class="my-4">

                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New role') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
