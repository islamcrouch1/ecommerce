@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('Videos') }} </h1>
            </div>
            {{-- <p class="fsz-18 mt-30 text-white op-6"> Ensuring the best return on investment for your bespoke <br> SEO
                campaign requirement. </p> --}}
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.videos') }}" class="active gold"> {{ __('Videos') }} </a>
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
                                {{ __('About Elkomy') }}
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


                                    <div class="col-lg-8">
                                        <div class="portfolio-column">

                                            <div class="portfolio-card">
                                                <div class="row pb-3">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <iframe width="100%" height="400"
                                                                src="{{ getYoutubeEmbedUrl('https://www.youtube.com/watch?v=OzK30cMsnX4') }}"
                                                                allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
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

                            </div>
                        </div>



                        <div class="tab-pane fade show" id="pills-prt2" role="tabpanel" aria-labelledby="pills-prt2-tab">
                            <div class="content">
                                <div class="row">


                                    <div class="col-lg-8">
                                        <div class="portfolio-column">

                                            <div class="portfolio-card">
                                                <div class="row pb-3">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <iframe width="100%" height="400"
                                                                src="{{ getYoutubeEmbedUrl('https://www.youtube.com/watch?v=CXQgaz78pIQ') }}"
                                                                allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="info">
                                                    <div class="cont">
                                                        <div class="date">
                                                            <a href="#" class="fsz-14 color-999"> Elkomy Media
                                                            </a>
                                                            <span class="color-red3 fw-bold gold"> 2023 </span>
                                                        </div>
                                                        <h6 class="title"> <a href="#">
                                                                {{ __('About Elkomy') }} </a> </h6>
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