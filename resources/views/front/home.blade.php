@extends('layouts.front.app')

@section('contentFront')
    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0 overflow-hidden light" id="banner">

        <div class="bg-holder overlay"
            style="background-image:url({{ asset('/assets/img/generic/bg-1.jpg') }});background-position: center ;">
        </div>
        <!--/.bg-holder-->


        <div class="container ">
            <div class="row flex-center   pt-lg-7 pb-lg-7 pb-xl-0">
                <div class="col-md-11 col-lg-8 col-xl-4 pb-3  pt-7 pb-xl-5 text-center text-xl-start"><a
                        class="btn btn-outline-danger disabled ready mb-5 fs-1 first border-2 rounded-pill"><span
                            class="me-2" role="img" aria-label="Gift"></span>{{ __('Catch Your Profit') }} !!</a>
                    <h1 class="text-white fw-light">{{ __('Faster') }} <span class="typed-text fw-bold"
                            data-typed-text='["{{ __('Delivery') }}","{{ __('Profit') }}","{{ __('Success') }}"]'></span>
                    </h1>
                    <h3 class="lead lh-base fs-2 mt-5 mb-3  text-white opacity-75">
                        {{ __('Our first goal is for you earn and increase your profit!') }}
                        {{ __('You are not just a normal individual, you are a person who share our goals and our ambitions') }}
                        {{ __('and you are a') }}
                        <span class="ready typed-text  fs-3 fw-bold">{{ __('success partner') }}.</span>

                    </h3>
                    <div class="wrap">
                        <a style="text-decoration: none; text-align: center;" href="{{ route('register') }}"
                            class=" mt-3 fs-4 fw-bold action">{{ __('START NOW') }}</a>

                    </div>

                </div>
                <div class="col-xl-7 offset-xl-1 align-self-end mt-5 mt-xl-0"><a class="img-landing-banner rounded"
                        href="{{ route('front.index') }}"><img class="img-fluid mb-10" src="../assets/img/generic/h1.png"
                            alt="" /></a></div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    {{-- <section class="py-3 bg-light shadow-sm">

        <div class="container">
            <div class="row flex-center">
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40"
                        src="{{ asset('/assets/img/logos/b&amp;w/6.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="45"
                        src="{{ asset('/assets/img/logos/b&amp;w/11.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="30"
                        src="{{ asset('/assets/img/logos/b&amp;w/2.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="30"
                        src="{{ asset('/assets/img/logos/b&amp;w/4.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="35"
                        src="{{ asset('/assets/img/logos/b&amp;w/1.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40"
                        src="{{ asset('/assets/img/logos/b&amp;w/10.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40"
                        src="{{ asset('/assets/img/logos/b&amp;w/12.png') }}" alt="" /></div>
            </div>
        </div>
        <!-- end of .container-->

    </section> --}}
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0 pb-5 overflow-hidden light background" id="banner">



        <div class="container  mt-7">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 col-xl-7  col-xxl-6">
                    <h1 class=" mb-3 ncolorr fs-2 fs-sm-4 fs-md-5"><span
                            class="tcolor">{{ __('How do you increase your income with') }}</span> <span
                            class="fs-5 fw-bolder">{{ __('Sonoo?') }}</span>
                    </h1>
                    <p class=" lead ncolor">
                        {{ __('Without any time, commitment or place. You can work on your mobile phone and be in charge') }}
                        {{ __('without any restrictions or directives, your income will easily increase after every sale you make.') }}
                        {{ __("Without wasting your time, you'll dedicate one or two hours a day to promote our products") }}
                        {{ __('to your customers, add your order, and leave the rest to us.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-0 overflow-hidden  " id="banner">

        <div class=" layer bg-holder "
            style="background-image:url({{ asset('/assets/img/generic/Artboard1.png') }});background-position: center bottom;">
        </div>
        <div class="container ">
            <div class="row flex-center mt-3 ">
                <div class=" me-10 col-md-4  col-lg-5  col-xl-4   order-md-2 "><img class="  px-6 px-md-0"
                        src="../assets/img/icons/spot-illustrations/mobile.png" alt="" /></div>
                <div class="col-md-4  col-lg-5 col-xl-4  mt-md-0">
                    <h5 class="text-warning"><span class=" fs-4 far fa-lightbulb me-2"></span><span
                            class="fs-4">{{ __('THINK') }}</span></h5>
                    <h3 class=" fs-6  fw-bolder ncolorr">{{ __('Who is Sonoo?') }}
                    </h3>
                    <p class=" tcolor fs-3">{{ __("We're an open market for affiliate marketers.") }}
                        {{ __('With easy and simple transactions, we are able to deliver all of your orders to all the people,') }}
                        {{ __('whether you are a Seller or an Affiliate.') }}
                    </p>
                </div>
            </div>
    </section>

    {{-- @endsection --}}
    <section class="py-0 overflow-hidden  " id="banner">

        <div class=" layer bg-holder "
            style="background-image:url({{ asset('/assets/img/generic/background12.jpg') }});background-position: center bottom;">
        </div>
        <div class="container ">
            <div class="row  flex-center ">
                <div class="me-10 col-md-4  col-lg-5  col-xl-4   order-md-2"><img class=" px-6 px-md-0"
                        src="../assets/img/icons/spot-illustrations/cart.png" alt="" /></div>
                <div class="col-md-4  col-lg-5 col-xl-4  mt-md-0">
                    <h5 class="text-info"> <span class=" fs-4 ready far fa-object-ungroup me-2"></span><span
                            class=" ready fs-4">{{ __("LET'S TRY") }}</span></h5>
                    <h3 class="fs-6  fw-bolder tcolor">{{ __('How did we make it so easy?') }}
                    </h3>
                    <p class=" tcolor fs-3">{{ __('Your products and orders are delivered all across Egypt,') }}
                        {{ __('with faster and safer shipping without the costing you shipping or storing.') }}
                    </p>
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-5  text-center">

        <div class="  bg-holder "
            style="background-image:url({{ asset('/assets/img/generic/Untitleddesign.gif') }});background-position: center bottom;">
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="fs-6 mt-0 pt-0  "> {{ __('YOU ARE A SUCCESSS') }} <span
                            class="ncolorr fs-6  fw-bolder">{{ __('PARTNER!') }}</span>
                    </h1>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-lg-4">
                    <div class="card yellow card-span  h-100">
                        <div class="card-span-img gridd5"></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">{{ __('The largest number of affiliates for your products.') }}
                            </h5>
                            <p>"{{ __('Sell faster and profit more') }}"
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-6 mt-lg-0">
                    <div class="card turquoise card-span h-100">
                        <div class="gridd card-span-img"></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2"> {{ __('Free storage and packaging services.') }}</h5>
                            <p>"{{ __('Easy to store and pack your products.') }}"</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-6 mt-lg-0">
                    <div class="card linon card-span h-100">
                        <div class="card-span-img gridd2"></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">{{ __('The strongest customer service team.') }}
                            </h5>
                            <p>“{{ __('Always with you momentarily') }}”</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-6 mt-lg-7">
                    <div class="card steel card-span h-100">
                        <div class="card-span-img gridd3"></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2"> {{ __('Fastest shipping and fulfilment.') }}

                            </h5>
                            <p>"{{ __('Your product is delivered safely, with premium packaging, and a competitive shipping fee') }}"
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-6 mt-lg-7">
                    <div class="card sky card-span h-100">
                        <div class="card-span-img gridd4"></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">{{ __('Collecting your profits from the customer') }}
                            </h5>
                            <p>"{{ __('We will provide you with your sales report, and you will have your income without any effort,') }}
                                {{ __('and you can withdraw your profit  wherever you are') }} "
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="bg-200 text-center">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <h1 class=" tcolor fs-6  fw-bold mt-0 pt-0 mb-5">{{ __('How can you be') }}

                        {{ __('a marketer') }} <span class="ncolorr">{{ __('with Sonoo?') }}</span>
                    </h1>
                    <h3 class="first">
                        {{ __('Just register your private account with us from here. “Sonoo.Online”') }}
                    </h3>

                    <div class="swiper-container theme-slider"
                        data-swiper='{"autoplay":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"slideToClickedSlide":true}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="px-5 px-sm-6">
                                    <img class=" w-auto mx-auto" src="../assets/img/logos/b&w/4.png" alt=""
                                        height="300" />
                                    <p class="fs-sm-1 fs-md-2 fst-italic ">
                                        {{ __('We offer all the products in  large quantities and whole price.') }} </p>

                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="px-5 px-sm-6">
                                    <img class=" w-auto mx-auto" src="../assets/img/logos/b&w/2.png" alt=""
                                        height="300" />
                                    <p class="  fs-sm-1 fs-md-2 fst-italic ">
                                        {{ __('Pick your product, promote it to your social media channels,') }}
                                        {{ __('choose the commission you like and leave the rest to us.') }}
                                    </p>

                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="px-5 px-sm-6">
                                    <img class=" w-auto mx-auto" src="../assets/img/logos/b&w/5.png" alt=""
                                        height="300" />
                                    <p class=" fs-sm-1 fs-md-2 fst-italic ">
                                        {{ __('Our confirmation team, wil confirm your orders with the customer.') }}
                                    </p>

                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="px-5 px-sm-6">
                                    <img class=" w-auto mx-auto" src="../assets/img/logos/b&w/1.png" alt=""
                                        height="300" />
                                    <p class="  fs-sm-1 fs-md-2 fst-italic ">
                                        {{ __("We'll package and deliver your orders with our fast shipping") }}.<br>
                                        "{{ __("As we achieved speed and safety and earned the client's trust for the end") }}.”


                                    </p>

                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="px-5 px-sm-6">
                                    <img class=" w-auto mx-auto" src="../assets/img/logos/b&w/3.png" alt=""
                                        height="300" />
                                    <p class="fs-sm-1 fs-md-2 fst-italic ">
                                        {{ __('We collect the money and you can withdraw your earnings three working days after the product') }}
                                        {{ __('is delivered, and you choose the best way you for you weather it’s cash, e-wallet or bank account.') }}
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="swiper-nav">
                            <div class="swiper-button-next swiper-button ncolorr"></div>
                            <div class="swiper-button-prev swiper-button ncolorr"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->

    <!-- <section> begin ============================-->
    <section class="py-5  " id="banner">

        <div class="  opicity bg-holder "
            style=" background-image:url({{ asset('/assets/img/generic/Artboard1.png') }});background-position: center  ;">
        </div>
        <div class="container ">
            <div class="row">

                <div class="col-lg-6 mt-6  my-3 mt-lg-5">

                    <h1 class="fs-6 fw-bolder text-center "> {{ __('We Will Share Success And') }} <br> <span
                            class="fs-4 text-center first">{{ __('Increase Profits') }}</span>
                    </h1>

                </div>
                <div class="col-lg-6 text-center  my-4 mt-lg-0">
                    <div class="card mt-4 card-span border  ">
                        <div class=" one card-span-img"></div>
                        <div class="card-body pb-4 pt-6">
                            <h5 class=" ncolorr fw-bold fs-2 mb-2"> {{ __('What is “My Inventory”') }}

                            </h5>
                            <p>{{ __('It means you can buy an amount of any product you choose,') }} <br>
                                {{ __('add it to your own inventory, and increase your profits.') }}
                            </p>
                        </div>
                    </div>

                </div>
                {{-- <div class="col">
                    <h1 class="fs-6 fw-bolder text-right fs-sm-4 fs-md-5"> {{ __('We Will Share Success And') }} <br> <span class="fs-3 text-center ncolorr">{{ __('Increase Profits') }}</span>
                    </h1>
                </div> --}}
            </div>
            <div class="row text-center ">


                <div class="col-lg-6 my-4 mt-lg-5">
                    <div class="card card-span border ">
                        <div class="card-span-img two"></div>
                        <div class="card-body px-5 pt-6 pb-4 ">
                            <h5 class=" ncolorr fs-2 fw-bold mb-2">{{ __("It's also a free marketing tool.") }}
                            </h5>
                            <p>{{ __('Increase your sales and earn your customer’s trust with our free done for you professional online Store.') }}
                                {{ __('Just choose the products you want, add them to your website, and promote your landing page on all social media platforms and search engines, your orders will be registered automatically and leave the rest to us.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 my-3  mt-lg-0">
                    <img style="width:100%" class=" px-6 px-md-0"
                        src="../assets/img/icons/spot-illustrations/Untitled design (44).png" alt="" />

                </div>
            </div>
        </div>
        <!-- end of .container-->
    </section>


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="light">

        <div class="bg-holder overlay"
            style="background-image:url(../assets/img/generic/background1.jpg);background-position: center top;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class=" first fw-bolder mt-0  mb-4">
                        {{ __('What are you waiting for?!') }}

                    </h1>
                    <p class="fs-6 fs-sm-4  fw-bold text-white">
                        {{ __('Choose your products, start your AD campaigns and collect your profits.') }}
                    </p>
                    <div class="wrap">
                        <a style="text-decoration: none; text-align: center;" href="{{ route('register') }}"
                            class=" mt-2 fs-4 fw-bold action">{{ __('START NOW') }}</a>

                    </div>

                    {{-- <button class="btn btn-outline-light border-2 rounded-pill ready btn-lg mt-4 px-4 fs-4 py-2" type="button"> {{ __('START NOW') }}
                    </button> --}}
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->
@endsection
