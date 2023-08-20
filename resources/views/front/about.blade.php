@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('About Elkomy') }} </h1>
            </div>
            <p class="fsz-18 mt-30 text-white op-6">{{ __('We are building tomorrow') }}</p>
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.about') }}" class="active gold"> {{ __('About Elkomy') }} </a>
        </div>
    </header>
    <!-- end header -->




    <!--Contents-->
    <main>


        <!-- start partners -->
        <section class="tc-page-about-cards">
            <div class="container">
                <div class="cards">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="img img-cover">
                                <img src="{{ asset('/assets/img/elkomy/about1.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="img img-cover">
                                <img src="{{ asset('/assets/img/elkomy/about2.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="cont">
                                <div class="logo">
                                    <img src="{{ asset('/assets/img/elkomy/elkomy-logo.png') }}" alt="">
                                </div>
                                <div class="text">
                                    {{ __('In the late 1970s, Elkomy holding was founded by opening its own currency exchange agency. In 1995, Elkomy decided to start another professional business by opening the Suez iron factory at Suez Industrial Zone. Our success didn’t stop here; Elkomy continued to move forward and entered the real estate market, conquering it by constructing, developing, and investing in several real estate projects since 2002. And now, joining the education sector, contributing with our expertise and global vision to build a new well-educated generation. Elkomy aims to spread strength, quality, and innovation to contribute to building the future.') }}
                                </div>
                                <div class="btns">
                                    <div class="button_su shadow-lg radius-3 me-3">
                                        <span class="su_button_circle bg-000 desplode-circle"></span>
                                        <a href="{{ route('front.contact') }}"
                                            class="butn py-2 px-4 button_su_inner bg-blue3 radius-3 b-gold">
                                            <span class="button_text_container fsz-13 fw-bold text-capitalize text-white">
                                                {{ __('Contact us') }} </span>
                                        </a>
                                    </div>
                                    {{-- <div class="button_su shadow-lg radius-3">
                                        <span class="su_button_circle bg-light1 desplode-circle"></span>
                                        <a href="#" class="butn py-2 px-4 button_su_inner bg-fff radius-3">
                                            <span class="button_text_container fsz-13 fw-bold text-capitalize color-000">
                                                Our Clients </span>
                                        </a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{ asset('/assets/img/elkomy/lines_circle.png') }}" alt="" class="lines">
        </section>
        <!-- end partners -->


        <!-- start tc-page-about-clients -->
        {{-- <section class="tc-page-about-clients">
            <div class="container">
                <div class="logos">
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/1.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/2.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/3.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/4.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/5.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/6.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/7.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/8.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/9.png" alt="">
                    </a>
                    <a href="#" class="logo">
                        <img src="assets/img/about_logos/10.png" alt="">
                    </a>
                </div>
            </div>
        </section> --}}
        <!-- end tc-page-about-clients -->


        <!-- start tc-page-about-timeline -->
        <section class="tc-page-about-timeline">
            <div class="container">
                <div class="section-title section-title-style24 text-center mb-50">
                    <h6> <img src="{{ asset('/assets/img/elkomy/logo_mark_bl3.png') }}" alt="" class="icon-10">
                        <span class="mx-2 black">
                            history </span> <img src="{{ asset('/assets/img/elkomy/logo_mark_bl3.png') }}" alt=""
                            class="icon-10">
                    </h6>
                    <h2> Our Own <span class="gold"> Journey </span> </h2>
                </div>
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="year-item mt-30">
                                <p class="year color-blue3 mb-15 fw-500 black"> 2000 </p>
                                <span class="icon-15 mb-40"> <img src="{{ asset('/assets/img/elkomy/logo_mark_bl3.png') }}"
                                        alt="">
                                </span>
                                <h6 class="fsz-20 mb-20"> Building <br> The Future Cities </h6>
                                <div class="text color-777"> Urban design draws together the many strands of place-making,
                                    environmental stewardship, social equity and economic </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="year-item mt-30">
                                <p class="year color-blue3 mb-15 fw-500 black"> 2010 </p>
                                <span class="icon-15 mb-40"> <img src="{{ asset('/assets/img/elkomy/logo_mark_bl3.png') }}"
                                        alt="">
                                </span>
                                <h6 class="fsz-20 mb-20"> Influential <br> & Impactful Design </h6>
                                <div class="text color-777"> Urban design draws together the many strands of place-making,
                                    environmental stewardship, social equity and economic </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="year-item mt-30">
                                <p class="year color-blue3 mb-15 fw-500 black"> 2015 </p>
                                <span class="icon-15 mb-40"> <img src="{{ asset('/assets/img/elkomy/logo_mark_bl3.png') }}"
                                        alt="">
                                </span>
                                <h6 class="fsz-20 mb-20"> Award <br> Winning Architecture </h6>
                                <div class="text color-777"> Urban design draws together the many strands of place-making,
                                    environmental stewardship, social equity and economic </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="year-item mt-30">
                                <p class="year color-blue3 mb-15 fw-500 black"> 2023 </p>
                                <span class="icon-15 mb-40"> <img src="{{ asset('/assets/img/elkomy/logo_mark_bl3.png') }}"
                                        alt="">
                                </span>
                                <h6 class="fsz-20 mb-20"> Urban <br> Design Draws Together </h6>
                                <div class="text color-777 fsz-14"> Urban design draws together the many strands of
                                    place-making, environmental stewardship, social equity and economic </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end tc-page-about-timeline -->


        <!-- start tc-page-about-numbers -->
        <section class="tc-page-about-numbers mb-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="number-card">
                            <h2> 12k </h2>
                            <p> Happy User <br> Around World </p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="number-card">
                            <h2> 50k </h2>
                            <p> Projects <br> Already Done </p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="number-card">
                            <h2> 20+ </h2>
                            <p> Worldwide <br> Offline Office </p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="number-card">
                            <h2> 10+ </h2>
                            <p> HProduct <br> Under Progress </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end tc-page-about-numbers -->


        <!-- start tc-testimonials-style24 -->
        {{-- <section class="tc-testimonials-style24">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="content wow fadeInUp">
                            <div class="icon">
                                <img src="assets/img/testi_icon.png" alt="">
                            </div>
                            <div class="testimonials-main-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="main-text">
                                            “ User feedback is qualitative and quantitative data from customers on like,
                                            dislike, impression, & requests about a product. Collecting & making sense of
                                            user feedback is critical for businesses. ”
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="main-text">
                                            “ User feedback is qualitative and quantitative data from customers on like,
                                            dislike, impression, & requests about a product. Collecting & making sense of
                                            user feedback is critical for businesses. ”
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="main-text">
                                            “ User feedback is qualitative and quantitative data from customers on like,
                                            dislike, impression, & requests about a product. Collecting & making sense of
                                            user feedback is critical for businesses. ”
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="main-text">
                                            “ User feedback is qualitative and quantitative data from customers on like,
                                            dislike, impression, & requests about a product. Collecting & making sense of
                                            user feedback is critical for businesses. ”
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="main-text">
                                            “ User feedback is qualitative and quantitative data from customers on like,
                                            dislike, impression, & requests about a product. Collecting & making sense of
                                            user feedback is critical for businesses. ”
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonials-sub-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="client-card d-flex align-items-center">
                                            <div
                                                class="img icon-85 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                <img src="assets/img/testi_cl1.jpg" alt="">
                                            </div>
                                            <div class="inf">
                                                <h6 class="color-orange3 text-uppercase fsz-12"> founder of pablo co </h6>
                                                <h4 class="fsz-20 text-capitalize fw-bold"> Pablo D. Scoberix </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="client-card d-flex align-items-center">
                                            <div
                                                class="img icon-85 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                <img src="assets/img/testi_cl2.jpg" alt="">
                                            </div>
                                            <div class="inf">
                                                <h6 class="color-orange3 text-uppercase fsz-12"> founder of pablo co </h6>
                                                <h4 class="fsz-20 text-capitalize fw-bold"> Rosalina D. William </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="client-card d-flex align-items-center">
                                            <div
                                                class="img icon-85 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                <img src="assets/img/testi_cl3.jpg" alt="">
                                            </div>
                                            <div class="inf">
                                                <h6 class="color-orange3 text-uppercase fsz-12"> founder of pablo co </h6>
                                                <h4 class="fsz-20 text-capitalize fw-bold"> Miranda H. Halim </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="client-card d-flex align-items-center">
                                            <div
                                                class="img icon-85 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                <img src="assets/img/testi_cl4.jpg" alt="">
                                            </div>
                                            <div class="inf">
                                                <h6 class="color-orange3 text-uppercase fsz-12"> founder of pablo co </h6>
                                                <h4 class="fsz-20 text-capitalize fw-bold"> Pablo D. Scoberix </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="client-card d-flex align-items-center">
                                            <div
                                                class="img icon-85 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                <img src="assets/img/testi_cl3.jpg" alt="">
                                            </div>
                                            <div class="inf">
                                                <h6 class="color-orange3 text-uppercase fsz-12"> founder of pablo co </h6>
                                                <h4 class="fsz-20 text-capitalize fw-bold"> Miranda H. Halim </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stars wow fadeInRight" data-wow-delay="0.1s">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <span class="float-text wow fadeInUp" data-wow-delay="0.1s"> Testimonials </span>
        </section> --}}
        <!-- end tc-testimonials-style24 -->


        <!-- start tc-blog-style24 -->
        {{-- <section class="tc-blog-style24">
            <div class="container">
                <div class="section-title section-title-style24 text-center mb-50">
                    <h6> <img src="assets/img/logo_mark_bl3.png" alt="" class="icon-10"> <span class="mx-2">
                            insights </span> <img src="assets/img/logo_mark_bl3.png" alt="" class="icon-10">
                    </h6>
                    <h2> Company <span> Blog <small class="mirror_1"> Blog </small> <small class="mirror_2"> Blog </small>
                        </span> </h2>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="blog-card">
                                <div class="main-img img-cover">
                                    <img src="assets/img/blog/1.jpg" alt="">
                                </div>
                                <div class="info">
                                    <div class="date mb-10"> <a href="#" class="text-uppercase color-blue3"> design
                                        </a> <img src="assets/img/logo_mark_bl3.png" alt="" class="icon-10 mx-2">
                                        <a href="#"> March 20, 2023 </a>
                                    </div>
                                    <h6> <a href="#" class="fsz-20 hover-red2 mb-30 fw-bold lh-4"> Talk magazine is
                                            the best global business magazine... </a> </h6>
                                    <div class="row align-items-center">
                                        <div class="col-10">
                                            <div class="author d-flex align-items-center">
                                                <div
                                                    class="img icon-50 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                    <img src="assets/img/testi_cl2.jpg" alt="">
                                                </div>
                                                <div class="inf">
                                                    <h6 class="color-999 text-uppercase fsz-12 mb-1"> Posted By </h6>
                                                    <h4 class="fsz-16 text-capitalize fw-bold"> <a href="#"> Miranda
                                                            H. Halim </a> </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-lg-end">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <i class="far fa-heart"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="blog-card">
                                <div class="main-img img-cover">
                                    <img src="assets/img/blog/2.jpg" alt="">
                                </div>
                                <div class="info">
                                    <div class="date mb-10"> <a href="#" class="text-uppercase color-blue3"> agency
                                        </a> <img src="assets/img/logo_mark_bl3.png" alt="" class="icon-10 mx-2">
                                        <a href="#"> March 20, 2023 </a>
                                    </div>
                                    <h6> <a href="#" class="fsz-20 hover-red2 mb-30 fw-bold lh-4"> Content is the
                                            info contained with in communication media... </a> </h6>
                                    <div class="row align-items-center">
                                        <div class="col-10">
                                            <div class="author d-flex align-items-center">
                                                <div
                                                    class="img icon-50 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                    <img src="assets/img/testi_cl3.jpg" alt="">
                                                </div>
                                                <div class="inf">
                                                    <h6 class="color-999 text-uppercase fsz-12 mb-1"> Posted By </h6>
                                                    <h4 class="fsz-16 text-capitalize fw-bold"> <a href="#">
                                                            Rosalina D. William </a> </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-lg-end">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <i class="far fa-heart"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="blog-card">
                                <div class="main-img img-cover">
                                    <img src="assets/img/blog/3.jpg" alt="">
                                </div>
                                <div class="info">
                                    <div class="date mb-10"> <a href="#" class="text-uppercase color-blue3">
                                            business </a> <img src="assets/img/logo_mark_bl3.png" alt=""
                                            class="icon-10 mx-2"> <a href="#"> March 20, 2023 </a> </div>
                                    <h6> <a href="#" class="fsz-20 hover-red2 mb-30 fw-bold lh-4"> It’s directed at
                                            an end-user or audience in the sectors... </a> </h6>
                                    <div class="row align-items-center">
                                        <div class="col-10">
                                            <div class="author d-flex align-items-center">
                                                <div
                                                    class="img icon-50 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
                                                    <img src="assets/img/testi_cl1.jpg" alt="">
                                                </div>
                                                <div class="inf">
                                                    <h6 class="color-999 text-uppercase fsz-12 mb-1"> Posted By </h6>
                                                    <h4 class="fsz-16 text-capitalize fw-bold"> <a href="#"> Miranda
                                                            H. Halim </a> </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-lg-end">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <i class="far fa-heart"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- end tc-blog-style24 -->


        <!-- start tc-page-about-request -->
        {{-- <div class="tc-page-about-request">
            <div class="container">
                <div class="request-card text-center text-lg-start">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="info">
                                <div class="icon d-none d-lg-block">
                                    <img src="assets/img/logo_mark_wh.png" alt="">
                                </div>
                                <h3 class="fsz-35"> Comprehensive Enterprise <br> Services & Support </h3>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                            <div class="button_su shadow-lg radius-3">
                                <span class="su_button_circle bg-light1 desplode-circle"></span>
                                <a href="#" class="butn py-2 px-4 button_su_inner bg-fff radius-3">
                                    <span class="button_text_container fsz-13 fw-bold text-capitalize color-000"> <img
                                            src="assets/img/logo_mark_bl3.png" alt="" class="icon-10 me-2"> Make
                                        A Request </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- end tc-page-about-request -->



    </main>
    <!--End-Contents-->
@endsection
