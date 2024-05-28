@extends('layouts.front.app')

@section('contentFront')
    <!--Contents-->
    <main class="px-2 px-lg-5 pt-3 pb-3">

        <!--  start contact  -->
        <section class="conatct-form">
            <div style="z-index: 0" class="container">
                <div class="content">
                    <div class="section_title3 text-white mb-80">
                        <h2> Connect, Communicate, and Collaborate: Reach out to our Expert Team and <span class="fw-100">
                                Let's Start a Conversation! </span> </h2>
                        {{-- <p class="color-999 mt-60"> Give us a chance to serve and bring magic to your brand. </p> --}}
                    </div>
                    <div class="row gx-5">
                        <div class="col-lg-8">
                            <div class="contact-side">
                                <form action="contact.php" class="contact-form">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder=" Your Name * ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder=" Email Address * ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    placeholder=" Phone Number (optional) ">
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <select name="" id="" class="form-control form-select">
                                                    <option value="" selected> Country * </option>
                                                    <option value=""> USA </option>
                                                    <option value=""> KSA </option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder=" Company ">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    placeholder=" Write your message here ... ">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="upload_img_content">
                                        <div class="file">
                                            <div class="file__input" id="file__input">
                                                <input class="file__input--file" id="customFile" type="file"
                                                    multiple="multiple" name="files[]" />
                                                <label class="file__input--label" for="customFile"
                                                    data-text-btn="Add an attachment"> <i class="la la-paperclip"></i> Add
                                                    an attachment </label>
                                            </div>
                                            <div class="file__value_content" id="file__value_content"></div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-check mt-40">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            I want to receive news and updates once in a while
                                        </label>
                                    </div>
                                    <p class="fsz-13 color-999 mt-10"> By submitting, I’m agreed to the <a href="#"
                                            class="color-fff text-decoration-underline"> Terms & Conditons </a> </p> --}}
                                    <div class="button_su mt-90">
                                        <span class="su_button_circle bg-000 desplode-circle"></span>
                                        <a href="#" class="butn text-uppercase button_su_inner bg-cyan1">
                                            <span class="button_text_container fsz-16"> send message <i
                                                    class="ti-arrow-top-right ms-1"></i></span>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-info mt-5">
                                <div class="info-card fsz-18">
                                    <small class="text-uppercase color-999 mb-20 fsz-12"> Egypt Office</small>
                                    <a href="#"> 4 Ebn Elmotawag . Elkalifa Elmamon Heliopolis </a>
                                    <a href="#"> contact@elkomyholding.com </a>
                                    <a href="#"> 01223991811 </a>
                                </div>
                                {{-- <div class="info-card mt-60 fsz-18">
                                    <small class="text-uppercase color-999 mb-20 fsz-12"> Egypt Office 2 </small>
                                    <a href="#"> 12 Buckingham Rd, Thornthwaite, HG3 4TY, UK </a>
                                    <a href="#"> contact@elkomyholding.com </a>
                                    <a href="#"> (+20) 33333-4444444 </a>
                                </div> --}}
                                <div class="social-icons mt-90">
                                    <a href="#"> <i class="lab la-twitter"></i> </a>
                                    <a href="#"> <i class="lab la-facebook-f"></i> </a>
                                    <a href="#"> <i class="lab la-instagram"></i> </a>
                                    <a href="#"> <i class="lab la-youtube"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--  end contact  -->

        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7292334.064639742!2d25.586705161750036!3d26.817361333238242!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14368976c35c36e9%3A0x2c45a00925c4c444!2sEgypt!5e0!3m2!1sen!2seg!4v1686809747006!5m2!1sen!2seg"
                width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </main>
    <!--End-Contents-->
@endsection
