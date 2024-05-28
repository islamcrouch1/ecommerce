        {{-- <!-- Start blog -->
        <section class="tc-blog-style39">
            <h2 class="float-title"> {{ __('Blog') }} </h2>
            <div class="container">
                <div class="title text-center mb-60 wow fadeInUp slow">
                    <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase"> {{ __('Blog') }} </h6>
                    <h3 class="fsz-50"> {{ __('latest news') }} </h3>
                </div>
                <div class="row gx-0 wow fadeInUp slow" data-wow-delay="0.2s">
                    @foreach ($posts as $post)
                        <div class="col-lg-4">
                            <div class="blog-card">
                                <div class="img img-cover">
                                    <img src="{{ asset($post->media->path) }}" alt="{{ getName($post) }}">
                                </div>
                                <div class="info">
                                    <div class="cont">
                                        <div class="date text-uppercase mb-15 fsz-14 "> <span class="me-30">
                                                {{ getName($post->website_category) }}
                                            </span> <a
                                                href="{{ route('front.posts', ['post' => $post->id, 'slug' => getName($post)]) }}">
                                                {{ $post->created_at }} </a> </div>
                                        <h6 class="fsz-20 fw-500 lh-4"> <a
                                                href="{{ route('front.posts', ['post' => $post->id, 'slug' => getName($post)]) }}">
                                                {{ getName($post) }}</a> </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>






            </div>
        </section>
        <!-- End blog --> --}}



        <!-- start projects -->
        <section class="tc-projects-style39">
            <div class="container-fluid p-0">
                <div class="content">
                    <div class="info wow fadeInUp slow">
                        <h2 class="float-title"> {{ __('Blog') }} </h2>
                        {{-- <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase"> {{ __('Blog') }} </h6> --}}
                        <h3 class="fsz-50"> {{ __('latest news') }} </h3>
                        <div class="arrows">
                            <a href="#0" class="swiper-prev"> <i
                                    class="fal fa-long-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                            </a>
                            <a href="#0" class="swiper-next"> <i
                                    class="fal fa-long-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                            </a>
                        </div>
                    </div>
                    <div class="tc-projects-slider39 wow fadeInUp slow" data-wow-delay="0.5s">
                        <div class="swiper-wrapper">


                            @foreach ($posts as $post)
                                <div class="swiper-slide">
                                    <div class="project-card">
                                        <div class="img img-cover">
                                            <img src="{{ asset($post->media->path) }}" alt="{{ getName($post) }}">
                                        </div>
                                        <div class="inf pt-40">
                                            <h6 class="fsz-14 ltspc-1 color-blue6 text-uppercase mb-10">
                                                {{ getName($post->website_category) }} </h6>
                                            <h5 class="fsz-24 fw-bold"> <a
                                                    href="{{ route('front.posts', ['post' => $post->id, 'slug' => getName($post)]) }}"
                                                    class="hover-underLine">
                                                    {{ getName($post) }} </a> </h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end projects -->
