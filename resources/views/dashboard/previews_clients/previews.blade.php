@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5> {{ __('Preview') . ': ' . $user->name . ' - ' . getName($stage) }}

                        <a href="{{ route('previews.create', ['user' => $user->id, 'preview' => $preview == null ? null : $preview->id, 'stage' => $stage->id, 'dir' => 'prev']) }}"
                            class="btn btn-outline-primary btn-sm add_account me-1 mb-1 mt-1"
                            type="button">{{ __('previous stage') }}
                        </a>
                        <a href="{{ route('previews.create', ['user' => $user->id, 'preview' => $preview == null ? null : $preview->id, 'stage' => $stage->id, 'dir' => 'next']) }}"
                            class="btn btn-outline-primary btn-sm add_account me-1 mb-1 mt-1"
                            type="button">{{ __('next stage') }}
                        </a>

                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('previews.store', ['user' => $user->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div style="display:none" class="mb-3">
                                <input name="stage" class="form-control" value="{{ $stage->id }}" type="text"
                                    id="stage" required />
                            </div>

                            <div style="display:none" class="mb-3">
                                <input name="preview" class="form-control" value="{{ $preview == null ? 0 : $preview->id }}"
                                    type="text" id="preview" required />
                            </div>

                            <div class="row">
                                @foreach ($stage->fields as $field)
                                    {!! getStageField($field, $preview) !!}
                                @endforeach
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
