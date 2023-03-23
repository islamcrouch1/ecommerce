@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit Client') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('clients.update', ['client' => $client->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $client->name }}" type="text" autocomplete="on" id="name" autofocus
                                    required />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">{{ __('Phone') }}</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="number"
                                    autocomplete="on" id="phone" name="phone" autocomplete="on"
                                    value="{{ getPhoneWithoutCode($client->phone, $client->user->country_id) }}" required />
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="whatsapp">{{ __('whatsapp') . ' *' }}</label>
                                <input class="form-control @error('whatsapp') is-invalid @enderror" type="number"
                                    autocomplete="on" id="whatsapp" name="whatsapp" autocomplete="on"
                                    value="{{ $client->whatsapp }}" />
                                @error('whatsapp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label" for="place_type">{{ __('Type of place') }}</label>

                                <select class="form-select @error('place_type') is-invalid @enderror" aria-label=""
                                    name="place_type" id="place_type" required>
                                    <option value="club" {{ $client->place_type == 'club' ? 'selected' : '' }}>
                                        {{ __('club') }}
                                    </option>
                                    <option value="resort" {{ $client->place_type == 'resort' ? 'selected' : '' }}>
                                        {{ __('resort') }}
                                    </option>
                                    <option value="village" {{ $client->place_type == 'village' ? 'selected' : '' }}>
                                        {{ __('village') }}
                                    </option>
                                    <option value="company" {{ $client->place_type == 'company' ? 'selected' : '' }}>
                                        {{ __('company') }}
                                    </option>
                                    <option value="nursery" {{ $client->place_type == 'nursery' ? 'selected' : '' }}>
                                        {{ __('nursery') }}
                                    </option>
                                    <option value="School" {{ $client->place_type == 'School' ? 'selected' : '' }}>
                                        {{ __('School') }}
                                    </option>
                                    <option value="hotel" {{ $client->place_type == 'hotel' ? 'selected' : '' }}>
                                        {{ __('hotel') }}
                                    </option>
                                    <option value="resturant" {{ $client->place_type == 'resturant' ? 'selected' : '' }}>
                                        {{ __('resturant') }}
                                    </option>
                                    <option value="cafe" {{ $client->place_type == 'cafe' ? 'selected' : '' }}>
                                        {{ __('cafe') }}
                                    </option>
                                    <option value="Kidsarea" {{ $client->place_type == 'Kidsarea' ? 'selected' : '' }}>
                                        {{ __('Kidsarea') }}
                                    </option>
                                    <option value="house" {{ $client->place_type == 'house' ? 'selected' : '' }}>
                                        {{ __('house') }}
                                    </option>
                                    <option value="other" {{ $client->place_type == 'other' ? 'selected' : '' }}>
                                        {{ __('other') }}
                                    </option>

                                </select>
                                @error('place_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label" for="address">{{ __('Address') }}</label>
                                <input name="address" class="form-control @error('address') is-invalid @enderror"
                                    value="{{ $client->address }}" type="text" autocomplete="on" id="address" />
                                @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">{{ __('Email address') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="email" name="email" autocomplete="on" value="{{ $client->email }}" />
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="gender">{{ __('Gender') }}</label>

                                <br>
                                <div class="form-check form-check-inline">
                                    <input {{ $client->gender == 'male' ? 'checked' : '' }}
                                        class="form-check-input @error('gender') is-invalid @enderror" id="gender1"
                                        type="radio" name="gender" value="male" required />
                                    <label class="form-check-label" for="flexRadioDefault1">{{ __('Male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input {{ $client->gender == 'female' ? 'checked' : '' }}
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
                                    name="submit">{{ __('Edit Client') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
