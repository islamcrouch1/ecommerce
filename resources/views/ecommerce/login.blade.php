@extends('layouts.ecommerce.app')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('login') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav style="direction: ltr; float:{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                        aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('login') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>{{ __('login') }}</h3>
                    <div class="theme-card">
                        <form class="theme-form" method="POST" action="{{ route('ecommerce.user.login') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="phone">{{ __('Phone Number') }}</label>
                                <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    type="txt" name="phone" value="{{ old('phone') }}" required autofocus
                                    autocomplete="on" />
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">{{ __('Password') }}</label>
                                </div>
                                <div style="position: relative" id="show_hide_password">
                                    <input class="form-control @error('password') is-invalid @enderror" id="password"
                                        type="password" name="password" required />
                                    <a style="position: absolute; top: 0px;  padding: 15px; font-size:20px; {{ app()->getLocale() == 'ar' ? 'left: 20px;' : 'right: 20px;' }}"
                                        id="show-pass" href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-solid" type="submit" name="submit">{{ __('Login') }}</button>

                        </form>
                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>{{ __('New Customer') }}</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">{{ __('Create A Account') }}</h6>
                        <p>{{ __('Registration is quick and easy. It allows you to be able to order from our shop. To start shopping click register.') }}
                        </p><a href="{{ route('ecommerce.user.create') }}"
                            class="btn btn-solid">{{ __('Create A Account') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection
