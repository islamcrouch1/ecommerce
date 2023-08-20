@extends('layouts.dashboard.app')

@section('adminContent')
    @if (auth()->user()->hasPermission('queries-update'))
        <div class="row pt-1 g-0 h-100">
            <div class="col-md-12 d-flex flex-center">
                <div class="flex-grow-1">
                    <form method="POST" action="{{ route('queries.admin.update', ['query' => $query->id]) }}">
                        @csrf
                        <div class="mb-3 mt-3">
                            <label class="form-label" for="note">{{ __('Edit Query') }}</label>
                            <input name="query" class="form-control @error('query') is-invalid @enderror"
                                value="{{ $query->query }}" type="text" autocomplete="on" id="query" required />
                            @error('query')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'Hotline' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender1"
                                    type="radio" name="query_type" value="Hotline" required />
                                <label class="form-check-label" for="flexRadioDefault1">{{ __('Hotline') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'Facebook' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender2"
                                    type="radio" name="query_type" value="Facebook" required />
                                <label class="form-check-label" for="flexRadioDefault2">{{ __('Facebook') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'Email' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender3"
                                    type="radio" name="query_type" value="Email" required />
                                <label class="form-check-label" for="flexRadioDefault2">{{ __('Email') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'Website' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender4"
                                    type="radio" name="query_type" value="Website" required />
                                <label class="form-check-label" for="flexRadioDefault2">{{ __('Website') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'Customer service phone' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender5"
                                    type="radio" name="query_type" value="Customer service phone" required />
                                <label class="form-check-label"
                                    for="flexRadioDefault2">{{ __('Customer service phone') }}</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'whatsapp' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender6"
                                    type="radio" name="query_type" value="whatsapp" required />
                                <label class="form-check-label" for="flexRadioDefault2">{{ __('whatsapp') }}</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'Recommendation from client' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender7"
                                    type="radio" name="query_type" value="Recommendation from client" required />
                                <label class="form-check-label"
                                    for="flexRadioDefault2">{{ __('Recommendation from client') }}</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input {{ $query->query_type == 'Instagram' ? 'checked' : '' }}
                                    class="form-check-input @error('query_type') is-invalid @enderror" id="gender8"
                                    type="radio" name="query_type" value="Instagram" required />
                                <label class="form-check-label" for="flexRadioDefault2">{{ __('Instagram') }}</label>
                            </div>

                            @error('query_type')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                name="submit">{{ __('Save Query') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif
@endsection
