@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('Currency Exchange') }} </h1>
            </div>
            {{-- <p class="fsz-18 mt-30 text-white op-6"> Ensuring the best return on investment for your bespoke <br> SEO
                campaign requirement. </p> --}}
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.steel') }}" class="active gold"> {{ __('Currency Exchange') }} </a>
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
                                <img src="{{ asset('/assets/img/elkomy/c2.jpg') }}" alt="">
                            </div>

                            @if (app()->getLocale() == 'en')
                                <div class="text fsz-18 color-777 mb-30">
                                    Elkomy currency exchange activity started started in the late seventies by opening
                                    their
                                    office which was located in downtown Cairo, offering all the exchange services.<br>
                                    Elkomy Exchange company covers and exchanges a wide range of currencies to make it
                                    easier for our customer to exchange their money.<br>
                                    Our objective is to expand our company’s branches all over Egypt, letting our customers
                                    experience outstanding service.


                                </div>
                            @else
                                <div class="text fsz-18 color-777 mb-30">
                                    ببدأت الكومي القابضة نشاطها في تدول العملات في اواخر السبعينات. تقدم الكومي للصرافة جميع
                                    خدمات تداول العملات الاجنبية, حيث يوجد مقر الشركة في وسط البلد بالقاهرة.<br>
                                    تقوم الكومي بتغيير اكبر عدد من العملات الاجنبية لنسهل علي جميع عملائنا عملية
                                    التداول.<br>
                                    اهم اهدافنا ان تنتشر فروع الكومي للصرافة في جميع انحاء مصر و ان نكسب رضا جميع عملائنا من
                                    خلال تقديم خدمات متميزة.


                                </div>
                            @endif



                            <div class="vision-card mb-70 overflow-hidden">
                                <div class="row align-items-center gx-5">
                                    <div class="col-lg-5">
                                        <div class="img img-cover th-350 radius-3 overflow-hidden">
                                            <img src="{{ asset('/assets/img/elkomy/c1.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="info mt-4 mt-lg-0">
                                            <h5 class="fsz-24 mb-30">{{ __('Mission & Vision') }}</h5>


                                            <h6>{{ __('Mission') }}</h6>

                                            <p class="fsz-18 color-777 fw-400">
                                                {{ __('To facilitate our customers’ access to international money.') }}
                                            </p>
                                            <h6>{{ __('Vision') }}</h6>

                                            <p class="fsz-18 color-777 fw-400">
                                                {{ __('To be the most trusted money changer in our society.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text fsz-18 mb-50">
                                <h2 class="mt-3">{{ __('Our Objectives') }}</h2>


                                <ul class="mt-3">
                                    <li class="mb-2">



                                        <span class="fsz-14">
                                            <span class="fw-bold gold">{{ __('1- ') }}</span>
                                            {{ __('To be digital oriented currency exchange company.') }}</span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('2- ') }}</span>
                                            {{ __('Develop and innovate new methods in the currency exchange world.') }}
                                        </span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('3- ') }}</span>
                                            {{ __('Expand our company’s branches all over Egypt.') }}
                                        </span>
                                    </li>
                                </ul>
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




    </main>
    <!--End-Contents-->
@endsection
