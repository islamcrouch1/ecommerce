@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 btn-reveal-trigger">
                <div class="card-header position-relative min-vh-25 mb-8">
                    <div class="cover-image">
                        <div class="bg-holder rounded-3 rounded-bottom-0"
                            style="background-image:url(../../assets/img/generic/4.jpg);">
                        </div>
                    </div>
                    <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                        <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img
                                src="{{ asset('storage/images/users/' . $user->profile) }}" width="200" alt=""
                                data-dz-thumbnail="data-dz-thumbnail" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-0">
        <div class="col-lg-12 pe-lg-2">
            <div class="card mb-3 overflow-hidden">
                <div class="card-header">
                    <h5 class="mb-0">Account Information</h5>
                </div>
                <div class="card-body bg-light">


                    <h6 class="fw-bold">{{ __('User ID') . ': #' . $user->id }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('User Name') . ': ' . $user->name }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('User Type') . ': ' }}
                        @if ($user->hasRole('affiliate'))
                            {{ __('Affiliate') }}
                        @elseif($user->hasRole('vendor'))
                            {{ __('Vendor') }}
                        @endif
                    </h6>
                    <h6 class="mt-2 fw-bold">
                        {{ __('Country') . ': ' . App()->getLocale() == 'ar' ? $user->country->name_ar : $user->country->name_en }}
                    </h6>
                    <h6 class="mt-2 fw-bold">{{ __('Phone') . ': ' . $user->phone }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Gender') . ': ' . $user->gender }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Verification Code') . ': ' . $user->verification_code }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Created At') . ': ' . $user->created_at }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Updated At') . ': ' . $user->updated_at }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Email') . ': ' . $user->email }}</h6>
                    <div class="border-dashed-bottom my-3"></div>
                    <h6 class="mt-2 fw-bold"><a
                            href="{{ route('previews_clients.edit', ['previews_client' => $user->id]) }}"
                            class="btn btn-falcon-primary me-1 mb-1" type="button">{{ __('Edit') }}
                        </a></h6>

                </div>
            </div>


        </div>
    </div>
@endsection
