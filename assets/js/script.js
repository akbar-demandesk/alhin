(function ($) {

    "use strict";

    $(document).ready(function () {

        // Header Style and Scroll to Top
        function headerStyle() {
            if ($('.main-header').length) {
                var windowpos = $(window).scrollTop();
                var siteHeader = $('.main-header');
                var scrollLink = $('.scroll-top');
                if (windowpos >= 250) {
                    siteHeader.addClass('fixed-header');
                    scrollLink.fadeIn(300);
                } else {
                    siteHeader.removeClass('fixed-header');
                    scrollLink.fadeOut(300);
                }
            }
        }
        headerStyle();

        // dropdown menu

        var mobileWidth = 992;
        var navcollapse = $('.navigation li.dropdown');

        navcollapse.hover(function () {
            if ($(window).innerWidth() >= mobileWidth) {
                $(this).children('ul').stop(true, false, true).slideToggle(300);
                $(this).children('.megamenu').stop(true, false, true).slideToggle(300);
            }
        });

        //Submenu Dropdown Toggle
        if ($('.main-header .navigation li.dropdown ul').length) {
            $('.main-header .navigation li.dropdown').append('<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>');

            //Dropdown Button
            $('.main-header .navigation li.dropdown .dropdown-btn').on('click', function () {
                $(this).prev('ul').slideToggle(500);
                $(this).prev('.megamenu').slideToggle(800);
            });

            //Disable dropdown parent link
            $('.navigation li.dropdown > a').on('click', function (e) {
                e.preventDefault();
            });
        }

        //Submenu Dropdown Toggle
        if ($('.main-header .main-menu').length) {
            $('.main-header .main-menu .navbar-toggle').click(function () {
                $(this).prev().prev().next().next().children('li.dropdown').hide();
            });

        }


        /* Fact Counter + Text Count - Our Success */
        if ($('.success-item').length) {
            $('.success-item').appear(function () {

                var $t = $(this),
                    n = $t.find(".count-text").attr("data-stop"),
                    r = parseInt($t.find(".count-text").attr("data-speed"), 10);

                if (!$t.hasClass("counted")) {
                    $t.addClass("counted");
                    $({
                        countNum: $t.find(".count-text").text()
                    }).animate({
                        countNum: n
                    }, {
                        duration: r,
                        easing: "linear",
                        step: function () {
                            $t.find(".count-text").text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $t.find(".count-text").text(this.countNum);
                        }
                    });
                }

            }, {
                accY: 0
            });
        }

        
        //Testimony Section
        let reviewContainer = document.querySelector('.review-buttons');
        if (reviewContainer) {
            let currentBtn = document.querySelector('.review-buttons .review-btn.active');
            currentBtn.parentElement.classList.add('active-btn');
            reviewContainer.addEventListener('click', (e)=>{
                let reviewBtn = e.target.parentElement;
                if( 'A' == reviewBtn.nodeName ){
                    e.preventDefault();
                    let clickedIndex = parseInt(reviewBtn.getAttribute('data-review'));
                    let itemList = document.querySelectorAll('.testimony-content .review-single');
                    let currentReview = document.querySelector('.review-single.active');
                    let currentBtn = document.querySelector('.review-buttons .review-btn.active');
                    let currentBtnBox = document.querySelector('.review-buttons .active-btn');
                    currentBtnBox.classList.remove('active-btn');
                    currentReview.classList.remove('active');
                    currentBtn.classList.remove('active');
                    itemList[clickedIndex - 1].classList.add('active');
                    reviewBtn.classList.add('active');
                    reviewBtn.parentElement.classList.add('active-btn');
                }
            });
        }
        

        /* Partner Slider */
       if ($('.partner-wrap').length) {
           $('.partner-wrap').slick({
               infinite: true,
               autoplay: false,
               arrows: true,
               prevArrow: '<button class="partner-prev"><i class="fas fa-angle-double-left"></i></button>',
               nextArrow: '<button class="partner-next"><i class="fas fa-angle-double-right"></i></button>',
               pauseOnHover: false,
               autoplaySpeed: 2000,
               slidesToShow: 4,
               slidesToScroll: 1,
               responsive: [
                   {
                       breakpoint: 1200,
                       settings: {
                           slidesToShow: 4
                       }
                   },
                   {
                       breakpoint: 768,
                       settings: {
                           slidesToShow: 3
                       }
                   },
                   {
                       breakpoint: 400,
                       settings: {
                           slidesToShow: 2
                       }
                   }
               ]
           });
       }


        /* Case Slider */
       if ($('.case-wrap').length) {
           $('.case-wrap').slick({
               infinite: true,
               autoplay: false,
               arrows: true,
               prevArrow: '<button class="case-prev"><i class="fas fa-angle-double-left"></i></button>',
               nextArrow: '<button class="case-next"><i class="fas fa-angle-double-right"></i></button>',
               pauseOnHover: false,
               autoplaySpeed: 2000,
               slidesToShow: 3,
               slidesToScroll: 1,
               responsive: [
                   {
                       breakpoint: 1200,
                       settings: {
                           slidesToShow: 3
                       }
                   },
                   {
                       breakpoint: 768,
                       settings: {
                           slidesToShow: 2
                       }
                   },
                   {
                       breakpoint: 475,
                       settings: {
                           slidesToShow: 1
                       }
                   }
               ]
           });
       }


        /* Vission Mission Tabs */
        if($('.vission-tabs li').length){
          $('.vission-tabs li').click(function(){
            var tab_id = $(this).attr('data-tab');
            $('.vission-tabs li').removeClass('active');
            $('.vission-tab-content').removeClass('active');
            $(this).addClass('active');
            $("#"+tab_id).addClass('active');
          })
        };
        

        // Scroll to a Specific Div
        if ($('.scroll-to-target').length) {
            $(".scroll-to-target").on('click', function () {
                var target = $(this).attr('data-target');
                // animate
                $('html, body').animate({
                    scrollTop: $(target).offset().top
                }, 2000);

            });
        }


        // Elements Animation
        if ($('.wow').length) {
            var wow = new WOW({
                boxClass: 'wow', // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 0, // distance to the element when triggering the animation (default is 0)
                mobile: false, // trigger animations on mobile devices (default is true)
                live: true // act on asynchronously loaded content (default is true)
            });
            wow.init();
        }

        if ($("#map").length !== 0) {
            var map = L.map("map", { center: [-6.185033, 106.798862], zoom: 10, zoomControl: false, scrollWheelZoom: true });
            L.tileLayer("https://tile.osm.ch/switzerland/{z}/{x}/{y}.png", {}).addTo(map);
        }


    });

    
    
    /* ==========================================================================
       When document is resize, do
       ========================================================================== */

    $(window).on('resize', function () {
        var mobileWidth = 992;
        var navcollapse = $('.navigation li.dropdown');
        navcollapse.children('ul').hide();
        navcollapse.children('.megamenu').hide();

    });


    /* ==========================================================================
       When document is scroll, do
       ========================================================================== */

    $(window).on('scroll', function () {

        // Header Style and Scroll to Top
        function headerStyle() {
            if ($('.main-header').length) {
                var windowpos = $(window).scrollTop();
                var siteHeader = $('.main-header');
                var scrollLink = $('.scroll-top');
                if (windowpos >= 100) {
                    siteHeader.addClass('fixed-header');
                    scrollLink.fadeIn(300);
                } else {
                    siteHeader.removeClass('fixed-header');
                    scrollLink.fadeOut(300);
                }
            }
        }

        headerStyle();

    });

    /* ==========================================================================
       When document is loaded, do
       ========================================================================== */

    $(window).on('load', function () {

        //Hide Loading Box (Preloader)
        function handlePreloader() {
            if ($('.preloader').length) {
                $('.preloader').delay(200).fadeOut(500);
            }
        }
        handlePreloader();
        
    });


})(window.jQuery);
