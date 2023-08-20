@if (!Route::is('ecommerce.invoice'))
    <!-- footer section start -->
    <footer class="dark-footer footer-style-1 footer-theme-color">
        <section class="section-b-space darken-layout">
            <div class="container">
                <div class="row footer-theme partition-f">
                    <div class="col-lg-4 col-md-6 sub-title">
                        <div class="footer-title footer-mobile-title">
                            <h4>{{ __('about') }}</h4>
                        </div>
                        <div class="footer-contant">
                            <div class="footer-logo"><img style="width:130px"
                                    src="{{ asset(websiteSettingMedia('header_logo')) }}" alt="">
                            </div>

                            <ul class="contact-list">
                                @if (websiteSettingAr('footer_address'))
                                    <li><i
                                            class="fa fa-map-marker"></i>{{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_address') : websiteSettingEn('footer_address') }}
                                    </li>
                                @endif
                                @if (websiteSettingAr('footer_phone'))
                                    <li><i
                                            class="fa fa-phone"></i>{{ __('Call Us:') . ' ' . websiteSettingAr('footer_phone') }}
                                    </li>
                                @endif

                                @if (websiteSettingAr('footer_email'))
                                    <li><i class="fa fa-envelope"></i>{{ __('Email Us:') . ' ' }}<a
                                            href="#">{{ websiteSettingAr('footer_email') }}</a></li>
                                @endif

                            </ul>
                        </div>
                    </div>
                    @if (websiteSettingAr('show_categories') == 'on' && getCategories()->count() > 0)
                        <div class="col-lg-2 col-md-6">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>{{ __('Categories') }}</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul>
                                        <div class="row">
                                            @foreach (getCategories() as $category)
                                                <div class="col-{{ getCategories()->count() > 10 ? '6' : '12' }}">
                                                    <li><a
                                                            href="{{ route('ecommerce.products', ['category' => $category->id]) }}">
                                                            {{ getName($category) }}
                                                        </a></li>
                                                </div>
                                            @endforeach

                                        </div>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (websiteSettingAr('show_brands') == 'on' && getBrands()->count() > 0)

                        <div class="col-lg-2 col-md-6">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>{{ __('Brands') }}</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul>
                                        <div class="row">
                                            @foreach (getBrands() as $brand)
                                                <div class="col-{{ getBrands()->count() > 10 ? '6' : '12' }}">
                                                    <li><a
                                                            href="{{ route('ecommerce.products', ['brand[]' => $brand->id]) }}">
                                                            {{ getName($brand) }}
                                                        </a></li>
                                                </div>
                                            @endforeach
                                        </div>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif


                    @if (websiteSettingMultiple('quick_links') && websiteSettingMultiple('quick_links')->count() > 0)

                        <div class="col-lg-2 col-md-6">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>{{ __('Quick Links') }}</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul>
                                        <div class="row">
                                            @foreach (websiteSettingMultiple('quick_links') as $item)
                                                <div class="col-{{ getBrands()->count() > 10 ? '6' : '12' }}">
                                                    <li><a href="{{ $item->description_ar }}" target="_blank">
                                                            {{ app()->getLocale() == 'ar' ? $item->value_ar : $item->value_en }}
                                                        </a></li>
                                                </div>
                                            @endforeach
                                        </div>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (websiteSettingAr('footer_follow') ||
                            websiteSettingAr('footer_facebook') ||
                            websiteSettingAr('footer_youtube') ||
                            websiteSettingAr('footer_instagram') ||
                            websiteSettingAr('footer_linkedin') ||
                            websiteSettingAr('footer_about'))
                        <div class="col-lg-4 col-md-6">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>{{ __('follow us') }}</h4>
                                </div>
                                <div class="footer-contant">
                                    <p class="mb-cls-content">
                                        {{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_follow') : websiteSettingEn('footer_follow') }}
                                    </p>
                                    {{-- <form class="form-inline">
                                <div class="form-group me-sm-3 mb-2">
                                    <label for="inputPassword2" class="sr-only">Password</label>
                                    <input type="password" class="form-control" id="inputPassword2"
                                        placeholder="Enter Your Email">
                                </div>
                                <button type="submit" class="btn btn-solid mb-2">subscribe</button>
                            </form> --}}
                                    <div class="footer-social mt-4">
                                        <ul>
                                            @if (websiteSettingAr('footer_facebook'))
                                                <li><a href="{{ websiteSettingAr('footer_facebook') }}"
                                                        target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            @endif
                                            @if (websiteSettingAr('footer_youtube'))
                                                <li><a href="{{ websiteSettingAr('footer_youtube') }}"
                                                        target="_blank"><i class="fa-brands fa-youtube"></i></a></li>
                                            @endif
                                            @if (websiteSettingAr('footer_instagram'))
                                                <li><a href="{{ websiteSettingAr('footer_instagram') }}"
                                                        target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                                            @endif
                                            @if (websiteSettingAr('footer_linkedin'))
                                                <li><a href="{{ websiteSettingAr('footer_linkedin') }}"
                                                        target="_blank"><i class="fa-brands fa-linkedin"
                                                            aria-hidden="true"></i></a></li>
                                            @endif
                                            @if (websiteSettingAr('footer_snapchat'))
                                                <li><a href="{{ websiteSettingAr('footer_snapchat') }}"
                                                        target="_blank"><i class="fa-brands fa-snapchat"
                                                            aria-hidden="true"></i></a></li>
                                            @endif
                                            @if (websiteSettingAr('footer_tiktok'))
                                                <li><a href="{{ websiteSettingAr('footer_tiktok') }}"
                                                        target="_blank"><i class="fa-brands fa-tiktok"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <p class="mt-3">
                                        {{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_about') : websiteSettingEn('footer_about') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
        <div class="sub-footer dark-subfooter">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="footer-end">
                            <p><i class="fa fa-copyright" aria-hidden="true"></i>

                                {{ app()->getLocale() == 'ar' ? websiteSettingAr('copyright_text') : websiteSettingEn('copyright_text') }}
                                <span> {{ ' - ' . __('Developed By') . ' ' }} <a style="color:#dd2027 !important;"
                                        href="https://red-gulf.com/" target="_blank">RED</a></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="payment-card-bottom">
                            <ul>
                                <li>
                                    <a href="#"><img src="{{ asset('e-assets/images/icon/visa.png') }}"
                                            alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('e-assets/images/icon/mastercard.png') }}"
                                            alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('e-assets/images/icon/paypal.png') }}"
                                            alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img
                                            src="{{ asset('e-assets/images/icon/american-express.png') }}"
                                            alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('e-assets/images/icon/discover.png') }}"
                                            alt=""></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer section end -->
@endif
