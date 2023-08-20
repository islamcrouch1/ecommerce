    <!--  start footer  -->
    <footer class="tc-footer-style39">
        <div class="container">
            <div class="contact-card">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="l-side">
                            <div class="call-icon">
                                <img src="{{ asset('assets/img/icons/6.png') }}" alt="" class="icon">
                            </div>
                            <div class="inf">
                                <h5 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-2"> {{ __('Get In Touch') }}
                                </h5>
                                {{-- <h5 class="fsz-24 mb-0"> {{ __('Always available to serve you') }} </h5> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="call-content">
                            <div class="call-card me-30">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/icons/7.png') }}" alt="">
                                </div>
                                <div class="cont">
                                    <h6 class="fsz-14 color-777 text-uppercase mb-2"> {{ __('Phone Number') }} </h6>
                                    <h5 class="fsz-18 text-uppercase ltr"> 02 26908603 </h5>
                                </div>
                            </div>
                            <div class="call-card">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/icons/8.png') }}" alt="">
                                </div>
                                <div class="cont">
                                    <h6 class="fsz-14 color-777 text-uppercase mb-2"> {{ __('Email Address') }} </h6>
                                    <h5 class="fsz-18 text-uppercase"> contact@elkomyholding.com </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content">
                <div class="row justify-content-between">
                    <div class="col-lg-4">
                        <div class="foot-info">
                            <h2 class="fsz-40 mb-40 ltr"> We’d Love To Make Next-Level Product Development. </h2>
                            <div class="text ltr"> Looking for collaboration? Send an email to contact@elkomyholding.com
                                to for
                                vailable for enquires and collaborations, </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="foot-links">
                            <div class="form-group">
                                <div class="icon">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                                <input type="text" placeholder="Business email">
                                <button> Subscribe <i class="fal fa-long-arrow-right ms-2 color-blue6"></i> </button>
                            </div>
                            <div class="links">
                                <div class="row">
                                    <div class="col-lg-4 col-6">
                                        <ul>
                                            <li> <a href="{{ route('front.steel') }}">
                                                    {{ __('Steel manufacturing') }}</a> </li>
                                            <li> <a href="{{ route('front.real') }}">
                                                    {{ __('Real estate investments') }} </a> </li>
                                            <li> <a href="{{ route('front.currency') }}">
                                                    {{ __('Currency Exchange') }} </a> </li>
                                            <li> <a href="{{ route('front.educational') }}">
                                                    {{ __('Educational services') }} </a> </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <ul>
                                            <li> <a href="{{ route('front.about') }}"> {{ __('About Elkomy') }} </a>
                                            </li>
                                            <li> <a href="{{ route('front.strategy') }}"> {{ __('Strategy') }} </a>
                                            </li>
                                            {{-- <li> <a href="#"> How It Works </a> </li> --}}
                                        </ul>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <ul class="fw-600 text-white ltr">
                                            <li> <a href="#"> contact@elkomyholding.com </a> </li>
                                            <li> <a href="#"> 02 26908603 </a> </li>
                                            <li> <a href="#"> 4 Ebn Elmotawag . Elkalifa Elmamon Heliopolis <br>
                                                    Egypt. </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="foot py-4 border-1 border-top brd-light">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="foot-logo text-center text-lg-start">
                            <img style="height: 80px; max-width:107px"
                                src="{{ asset('/assets/img/elkomy/elkomy-logo.png') }}" alt=""
                                class="icon-150 h-auto">
                        </div>
                    </div>
                    <div class="col-lg-6 my-4 m-lg-0">
                        <p class="text-center color-999 ltr"> Copyright <a href="#" class="text-white fw-bold">
                                Elkomy
                                Group. </a> All rights reserved. </p>
                    </div>
                    <div class="col-lg-3">
                        <div class="links text-center text-lg-end color-999">
                            <a href="{{ route('front.contact') }}" class="me-20"> {{ __('Contact us') }} </a>
                            <a href="{{ route('front.careers') }}" class="me-20"> {{ __('Careers') }} </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ asset('assets/img/elkomy/f_pattern1.png') }}" alt="" class="l_pattern">
        <img src="{{ asset('assets/img/elkomy/f_pattern2.png') }}" alt="" class="r_pattern">
    </footer>
    <!--  end footer  -->
