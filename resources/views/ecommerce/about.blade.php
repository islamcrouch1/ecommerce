@extends('layouts.ecommerce.app')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('About Us?') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('About Us?') }}</li>
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
                <div class="col-lg-12">
                    <div class="banner-section"><img src="{{ asset(websiteSettingMedia('about')) }}"
                            class="img-fluid blur-up lazyload" alt=""></div>
                </div>
                <div class="col-sm-12">
                    <h4>
                        {{ app()->getLocale() == 'ar' ? websiteSettingAr('about') : websiteSettingEn('about') }}
                    </h4>
                    <p>{!! app()->getLocale() == 'ar' ? websiteSettingDAr('about') : websiteSettingDEn('about') !!}
                    </p>

                </div>
            </div>
        </div>
    </section>
    <!-- about section end -->


    {{-- <!--Testimonial start-->
    <section class="testimonial small-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="slide-2 testimonial-slider no-arrow">
                        <div>
                            <div class="media">
                                <div class="text-center">
                                    <img src="../assets/images/avtar.jpg" alt="#">
                                    <h5>Mark Jecno</h5>
                                    <h6>Designer</h6>
                                </div>
                                <div class="media-body">
                                    <p>you how all this mistaken idea of denouncing pleasure and praising pain was born
                                        and I will give you a complete account of the system, and expound the actual
                                        teachings.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media">
                                <div class="text-center">
                                    <img src="../assets/images/2.jpg" alt="#">
                                    <h5>Mark Jecno</h5>
                                    <h6>Designer</h6>
                                </div>
                                <div class="media-body">
                                    <p>you how all this mistaken idea of denouncing pleasure and praising pain was born
                                        and I will give you a complete account of the system, and expound the actual
                                        teachings.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media">
                                <div class="text-center">
                                    <img src="../assets/images/avtar.jpg" alt="#">
                                    <h5>Mark Jecno</h5>
                                    <h6>Designer</h6>
                                </div>
                                <div class="media-body">
                                    <p>you how all this mistaken idea of denouncing pleasure and praising pain was born
                                        and I will give you a complete account of the system, and expound the actual
                                        teachings.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media">
                                <div class="text-center">
                                    <img src="../assets/images/avtar.jpg" alt="#">
                                    <h5>Mark Jecno</h5>
                                    <h6>Designer</h6>
                                </div>
                                <div class="media-body">
                                    <p>you how all this mistaken idea of denouncing pleasure and praising pain was born
                                        and I will give you a complete account of the system, and expound the actual
                                        teachings.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media">
                                <div class="text-center">
                                    <img src="../assets/images/avtar.jpg" alt="#">
                                    <h5>Mark Jecno</h5>
                                    <h6>Designer</h6>
                                </div>
                                <div class="media-body">
                                    <p>you how all this mistaken idea of denouncing pleasure and praising pain was born
                                        and I will give you a complete account of the system, and expound the actual
                                        teachings.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media">
                                <div class="text-center">
                                    <img src="../assets/images/avtar.jpg" alt="#">
                                    <h5>Mark Jecno</h5>
                                    <h6>Designer</h6>
                                </div>
                                <div class="media-body">
                                    <p>you how all this mistaken idea of denouncing pleasure and praising pain was born
                                        and I will give you a complete account of the system, and expound the actual
                                        teachings.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Testimonial ends-->


    <!--Team start-->
    <section id="team" class="team section-b-space slick-default-margin ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Our Team</h2>
                    <div class="team-4">
                        <div>
                            <div>
                                <img src="../assets/images/team/1.jpg" class="img-fluid blur-up lazyload bg-img"
                                    alt="">
                            </div>
                            <h4>Hileri Keol</h4>
                            <h6>CEo & Founder At Company</h6>
                        </div>
                        <div>
                            <div>
                                <img src="../assets/images/team/2.jpg" class="img-fluid blur-up lazyload bg-img"
                                    alt="">
                            </div>
                            <h4>Hileri Keol</h4>
                            <h6>CEo & Founder At Company</h6>
                        </div>
                        <div>
                            <div>
                                <img src="../assets/images/team/3.jpg" class="img-fluid blur-up lazyload bg-img"
                                    alt="">
                            </div>
                            <h4>Hileri Keol</h4>
                            <h6>CEo & Founder At Company</h6>
                        </div>
                        <div>
                            <div>
                                <img src="../assets/images/team/4.jpg" class="img-fluid blur-up lazyload bg-img"
                                    alt="">
                            </div>
                            <h4>Hileri Keol</h4>
                            <h6>CEo & Founder At Company</h6>
                        </div>
                        <div>
                            <div>
                                <img src="../assets/images/team/1.jpg" class="img-fluid blur-up lazyload bg-img"
                                    alt="">
                            </div>
                            <h4>Hileri Keol</h4>
                            <h6>CEo & Founder At Company</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Team ends--> --}}


    <!-- service section start -->
    <section class="service section-b-space bg-light">
        <div class="container">
            <div class="row partition4 ">
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_1')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_1') : websiteSettingEn('icon_1') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_1') : websiteSettingDEn('icon_1') }}
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_2')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_2') : websiteSettingEn('icon_2') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_2') : websiteSettingDEn('icon_2') }}
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_3')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_3') : websiteSettingEn('icon_3') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_3') : websiteSettingDEn('icon_3') }}
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 service-block1">
                    <img src="{{ asset(websiteSettingMedia('icon_4')) }}" alt="">
                    <h4>{{ app()->getLocale() == 'ar' ? websiteSettingAr('icon_4') : websiteSettingEn('icon_4') }}
                    </h4>
                    <p>{{ app()->getLocale() == 'ar' ? websiteSettingDAr('icon_4') : websiteSettingDEn('icon_4') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- service section end -->
@endsection
