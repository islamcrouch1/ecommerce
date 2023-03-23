@extends('layouts.front.app')

@section('contentFront')
    <div class="position-relative py-6 py-lg-8 light">
        <div class="bg-holder rounded-3  overlay-0" style="background-image:url(../../assets/img/gallery/backgrounds.jpg);">
        </div>
        <!--/.bg-holder-->
        <div class="position-relative text-center">
            <h4 class="text-white">{{ __('Frequent Questions') }}</h4>
            <nav style="--falcon-breadcrumb-divider: '»';" aria-label="breadcrumb">
                <ol style="justify-content: center;" class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Frequent Questions') }}</li>
                </ol>
            </nav>
        </div>
    </div>


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0 pb-5 overflow-hidden light background" id="banner">



        <div class="container-fluid   mt-7">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10 col-xl- 9   col-xxl-7">


                    <div class="accordion" id="accordionExample">
                        <div class="accordion-itemb ">
                            <h2 class="accordion-hader" id="heading1">
                                <button class="accordion-button  fs-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1" aria-expanded="true"
                                    aria-controls="collapse1">{{ __('1-Why would I work in affiliate marketing?') }}</button>
                            </h2>
                            <div class="accordion-collapse collapse show" id="collapse1" aria-labelledby="heading1"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    <p>

                                        {{ __('- You don’t need any capital.') }} <br>
                                        {{ __('- Guaranteed profits.') }} <br>
                                        {{ __('- Wider and faster reach.') }} <br>
                                        {{ __('- No commitment with working') }} <br>
                                        {{ __('hours or working place.') }} <br>
                                        {{ __('- Zero risk.') }} <br>

                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2" aria-expanded="true"
                                    aria-controls="collapse2">{{ __('2-Can you provide a specific product that is not available in the market? ') }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse2" aria-labelledby="heading2"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('- We provide all the products in large quantities,In case there is a product that you can’t find on other platforms, you can message us the product’s picture on our facebook page Sonoo.online (facebook page link) and we will provide it for you as soon as possible.') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true"
                                    aria-controls="collapse3">{{ __('3-How long does it take for the order to be delivered?') }}</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('From two to five working days, Fridays and Saturdays are off.') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse4" aria-expanded="true"
                                    aria-controls="collapse4">{{ __('4-What are the shipping prices?') }} </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('Each governorate has its own price, ranging from 30 EGP to 60 EGP.') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true"
                                    aria-controls="collapse3">{{ __('5-Is there any provinces where shipping is not available?') }}</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('Shipping is available in all provinces except North Sinai.') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true"
                                    aria-controls="collapse3">{{ __('6-How long does it take until I receive my commission?') }}</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('As a vendor, you can receive your money 7 days after the order is delivered.') }}
                                    <br>
                                    {{ __('As an affiliate, you can receive your money three days after the order is delivered.') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true"
                                    aria-controls="collapse3">{{ __('7-What is the maximum limit that I can add to my commission?') }}</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('You can add from 1% to 150% of the product price.') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true"
                                    aria-controls="collapse3">{{ __('8-Can the customer replace or return the product after it’s delivered?') }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('- The customer has the right to replace the product after it’s delivered within a period not exceeding 3 days.') }}<br>
                                    {{ __('- The customer has the right to return the product in case there is a manufacturing defect in the product or the product is not identical to the requested order.') }}

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true"
                                    aria-controls="collapse3">{{ __('9-Can I request a replacement for an order before it’s delivered? ') }}</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('- You can simply make a new order and cancel the old order, and write in notes the reason for the replacement.') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button  fs-2 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true"
                                    aria-controls="collapse3">{{ __('10-How can I withdraw my profits?') }}</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body fs-1 text-start">
                                    {{ __('-Cash: You can come to our Head Quarters and receive your profits in cash after making a request to withdraw your profits from your account.') }}<br>
                                    {{ __(' - E-Wallet: You will receive your profits after 2 working days from making a request to withdraw your profits.') }}<br>
                                    {{ __('- Bank Transfer: you can request to withdraw your money from your account, and it takes From 2 to 5 working days after confirming your request.') }}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection
