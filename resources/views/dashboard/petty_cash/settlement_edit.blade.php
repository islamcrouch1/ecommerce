@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">



                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('statement edit') }}

                    </h5>
                </div>
            </div>
        </div>





        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('employee.settlement.update', ['record' => $record->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="mb-3 col-sm-6">
                                    <label class="form-label" for="name_ar">{{ __('statement') }}</label>
                                    <input name="statement" class="form-control @error('statement') is-invalid @enderror"
                                        value="{{ $record->statement }}" type="text" autocomplete="on" id="statement"
                                        autofocus required />
                                    @error('statement')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-sm-6">
                                    <label class="form-label" for="amount">{{ __('amount') }}</label>
                                    <input class="form-control @error('amount') is-invalid @enderror" type="numbet"
                                        id="amount" name="amount" min="0" step="0.01"
                                        value="{{ $record->amount }}" required />
                                    @error('amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3 col-sm-6">
                                    <label class="form-label" for="media">{{ __('invoice image') }}</label>
                                    <input name="media" class="img form-control @error('media') is-invalid @enderror"
                                        type="file" id="media" />
                                    @error('media')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3 col-sm-6">
                                    <label class="form-label" for="notes">{{ __('notes') }}</label>
                                    <input name="notes" class="form-control @error('notes') is-invalid @enderror"
                                        value="{{ $record->notes }}" type="text" autocomplete="on" id="notes" />
                                    @error('notes')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                @if ($record->media != null)
                                    <div class="mb-3">

                                        <div class="col-md-10">
                                            <img src="{{ asset($record->media->path) }}"
                                                style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                        </div>

                                    </div>
                                @endif

                            </div>




                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('edit') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection
