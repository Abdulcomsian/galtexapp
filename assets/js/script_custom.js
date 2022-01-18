$(document).ready(function() {
  
  // header sticky start
 
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();    
        if (scroll >= 150) {
            $(".header_sec").addClass('affix');
        } else {
            $(".header_sec").removeClass('affix');
        }
    });

  // header sticky end

  $('.pro_package_slider').slick({
    dots: false,
    arrows:false,
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    rtl: rtl_slick(),
  });


  $('.product_slider_main').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots:false,
        fade: true,
        asNavFor: '.product_slider_thumb',
        rtl: rtl_slick(),
    });
    $('.product_slider_thumb').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.product_slider_main',
        dots: false,
        arrows:true,
        focusOnSelect: true,
        rtl: rtl_slick(),
    });

    // ZOOM
    if ($('.ex1').length > 0) {    
      $('.ex1').zoom();
    }

    if ($('.touch-spin-count').length > 0) {   
      $(".touch-spin-count").TouchSpin({
          min: 1,
          max: 99
      });
    }
    if ($('.touch-spin-count-ver').length > 0) {   
        $(".touch-spin-count-ver").TouchSpin({
            min: 1,
            max: 99
        });
      }


    // $(".custom_form .form-control").focus(function() {
    //     $(this).parents('.form-group').addClass('focus_label');
    // })
    // .blur(function() {
    //     tmpval = $(this).val();
    //     if (tmpval == '') {
    //         $(this).parents('.form-group').removeClass('focus_label');
    //     }
    // });


    //sub_mnu start
    if ($(window).width() < 992) {
      $(".has_dd").append("<span class='dd_arrow'> <i class='fas fa-angle-down'></i></span>");
      $(".has_dd > .dd_arrow").click(function(){
        $(this).prev('.sub_menu').slideToggle();
        // $(this).toggleClass('open');
        // $(this).parents('.has_dd').siblings('li').removeClass('open');
        $(this).parents('.has_dd').siblings('li').children('.sub_menu').slideUp();
      });

      $('.userdd_open').attr("href", "javascript:void(0);")
      $(document).on('click', '.userdd_open', function(){
        $(this).next('.dropdown-hover').slideToggle();
      });
    }



    // home slider start
    $('.home_slider').on('init', function(e, slick) {
          var $firstAnimatingElements = $('.home_slide:first-child').find('[data-animation]');
          doAnimations($firstAnimatingElements);    
    });
    $('.home_slider').on('beforeChange', function(e, slick, currentSlide, nextSlide) {
              var $animatingElements = $('.home_slide[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
              doAnimations($animatingElements);    
    });
    $('.home_slider').slick({
      dots: false,
      arrows:true,
      infinite: true,
      loop:true,
      speed: 1000,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade:true,
      autoplay: true,
      autoplaySpeed: 5000,
      rtl: rtl_slick(),
    });  
    function doAnimations(elements) {
        var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        elements.each(function() {
            var $this = $(this);
            var $animationDelay = $this.data('delay');
            var $animationType = 'animated ' + $this.data('animation');
            $this.css({
                'animation-delay': $animationDelay,
                '-webkit-animation-delay': $animationDelay
            });
            $this.addClass($animationType).one(animationEndEvents, function() {
                $this.removeClass($animationType);
            });
        });
    }
    // home slider end

    $('.product_slider_list').slick({
      dots: false,
      arrows:true,
      infinite: true,
      loop:true,
      speed: 1000,
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      rtl: rtl_slick(),
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2,
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    }); 

    function rtl_slick(){
    if ($('html').hasClass("lang_he")) {
       return true;
    } else {
       return false;
    }}

});  //document.ready end




  wow = new WOW(
    {
      animateClass: 'animated',
      offset:       120,
      mobile:       false, 
    }
  );
  wow.init();


$('body').on('change','input.budget-categories',function(){
  let budget_categories = $('input.budget-categories:checkbox:checked').map(function() {
                        return this.value;
                    }).get();

  var url = new URL(location.origin + location.pathname + location.search + (location.search=='' ? '?' : '&'));
  var search_params = url.searchParams;
  search_params.set('budget_categories', budget_categories.join(","));
  url.search = search_params.toString();
  var new_url = url.toString();
  window.location.href = new_url;
})

$('body').on('change','input.main_categories',function(){
  let main_categories = $('input.main_categories:checkbox:checked').map(function() {
                        return this.value;
                    }).get();

  var url = new URL(location.origin + location.pathname + location.search + (location.search=='' ? '?' : '&'));
  var search_params = url.searchParams;
  search_params.set('main_categories', main_categories.join(","));
  url.search = search_params.toString();
  var new_url = url.toString();
  window.location.href = new_url;
})