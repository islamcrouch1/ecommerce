@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ getName($post) }} </h1>
            </div>
            <p class="fsz-18 mt-30 text-white op-6">{{ getName($post->website_category) }}</p>
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.about') }}" class="gold"> {{ getName($post->website_category) }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.about') }}" class="active gold"> {{ getName($post) }} </a>

        </div>
    </header>
    <!-- end header -->




    <!--Contents-->
    <main>


        <!-- start partners -->
        <section class="tc-page-about-cards">
            <div class="container">

                <div class="row">
                    <div class="col-md-6">
                        <div class="cards">
                            <div class="row">
                                <div id="home-carousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">

                                        @if ($post->images->count() > 0)
                                            @foreach ($post->images as $image)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }} ">
                                                    <img src="{{ asset($image->media->path) }}" class="d-block w-100"
                                                        alt="...">
                                                </div>
                                            @endforeach
                                        @endif



                                        @if ($post->media_id != null)
                                            <div class="carousel-item {{ $post->images->count() > 0 ? '' : 'active' }}">
                                                <img src="{{ asset($post->media->path) }}" class="d-block w-100"
                                                    alt="...">
                                            </div>
                                        @endif



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="cont">
                                        <div class="logo">
                                            <img src="{{ asset('/assets/img/elkomy/elkomy-logo.png') }}" alt="">
                                        </div>
                                        <div class="text">
                                            @if (app()->getLocale() == 'ar')
                                                {!! $post->description_ar !!}
                                            @else
                                                {!! $post->description_en !!}
                                            @endif
                                        </div>
                                        <div class="btns">
                                            <div class="button_su shadow-lg radius-3 me-3">
                                                <span class="su_button_circle bg-000 desplode-circle"></span>
                                                <a href="{{ route('front.contact') }}"
                                                    class="butn py-2 px-4 button_su_inner bg-blue3 radius-3 b-gold">
                                                    <span
                                                        class="button_text_container fsz-13 fw-bold text-capitalize text-white">
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
                </div>



            </div>
            <img src="{{ asset('/assets/img/elkomy/lines_circle.png') }}" alt="" class="lines">
        </section>
        <!-- end partners -->

        @include('front._portfolio', [
            'posts' => $portfolio_posts,
        ])


    </main>
    <!--End-Contents-->
@endsection
