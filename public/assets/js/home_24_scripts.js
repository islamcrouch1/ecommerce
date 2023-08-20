$( function() {

    var wind = $(window);

    wow = new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        offset: 200,
        mobile: false,
        live: false
    });
    wow.init();

    // ---------- background change -----------
    var pageSection = $(".bg-img");
    pageSection.each(function (indx) {

        if ($(this).attr("data-background")) {
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });

    // ---------- social links -----------
    $(".tc-team-style38 .plus-btn").on("click",function(){
        $(this).siblings().toggleClass("show");
        $(this).toggleClass("show");
    })
    $(".tc-team-style38 .socials").on("mouseleave",function(){
        $("a").removeClass("show");
    })

    // ---------- to top -----------

    wind.on("scroll", function() {

        var bodyScroll = wind.scrollTop(),
            toTop = $(".to_top")

        if (bodyScroll > 700) {

            toTop.addClass("show");

        } else {

            toTop.removeClass("show");
        }
    });

    $('.to_top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 0);
        return false;
    });

    /* ==  float_box_container button  == */
  $( ".float_box_container" ).mousemove(function(e) {
        var parentOffset = $(this).offset(); 
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top;
        $(".float_box").css({"left": relX, "top": relY });
        $(".float_box").addClass("show");
    });
    $( ".float_box_container" ).mouseleave(function(e) {
        $(".float_box").removeClass("show");
    });

    /* ==  Button Animation  == */
  $( ".button_su_inner" ).mouseenter(function(e) {
    var parentOffset = $(this).offset(); 
    var relX = e.pageX - parentOffset.left;
    var relY = e.pageY - parentOffset.top;
    $(this).prev(".su_button_circle").css({"left": relX, "top": relY });
    $(this).prev(".su_button_circle").removeClass("desplode-circle");
    $(this).prev(".su_button_circle").addClass("explode-circle");
  });
  
  $( ".button_su_inner" ).mouseleave(function(e) {
    var parentOffset = $(this).offset(); 
    var relX = e.pageX - parentOffset.left;
    var relY = e.pageY - parentOffset.top;
    $(this).prev(".su_button_circle").css({"left": relX, "top": relY });
    $(this).prev(".su_button_circle").removeClass("explode-circle");
    $(this).prev(".su_button_circle").addClass("desplode-circle");
  });

  // -------- counter --------
  $('.counter').countUp({
        delay: 10,
        time: 2000
    });

    // --------- fav btn ---------
    $(".fav-btn").on("click" , function(){
        $(this).toggleClass("active");
    })

});

// ------------ working in desktop -----------
if ($(window).width() > 991) {
        $('.parallaxie').parallaxie({
    });
}

// ------------ swiper sliders -----------
$(document).ready(function() {

    var swiper = new Swiper('.tc-projects-slider39', {
        slidesPerView: "auto",
        spaceBetween: 50,
        // centeredSlides: true,
        speed: 1000,
        pagination: false,
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
        mousewheel: false,
        keyboard: true,
        autoplay: {
            delay: 5000,
        },
        loop: true,
        // breakpoints: {
        //     0: {
        //         slidesPerView: 1,
        //     },
        //     480: {
        //         slidesPerView: 1,
        //     },
        //     787: {
        //         slidesPerView: 2,
        //     },
        //     991: {
        //         slidesPerView: 2,
        //     },
        //     1200: {
        //         slidesPerView: 2.7,
        //     }
        // }
    });


        // // clients sliders 
        var testiTop = new Swiper(".tc-testimonials-slider39 .testi-top", {
            spaceBetween: 40,
            grabCursor: true,
            speed: 1000,
            navigation: {
                nextEl: '.tc-testimonials-slider39 .swiper-next',
                prevEl: '.tc-testimonials-slider39 .swiper-prev',
            },
            loop: true,
            loopedSlides: 3,
            //  autoplay: false,
             autoplay: {
                 delay: 5000,
             },
            // other parameters
            on: {
            click: function() {
                /* do something */
            }
            },
            keyboard: {
            enabled: true,
            onlyInViewport: false
            }
        });
        /* thumbs */
        var testiThumbs = new Swiper(".tc-testimonials-slider39 .testi-btm", {
            spaceBetween: 50,
            centeredSlides: true,
            pagination: {
                el: ".tc-testimonials-slider39 .swiper-pagination",
                clickable: true,
            },
            speed: 1000,
            slidesPerView: "3",
            touchRatio: 0.4,
            slideToClickedSlide: true,
            loop: true,
            loopedSlides: 3,
            keyboard: {
            enabled: true,
            onlyInViewport: false
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                480: {
                    slidesPerView: 2,
                },
                787: {
                    slidesPerView: 2,
                },
                991: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                }
            },
        });
      
      /* set controller  */
      testiTop.controller.control = testiThumbs;
      testiThumbs.controller.control = testiTop;

});


