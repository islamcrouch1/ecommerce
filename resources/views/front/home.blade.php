@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->

    <header class="tc-header-style39">
        <div style="z-index: 0" class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="info wow fadeInUp slow" data-wow-delay="0.5s">
                        <h1>{{ __('Elkomy Group') }}</h1>
                        <h3 class="gold">{{ __('We are building tomorrow') }}</h3>

                        <ul>
                            <li>
                                <p>{{ __('A leading company in several fields.') }}
                                </p>
                            </li>
                            <li>
                                <p>{{ __('Steel manufacturing, real estate, education and currency exchange specialized.') }}
                                </p>
                            </li>
                            <li>
                                <p>{{ __('Credibility, quality, innovation are our major priorities.') }}
                                </p>
                            </li>
                        </ul>


                        <div class="button_su rounded-0 border-1 border-white mt-50">
                            <span class="su_button_circle bg-000 desplode-circle"></span>
                            <a href="{{ route('front.about') }}"
                                class="butn py-3 button_su_inner bg-transparent m-0 rounded-0">
                                <span
                                    class="button_text_container fsz-14 fw-bold text-uppercase text-white">{{ __('read more') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wow fadeInUp slow m-2">


                        <div id="home-carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('/assets/img/elkomy/slide1.png') }}" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('/assets/img/elkomy/slide2.png') }}" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('/assets/img/elkomy/slide3.png') }}" class="d-block w-100"
                                        alt="...">
                                </div>
                            </div>
                        </div>

                        {{-- <img src="{{ asset('/assets/img/test1.jpg') }}" alt=""> --}}
                        {{-- <div class="circle-text" data-wow-delay="0.1s">
                            <div class="rotate-circle fsz-40 rotate-text d-inline-block">
                                <svg class="textcircle" viewBox="0 0 500 500">
                                    <defs>
                                        <path id="textcircle" d="M250,400 a150,150 0 0,1 0,-300a150,150 0 0,1 0,300Z">
                                        </path>
                                    </defs>
                                    <text>
                                        <textPath xlink:href="#textcircle" textLength="900"> HIRE US FOR GREAT PRODUCT
                                        </textPath>
                                    </text>
                                </svg>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->





    <!--Contents-->
    <main>


        <!-- start services -->
        <section class="tc-services-style39">
            <h2> {{ __('Businesses') }} </h2>
            <div class="container">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="service-card mb-3 mb-lg-0 wow fadeInUp slow">
                                <div class="icon img-contain">
                                    <img src="{{ asset('assets/img/elkomy/icon1.png') }}" alt="">
                                </div>
                                <div class="info">
                                    <h6> {{ __('Steel manufacturing') }} </h6>
                                    <p> {{ __('The Suez iron factory was founded on July 25, 1995, at Suez Industrial Zone, in a 95,00 metres square area with a total capital of 50 million EGP.') }}
                                    </p>
                                    <div class="link">
                                        <a href="{{ route('front.steel') }}"> {{ __('read more') }} <i
                                                class="fas fa-chevron-right ms-2 fsz-12"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="service-card mb-3 mb-lg-0 wow fadeInUp slow">
                                <div class="icon img-contain">
                                    <img src="{{ asset('assets/img/elkomy/icon2.png') }}" alt="">
                                </div>
                                <div class="info">
                                    <h6> {{ __('Real estate investments') }} </h6>
                                    <p> {{ __('Elkomy holding’s activity in real state started in 2002. Our company works in several fields of real estate from construction, contracting, developing to real estate and industrial investment.') }}
                                    </p>
                                    <div class="link">
                                        <a href="{{ route('front.real') }}"> {{ __('read more') }} <i
                                                class="fas fa-chevron-right ms-2 fsz-12"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div class="service-card mb-3 mb-lg-0 wow fadeInUp slow">
                                <div class="icon img-contain">
                                    <img src="{{ asset('assets/img/elkomy/icon3.png') }}" alt="">
                                </div>
                                <div class="info">
                                    <h6> {{ __('Currency Exchange') }} </h6>
                                    <p> {{ __('Our currency exchange agency was founded in the late seventies.') }}
                                    </p>
                                    <div class="link">
                                        <a href="{{ route('front.currency') }}"> {{ __('read more') }} <i
                                                class="fas fa-chevron-right ms-2 fsz-12"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="service-card mb-3 mb-lg-0 wow fadeInUp slow">
                                <div class="icon img-contain">
                                    <img src="{{ asset('assets/img/elkomy/icon4.png') }}" alt="">
                                </div>
                                <div class="info">
                                    <h6> {{ __('Educational services') }} </h6>
                                    <p> {{ __('Our aim in elkomy holding is to build a promising future therefor elkomy is joining the education sector by having national and international schools under construction.') }}
                                    </p>
                                    <div class="link">
                                        <a href="{{ route('front.educational') }}"> {{ __('read more') }} <i
                                                class="fas fa-chevron-right ms-2 fsz-12"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </section>
        <!-- end services -->


        <!-- start about -->
        <section class="tc-chooseUs-style39">
            <div class="container">
                <div class="choose-card">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="img mb-5 mb-lg-0 wow zoomIn slow">
                                <img src="{{ asset('assets/img/elkomy/logo-circle.png') }}" alt=""
                                    class="main-img">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="info wow fadeInUp slow" data-wow-delay="0.2s">
                                <h6> {{ __('Why Choose Us!') }} </h6>
                                <h2> {{ __('Elkomy Holding') }} </h2>



                                <div class="inf-card">
                                    <div class="icon">
                                        <img style="width:60px" src="{{ asset('assets/img/elkomy/icon7.png') }}"
                                            alt="">
                                    </div>
                                    <div class="inf">
                                        <h5> {{ __('We provide quality.') }} </h5>
                                        {{-- <p> Whether you are looking for a custom </p> --}}
                                    </div>
                                </div>
                                <div class="inf-card">
                                    <div class="icon">
                                        <img style="width:60px" src="{{ asset('assets/img/elkomy/icon6.png') }}"
                                            alt="">
                                    </div>
                                    <div class="inf">
                                        <h5> {{ __('Commitment is our priority.') }} </h5>
                                    </div>
                                </div>
                                <div class="inf-card">
                                    <div class="icon">
                                        <img style="width:60px" src="{{ asset('assets/img/elkomy/icon5.png') }}"
                                            alt="">
                                    </div>
                                    <div class="inf">
                                        <h5> {{ __('Innovation and Hi-tech oriented.') }} </h5>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end about -->


        <!-- start partners -->
        {{-- <section class="tc-partners-style39">
            <div class="container">
                <div class="content">
                    <h6 class="fsz-14 fw-bold ltspc-1 text-uppercase pb-30 border-bottom brd-gray color-blue6"> trusted by
                        2000+ clients </h6>
                    <div class="logos">
                        <a href="#" class="logo wow fadeInUp slow">
                            <div class="img">
                                <img src="assets/img/partners/1.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow" data-wow-delay="0.2s">
                            <div class="img">
                                <img src="assets/img/partners/2.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow" data-wow-delay="0.4s">
                            <div class="img">
                                <img src="assets/img/partners/3.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow" data-wow-delay="0.6s">
                            <div class="img">
                                <img src="assets/img/partners/4.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow" data-wow-delay="0.6s">
                            <div class="img">
                                <img src="assets/img/partners/5.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow">
                            <div class="img">
                                <img src="assets/img/partners/6.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow" data-wow-delay="0.2s">
                            <div class="img">
                                <img src="assets/img/partners/7.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow" data-wow-delay="0.4s">
                            <div class="img">
                                <img src="assets/img/partners/8.png" alt="">
                            </div>
                        </a>
                        <a href="#" class="logo wow fadeInUp slow" data-wow-delay="0.6s">
                            <div class="img">
                                <img src="assets/img/partners/9.png" alt="">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- end partners -->


        <!-- start projects -->
        <section class="tc-projects-style39">
            <div class="container-fluid p-0">
                <div class="content">
                    <div class="info wow fadeInUp slow">
                        <h2 class="float-title"> Portfolio </h2>
                        <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase"> portfolio </h6>
                        <h3 class="fsz-50"> What We Did Already </h3>
                        <div class="arrows">
                            <a href="#0" class="swiper-prev"> <i
                                    class="fal fa-long-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                            </a>
                            <a href="#0" class="swiper-next"> <i
                                    class="fal fa-long-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                            </a>
                        </div>
                    </div>
                    <div class="tc-projects-slider39 wow fadeInUp slow" data-wow-delay="0.5s">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="project-card">
                                    <div class="img img-cover">
                                        <img src="{{ asset('assets/img/projects/1.jpg') }}" alt="">
                                    </div>
                                    <div class="inf pt-40">
                                        <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-10"> software </h6>
                                        <h5 class="fsz-24 fw-bold"> <a href="#" class="hover-underLine"> Yokoli App
                                                Development </a> </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="project-card">
                                    <div class="img img-cover">
                                        <img src="{{ asset('assets/img/projects/2.jpg') }}" alt="">
                                    </div>
                                    <div class="inf pt-40">
                                        <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-10"> app, ux </h6>
                                        <h5 class="fsz-24 fw-bold"> <a href="#" class="hover-underLine"> Mikando
                                                Website Design </a> </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="project-card">
                                    <div class="img img-cover">
                                        <img src="{{ asset('assets/img/projects/3.jpg') }}" alt="">
                                    </div>
                                    <div class="inf pt-40">
                                        <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-10"> design </h6>
                                        <h5 class="fsz-24 fw-bold"> <a href="#" class="hover-underLine"> Humble
                                                Game Design </a> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end projects -->


        <!-- Start video -->
        <section class="tc-video-style39">
            <div class="img">
                <img src="{{ asset('assets/img/video.png') }}" alt="">
                <a href="https://www.youtube.com/watch?v=pGbIOC83-So&t=21s" class="play-btn wow zoomIn slow"
                    data-lity=""> play </a>
            </div>
        </section>
        <!-- End video -->


        <!-- Start testimonials -->
        {{-- <section class="tc-testimonials-style39">
            <div class="container">
                <div class="content wow fadeInUp slow">
                    <div class="icon icon-80 mx-auto">
                        <img src="{{ asset('assets/img/tisti_icon.png') }}" alt="">
                    </div>
                    <div class="tc-testimonials-slider39">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="testi-top">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="testi-comment text-center">
                                                <h4 class="fsz-30 fw-500 lh-4"> “ User feedback is qualitative and
                                                    quantitative data from customers on like, dislike, impression, &
                                                    requests about a product. Collecting & making sense of user feedback is
                                                    critical for businesses. ” </h4>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testi-comment text-center">
                                                <h4 class="fsz-30 fw-500 lh-4"> “ User feedback is qualitative and
                                                    quantitative data from customers on like, dislike, impression, &
                                                    requests about a product. Collecting & making sense of user feedback is
                                                    critical for businesses. ” </h4>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testi-comment text-center">
                                                <h4 class="fsz-30 fw-500 lh-4"> “ User feedback is qualitative and
                                                    quantitative data from customers on like, dislike, impression, &
                                                    requests about a product. Collecting & making sense of user feedback is
                                                    critical for businesses. ” </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="testi-btm border-top brd-gray">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="item-card d-flex align-items-center pt-40">
                                                <div
                                                    class="img icon-80 img-cover overflow-hidden rounded-circle me-20 flex-shrink-0">
                                                    <img src="{{ asset('assets/img/testi_cl1.jpg') }}" alt="">
                                                </div>
                                                <div class="inf">
                                                    <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-10"> founder of
                                                        will ltd. </h6>
                                                    <h4 class="fsz-22"> Rosalina D. William </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="item-card d-flex align-items-center pt-40">
                                                <div
                                                    class="img icon-80 img-cover overflow-hidden rounded-circle me-20 flex-shrink-0">
                                                    <img src="{{ asset('assets/img/testi_cl2.jpg') }}" alt="">
                                                </div>
                                                <div class="inf">
                                                    <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-10"> founder of
                                                        pablo </h6>
                                                    <h4 class="fsz-22"> Pablo D. Scoberix </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="item-card d-flex align-items-center pt-40">
                                                <div
                                                    class="img icon-80 img-cover overflow-hidden rounded-circle me-20 flex-shrink-0">
                                                    <img src="{{ asset('assets/img/testi_cl3.jpg') }}" alt="">
                                                </div>
                                                <div class="inf">
                                                    <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-10"> founder of
                                                        halim </h6>
                                                    <h4 class="fsz-22"> Miranda H. Halim </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="arrows">
                            <a href="#" class="swiper-prev"> <i
                                    class="fal fa-long-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                            </a>
                            <a href="#" class="swiper-next"> <i
                                    class="fal fa-long-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                            </a>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- End testimonials -->



        <!-- Start blog -->
        <section class="tc-blog-style39">
            <h2 class="float-title"> Insights </h2>
            <div class="container">
                <div class="title text-center mb-60 wow fadeInUp slow">
                    <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase"> insights </h6>
                    <h3 class="fsz-50"> Blog & Insights </h3>
                </div>
                <div class="row gx-0 wow fadeInUp slow" data-wow-delay="0.2s">
                    <div class="col-lg-4">
                        <div class="blog-card">
                            <div class="img img-cover">
                                <img src="{{ asset('assets/img/blog/1.png') }}" alt="">
                            </div>
                            <div class="info">
                                <div class="cont">
                                    <div class="date text-uppercase mb-15 fsz-14 "> <span class="me-30"> corporate
                                        </span> <a href="#"> jan 21, 2023 </a> </div>
                                    <h6 class="fsz-20 fw-500 lh-4"> <a href="../page-single-post-3.html"> iteck IT allows
                                            your business and technology </a> </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog-card">
                            <div class="img img-cover">
                                <img src="{{ asset('assets/img/blog/2.png') }}" alt="">
                            </div>
                            <div class="info">
                                <div class="cont">
                                    <div class="date text-uppercase mb-15 fsz-14 "> <span class="me-30"> business </span>
                                        <a href="#"> feb 08, 2023 </a>
                                    </div>
                                    <h6 class="fsz-20 fw-500 lh-4"> <a href="../page-single-post-3.html"> Schedule a
                                            meeting to take your business </a> </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog-card">
                            <div class="img img-cover">
                                <img src="{{ asset('assets/img/blog/3.png') }}" alt="">
                            </div>
                            <div class="info">
                                <div class="cont">
                                    <div class="date text-uppercase mb-15 fsz-14 "> <span class="me-30"> corporate
                                        </span> <a href="#"> mar 01, 2023 </a> </div>
                                    <h6 class="fsz-20 fw-500 lh-4"> <a href="../page-single-post-3.html"> Highly flexible,
                                            adaptable, and scalable projects </a> </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End blog -->


    </main>
    <!--End-Contents-->
@endsection
