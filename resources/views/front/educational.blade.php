@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('Educational services') }} </h1>
            </div>
            {{-- <p class="fsz-18 mt-30 text-white op-6"> Ensuring the best return on investment for your bespoke <br> SEO
                campaign requirement. </p> --}}
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.steel') }}" class="active gold"> {{ __('Educational services') }} </a>
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
                                <img src="{{ asset('/assets/img/elkomy/main_img.jpg') }}" alt="">
                            </div>

                            @if (app()->getLocale() == 'en')
                                <div class="text fsz-18 color-777 mb-30">
                                    Our aim in elkomy holding is to build a promising future therefor elkomy is joining the
                                    education sector by having national and international schools under construction.

                                    <h3 class="m-2">Why elkomy is joining the education sector?</h3>

                                    We are joining the education sector to develop well-rounded and thoughtful students
                                    prepared to cope with a rapidly changing and globalized world. <br> Instilling them
                                    lifelong
                                    learning, critical thinking and ethics using the modern and innovative educational
                                    methods.

                                </div>
                            @else
                                <div class="text fsz-18 color-777 mb-30">
                                    هدفنا في مجموعة الكومي هو بناء مستقبل واعد لذا، تنضم مجموعة الكومي إلى القطاع التعليمي
                                    من خلال مدرستين دولية و الاخري رسمية, تحت الإنشاء الان.

                                    <h3 class="m-2">لماذا القطاع التعليمي؟ </h3>

                                    نحن نهدف من خلال نشاطنا التعليمي ان نخلق جيل جديد متعلم ومنفتح, جيل علي استعداد لمواكبة
                                    تغييرات العالم السريعة.وايضا لنغرس فيهم حب التعلم مدى الحياة والتفكير النقدي و التمسك
                                    بالأخلاق الحميدة باستخدام اساليب تربوية إبداعية و حديثة.


                                </div>
                            @endif



                            <div class="vision-card mb-70 overflow-hidden">
                                <div class="row align-items-center gx-5">
                                    <div class="col-lg-5">
                                        <div class="img img-cover th-350 radius-3 overflow-hidden">
                                            <img src="{{ asset('/assets/img/elkomy/vision.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="info mt-4 mt-lg-0">
                                            <h5 class="fsz-24 mb-30">{{ __('mission & vission') }}</h5>


                                            <h6>{{ __('Mission') }}</h6>

                                            <p class="fsz-18 color-777 fw-400">
                                                {{ __('we strive to offer comprehensive and balanced educational programs that enable our students to reach and expand their potential.') }}
                                            </p>
                                            <h6>{{ __('Vision') }}</h6>

                                            <p class="fsz-18 color-777 fw-400">
                                                {{ __('serve our society through productive, responsible, ethical, creative citizens.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text fsz-18 mb-50">
                                <h2 class="mt-3">{{ __('Our Values') }}</h2>


                                <ul class="mt-3">
                                    <li class="mb-2">
                                        <span class="fsz-14">
                                            <span class="fw-bold gold">{{ __('Knowledge:') }}</span>
                                            {{ __('Cultivating knowledge in every student.') }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Concern:') }}</span>
                                            {{ __('Our concern is to provide a healthy and respectful environment to our students.') }}
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Citizenship:') }}</span>
                                            {{ __('Instill our country’s love and respect in the upcoming generations.') }}
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Modernity:') }}</span>
                                            {{ __('Having a global perspective, using modern and innovative educational system.') }}
                                        </span>
                                    </li>

                                    <li class="mb-2">
                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Responsive:') }}</span>
                                            {{ __('Continual enhancements to our educational system.') }}
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
