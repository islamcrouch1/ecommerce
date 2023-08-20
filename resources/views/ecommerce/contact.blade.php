@extends('layouts.ecommerce.app')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('Contact') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Contact') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->



    <!--section start-->
    <section class="contact-page section-b-space">
        <div class="container">
            <div class="row section-b-space">
                <div class="col-sm-12">
                    <form class="theme-form" method="POST" action="{{ route('ecommerce.contact.create') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-row row">



                            <div class="col-md-12">
                                <label for="name">{{ __('Name') }}</label>
                                <input name="name" type="text"
                                    class="form-control  @error('name') is-invalid @enderror" id="name"
                                    placeholder="{{ __('Enter Your name') }}"
                                    value="{{ Auth::check() ? Auth::user()->name : old('name') }}" required>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input name="phone" type="text"
                                    class="form-control  @error('phone') is-invalid @enderror" id="phone"
                                    placeholder="{{ __('Enter Your Phone') }}"
                                    value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}" required>
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-12">
                                <label for="review">{{ __('Write Your Message') }}</label>
                                <textarea name="message" class="form-control   @error('phone') is-invalid @enderror" id="exampleFormControlTextarea1"
                                    rows="6">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <input style="display:none" name="n1" type="text" class="form-control" id="n1"
                                value="{{ $n1 }}" required>

                            <input style="display:none" name="n2" type="text" class="form-control" id="n2"
                                value="{{ $n2 }}" required>

                            <div class="col-md-12">
                                <label
                                    for="answer">{{ __('please solve this equation') . ' ( ' . $n1 . ' + ' . $n2 . ' ) ' }}</label>
                                <input name="answer" type="text"
                                    class="form-control  @error('answer') is-invalid @enderror" id="answer"
                                    value="" required>
                                @error('answer')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{--

                            <div class="col-md-12">
                                <label for="file">{{ __('Attach File') }}</label>
                                <input name="file" class="form-control @error('file') is-invalid @enderror"
                                    type="file" id="file" />
                                @error('file')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}




                            <div class="col-md-12">
                                <button class="btn btn-solid" type="submit">{{ __('Send Your Message') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="row section-b-space">
                <div class="col-lg-7 map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3621.3357820312076!2d46.6393599153849!3d24.818188053061952!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2ee40eefcb6a9d%3A0xbc4308498520f827!2sAnas%20Ibn%20Malik%20Rd%2C%20Riyadh%20Saudi%20Arabia!5e0!3m2!1sen!2seg!4v1678609507110!5m2!1sen!2seg"
                        allowfullscreen></iframe>
                </div>
                <div class="col-lg-5">
                    <div class="contact-right">
                        <ul>
                            <li>
                                <div class="contact-icon"><img src="{{ asset('e-assets/images/icon/phone.png') }}"
                                        alt="Generic placeholder image">
                                    <h6>{{ __('Contact Us') }}</h6>
                                </div>
                                <div class="media-body">
                                    <p>Tel : +966 (0) 11 248 4111</p>
                                    <p>Fax : +966 (0) 11 248 4541</p>
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <h6>{{ __('Address') }}</h6>
                                </div>
                                <div class="media-body">
                                    <p>Al Yasmin District, Anas Bin Malek Road P.O. Box 15310 Riyadh 11444</p>
                                    <p>Kingdom of Saudi Arabia</p>
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><img src="{{ asset('e-assets/images/icon/email.png') }}"
                                        alt="Generic placeholder image">
                                    <h6>{{ __('Email') }}</h6>
                                </div>
                                <div class="media-body">
                                    <p>customercare@bintaleb.com </p>
                                    <p>bintaleb@bintaleb.com</p>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div> --}}

        </div>
    </section>
    <!--Section ends-->
@endsection
