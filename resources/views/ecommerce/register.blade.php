@extends('layouts.ecommerce.app', ['page_title' => 'register'])
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('create account') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('create account') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->



    <!--section start-->
    <section class="register-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{ __('create account') }}</h3>
                    <div class="theme-card">
                        <form class="theme-form" method="POST" action="{{ route('ecommerce.user.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">{{ __('Name') . ' *' }}</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" type="text" autocomplete="on" id="name"
                                        autofocus required />
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">{{ __('Phone') . ' *' }}</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="number"
                                        autocomplete="on" id="phone" name="phone" autocomplete="on"
                                        value="{{ old('phone') }}" required />
                                    @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label class="form-label" for="email">{{ __('Email address') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        autocomplete="on" id="email" name="email" autocomplete="on"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="country">{{ __('Country') . ' *' }}</label>

                                    <select class="form-select @error('country') is-invalid @enderror" aria-label=""
                                        name="country" id="country" required>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country') == $country->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label class="form-label" for="password">{{ __('Password') . ' *' }}</label>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        autocomplete="on" id="password" name="password" required />
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="password_confirmation">{{ __('Confirm Password') . ' *' }}</label>
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                        type="password" autocomplete="on" id="password_confirmation"
                                        name="password_confirmation" required />
                                    @error('password_confirmation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <input style="padding: 8px"
                                        class="form-check-input @error('check') is-invalid @enderror" type="checkbox"
                                        id="check" name="check" required />
                                    <span class="p-4" for="check">{{ __('I accept the') }} <a
                                            href="{{ route('ecommerce.terms') }}">{{ __('terms') }}
                                        </a>{{ __('and') }} <a
                                            href="{{ route('ecommerce.terms') }}">{{ __('privacy policy') }}</a></span>
                                    @error('check')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-solid w-auto" type="submit"
                                name="submit">{{ __('Register') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection
