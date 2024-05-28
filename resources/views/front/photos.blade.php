@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('Photos') }} </h1>
            </div>
            {{-- <p class="fsz-18 mt-30 text-white op-6"> Ensuring the best return on investment for your bespoke <br> SEO
                campaign requirement. </p> --}}
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.photos') }}" class="active gold"> {{ __('Photos') }} </a>
        </div>
    </header>
    <!-- end header -->

    <!--Contents-->
    <main>


        <!-- start tc-portfolio-style25 -->
        <section class="tc-portfolio-style25">
            <div class="container">
                <div class="portfolio-tabs text-center wow fadeInUp">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#0" class="nav-link active" id="pills-prt1-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-prt1" type="button" role="tab" aria-controls="pills-prt1"
                                aria-selected="true">
                                {{ __('Steel manufacturing') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#0" class="nav-link" id="pills-prt2-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-prt2" type="button" role="tab" aria-controls="pills-prt2"
                                aria-selected="false">
                                {{ __('Real estate investments') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#0" class="nav-link" id="pills-prt3-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-prt3" type="button" role="tab" aria-controls="pills-prt3"
                                aria-selected="false">
                                {{ __('Currency Exchange') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#0" class="nav-link" id="pills-prt4-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-prt4" type="button" role="tab" aria-controls="pills-prt4"
                                aria-selected="false">
                                {{ __('Educational services') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="portfolio-content wow fadeInUp" data-wow-delay="0.2s">
                    <div class="tab-content" id="pills-tabContent">


                        <div class="tab-pane fade show active" id="pills-prt1" role="tabpanel"
                            aria-labelledby="pills-prt1-tab">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/steel/2.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Steel manufacturing') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/steel/3.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Steel manufacturing') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/steel/1.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Steel manufacturing') }}</a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/steel/4.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Steel manufacturing') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/steel/5.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Steel manufacturing') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/steel/6.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Steel manufacturing') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="text-center">
                                    <div class="button_su rounded-pill mt-80">
                                        <span class="su_button_circle bg-light1 desplode-circle"></span>
                                        <a href="#" class="butn pt-15 pb-15 button_su_inner m-0 rounded-pill lh-1">
                                            <span class="button_text_container fsz-13 fw-bold gold text-capitalize"> More Works
                                                <i class="far fa-plus ms-2"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>


                        <div class="tab-pane fade" id="pills-prt2" role="tabpanel" aria-labelledby="pills-prt2-tab">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/3.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Real estate investments') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/5.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a
                                                                href="#">{{ __('Real estate investments') }} </a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/8.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a
                                                                href="#">{{ __('Real estate investments') }} </a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/6.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Real estate investments') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/7.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Real estate investments') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/9.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Real estate investments') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/4.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a
                                                                href="#">{{ __('Real estate investments') }} </a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/1.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Real estate investments') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/real/2.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Real estate investments') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="text-center">
                                    <div class="button_su rounded-pill mt-80">
                                        <span class="su_button_circle bg-light1 desplode-circle"></span>
                                        <a href="#" class="butn pt-15 pb-15 button_su_inner m-0 rounded-pill lh-1">
                                            <span class="button_text_container fsz-13 fw-bold gold text-capitalize"> More Works
                                                <i class="far fa-plus ms-2"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-prt3" role="tabpanel" aria-labelledby="pills-prt3-tab">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/c/1.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Currency Exchange') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/c/3.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Currency Exchange') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/c/4.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Currency Exchange') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/c/2.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Currency Exchange') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="text-center">
                                    <div class="button_su rounded-pill mt-80">
                                        <span class="su_button_circle bg-light1 desplode-circle"></span>
                                        <a href="#" class="butn pt-15 pb-15 button_su_inner m-0 rounded-pill lh-1">
                                            <span class="button_text_container fsz-13 fw-bold gold text-capitalize"> More Works
                                                <i class="far fa-plus ms-2"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>



                        <div class="tab-pane fade" id="pills-prt4" role="tabpanel" aria-labelledby="pills-prt4-tab">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/edu/1.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Educational services') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/edu/4.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Educational services') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/edu/5.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Educational services') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/edu/6.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Educational services') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="portfolio-column">
                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/edu/2.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Educational services') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="portfolio-card">
                                                <div class="img">
                                                    <img src="{{ asset('/assets/img/elkomy/media/edu/7.jpg') }}"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('Educational services') }} </a> </h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- end tc-portfolio-style25 -->




    </main>
    <!--End-Contents-->
@endsection
