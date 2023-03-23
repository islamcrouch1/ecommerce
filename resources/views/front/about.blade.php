@extends('layouts.front.app')

@section('contentFront')
    <div class="position-relative py-6 py-lg-8 light">
        <div class="bg-holder rounded-3  overlay-0" style="background-image:url(../../assets/img/gallery/backgrounds.jpg);">
        </div>
        <!--/.bg-holder-->
        <div class="position-relative text-center">
            <h4 class="text-white">{{ __('About Us') }}</h4>
            <nav style="--falcon-breadcrumb-divider: '»';" aria-label="breadcrumb">
                <ol style="justify-content: center;" class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('About Us') }}</li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="container" data-layout="container">

        <div class="card-body position-relative">


            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-auto">
                            <div class="sticky-top pt-sm-7 mb-3">
                                <div class="nav flex-column nav-pills" id="v-pills"><a class="nav-link ps-0 ps-sm-3"
                                        href="#v-pills-home">{{ __('Who are we?') }}</a><a class="nav-link ps-0 ps-sm-3"
                                        href="#v-pills-profile">{{ __('Our vision') }}</a><a class="nav-link ps-0 ps-sm-3"
                                        href="#v-pills-messages">{{ __('Our Mission') }}</a><a class="nav-link ps-0 ps-sm-3"
                                        href="#v-pills-settings">{{ __('Our Values') }}</a><a class="nav-link ps-0 ps-sm-3"
                                        href="#v-pills-settings">{{ __('Social responsibility') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <h3 id="v-pills-home">{{ __('Who are we?') }}</h3>
                            <p class="mb-6">
                                {{ __('Sonoo Egy is a company that specializes in e-commerce and affiliate marketing; We provide you with a variety of products, and we market the products of sellers as well, with integrated services and the provision of storage.') }}
                            </p>
                            <h3 id="v-pills-profile">{{ __('Our vision') }}</h3>
                            <p class="mb-6">
                                {{ __('Sonoo Egy is looking forward to the continuous development in the field of e-commerce within Egypt and the opening of several markets around the  world success partners and bring them to professionalism, productivity, excellence, and to increase financial income.') }}
                            </p>
                            <h3 id="v-pills-messages">{{ __('Our Mission') }}</h3>
                            <p class="mb-6">
                                {{ __('We seek to provide the best services to our partners with a sense of comfort and excellence by developing the sales process electronically, by quick delivery to gain customer confidence, and by taking care of the quality of the products offered to our customers We effectively train the largest number of affiliate marketers also seek to join the largest number of merchants and companies with high quality, diverse and marketable products.') }}
                            </p>
                            <h3 id="v-pills-settings">{{ __('Our Values') }}</h3>
                            <p class="mb-6">
                                {{ __("- Sonoo's top priority is the satisfaction of all individuals (merchants, marketers and customers).<br>- Credibility, honesty, and professionalism.<br> - The importance of teamwork among all individuals.<br> - To invest in human potential and work to develop workers' skills.") }}
                            </p>
                            <h3 id="v-pills-settings">{{ __('Social responsibility') }}</h3>
                            <p class="mb-6">
                                {{ __('Sonoo participates in the Egyptian labor market, and we value Social responsibility by contributing to the development of the modern Egyptian economy, providing employment opportunities for young and young entrepreneurs and advancing their thinking through training programs and online marketing for professionalism and productivity Increase financial income to improve living standards, and develop the mental image of affiliate marketing') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>
@endsection
