@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New Client') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">{{ __('Name') . ' *' }}</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" type="text" autocomplete="on" id="name" autofocus
                                    required />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">{{ __('Phone') . ' *' }}</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="number"
                                    autocomplete="on" id="phone" name="phone" autocomplete="on"
                                    value="{{ old('phone') }}" required />
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="whatsapp">{{ __('whatsapp') . ' *' }}</label>
                                <input class="form-control @error('whatsapp') is-invalid @enderror" type="number"
                                    autocomplete="on" id="whatsapp" name="whatsapp" autocomplete="on"
                                    value="{{ old('whatsapp') }}" />
                                @error('whatsapp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label" for="place_type">{{ __('Type of place') }}</label>

                                <select class="form-select @error('place_type') is-invalid @enderror" aria-label=""
                                    name="place_type" id="place_type" required>
                                    <option value="club">
                                        {{ __('club') }}
                                    </option>
                                    <option value="resort">
                                        {{ __('resort') }}
                                    </option>
                                    <option value="village">
                                        {{ __('village') }}
                                    </option>
                                    <option value="company">
                                        {{ __('company') }}
                                    </option>
                                    <option value="nursery">
                                        {{ __('nursery') }}
                                    </option>
                                    <option value="School">
                                        {{ __('School') }}
                                    </option>
                                    <option value="hotel">
                                        {{ __('hotel') }}
                                    </option>
                                    <option value="resturant">
                                        {{ __('resturant') }}
                                    </option>
                                    <option value="cafe">
                                        {{ __('cafe') }}
                                    </option>
                                    <option value="Kidsarea">
                                        {{ __('Kidsarea') }}
                                    </option>
                                    <option value="house">
                                        {{ __('house') }}
                                    </option>
                                    <option value="other">
                                        {{ __('other') }}
                                    </option>

                                </select>
                                @error('place_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}



                            <div class="mb-3">
                                <label class="form-label" for="email">{{ __('Email address') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="email" name="email" autocomplete="on" value="{{ old('email') }}" />
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="country_id">{{ __('Country') }}</label>

                                <select class="form-select country-select @error('country_id') is-invalid @enderror"
                                    aria-label="" name="country_id" id="country_id"
                                    data-url="{{ route('country.states') }}" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" data-country_id="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="state_id">{{ __('state') }}</label>
                                <select class="form-control state-select @error('state_id') is-invalid @enderror"
                                    id="state_id" name="state_id" data-url="{{ route('state.cities') }}" required>

                                </select>
                                @error('state_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="city_id">{{ __('city') }}</label>
                                <select class="form-control js-choice city-select @error('city_id') is-invalid @enderror"
                                    id="city_id" name="city_id" required>

                                </select>
                                @error('city_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="address">{{ __('Address') }}</label>
                                <input name="address" class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}" type="text" autocomplete="on" id="name" />
                                @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="gender">{{ __('Gender') }}</label>

                                <br>
                                <div class="form-check form-check-inline">
                                    <input {{ old('gender') == 'male' ? 'checked' : '' }}
                                        class="form-check-input @error('gender') is-invalid @enderror" id="gender1"
                                        type="radio" name="gender" value="male" required />
                                    <label class="form-check-label" for="flexRadioDefault1">{{ __('Male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input {{ old('gender') == 'female' ? 'checked' : '' }}
                                        class="form-check-input @error('gender') is-invalid @enderror" id="gender2"
                                        type="radio" name="gender" value="female" required />
                                    <label class="form-check-label" for="flexRadioDefault2">{{ __('Female') }}</label>
                                </div>

                                @error('gender')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New Client') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
