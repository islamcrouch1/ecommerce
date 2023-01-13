@extends('layouts.dashboard.app_login')

@section('authContent')
    <div class="row min-vh-100 flex-center g-0">
        <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                src="../../../assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img
                class="bg-auth-circle-shape-2" src="../../../assets/img/icons/spot-illustrations/shape-1.png" alt=""
                width="150">
            <div class="card overflow-hidden z-index-1">
                <div class="card-body p-0">
                    <div class="row g-0 h-100">
                        <div class="col-md-5 text-center bg-card-gradient">
                            <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                <div class="bg-holder bg-auth-card-shape"
                                    style="background-image:url(../../../assets/img/icons/spot-illustrations/half-circle.png);">
                                </div>
                                <!--/.bg-holder-->

                                <div class="z-index-1 position-relative"><a
                                        class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                        href="#"> <img style="width:150px" src="{{ asset('assets/img/logo.png') }}"
                                            alt="">
                                    </a>
                                    <p class="opacity-75 text-white">
                                        {{ __('Please enter the mobile number that you registered with') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                                <p class="mb-0 mt-4 mt-md-5 fs--1 fw-semi-bold text-white opacity-75">{{ __('Read our') }}
                                    <a class="text-decoration-underline text-white" href="#!">{{ __('terms') }}</a>
                                    {{ __('and') }} <a class="text-decoration-underline text-white"
                                        href="#!">{{ __('conditions') }} </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-7 d-flex flex-center">

                            <div class="p-4 p-md-5 flex-grow-1">
                                @if (session('status'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <h3>{{ __('Forgot Password?') }}</h3>
                                <form id="sonoo-form" class="mt-3 mb-2" method="POST"
                                    action="{{ route('password.reset.verify') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="phone">{{ __('Phone Number') }}</label>
                                        <input class="form-control @error('phone') is-invalid @enderror" type="txt"
                                            id="phone" name="phone" value="{{ old('phone') }}" required autofocus />
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">{{ __('Change the password') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
