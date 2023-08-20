<div class="nav-container style39">
    <div class="container-fluid">

        <!-- top navbar -->
        {{-- <div class="top-nav text-center py-1 bg-white">
            <p class="color-777"> {{ __('We Are Hiring In This New Year 2023!') }} <a href="#" class="color-blue6 fw-bold ms-1">
                    {{ __('Apply Today') }} <i class="fal fa-long-arrow-right ms-2"></i> </a> </p>
        </div> --}}

        <!-- start navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark style39">
            <div class="container-fluid p-0">
                <a class="navbar-brand me-lg-5" href="{{ route('front.index') }}">
                    <img style="height: 100px; max-width:125px" src="{{ asset('/assets/img/elkomy/elkomy-logo.png') }}"
                        alt="" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page"
                                href="{{ route('front.index') }}">{{ __('Home') }}</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('About') }}
                            </a>
                            <ul class="dropdown-menu br-10" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item"
                                        href="{{ route('front.about') }}">{{ __('About Elkomy') }}</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('front.strategy') }}">{{ __('Strategy') }}</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('Businesses') }}
                            </a>
                            <ul class="dropdown-menu br-10" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item"
                                        href="{{ route('front.steel') }}">{{ __('Steel manufacturing') }}</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('front.real') }}">{{ __('Real estate investments') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('front.currency') }}">{{ __('Currency Exchange') }}</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('front.educational') }}">{{ __('Educational services') }}</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('Media') }}
                            </a>
                            <ul class="dropdown-menu br-10" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item"
                                        href="{{ route('front.photos') }}">{{ __('Photos') }}</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('front.videos') }}">{{ __('Videos') }}</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.careers') }}">{{ __('Careers') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.contact') }}">{{ __('Contact us') }}</a>
                        </li>

                    </ul>
                    <div class="nav-side">
                        {{-- <div class="inf-card text-lg-end me-30">
                            <p class="gold">{{ __('Consultation') }}</p>
                            <h6 style="direction:ltr !important"> 02-26908603 </h6>
                        </div> --}}
                        <div class="button_su rounded-0 border-1 border-white">
                            <span class="su_button_circle bg-000 desplode-circle"></span>
                            <a href="{{ route('setlocale') }}"
                                class="butn py-2 button_su_inner bg-transparent m-0 pb-10 rounded-0">
                                <span
                                    class="button_text_container fsz-14 fw-bold text-capitalize text-white">{{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end navbar -->

    </div>
</div>
