@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('Strategy') }} </h1>
            </div>
            {{-- <p class="fsz-18 mt-30 text-white op-6"> Ensuring the best return on investment for your bespoke <br> SEO
                campaign requirement. </p> --}}
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.strategy') }}" class="active gold"> {{ __('Our Strategy') }} </a>
        </div>
    </header>
    <!-- end header -->


    <!--Contents-->
    <main>


        <!-- start partners -->
        {{-- <section class="tc-page-faq">
            <div class="container">
                <div class="row">
                    <div class="col-lg-11">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        {{ __('Mission') }}
                                    </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="text fsz-16 color-777">
                                            {{ __('To provide high quality products and services by engaging innovative technologies, global business standers, adding value to everything we do.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading2">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                        {{ __('Vision') }}
                                    </button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="heading2"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="text fsz-16 color-777">
                                            {{ __('Conquer more and more markets, providing quality, and innovation.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading3">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                        {{ __('Our Values') }}
                                    </button>
                                </h2>
                                <div id="collapse3" class="accordion-collapse collapse show" aria-labelledby="heading3"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="text fsz-16 color-777">
                                            {{ __('Quality: Our aim is not just to deliver quality but to exceed expectations.') }}
                                            <br>
                                            {{ __('Integrity: Transparency and integrity in with our clients.') }} <br>
                                            {{ __('Agility: Always committed with resilience, we are able to adapt fast and keep up with the world’s changes.') }}
                                            <br>
                                            {{ __('Courage: Our team is always ready to face new challenges.') }} <br>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </section> --}}
        <!-- end partners -->


        <!-- start tc-services-text-style26 -->
        <section class="tc-about-style26">
            <div class="container">
                <div class="top-info wow fadeInUp slow">
                    <div class="row">
                        <div class="col-lg-7">
                            <h2 class=""> {{ __('Our Strategy') }}
                            </h2>
                            <div class="btns d-lg-flex align-items-center">
                                <div class="button_su rounded-0">
                                    <span class="su_button_circle bg-000 desplode-circle"></span>
                                    <a href="{{ route('front.about') }}"
                                        class="butn py-2 button_su_inner m-0 rounded-0 bg-blue4 lh-5 b-gold">
                                        <span class="button_text_container fsz-13 text-uppercase text-white fw-400 ltspc-1">
                                            {{ __('About Elkomy') }}
                                        </span>
                                    </a>
                                </div>
                                <p class="fsz-14 color-777 ms-lg-4 mt-4 mt-lg-0"> {{ __('Discover more about our') }} <br>
                                    {{ __('Elkomy Group') }} </p>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center mt-4 mt-lg-0 d-none d-lg-block">
                            <div class="circle-text">
                                <div style="direction: ltr !important"
                                    class="rotate-circle fsz-40 rotate-text d-inline-block">
                                    <svg class="textcircle" viewBox="0 0 500 500">
                                        <defs>
                                            <path id="textcircle" d="M250,400 a150,150 0 0,1 0,-300a150,150 0 0,1 0,300Z">
                                            </path>
                                        </defs>
                                        <text>
                                            <textPath xlink:href="#textcircle" textLength="900">
                                                We are building tomorrow
                                            </textPath>
                                        </text>
                                    </svg>
                                </div>
                                <img style="width: 80px; height:40px" src="{{ asset('/assets/img/elkomy/icon.png') }}"
                                    alt="" class="icon icon-25">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content wow fadeInUp slow">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="img mb-5 mb-lg-0 wow zoomIn slow">
                                <img style="width:85%" src="{{ asset('assets/img/elkomy/logo-circle.png') }}"
                                    alt="" class="main-img">
                            </div>
                        </div>
                        <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0 align-middle">
                            <div class="info mt-4">
                                <h6 class="fsz-14 text-uppercase color-blue4 mb-30 ltspc-1 gold">
                                    {{ __('mission & vission') }}
                                </h6>

                                <h6>{{ __('Mission') }}</h6>

                                <p class="fsz-18 color-777 fw-400">
                                    {{ __('To provide high quality products and services by engaging innovative technologies, global business standers, adding value to everything we do.') }}
                                </p>
                                <h6>{{ __('Vision') }}</h6>

                                <p class="fsz-18 color-777 fw-400">
                                    {{ __('Conquer more and more markets, providing quality, and innovation.') }}
                                </p>

                                <h6 class="mt-3">{{ __('Our Values') }}</h6>


                                <ul class="mt-3">
                                    <li class="mb-2">



                                        <span class="fsz-14">
                                            <span class="fw-bold gold">{{ __('Quality:') }}</span>
                                            {{ __('Our aim is not just to deliver quality but to exceed expectations.') }}</span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Integrity:') }}</span>
                                            {{ __('Transparency and integrity in with our clients.') }} </span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Agility:') }}</span>
                                            {{ __('Always committed with resilience, we are able to adapt fast and keep up with the world’s changes.') }}
                                        </span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Courage:') }}</span>
                                            {{ __('Our team is always ready to face new challenges.') }} </span>
                                    </li>

                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Accountability:') }}</span>
                                            {{ __('We take responsibility for all our actions, and we are always to be better.') }}
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end tc-services-text-style26 -->



    </main>
    <!--End-Contents-->
@endsection
