@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('website setting') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('website-setting.store') }}" enctype="multipart/form-data">
                            @csrf


                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        href="#tab-home" role="tab" aria-controls="tab-home"
                                        aria-selected="true">{{ __('header setting') }}</a></li>
                                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        href="#tab-profile" role="tab" aria-controls="tab-profile"
                                        aria-selected="false">{{ __('website colors') }}</a></li>
                                <li class="nav-item"><a class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        href="#tab-contact" role="tab" aria-controls="tab-contact"
                                        aria-selected="false">{{ __('homepage') }}</a></li>
                                <li class="nav-item"><a class="nav-link" id="footer-tab" data-bs-toggle="tab"
                                        href="#tab-footer" role="tab" aria-controls="tab-footer"
                                        aria-selected="false">{{ __('footer setting') }}</a></li>
                            </ul>
                            <div class="tab-content border-x border-bottom p-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-home" role="tabpanel"
                                    aria-labelledby="home-tab">

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="welcome_text_ar">{{ __('welcome text') . ' ' . __('arabic') }}</label>
                                        <input name="welcome_text_ar"
                                            class="form-control @error('welcome_text_ar') is-invalid @enderror"
                                            value="{{ websiteSettingData('welcome_text') ? websiteSettingData('welcome_text')->value_ar : '' }}"
                                            type="text" autocomplete="on" id="welcome_text_ar" autofocus />
                                        @error('welcome_text_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="welcome_text_en">{{ __('welcome text') . ' ' . __('english') }}</label>
                                        <input name="welcome_text_en"
                                            class="form-control @error('welcome_text_en') is-invalid @enderror"
                                            value="{{ websiteSettingData('welcome_text') ? websiteSettingData('welcome_text')->value_en : '' }}"
                                            type="text" autocomplete="on" id="welcome_text_en" />
                                        @error('welcome_text_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="header_phone">{{ __('header phone') }}</label>
                                        <input name="header_phone"
                                            class="form-control @error('header_phone') is-invalid @enderror"
                                            value="{{ websiteSettingData('header_phone') ? websiteSettingData('header_phone')->value_ar : '' }}"
                                            type="text" autocomplete="on" id="header_phone" />
                                        @error('header_phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="header_logo">{{ __('header logo') . '( 179 * 34 )' }}</label>
                                        <input name="header_logo"
                                            class="img form-control @error('header_logo') is-invalid @enderror"
                                            type="file" id="header_logo" />
                                        @error('header_logo')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if (websiteSettingMedia('header_logo'))
                                        <div class="mb-3">

                                            <div class="col-md-10">
                                                <img src="{{ asset(websiteSettingMedia('header_logo')) }}"
                                                    style="width:100px; border: 1px solid #999"
                                                    class="img-thumbnail img-prev">
                                            </div>

                                        </div>
                                    @endif


                                    <div
                                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 border-bottom">
                                    </div>

                                    <div class="mb-3 mt-5">
                                        <label class="form-label"
                                            for="flash_news_ar">{{ __('header flash news') }}</label><br>
                                        <button href="javascript:void(0);"
                                            class="btn btn-outline-primary btn-sm add_button me-1 mb-1 mt-1"
                                            type="button">{{ __('add new') }}
                                        </button>
                                        <div class="field_wrapper">
                                            @if (websiteSettingMultiple('flash_news'))
                                                @foreach (websiteSettingMultiple('flash_news') as $item)
                                                    <div class="input-group mt-3">
                                                        <input style="width:40%" class="form-control" type="text"
                                                            name="flash_news_ar[]" value="{{ $item->value_ar }}"
                                                            placeholder="arabic" />
                                                        <input style="width:40%" class="form-control" type="text"
                                                            name="flash_news_en[]" value="{{ $item->value_en }}"
                                                            placeholder="english" />
                                                        <a href="javascript:void(0);" class="remove_button"><span
                                                                class="input-group-text" id="basic-addon1"><span
                                                                    class="far fa-trash-alt text-danger fs-2"></span></span></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>


                                </div>

                                <div class="tab-pane fade" id="tab-profile" role="tabpanel"
                                    aria-labelledby="profile-tab">

                                    <div class="mb-3">
                                        <label class="form-label" for="primary_color">{{ __('primary color') }}</label>
                                        <div style="position: relative" class="colorpicker colorpicker-component">
                                            <input name="primary_color"
                                                class="form-control @error('primary_color') is-invalid @enderror"
                                                value="{{ websiteSettingAr('primary_color') }}" type="text"
                                                autocomplete="on" id="primary_color" />
                                            <span class="input-group-addon"><i
                                                    style="width:35px; height:35px; border-radius:10px; border:1px solid #ced4da; position: absolute; top:4px; {{ app()->getLocale() == 'ar' ? 'left:4px;' : 'right:4px;' }}"></i></span>

                                            @error('primary_color')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="secondary_color">{{ __('secondry color') }}</label>
                                        <div style="position: relative" class="colorpicker colorpicker-component">
                                            <input name="secondary_color"
                                                class="form-control @error('secondary_color') is-invalid @enderror"
                                                value="{{ websiteSettingAr('secondary_color') }}" type="text"
                                                autocomplete="on" id="secondary_color" />
                                            <span class="input-group-addon"><i
                                                    style="width:35px; height:35px; border-radius:10px; border:1px solid #ced4da; position: absolute; top:4px; {{ app()->getLocale() == 'ar' ? 'left:4px;' : 'right:4px;' }}"></i></span>

                                            @error('secondary_color')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="website_title_ar">{{ __('website title') . ' ' . __('arabic') }}</label>
                                        <input name="website_title_ar"
                                            class="form-control @error('website_title_ar') is-invalid @enderror"
                                            value="{{ websiteSettingAr('website_title') }}" type="text"
                                            autocomplete="on" id="website_title_ar" />
                                        @error('website_title_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="website_title_en">{{ __('website title') . ' ' . __('arabic') }}</label>
                                        <input name="website_title_en"
                                            class="form-control @error('website_title_en') is-invalid @enderror"
                                            value="{{ websiteSettingEn('website_title') }}" type="text"
                                            autocomplete="on" id="website_title_en" />
                                        @error('website_title_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>




                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="header_icon">{{ __('website icon') . '( 100 * 100 )' }}</label>
                                        <input name="header_icon"
                                            class="img form-control @error('header_icon') is-invalid @enderror"
                                            type="file" id="header_icon" />
                                        @error('header_icon')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if (websiteSettingMedia('header_icon'))
                                        <div class="mb-3">

                                            <div class="col-md-10">
                                                <img src="{{ asset(websiteSettingMedia('header_icon')) }}"
                                                    style="width:100px; border: 1px solid #999"
                                                    class="img-thumbnail img-prev">
                                            </div>

                                        </div>
                                    @endif

                                </div>


                                <div class="tab-pane fade" id="tab-contact" role="tabpanel"
                                    aria-labelledby="contact-tab">

                                    <div
                                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="categories">{{ __('categories for homepage section 1') }}</label>

                                        <select class="form-select js-choice @error('categories') is-invalid @enderror"
                                            multiple="multiple" name="categories[]" id="categories"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">
                                                {{ __('Select Categories') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ websiteSettingMultiple('categories')->where('value_ar', $category->id)->first()? 'selected': '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="categories">{{ __('categories for homepage section 2') }}</label>

                                        <select class="form-select js-choice @error('categories_2') is-invalid @enderror"
                                            multiple="multiple" name="categories_2[]" id="categories_2"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">
                                                {{ __('Select Categories') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ websiteSettingMultiple('categories_2')->where('value_ar', $category->id)->first()? 'selected': '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categories_2')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div
                                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="top_collection_text_ar">{{ __('top collection text') }}</label>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="top_collection_text_ar">{{ __('Title') . ' ' . __('arabic') }}</label>
                                        <input name="top_collection_text_ar"
                                            class="form-control @error('top_collection_text_ar') is-invalid @enderror"
                                            value="{{ websiteSettingAr('top_collection') }}" type="text"
                                            autocomplete="on" id="top_collection_text_ar" />
                                        @error('top_collection_text_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="top_collection_description_ar">{{ __('description') . ' ' . __('arabic') }}</label>
                                        <input name="top_collection_description_ar"
                                            class="form-control @error('top_collection_description_ar') is-invalid @enderror"
                                            value="{{ websiteSettingDAr('top_collection') }}" type="text"
                                            autocomplete="on" id="top_collection_description_ar" />
                                        @error('top_collection_description_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="top_collection_text_en">{{ __('Title') . ' ' . __('english') }}</label>
                                        <input name="top_collection_text_en"
                                            class="form-control @error('top_collection_text_en') is-invalid @enderror"
                                            value="{{ websiteSettingEn('top_collection') }}" type="text"
                                            autocomplete="on" id="top_collection_text_en" />
                                        @error('top_collection_text_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="top_collection_description_en">{{ __('description') . ' ' . __('english') }}</label>
                                        <input name="top_collection_description_en"
                                            class="form-control @error('top_collection_description_en') is-invalid @enderror"
                                            value="{{ websiteSettingDEn('top_collection') }}" type="text"
                                            autocomplete="on" id="top_collection_description_en" />
                                        @error('top_collection_description_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="best_selling_text_ar">{{ __('best selling text') }}</label>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="best_selling_text_ar">{{ __('Title') . ' ' . __('arabic') }}</label>
                                        <input name="best_selling_text_ar"
                                            class="form-control @error('best_selling_text_ar') is-invalid @enderror"
                                            value="{{ websiteSettingAr('best_selling') }}" type="text"
                                            autocomplete="on" id="best_selling_text_ar" />
                                        @error('best_selling_text_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="best_selling_description_ar">{{ __('description') . ' ' . __('arabic') }}</label>
                                        <input name="best_selling_description_ar"
                                            class="form-control @error('best_selling_description_ar') is-invalid @enderror"
                                            value="{{ websiteSettingDAr('best_selling') }}" type="text"
                                            autocomplete="on" id="best_selling_description_ar" />
                                        @error('best_selling_description_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="best_selling_text_en">{{ __('Title') . ' ' . __('english') }}</label>
                                        <input name="best_selling_text_en"
                                            class="form-control @error('best_selling_text_en') is-invalid @enderror"
                                            value="{{ websiteSettingEn('best_selling') }}" type="text"
                                            autocomplete="on" id="best_selling_text_en" />
                                        @error('best_selling_text_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="best_selling_description_en">{{ __('description') . ' ' . __('english') }}</label>
                                        <input name="best_selling_description_en"
                                            class="form-control @error('best_selling_description_en') is-invalid @enderror"
                                            value="{{ websiteSettingDEn('best_selling') }}" type="text"
                                            autocomplete="on" id="best_selling_description_en" />
                                        @error('best_selling_description_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div
                                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="">{{ __('homepage icons') }}</label>
                                    </div>


                                    <div class="row">

                                        <div class="mb-3">
                                            <label class="form-label" for="">{{ __('icon') . ' 1' }}</label>
                                        </div>


                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_title_1_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                            <input name="icon_title_1_ar"
                                                class="form-control @error('icon_title_1_ar') is-invalid @enderror"
                                                value="{{ websiteSettingAr('icon_1') }}" type="text"
                                                autocomplete="on" id="icon_title_1_ar" />
                                            @error('icon_title_1_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_description_1_ar">{{ __('description') . ' ' . __('arabic') }}</label>
                                            <input name="icon_description_1_ar"
                                                class="form-control @error('icon_description_1_ar') is-invalid @enderror"
                                                value="{{ websiteSettingDAr('icon_1') }}" type="text"
                                                autocomplete="on" id="icon_description_1_ar" />
                                            @error('icon_description_1_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_title_1_en">{{ __('title') . ' ' . __('english') }}</label>
                                            <input name="icon_title_1_en"
                                                class="form-control @error('icon_title_1_en') is-invalid @enderror"
                                                value="{{ websiteSettingEn('icon_1') }}" type="text"
                                                autocomplete="on" id="icon_title_1_en" />
                                            @error('icon_title_1_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_description_1_en">{{ __('description') . ' ' . __('english') }}</label>
                                            <input name="icon_description_1_en"
                                                class="form-control @error('icon_description_1_en') is-invalid @enderror"
                                                value="{{ websiteSettingDEn('icon_1') }}" type="text"
                                                autocomplete="on" id="icon_description_1_en" />
                                            @error('icon_description_1_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_1">{{ __('icon') . '( 60 * 60 )' }}</label>
                                            <input name="icon_1"
                                                class="img form-control @error('icon_1') is-invalid @enderror"
                                                type="file" id="icon_1" />
                                            @error('icon_1')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        @if (websiteSettingMedia('icon_1'))
                                            <div class="mb-3">

                                                <div class="col-md-10">
                                                    <img src="{{ asset(websiteSettingMedia('icon_1')) }}"
                                                        style="width:100px; border: 1px solid #999"
                                                        class="img-thumbnail img-prev">
                                                </div>

                                            </div>
                                        @endif

                                    </div>


                                    <div class="row">

                                        <div class="mb-3">
                                            <label class="form-label" for="">{{ __('icon') . ' 2' }}</label>
                                        </div>


                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_title_2_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                            <input name="icon_title_2_ar"
                                                class="form-control @error('icon_title_2_ar') is-invalid @enderror"
                                                value="{{ websiteSettingAr('icon_2') }}" type="text"
                                                autocomplete="on" id="icon_title_2_ar" />
                                            @error('icon_title_2_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_description_2_ar">{{ __('description') . ' ' . __('arabic') }}</label>
                                            <input name="icon_description_2_ar"
                                                class="form-control @error('icon_description_2_ar') is-invalid @enderror"
                                                value="{{ websiteSettingDAr('icon_2') }}" type="text"
                                                autocomplete="on" id="icon_description_2_ar" />
                                            @error('icon_description_2_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_title_2_en">{{ __('title') . ' ' . __('english') }}</label>
                                            <input name="icon_title_2_en"
                                                class="form-control @error('icon_title_2_en') is-invalid @enderror"
                                                value="{{ websiteSettingEn('icon_2') }}" type="text"
                                                autocomplete="on" id="icon_title_2_en" />
                                            @error('icon_title_2_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_description_2_en">{{ __('description') . ' ' . __('english') }}</label>
                                            <input name="icon_description_2_en"
                                                class="form-control @error('icon_description_2_en') is-invalid @enderror"
                                                value="{{ websiteSettingDEn('icon_2') }}" type="text"
                                                autocomplete="on" id="icon_description_2_en" />
                                            @error('icon_description_2_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_2">{{ __('icon') . '( 60 * 60 )' }}</label>
                                            <input name="icon_2"
                                                class="img form-control @error('icon_2') is-invalid @enderror"
                                                type="file" id="icon_2" />
                                            @error('icon_2')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if (websiteSettingMedia('icon_2'))
                                            <div class="mb-3">

                                                <div class="col-md-10">
                                                    <img src="{{ asset(websiteSettingMedia('icon_2')) }}"
                                                        style="width:100px; border: 1px solid #999"
                                                        class="img-thumbnail img-prev">
                                                </div>

                                            </div>
                                        @endif

                                    </div>

                                    <div class="row">

                                        <div class="mb-3">
                                            <label class="form-label" for="">{{ __('icon') . ' 3' }}</label>
                                        </div>


                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_title_3_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                            <input name="icon_title_3_ar"
                                                class="form-control @error('icon_title_3_ar') is-invalid @enderror"
                                                value="{{ websiteSettingAr('icon_3') }}" type="text"
                                                autocomplete="on" id="icon_title_3_ar" />
                                            @error('icon_title_3_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_description_3_ar">{{ __('description') . ' ' . __('arabic') }}</label>
                                            <input name="icon_description_3_ar"
                                                class="form-control @error('icon_description_3_ar') is-invalid @enderror"
                                                value="{{ websiteSettingDAr('icon_3') }}" type="text"
                                                autocomplete="on" id="icon_description_3_ar" />
                                            @error('icon_description_3_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_title_3_en">{{ __('title') . ' ' . __('english') }}</label>
                                            <input name="icon_title_3_en"
                                                class="form-control @error('icon_title_3_en') is-invalid @enderror"
                                                value="{{ websiteSettingEn('icon_3') }}" type="text"
                                                autocomplete="on" id="icon_title_3_en" />
                                            @error('icon_title_3_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_description_3_en">{{ __('description') . ' ' . __('english') }}</label>
                                            <input name="icon_description_3_en"
                                                class="form-control @error('icon_description_3_en') is-invalid @enderror"
                                                value="{{ websiteSettingDEn('icon_3') }}" type="text"
                                                autocomplete="on" id="icon_description_3_en" />
                                            @error('icon_description_3_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_3">{{ __('icon') . '( 60 * 60 )' }}</label>
                                            <input name="icon_3"
                                                class="img form-control @error('icon_3') is-invalid @enderror"
                                                type="file" id="icon_3" />
                                            @error('icon_3')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if (websiteSettingMedia('icon_3'))
                                            <div class="mb-3">

                                                <div class="col-md-10">
                                                    <img src="{{ asset(websiteSettingMedia('icon_3')) }}"
                                                        style="width:100px; border: 1px solid #999"
                                                        class="img-thumbnail img-prev">
                                                </div>

                                            </div>
                                        @endif

                                    </div>

                                    <div class="row">

                                        <div class="mb-3">
                                            <label class="form-label" for="">{{ __('icon') . ' 4' }}</label>
                                        </div>


                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_title_4_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                            <input name="icon_title_4_ar"
                                                class="form-control @error('icon_title_4_ar') is-invalid @enderror"
                                                value="{{ websiteSettingAr('icon_4') }}" type="text"
                                                autocomplete="on" id="icon_title_4_ar" />
                                            @error('icon_title_4_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-5">
                                            <label class="form-label"
                                                for="icon_description_4_ar">{{ __('description') . ' ' . __('arabic') }}</label>
                                            <input name="icon_description_4_ar"
                                                class="form-control @error('icon_description_4_ar') is-invalid @enderror"
                                                value="{{ websiteSettingDAr('icon_4') }}" type="text"
                                                autocomplete="on" id="icon_description_4_ar" />
                                            @error('icon_description_4_ar')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_title_4_en">{{ __('title') . ' ' . __('english') }}</label>
                                            <input name="icon_title_4_en"
                                                class="form-control @error('icon_title_4_en') is-invalid @enderror"
                                                value="{{ websiteSettingEn('icon_4') }}" type="text"
                                                autocomplete="on" id="icon_title_4_en" />
                                            @error('icon_title_4_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_description_4_en">{{ __('description') . ' ' . __('english') }}</label>
                                            <input name="icon_description_4_en"
                                                class="form-control @error('icon_description_4_en') is-invalid @enderror"
                                                value="{{ websiteSettingDEn('icon_4') }}" type="text"
                                                autocomplete="on" id="icon_description_4_en" />
                                            @error('icon_description_4_en')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col-md-4">
                                            <label class="form-label"
                                                for="icon_4">{{ __('icon') . '( 60 * 60 )' }}</label>
                                            <input name="icon_4"
                                                class="img form-control @error('icon_4') is-invalid @enderror"
                                                type="file" id="icon_4" />
                                            @error('icon_4')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        @if (websiteSettingMedia('icon_4'))
                                            <div class="mb-3">

                                                <div class="col-md-10">
                                                    <img src="{{ asset(websiteSettingMedia('icon_4')) }}"
                                                        style="width:100px; border: 1px solid #999"
                                                        class="img-thumbnail img-prev">
                                                </div>

                                            </div>
                                        @endif

                                    </div>




                                </div>







                                <div class="tab-pane fade" id="tab-footer" role="tabpanel" aria-labelledby="footer-tab">


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="footer_about_ar">{{ __('about us') . ' ' . __('arabic') }}</label>
                                        <input name="footer_about_ar"
                                            class="form-control @error('footer_about_ar') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_about') }}" type="text"
                                            autocomplete="on" id="footer_about_ar" />
                                        @error('footer_about_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="footer_about_en">{{ __('about us') . ' ' . __('english') }}</label>
                                        <input name="footer_about_en"
                                            class="form-control @error('footer_about_en') is-invalid @enderror"
                                            value="{{ websiteSettingEn('footer_about') }}" type="text"
                                            autocomplete="on" id="footer_about_en" />
                                        @error('footer_about_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="footer_address_ar">{{ __('company address') . ' ' . __('arabic') }}</label>
                                        <input name="footer_address_ar"
                                            class="form-control @error('footer_address_ar') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_address') }}" type="text"
                                            autocomplete="on" id="footer_address_ar" />
                                        @error('footer_address_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="footer_address_en">{{ __('company address') . ' ' . __('english') }}</label>
                                        <input name="footer_address_en"
                                            class="form-control @error('footer_address_en') is-invalid @enderror"
                                            value="{{ websiteSettingEn('footer_address') }}" type="text"
                                            autocomplete="on" id="footer_address_en" />
                                        @error('footer_address_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>




                                    <div class="mb-3">
                                        <label class="form-label" for="footer_phone">{{ __('phone') }}</label>
                                        <input name="footer_phone"
                                            class="form-control @error('footer_phone') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_phone') }}" type="text"
                                            autocomplete="on" id="footer_phone" />
                                        @error('footer_phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="footer_email">{{ __('email') }}</label>
                                        <input name="footer_email"
                                            class="form-control @error('footer_email') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_email') }}" type="text"
                                            autocomplete="on" id="footer_email" />
                                        @error('footer_email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="footer_follow_ar">{{ __('follow us text') . ' ' . __('arabic') }}</label>
                                        <input name="footer_follow_ar"
                                            class="form-control @error('footer_follow_ar') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_follow') }}" type="text"
                                            autocomplete="on" id="footer_follow_ar" />
                                        @error('footer_follow_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="footer_follow_en">{{ __('follow us text') . ' ' . __('english') }}</label>
                                        <input name="footer_follow_en"
                                            class="form-control @error('footer_follow_en') is-invalid @enderror"
                                            value="{{ websiteSettingEn('footer_follow') }}" type="text"
                                            autocomplete="on" id="footer_follow_en" />
                                        @error('footer_follow_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>





                                    <div class="mb-3">
                                        <label class="form-label" for="footer_facebook">{{ __('facebook') }}</label>
                                        <input name="footer_facebook"
                                            class="form-control @error('footer_facebook') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_facebook') }}" type="text"
                                            autocomplete="on" id="footer_facebook" />
                                        @error('footer_facebook')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="footer_instagram">{{ __('instagram') }}</label>
                                        <input name="footer_instagram"
                                            class="form-control @error('footer_instagram') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_instagram') }}" type="text"
                                            autocomplete="on" id="footer_instagram" />
                                        @error('footer_instagram')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="footer_youtube">{{ __('youtube') }}</label>
                                        <input name="footer_youtube"
                                            class="form-control @error('footer_youtube') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_youtube') }}" type="text"
                                            autocomplete="on" id="footer_youtube" />
                                        @error('footer_youtube')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="footer_linkedin">{{ __('linkedin') }}</label>
                                        <input name="footer_linkedin"
                                            class="form-control @error('footer_linkedin') is-invalid @enderror"
                                            value="{{ websiteSettingAr('footer_linkedin') }}" type="text"
                                            autocomplete="on" id="footer_linkedin" />
                                        @error('footer_linkedin')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="copyright_text_ar">{{ __('copyrigt text') . ' ' . __('arabic') }}</label>
                                        <input name="copyright_text_ar"
                                            class="form-control @error('copyright_text_ar') is-invalid @enderror"
                                            value="{{ websiteSettingAr('copyright_text') }}" type="text"
                                            autocomplete="on" id="copyright_text_ar" />
                                        @error('copyright_text_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="copyright_text_en">{{ __('copyrigt text') . ' ' . __('english') }}</label>
                                        <input name="copyright_text_en"
                                            class="form-control @error('copyright_text_en') is-invalid @enderror"
                                            value="{{ websiteSettingEn('copyright_text') }}" type="text"
                                            autocomplete="on" id="copyright_text_en" />
                                        @error('copyright_text_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                </div>

                                {{-- data here  --}}

                            </div>


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
