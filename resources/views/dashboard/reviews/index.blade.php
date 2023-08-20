@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('add') . ' ' . __('review') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
                            @csrf



                            <div class="mb-3">
                                <label class="form-label" for="review">{{ __('review') }}</label>
                                <input name="review" class="form-control @error('review') is-invalid @enderror"
                                    value="{{ old('review') }}" type="text" autocomplete="on" id="review" autofocus
                                    required />
                                @error('review')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="rating">{{ __('rating stars') }}</label>
                                <input name="rating" class="form-control @error('rating') is-invalid @enderror"
                                    value="{{ old('rating') }}" type="number" min="0" max="5" step='0.1'
                                    autocomplete="on" id="rating" autofocus required />
                                @error('rating')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 p-variation product-variations-">
                                <label class="form-label" for="products">{{ __('products') }}</label>
                                <select class="form-select model-search @error('products') is-invalid @enderror"
                                    data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                    data-parent="" data-type="products" name="products[]" multiple="multiple"
                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">
                                        {{ __('select products') }}</option>

                                </select>
                                @error('products')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 p-variation product-variations-">
                                <label class="form-label" for="categories">{{ __('categories') }}</label>
                                <select class="form-select model-search @error('categories') is-invalid @enderror"
                                    data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                    data-parent="" data-type="categories" name="categories[]" multiple="multiple"
                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">
                                        {{ __('select categories') }}</option>

                                </select>
                                @error('categories')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>





                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('add') . ' ' . __('review') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('delete') . ' ' . __('reviews') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">



            <div class="row g-0 h-100">

                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('reviews.delete') }}" enctype="multipart/form-data">
                            @csrf



                            <div class="mb-3">
                                <label class="form-label" for="review">{{ __('Enter the review to be deleted') }}</label>
                                <input name="review" class="form-control @error('review') is-invalid @enderror"
                                    value="{{ old('review') }}" type="text" autocomplete="on" id="review" autofocus
                                    required />
                                @error('review')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                @if (auth()->user()->hasPermission('reviews-delete') ||
                                        auth()->user()->hasPermission('reviews-trash'))
                                    <button class="btn btn-danger d-block w-100 mt-3" type="submit"
                                        name="submit">{{ __('delete all admin reviews') }}</button>
                                @endif

                            </div>
                        </form>

                    </div>
                </div>




            </div>

        </div>
    </div>
@endsection
