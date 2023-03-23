@extends('layouts.front.app')

@section('contentFront')
    <div class="position-relative py-6 py-lg-8 light">
        <div class="bg-holder rounded-3  overlay-0" style="background-image:url(../../assets/img/gallery/backgrounds.jpg);">
        </div>
        <!--/.bg-holder-->
        <div class="position-relative text-center">
            <h4 class="text-white">{{ __('Terms and conditions') }}</h4>
            <nav style="--falcon-breadcrumb-divider: '»';" aria-label="breadcrumb">
                <ol style="justify-content: center;" class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Terms and conditions') }}</li>
                </ol>
            </nav>
        </div>
    </div>


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0 pb-5 overflow-hidden light background" id="banner">



        <div class="container  mt-7">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 col-xl-7  col-xxl-6">
                    {!! app()->getLocale() == 'ar' ? setting('terms_ar') : setting('terms_en') !!}
                </div>
            </div>
        </div>
    </section>
@endsection
