@if (!Route::is('ecommerce.invoice'))
    <!-- footer section start -->
    <footer class="dark-footer footer-style-1 footer-theme-color">
        <section class="section-b-space darken-layout">
            <div class="container">
                <div class="row footer-theme partition-f">
                    <div class="col-lg-4 col-md-6 sub-title">
                        <div class="footer-title footer-mobile-title">
                            <h4>about</h4>
                        </div>
                        <div class="footer-contant">
                            <div class="footer-logo"><img style="width:130px"
                                    src="{{ asset(websiteSettingMedia('header_logo')) }}" alt="">
                            </div>
                            <p>{{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_about') : websiteSettingEn('footer_about') }}
                            </p>
                            <ul class="contact-list">
                                <li><i
                                        class="fa fa-map-marker"></i>{{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_address') : websiteSettingEn('footer_address') }}
                                </li>
                                <li><i
                                        class="fa fa-phone"></i>{{ __('Call Us:') . ' ' . websiteSettingAr('footer_phone') }}
                                </li>
                                <li><i class="fa fa-envelope"></i>{{ __('Email Us:') . ' ' }}<a
                                        href="#">{{ websiteSettingAr('footer_email') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="sub-title">
                            <div class="footer-title">
                                <h4>{{ __('Categories') }}</h4>
                            </div>
                            <div class="footer-contant">
                                <ul>
                                    @foreach (getCategories() as $category)
                                        <li><a href="{{ route('ecommerce.products', ['category' => $category->id]) }}">
                                                {{ getName($category) }}
                                            </a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="sub-title">
                            <div class="footer-title">
                                <h4>{{ __('Brands') }}</h4>
                            </div>
                            <div class="footer-contant">
                                <ul>
                                    @foreach (getBrands() as $brand)
                                        <li><a href="{{ route('ecommerce.products', ['brand[]' => $brand->id]) }}">
                                                {{ getName($brand) }}
                                            </a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
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
                                        <li><a href="{{ websiteSettingAr('footer_facebook') }}" target="_blank"><i
                                                    class="fa fa-facebook-f"></i></a></li>
                                        <li><a href="{{ websiteSettingAr('footer_youtube') }}" target="_blank"><i
                                                    class="fa fa-youtube"></i></a></li>
                                        <li><a href="{{ websiteSettingAr('footer_instagram') }}" target="_blank"><i
                                                    class="fa fa-instagram"></i></a></li>
                                        <li><a href="{{ websiteSettingAr('footer_linkedin') }}" target="_blank"><i
                                                    class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        href="https://red-gulf.com/">RED</a></span>
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
