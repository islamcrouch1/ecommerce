 <!-- ============================================-->
 <!-- <section> begin ============================-->
 <section class="bg-dark pt-8 pb-4 light">

     <div class="container">
         <div class="position-absolute btn-back-to-top bg-dark"><a class="text-600" href="#banner" data-bs-offset-top="0"
                 data-scroll-to="#banner"><span class="fas fa-chevron-up" data-fa-transform="rotate-45"></span></a></div>
         <div class="row">
           

             {{-- <div class="col-lg-4 col-md-4 ">

                 <iframe id="mapcanvas"
                     src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.449033681021!2d31.2432972149728!3d30.052660781879318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145840960a775b41%3A0xfd2f355c9fc375f3!2zMyAyNiDZitmI2YTZitmI2IwgT3JhYnksIEFiZGVlbiwgQ2Fpcm8gR292ZXJub3JhdGU!5e0!3m2!1sen!2seg!4v1637431424568!5m2!1sen!2seg"></iframe>
                 <div class="icon-group mt-4"><a class="icon-item bg-white text-facebook" href="#!"><span
                             class="fab fa-facebook-f"></span></a><a class="icon-item bg-white text-twitter"
                         href="#!"><span class="fab fa-twitter"></span></a><a
                         class="icon-item bg-white text-google-plus" href="#!"><span
                             class="fab fa-google-plus-g"></span></a><a class="icon-item bg-white text-linkedin"
                         href="#!"><span class="fab fa-linkedin-in"></span></a><a class="icon-item bg-white"
                         href="#!"><span class="fab fa-medium-m"></span></a></div>
             </div> --}}


             <div class="col-lg-3  col-md-3">
                 <h5 class="  fs-1  text-white text-center  mb-3">{{ __('Menu') }}</h5>
                 <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-3"><a class="link-600" href="{{ route('front.index') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="mb-3"><a class="link-600"
                                        href="{{ route('front.about') }}">{{ __('About Us') }}</a></li>
                     {{-- <li class="mb-3"><a class="link-600" href="#!">{{ __('About') }}</a></li>
                             <li class="mb-3"><a class="link-600" href="#!">{{ __('Contact') }}</a></li> --}}
                     </ul>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <ul class="list-unstyled">
                        <li class="mb-3"><a class="link-600"
                                href="{{ route('front.terms') }}">{{ __('Terms and conditions') }}</a></li>
                        <li class="mb-3"><a class="link-600"
                                href="{{ route('front.fqs') }}">{{ __('Frequent Questions') }}</a></li>
                        
    

                        </ul>
                    </div>
                </div>
             </div>
             {{-- <div class="col-6 col-md-3">
                         <h5 class="text-uppercase text-white opacity-85 mb-3">Product</h5>
                         <ul class="list-unstyled">
                             <li class="mb-1"><a class="link-600" href="#!">Features</a></li>
                             <li class="mb-1"><a class="link-600" href="#!">Roadmap</a></li>
                             <li class="mb-1"><a class="link-600" href="#!">Changelog</a></li>
                             <li class="mb-1"><a class="link-600" href="#!">Pricing</a></li>
                             <li class="mb-1"><a class="link-600" href="#!">Docs</a></li>
                             <li class="mb-1"><a class="link-600" href="#!">System Status</a></li>
                             <li class="mb-1"><a class="link-600" href="#!">Agencies</a></li>
                             <li class="mb-1"><a class="link-600" href="#!">Enterprise</a></li>
                         </ul>
                     </div> --}}
             <div class=" offset-lg-2 offset-md-2 col-lg-4  col-md-4 mt-1 ">

                 <ul class="list-unstyled mt-0">
                     {{-- <li>
                                 <h5 class="fs-6 mb-0"><a class="link-600" href="#!"> terms and conditions
                                         </a></h5>
                                 <p class="text-600 opacity-50">Jan 15 &bull; 8min read </p>
                             </li> --}}
                     <li>
                         <span><h4 class="  mb-2"> 
                         </h4>
                         {{-- <p class="text-600  opacity-70">................</p> --}}
                         <a class="text-600  opacity-70" href="info@sonoo.online"><span class=" fs-1 text-light ">{{ __('Email') }}:</span> info@sonoo.online</a></span>
                     </li>
                     <li>
                         <h4 class="fs-2   text-light mb-2">
                         </h4>
                         {{-- <p class="text-600 opacity-70">....................</p> --}}
                         <a class=" text-600 opacity-70" href="tel:02-33050225"><span class=" fs-1 text-light ">{{ __('Phone Number') }}:</span> 02-33050225</a>
                     </li>
                     <li>
                         <h4 class="fs-2 text-light  mb-0">
                         </h4>
                         <p class="text-600 pt-2 opacity-70"><span class=" fs-1 text-light " >{{ __('Address') }}:</span>
                             {{ __(' Lebanon Square,  Al-Muhandseen') }}
                         </p>
                     </li>
                 </ul>
             </div>
             <div class="col-lg-3  text-center col-md-3">
                <a class=" text-center " href="{{ route('front.index') }}"><img
                    src="{{ asset('assets/logos/logo.png') }}" alt="img" height="100"></a>
                    {{-- <h4 class=" text-center w-auto mx-auto ms-2 pt-3 ">{{ __('Your Success On Us') }}</h4> --}}
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
 <section class="py-0 bg-dark  light">

     
         <hr class="my-0 text-600 opacity-25" />
         <div class="container  py-5">
             {{-- <div class="row justify-content-between fs--1"> --}}
                 <div class="col-12 col-sm-auto text-center">
                     <p class="mb-0 text-600 opacity-85"> {{ __('All Rights Reserved') }}<span
                             class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2022 &copy; <a
                             class="text-white opacity-85" href="https://sonoo.online.com"> {{ __('Sonooegy') }}</a>
                     </p>
                     <div class="icon-group justify-content-center  mt-4"><a class="icon-item bg-white text-facebook" href="#!"><span
                        class="fab fa-facebook-f"></span></a><a class="icon-item bg-white text-twitter"
                    href="#!"><span class="fab fa-twitter"></span></a><a
                    class="icon-item bg-white text-google-plus" href="#!"><span
                        class="fab fa-google-plus-g"></span></a><a class="icon-item bg-white text-linkedin"
                    href="#!"><span class="fab fa-linkedin-in"></span></a><a class="icon-item bg-white"
                    href="#!"><span class="fab fa-medium-m"></span></a></div>
                 </div>
                 {{-- <div class="col-12 col-sm-auto text-center">
                     <p class="mb-0 text-600 opacity-85"></p>
                 </div> --}}
             {{-- </div> --}}
         </div>
     
     <!-- end of .container-->

 </section>
 <!-- <section> close ============================-->
 <!-- ============================================-->
