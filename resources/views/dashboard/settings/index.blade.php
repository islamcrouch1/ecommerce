@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Settings') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="mb-3">
                                <label class="form-label" for="tax">{{ __('Tax %') }}</label>
                                <input name="tax" class="form-control @error('tax') is-invalid @enderror"
                                    value="{{ setting('tax') }}" type="number" autocomplete="on" id="tax" autofocus
                                    required />
                                @error('tax')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="max_price">{{ __('Max Price %') }}</label>
                                <input name="max_price" class="form-control @error('max_price') is-invalid @enderror"
                                    value="{{ setting('max_price') }}" type="number" autocomplete="on" id="max_price"
                                    required />
                                @error('max_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="commission">{{ __('Suggested commission %') }}</label>
                                <input name="commission" class="form-control @error('commission') is-invalid @enderror"
                                    value="{{ setting('commission') }}" type="number" autocomplete="on" id="commission"
                                    required />
                                @error('commission')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="country_id">{{ __('default country') }}</label>

                                <select class="form-select @error('country_id') is-invalid @enderror" aria-label=""
                                    name="country_id" id="country_id" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ setting('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="shipping_method">{{ __('default shipping method') }}</label>

                                <select class="form-select @error('shipping_method') is-invalid @enderror" aria-label=""
                                    name="shipping_method" id="shipping_method" required>
                                    @foreach ($shipping_methods as $method)
                                        <option value="{{ $method->id }}"
                                            {{ setting('shipping_method') == $method->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shipping_method')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="locale_pickup">{{ __('localPickup activate') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="locale_pickup"
                                            class="form-control @error('locale_pickup') is-invalid @enderror"
                                            name="locale_pickup" type="checkbox"
                                            {{ setting('locale_pickup') == 'on' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('locale_pickup')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">

                                <label class="form-label" for="commission">{{ __('Website warehouse') }}</label>
                                <select class="form-select @error('warehouse_id') is-invalid @enderror" aria-label=""
                                    name="warehouse_id" id="warehouse_id">
                                    <option value="">
                                        {{ __('select warehouse') }}
                                    </option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}"
                                            {{ setting('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $warehouse->name_ar : $warehouse->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="compression_ratio">{{ __('Image Compression Ratio') }}</label>
                                <input name="compression_ratio"
                                    class="form-control @error('compression_ratio') is-invalid @enderror"
                                    value="{{ setting('compression_ratio') }}" type="number" autocomplete="on"
                                    id="compression_ratio" required />
                                @error('compression_ratio')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <label class="form-label"
                                    for="affiliate_limit">{{ __('Affiliate withdrawal limit') }}</label>
                                <input name="affiliate_limit"
                                    class="form-control @error('affiliate_limit') is-invalid @enderror"
                                    value="{{ setting('affiliate_limit') }}" type="number" autocomplete="on"
                                    id="affiliate_limit" required />
                                @error('affiliate_limit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="vendor_limit">{{ __('Vendor withdrawal limit') }}</label>
                                <input name="vendor_limit"
                                    class="form-control @error('vendor_limit') is-invalid @enderror"
                                    value="{{ setting('vendor_limit') }}" type="number" autocomplete="on"
                                    id="vendor_limit" required />
                                @error('vendor_limit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label"
                                    for="mandatory_affiliate">{{ __('Mandatory Period For Affiliate') . __(' - in minutes') }}</label>
                                <input name="mandatory_affiliate"
                                    class="form-control @error('mandatory_affiliate') is-invalid @enderror"
                                    value="{{ setting('mandatory_affiliate') }}" type="number" autocomplete="on"
                                    id="mandatory_affiliate" required />
                                @error('mandatory_affiliate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="mandatory_vendor">{{ __('Mandatory Period For Vendors') . __(' - in minutes') }}</label>
                                <input name="mandatory_vendor"
                                    class="form-control @error('mandatory_vendor') is-invalid @enderror"
                                    value="{{ setting('mandatory_vendor') }}" type="number" autocomplete="on"
                                    id="mandatory_vendor" required />
                                @error('mandatory_vendor')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="terms_ar">{{ __('Terms and conditions - arabic') }}</label>
                                <textarea name="terms_ar" class="form-control tinymce @error('terms_ar') is-invalid @enderror" autocomplete="on"
                                    id="terms_ar">{!! setting('terms_ar') !!}</textarea>
                                @error('terms_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="terms_en">{{ __('Terms and conditions - english') }}</label>
                                <textarea name="terms_en" class="form-control tinymce @error('terms_en') is-invalid @enderror" autocomplete="on"
                                    id="terms_en">{!! setting('terms_en') !!}</textarea>
                                @error('terms_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="front_modal">{{ __('Front popup') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="front_modal"
                                            class="form-control @error('front_modal') is-invalid @enderror"
                                            name="front_modal" type="checkbox"
                                            {{ setting('front_modal') == 'on' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('front_modal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="front_modal_title">{{ __('Front popup - title') }}</label>
                                <input name="front_modal_title"
                                    class="form-control @error('front_modal_title') is-invalid @enderror"
                                    value="{{ setting('front_modal_title') }}" type="text" autocomplete="on"
                                    id="front_modal_title" />
                                @error('front_modal_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="front_modal_body">{{ __('Front popup - body') }}</label>
                                <input name="front_modal_body"
                                    class="form-control @error('front_modal_body') is-invalid @enderror"
                                    value="{{ setting('front_modal_body') }}" type="text" autocomplete="on"
                                    id="front_modal_body" />
                                @error('front_modal_body')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="affiliate_modal">{{ __('Affiliate popup') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="affiliate_modal"
                                            class="form-control @error('affiliate_modal') is-invalid @enderror"
                                            name="affiliate_modal" type="checkbox"
                                            {{ setting('affiliate_modal') == 'on' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('affiliate_modal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="affiliate_modal_title">{{ __('Affiliate popup - title') }}</label>
                                <input name="affiliate_modal_title"
                                    class="form-control @error('affiliate_modal_title') is-invalid @enderror"
                                    value="{{ setting('affiliate_modal_title') }}" type="text" autocomplete="on"
                                    id="affiliate_modal_title" />
                                @error('affiliate_modal_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="affiliate_modal_body">{{ __('Affiliate popup - body') }}</label>
                                <input name="affiliate_modal_body"
                                    class="form-control @error('affiliate_modal_body') is-invalid @enderror"
                                    value="{{ setting('affiliate_modal_body') }}" type="text" autocomplete="on"
                                    id="affiliate_modal_body" />
                                @error('affiliate_modal_body')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="vendor_modal">{{ __('Vendor popup') }}</label>
                                <div>
                                    <label class="switch">
                                        <input id="vendor_modal"
                                            class="form-control @error('vendor_modal') is-invalid @enderror"
                                            name="vendor_modal" type="checkbox"
                                            {{ setting('vendor_modal') == 'on' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('vendor_modal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label"
                                    for="vendor_modal_title">{{ __('Vendor popup - title') }}</label>
                                <input name="vendor_modal_title"
                                    class="form-control @error('vendor_modal_title') is-invalid @enderror"
                                    value="{{ setting('vendor_modal_title') }}" type="text" autocomplete="on"
                                    id="vendor_modal_title" />
                                @error('vendor_modal_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="vendor_modal_body">{{ __('Vendor popup - body') }}</label>
                                <input name="vendor_modal_body"
                                    class="form-control @error('vendor_modal_body') is-invalid @enderror"
                                    value="{{ setting('vendor_modal_body') }}" type="text" autocomplete="on"
                                    id="vendor_modal_body" />
                                @error('vendor_modal_body')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label" for="image">Country flag</label>
                                <input name="image" class="img form-control @error('image') is-invalid @enderror"
                                    type="file" id="image" />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">

                                <div class="col-md-10">
                                    <img src="" style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                </div>

                            </div> --}}


                            @if (auth()->user()->hasPermission('settings-update'))
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">{{ __('Save') }}</button>
                                </div>
                            @endif
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
