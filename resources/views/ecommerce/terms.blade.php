@extends('layouts.ecommerce.app')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('Terms and Conditions') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Terms and Conditions') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->



    <!-- about section start -->
    <section class="about-page section-b-space">
        <div class="container">
            <div class="row">

                <div class="col-sm-12">

                    <p>{!! app()->getLocale() == 'ar' ? setting('terms_ar') : setting('terms_en') !!}
                    </p>

                </div>
            </div>
        </div>
    </section>
@endsection
