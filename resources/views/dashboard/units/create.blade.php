@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('unit') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('units.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ old('name_ar') }}" type="text" autocomplete="on" id="name_ar" autofocus
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('title') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ old('name_en') }}" type="text" autocomplete="on" id="name_en" required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="category_id">{{ __('unit category') }}</label>

                                <select class="form-select @error('category_id') is-invalid @enderror" aria-label=""
                                    name="category_id" id="category_id">
                                    <option value="">
                                        {{ __('select unit category') }}
                                    </option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ getName($category) }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('type') }}</label>

                                <select class="form-select @error('type') is-invalid @enderror" aria-label=""
                                    name="type" id="type">
                                    <option value="">
                                        {{ __('select unit type') }}
                                    </option>
                                    <option value="bigger">
                                        {{ __('Bigger than the default Unit of Measure') }}
                                    </option>
                                    <option value="smaller">
                                        {{ __('Smaller than the default Unit of Measure') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="ratio">{{ __('ratio') }}</label>
                                <input name="ratio" class="form-control  @error('ratio') is-invalid @enderror"
                                    value="0" type="number" min="0" step="0.01" autocomplete="on"
                                    id="ratio" />

                                @error('ratio')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('unit') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
