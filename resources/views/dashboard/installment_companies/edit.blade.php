@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('edit') . ' ' . __('installment company') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST"
                            action="{{ route('installment_companies.update', ['installment_company' => $installment_company->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ $installment_company->name_ar }}" type="text" autocomplete="on"
                                    id="name_ar" autofocus required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('title') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ $installment_company->name_en }}" type="text" autocomplete="on"
                                    id="name_en" autofocus required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="admin_expenses">{{ __('admin expenses') }}</label>
                                <input name="admin_expenses"
                                    class="form-control @error('admin_expenses') is-invalid @enderror"
                                    value="{{ $installment_company->admin_expenses }}" min="1" step="0.01"
                                    type="number" autocomplete="on" id="admin_expenses" required />
                                @error('admin_expenses')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="type">{{ __('admin expenses type') }}</label>

                                <select class="form-select country-select @error('type') is-invalid @enderror"
                                    aria-label="" name="type" id="type" required>
                                    <option value="percentage"
                                        {{ $installment_company->type == 'percentage' ? 'selected' : '' }}>
                                        {{ __('percentage') }}
                                    </option>
                                    <option value="amount" {{ $installment_company->type == 'amount' ? 'selected' : '' }}>
                                        {{ __('amount') }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="amount">{{ __('monthly interest') }}</label>
                                <input name="amount" class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ $installment_company->amount }}" min="1" step="0.01" type="number"
                                    autocomplete="on" id="amount" required />
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <label class="form-label" for="months">{{ __('installment period') }}</label>

                                <select class="form-select js-choice @error('months') is-invalid @enderror" aria-label=""
                                    name="months[]" multiple="multiple" id="months" required>




                                    <option value="4"
                                        {{ in_array('4', unserialize($installment_company->months)) ? 'selected' : '' }}>4
                                    </option>
                                    <option value="6"
                                        {{ in_array('6', unserialize($installment_company->months)) ? 'selected' : '' }}>6
                                    </option>
                                    <option value="8"
                                        {{ in_array('8', unserialize($installment_company->months)) ? 'selected' : '' }}>8
                                    </option>
                                    <option value="10"
                                        {{ in_array('10', unserialize($installment_company->months)) ? 'selected' : '' }}>
                                        10</option>
                                    <option value="12"
                                        {{ in_array('12', unserialize($installment_company->months)) ? 'selected' : '' }}>
                                        12</option>
                                    <option value="15"
                                        {{ in_array('15', unserialize($installment_company->months)) ? 'selected' : '' }}>
                                        15</option>
                                    <option value="18"
                                        {{ in_array('18', unserialize($installment_company->months)) ? 'selected' : '' }}>
                                        18</option>
                                    <option value="24"
                                        {{ in_array('24', unserialize($installment_company->months)) ? 'selected' : '' }}>
                                        24</option>
                                    <option value="30"
                                        {{ in_array('30', unserialize($installment_company->months)) ? 'selected' : '' }}>
                                        30</option>
                                    <option value="36"
                                        {{ in_array('36', unserialize($installment_company->months)) ? 'selected' : '' }}>
                                        36</option>
                                </select>
                                @error('months')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <label class="form-label" for="image">{{ __('image') }}</label>
                                <input name="image" class="img form-control @error('image') is-invalid @enderror"
                                    type="file" id="image" />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">

                                <div class="col-md-10">
                                    <img src="{{ asset($installment_company->media->path) }}"
                                        style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                </div>

                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('edit') . ' ' . __('installment company') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
