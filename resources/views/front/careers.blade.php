@extends('layouts.front.app')

@section('contentFront')
    <!--Contents-->
    <main class="px-2 px-lg-5 pt-3 pb-3">

        <!--  start contact  -->
        <section class="conatct-form">
            <div class="container">
                <div class="content">
                    <div class="section_title3 text-white mb-80">
                        <h2> {{ __('start your career at Elkomy group') }} </h2>
                        {{-- <p class="color-999 mt-60"> Give us a chance to serve and bring magic to your brand. </p> --}}
                    </div>
                    <div class="row gx-5">
                        <div class="col-lg-12">
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
                                                <input type="text" class="form-control" placeholder=" Phone Number * ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder=" Job Title *">
                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    placeholder=" Why you want to apply for this job ... ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="upload_img_content">
                                        <div class="file">
                                            <div class="file__input" id="file__input">
                                                <input class="file__input--file" id="customFile" type="file"
                                                    multiple="multiple" name="files[]" />
                                                <label class="file__input--label" for="customFile"
                                                    data-text-btn="Add an attachment"> <i class="la la-paperclip"></i>
                                                    Upload your cv</label>
                                            </div>
                                            <div class="file__value_content" id="file__value_content"></div>
                                        </div>
                                    </div>
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
                                            <span class="button_text_container fsz-16"> apply <i
                                                    class="ti-arrow-top-right ms-1"></i></span>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!--  end contact  -->



    </main>
    <!--End-Contents-->
@endsection
