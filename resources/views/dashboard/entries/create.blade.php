@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('entry') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">

                {{-- @if ($check == true)
                    <div class="row m-2">
                        <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                            <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                            </div>
                            <p class="mb-0 flex-1">
                                {{ __('Please note that there are unequal entries, please settle them to adjust the accounting process') }}
                            </p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <a href="{{ route('entries.settle.create') }}" class="btn btn-falcon-danger me-1 mb-1"
                            type="button">{{ __('settle entry') }}
                        </a>
                    </div>
                @endif --}}
                <div class="col-md-12 d-flex flex-center">

                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('entries.store') }}" enctype="multipart/form-data">
                            @csrf


                            <div style="display:none" class="div-data" data-accounts="{{ $accounts }}"
                                data-url="{{ route('entries.accounts') }}" data-locale="{{ app()->getLocale() }}"></div>



                            <div class="mb-3 mt-5">
                                <label class="form-label"
                                    for="flash_news_ar">{{ __('please add entry accounts') }}</label><br>
                                <button href="javascript:void(0);"
                                    class="btn btn-outline-primary btn-sm add_account me-1 mb-1 mt-1"
                                    type="button">{{ __('add account') }}
                                </button>
                                <div class="field_wrapper">

                                </div>

                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="description">{{ __('entry description') }}</label>
                                <input name="description" class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}" type="text" autocomplete="on" id="description"
                                    required />
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('entry') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
