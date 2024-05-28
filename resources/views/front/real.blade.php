@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('Real estate investments') }} </h1>
            </div>
            {{-- <p class="fsz-18 mt-30 text-white op-6"> Ensuring the best return on investment for your bespoke <br> SEO
                campaign requirement. </p> --}}
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.real') }}" class="active gold"> {{ __('Real estate investments') }} </a>
        </div>
    </header>
    <!-- end header -->

    <!--Contents-->
    <main>


        <!-- start tc-services-content -->
        <section class="tc-services-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="main-content">
                            <div class="main-img img-cover mb-50">
                                <img src="{{ asset('/assets/img/elkomy/real1.jpg') }}" alt="">
                            </div>

                            @if (app()->getLocale() == 'en')
                                <div class="text fsz-18 color-777 mb-30">
                                    Elkomy Holding’s activity in real estate started in 2002.<br>
                                    Our company works in several fields of real estate from construction, contracting,
                                    and developing to real estate and industrial investment, with a capital of 20,000,000
                                    EGP.<br>
                                    Elkomy is currently working on multiple construction projects.<br>
                                    Our purpose is to build innovative and safe spaces to bring our clients together in
                                    exciting ways, and this requires an expert team to keep their eyes on our developments.


                                </div>
                            @else
                                <div class="text fsz-18 color-777 mb-30">
                                    الكومي –العالمية للعقارات تأسست عام 2002<br>
                                    تعمل العالمية في العديد من مجالات العقارات ,من البناء والمقاولات والتطوير إلى الاستثمار
                                    العقاري والصناعي. برأس مال 20,000,000 جنيه مصري.<br>
                                    حاليا تعمل الكومي القابضة في العديد من مشاريع البناء و التشييد.<br>
                                    هدفنا هو بناء مساحات مبتكرة وآمنة لجمع عملائنا معًا بطرق مميزة. وهذا يتطلب فريقًا من
                                    الخبراء للمراقبة والحفاظ علي تطوراتنا المستمرة.


                                </div>
                            @endif



                            <div class="vision-card mb-70 overflow-hidden">
                                <div class="row align-items-center gx-5">
                                    <div class="col-lg-5">
                                        <div class="img img-cover  radius-3 overflow-hidden">
                                            <img src="{{ asset('/assets/img/elkomy/real2.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="info mt-4 mt-lg-0">
                                            <h5 class="fsz-24 mb-30">{{ __('Our Values') }}</h5>


                                            <ul class="mt-3">
                                                <li class="mb-2">
                                                    <span class="fsz-14 ">
                                                        <span class="fw-bold gold">{{ __('Safety:') }}</span>
                                                        {{ __('Achieving a solid safety record to improve our clients’ experience.') }}
                                                    </span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fsz-14">
                                                        <span class="fw-bold gold">{{ __('Willingness to grow:') }}</span>
                                                        {{ __('Our company Is passionate about growing and innovating.') }}</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fsz-14 ">
                                                        <span
                                                            class="fw-bold gold">{{ __('Continuous improvement:') }}</span>
                                                        {{ __('Big improvements are what we seek for.') }}
                                                    </span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fsz-14 ">
                                                        <span class="fw-bold gold">{{ __('Commitment:') }}</span>
                                                        {{ __('We are committed to working diligently to remain the best and achieve more success.') }}
                                                    </span>
                                                </li>



                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>






                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="widgets ps-lg-4 mt-4 mt-lg-0">
                            <div class="widget-card widget-links">
                                <p class="fsz-14 color-999 fw-bold mb-20 text-uppercase op-5"> {{ __('more businesses') }}
                                </p>
                                <ul>
                                    <li><a href="{{ route('front.steel') }}">{{ __('Steel manufacturing') }}</a></li>
                                    <li><a href="{{ route('front.real') }}">{{ __('Real estate investments') }}</a>
                                    </li>
                                    <li><a href="{{ route('front.currency') }}">{{ __('Currency Exchange') }}</a></li>
                                    <li><a href="{{ route('front.educational') }}">{{ __('Educational services') }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="widget-card widget-form">
                                <div class="form-group">
                                    <div class="button_su radius-4 w-100">
                                        <span class="su_button_circle bg-000 desplode-circle"></span>
                                        <a href="{{ route('front.contact') }}"
                                            class="butn pt-15 pb-15 button_su_inner bg-blue3 m-0 radius-4 lh-1 w-100 text-center b-gold">
                                            <span class="button_text_container fsz-13 fw-bold text-capitalize text-white">
                                                {{ __('Contact us') }} </span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end tc-services-content -->

        @include('front._portfolio', [
            'posts' => $portfolio_posts,
        ])


    </main>
    <!--End-Contents-->
@endsection
