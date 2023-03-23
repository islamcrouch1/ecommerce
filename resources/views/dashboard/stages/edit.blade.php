@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('edit') . ' ' . __('stage') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('stages.update', ['stage' => $stage->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="mb-3">
                                <label class="form-label" for="name_ar">{{ __('title') . ' ' . __('arabic') }}</label>
                                <input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                    value="{{ $stage->name_ar }}" type="text" autocomplete="on" id="name_ar" autofocus
                                    required />
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name_en">{{ __('title') . ' ' . __('english') }}</label>
                                <input name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                    value="{{ $stage->name_en }}" type="text" autocomplete="on" id="name_en" autofocus
                                    required />
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="score">{{ __('score to pass this stage') }}</label>
                                <input name="score" class="form-control @error('score') is-invalid @enderror"
                                    value="{{ $stage->score }}" min="0" type="number" autocomplete="on"
                                    id="score" autofocus required />
                                @error('score')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-select select_type" aria-label="" name="select_type"
                                        id="select_type" required>
                                        <option value="name">
                                            {{ __('name') }}
                                        </option>
                                        <option value="text">
                                            {{ __('text') }}
                                        </option>
                                        <option value="photo">
                                            {{ __('photo') }}
                                        </option>
                                        <option value="number">
                                            {{ __('number') }}
                                        </option>
                                        <option value="checkbox">
                                            {{ __('checkbox') }}
                                        </option>
                                        <option value="radio">
                                            {{ __('radio') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button href="javascript:void(0);" data-locale="{{ app()->getLocale() }}"
                                        class="btn btn-outline-primary btn-sm add_field me-1 mb-1 mt-1"
                                        type="button">{{ __('add field') }}
                                    </button>
                                </div>
                            </div>

                            <div class="field_wrapper">
                                @foreach ($stage->fields as $index => $field)
                                    <div class="row div-{{ $index + 1 }}">

                                        <div class="col-md-2 mt-2">
                                            <label class="form-label" for="field_name_en">{{ __('field type') }}</label>
                                            <input name="type[]" class="form-control stage-field"
                                                value="{{ $field->type }}" type="text" required disabled />
                                        </div>

                                        <div style="display:none" class="col-md-2 mt-2">
                                            <input name="level[]" class="form-control stage-field"
                                                value="{{ $index + 1 }}" type="text" required disabled />
                                        </div>

                                        <div class="col-md-3 mt-2">
                                            <label class="form-label"
                                                for="field_name_ar">{{ __('field name arabic') }}</label>
                                            <input name="field_name_ar[]" class="form-control"
                                                value="{{ $field->name_ar }}" type="text" autocomplete="on"
                                                id="field_name_ar" autofocus required />
                                        </div>

                                        <div class="col-md-3 mt-2">
                                            <label class="form-label"
                                                for="field_name_en">{{ __('field name english') }}</label>
                                            <input name="field_name_en[]" class="form-control "
                                                value="{{ $field->name_en }}" type="text" autocomplete="on"
                                                id="field_name_en" autofocus required />
                                        </div>

                                        <div class="col-md-1 mt-2">
                                            <label class="form-label" for="field_score">{{ __('field score') }}</label>
                                            <input name="field_score[]" class="form-control" value="{{ $field->score }}"
                                                min="0" type="number" autocomplete="on" id="field_score"
                                                autofocus required />
                                        </div>

                                        <div class="col-md-1 mt-2">
                                            <label class="form-label"
                                                for="is_required">{{ __('field required') }}</label>
                                            <div>
                                                <label class="switch">
                                                    <input id="is_required" class="form-control "
                                                        name="is_required[{{ $index + 1 }}][]" type="checkbox"
                                                        {{ $field->is_required == 1 ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="col-md-1 mt-2">
                                            <label class="form-label" for="is_required">{{ __('delete') }}</label>
                                            <div>
                                                <a href="javascript:void(0);" data-x="{{ $index + 1 }}"
                                                    class="remove_button m-2">
                                                    <span id="basic-addon1">
                                                        <span class="far fa-trash-alt text-danger fs-2"></span>
                                                    </span>
                                                </a>
                                            </div>

                                        </div>

                                        @if ($field->type == 'checkbox' || $field->type == 'radio')
                                            <div class="col-md-2 mt-2">
                                                <button href="javascript:void(0);" data-x="{{ $index + 1 }}"
                                                    data-type="{{ $field->type }}"
                                                    data-locale="{{ app()->getLocale() }}"
                                                    class="btn btn-outline-primary btn-sm add_option me-1 mb-1 mt-1"
                                                    type="button">{{ __('add options') }}
                                                </button>
                                            </div>

                                            @php
                                                $data = explode(',', $field->data);
                                            @endphp

                                            @foreach ($data as $item)
                                                <div class="col-md-2 mt-2">
                                                    <label class="form-label"
                                                        for="options">{{ __('option name') }}</label>
                                                    <div class="input-group">
                                                        <input name="options[{{ $index + 1 }}][]" class="form-control"
                                                            value="{{ $item }}" type="text" autocomplete="on"
                                                            id="options" autofocus required />
                                                        <a href="javascript:void(0);" class="remove_button_option">
                                                            <span class="input-group-text" id="basic-addon1">
                                                                <span class="far fa-trash-alt text-danger fs-2"></span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div style="display:none" class="col-md-2 mt-2">
                                                <input name="options[{{ $index + 1 }}][]" class="form-control"
                                                    value="0" type="text" required />
                                            </div>
                                        @endif

                                    </div>
                                @endforeach

                                <div style="display: none" class="data-x" data-x="{{ $index + 1 }}"></div>

                            </div>






                            <div class="mb-3">
                                <button class="btn btn-primary submit-form d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('edit') . ' ' . __('stage') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
