@extends('layouts.front.app')

@section('contentFront')
    <!-- start header -->
    <header class="tc-header-style10">
        <div style="z-index: 0" class="container">
            <div class="title text-capitalize text-center text-white">
                <h1 class="fsz-60"> {{ __('Steel manufacturing') }} </h1>
            </div>
            {{-- <p class="fsz-18 mt-30 text-white op-6"> Ensuring the best return on investment for your bespoke <br> SEO
                campaign requirement. </p> --}}
        </div>

        <div class="head-links">
            <a href="{{ route('front.index') }}"> {{ __('Home') }} </a>
            <span class="icon mx-2"> <i class="fal fa-angle-right"></i> </span>
            <a href="{{ route('front.steel') }}" class="active gold"> {{ __('Steel manufacturing') }} </a>
        </div>
    </header>
    <!-- end header -->

    <!--Contents-->
    <main>


        <!-- start tc-services-content -->
        <section class="tc-services-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="main-content">
                            <div class="main-img  mb-50">
                                <img src="{{ asset('/assets/img/elkomy/steel1.jpg') }}" alt="">
                            </div>

                            @if (app()->getLocale() == 'en')
                                <div class="text fsz-18 color-777 mb-30">
                                    The Suez iron factory was founded on July 25, 1995, at Suez Industrial Zone, in a 95,00
                                    metres square area with a total capital of 50 million EGP. <br>
                                    Our company’s production capacity is 400 thousand tons per year produced by more than
                                    1,200 workers who runs the production process 24 hours a day in 3 shifts.<br>
                                    Our raw materials are imported from abroad and manufactured locally by our Egyptian
                                    hands, and that’s what makes suez iron unique.<br>
                                    Our entity’s main objective is to reach an outstanding position in the steel
                                    manufacturing market delivering high quality material.<br>
                                    By investing in our human resources with a trained, qualified, and skilled team to be an
                                    effective participant in such an entity, we aim to develop a high and sophisticated
                                    production processes with high safety features in our factory, offering an extraordinary
                                    service and product with a strong commitment with our customers, workforce and
                                    environment.

                                </div>
                            @else
                                <div class="text fsz-18 color-777 mb-30">
                                    بدأ تاسيس مصنع السويس للصناعات الحديدية " الكومي للصلب" في 25-7-1995 في المنطقة الصناعية
                                    بالسويس علي مساحة تصل اللي 9500 متر مربع. برأس مال 50 مليون جنيهه مصري.<br>
                                    تصل قدرة المصنع الانتاجية الي 400 الف طن في العام الواحد من خلال اكثر من 1200 عامل
                                    يقومون بالعملية الانتاجية عن طريق ثلاثة مناوبات عمل علي مدار 24 ساعة يوميا.<br>
                                    نحن نستورد كل المواد الخام من الخارج و تصنع محليا علي يد مصرية, و هذا ما يجعل شركة
                                    السويس للصناعات الحديدية الفريدة في مجالها.<br>
                                    هدف شركتنا الاساسي هو الحصول علي مكانة متميز في سوق الصناعات الحديدية و توفير مواد ذات
                                    جودة عالية عن طريق الاستثمار في مواردنا البشرية بتعيين اشخاص مؤهلة و مدربة و لديها
                                    المهارات الكافية لكي تكون جزء فعال في هذا الكيان.<br>
                                    نحن نهدف الي التطور الدائم و استخدام التكنولوجيا الحديثة في عملية التصنيع, مواصفات سلامة
                                    عالية بالمصنع, تقديم خدمة ومنتجات استثنائية مع التزام قوي بعملاءنا وموظفينا والبيئة.

                                </div>
                            @endif



                            <div class="vision-card mb-70 overflow-hidden">
                                <div class="row align-items-center gx-5">
                                    <div class="col-lg-5">
                                        <div class="img img-cover radius-3 overflow-hidden">
                                            <img src="{{ asset('/assets/img/elkomy/steel2.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="info mt-4 mt-lg-0">
                                            <h5 class="fsz-24 mb-30">{{ __('Mission & Vision') }}</h5>


                                            <h6>{{ __('Mission') }}</h6>

                                            <p class="fsz-18 color-777 fw-400">
                                                {{ __('To be the middle east class standard for steel manufacturing.') }}
                                            </p>
                                            <h6>{{ __('Vision') }}</h6>

                                            <p class="fsz-18 color-777 fw-400">
                                                {{ __('Manufacture steel products with the highest quality.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text fsz-18 mb-50">
                                <h2 class="mt-3">{{ __('Our Values') }}</h2>


                                <ul class="mt-3">
                                    <li class="mb-2">



                                        <span class="fsz-14">
                                            <span class="fw-bold gold">{{ __('Quality guaranteed:') }}</span>
                                            {{ __('Providing quality in everything—our products, our employees work environment and our customers’ relationships, is our priority.') }}</span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Eco –friendly:') }}</span>
                                            {{ __('Be the least harmful factory to the environment.') }} </span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Global standers:') }}</span>
                                            {{ __('Setting global standards to our products to compete with international products.') }}
                                        </span>
                                    </li>
                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Development:') }}</span>
                                            {{ __('Sustainable developments to our products, machines, production process, and our strategy.') }}
                                        </span>
                                    </li>

                                    <li class="mb-2">


                                        <span class="fsz-14 ">
                                            <span class="fw-bold gold">{{ __('Feasibility:') }}</span>
                                            {{ __('Always be able to execute all the new strategies, technologies, and developments to provide innovative products.') }}
                                        </span>
                                    </li>

                                </ul>
                            </div>

                            <div class="form-group mb-4">
                                <div class="button_su radius-4 w-100">
                                    <span class="su_button_circle bg-000 desplode-circle"></span>
                                    <a href="{{ asset('assets/files/doc.pdf') }}"
                                        class="butn pt-15 pb-15 button_su_inner bg-blue3 m-0 radius-4 lh-1 w-100 text-center b-gold">
                                        <span class="button_text_container fsz-13 fw-bold text-capitalize text-white">
                                            {{ __('Chemical analysis of Elkomy factory') }} </span>
                                    </a>
                                </div>
                            </div>


                            <div class="text fsz-18 mb-50">

                                <div class="col-lg-12 mb-5">
                                    <img src="{{ asset('assets/img/videocover.png') }}" alt="">
                                </div>

                                @if (app()->getLocale() == 'en')
                                    <p class="fsz-18 color-777 fw-400 mb-4">
                                        The Production capacity is 400 thousand tons annually of rebar in accordance with
                                        the highest international quality standards
                                        Serrated reinforcement steel: 12 meters long
                                    </p>

                                    <li class="mb-2">Diameter 10, standard weight 617</li>
                                    <li class="mb-2">Diameter 12, standard weight 888</li>
                                    <li class="mb-2">Diameter 14, standard weight 1209</li>
                                    <li class="mb-2">Diameter 16, standard weight 1579</li>
                                    <li class="mb-2">Diameter 18, standard weight 1999</li>


                                    <p class="fsz-18 color-777 fw-400 mt-4">

                                        We have training centres at the highest level inside and outside the factory to
                                        empower workers and develop young cadres.
                                    </p>

                                    <p class="fsz-18 color-777 fw-400 mt-2">

                                        We have engineers with the highest level of experience, competence and skill in
                                        production, operations, electricity, quality, maintenance and production management,
                                        as well as technicians and workers with the highest level of efficiency.
                                    </p>

                                    <p class="fsz-18 color-777 fw-400 mt-2">

                                        We have distributors for all markets.
                                    </p>

                                    <p class="fsz-18 color-777 fw-400 mt-2">

                                        We meet all the needs of the local market as well as the Arab and African markets.
                                        El-Komy Iron and Steel is a professional family business that has been cohesive for
                                        decades and is growing and getting stronger El-Komy Iron and Steel is also
                                        distinguished by the fact that our prices are the best prices in the iron and steel
                                        markets in Egypt. Future vision: We are working to open new global markets and
                                        always welcome the opening of new markets.
                                    </p>

                                    <p class="fsz-18 color-777 fw-400 mt-2">


                                        We have many investments directed to social responsibility projects, such as the [
                                        Our People] Project in Dar el Salaam.

                                    </p>
                                @else
                                    <p class="fsz-18 color-777 fw-400">
                                        إنتاجنا من أسياخ حديد التسليح الصلب B500DWR عالى المقاومة
                                        الطاقة الإنتاجية 400 ألف طن سنويا من حديد التسليح وفقا لأعلى معايير الجودة العالمية
                                        حديد تسليح مشرشر : أطوال 12 متر
                                    </p>

                                    <li class="mb-2">قُطر 10 الوزن القياسى 617</li>
                                    <li class="mb-2">قُطر 12 الوزن القياسى 888</li>
                                    <li class="mb-2">ُطر 14 الوزن القياسى 1209</li>
                                    <li class="mb-2">قُطر 16 الوزن القياسى 1579</li>
                                    <li class="mb-2">قُطر 18 الوزن القياسى 1999</li>


                                    <p class="fsz-18 color-777 fw-400">
                                        نغطى إحتياجات السوق المحلى و نقوم بالتصدير للدول العربية وبعض الدول الأفريقية
                                        لدينا مراكز تدريب على أعلى مستوى داخل وخارج المصنع لتمكين العاملين وتطوير الكوادر
                                        الشابة
                                        لدينا مهندسين على أعلى مستوى من الخبرة والكفاءة والمهارة فى الإنتاج والعمليات
                                        والكهرباء والجودة والصيانة وإدارة الإنتاج وكذلك فنيين وعمال على أعلى مستوى من
                                        الكفاءة
                                        لدينا موزعين لكل الأسواق نلبى كافة احتياجات السوق المحلى وكذلك الأسواق العربية
                                        والأفريقية
                                        يتميز الكومى للحديد والصلب بأنه Family Business إحترافى متماسك منذ عشرات السنين
                                        وينمو أكثر وأكثر ويزداد قوة
                                        وكذلك يتميز الكومى للحديد والصلب بأن أسعارنا هى أحسن أسعار فى أسواق الحديد والصلب فى
                                        مصر
                                        الرؤية المستقبلية نعمل على فتح أسواق عالمية جديدة ونرحب دائما بفتح أسواق جديدة
                                        لدينا العديد من الإستثمارات الموجهة لمشروعات المسئولية المجتمعية مثل مشروع أهالينا
                                        فى دار السلام

                                    </p>
                                @endif




                            </div>


                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="widgets ps-lg-4 mt-4 mt-lg-0">
                            <div class="widget-card widget-links">
                                <p class="fsz-14 color-999 fw-bold mb-20 text-uppercase op-5"> {{ __('more businesses') }}
                                </p>
                                <ul>
                                    <li><a href="{{ route('front.steel') }}">{{ __('Steel manufacturing') }}</a></li>
                                    <li><a href="{{ route('front.real') }}">{{ __('Real estate investments') }}</a>
                                    </li>
                                    <li><a href="{{ route('front.currency') }}">{{ __('Currency Exchange') }}</a></li>
                                    <li><a href="{{ route('front.educational') }}">{{ __('Educational services') }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="widget-card widget-form">
                                <div class="form-group">
                                    <div class="button_su radius-4 w-100">
                                        <span class="su_button_circle bg-000 desplode-circle"></span>
                                        <a href="{{ route('front.contact') }}"
                                            class="butn pt-15 pb-15 button_su_inner bg-blue3 m-0 radius-4 lh-1 w-100 text-center b-gold">
                                            <span class="button_text_container fsz-13 fw-bold text-capitalize text-white">
                                                {{ __('Contact us') }} </span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end tc-services-content -->




    </main>
    <!--End-Contents-->
@endsection
