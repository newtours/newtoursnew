/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function(){
  // setup your carousels as you normally would using JS
  // or via data attributes according to the documentation
  // https://getbootstrap.com/javascript/#carousel

}());

(function ($, Drupal, settings) {

    $(".vertical-center-4").slick({
        dots: true,
        vertical: true,
        centerMode: true,
        slidesToShow: 4,
        slidesToScroll: 2
    });
    $(".vertical-center-3").slick({
        dots: true,
        vertical: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3
    });
    $(".vertical-center-2").slick({
        dots: true,
        vertical: true,
        centerMode: true,
        slidesToShow: 2,
        slidesToScroll: 2
    });
    $(".vertical-center").slick({
        dots: true,
        vertical: true,
        centerMode: true
    });
    $(".vertical").slick({
        dots: true,
        vertical: true,
        slidesToShow: 3,
        slidesToScroll: 3
    });
    $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3
    });
    $("#top-mainpage-carousel").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        //focusOnSelect: true,
      responsive: [
        {
          breakpoint: 1210,
          settings: {
            variableWidth: true,
            draggable: true,
            slidesToShow: 2,
            arrows: false
          }
        },
        {
          breakpoint: 480,
          settings: {
            variableWidth: true,
            draggable: true,
            slidesToShow: 1,
            arrows: false
          }
        }
      ]
    });
    $(".variable").slick({
        dots: true,
        infinite: true,
        variableWidth: true
    });
    $(".lazy").slick({
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true
    });



    $('.carousel-custom').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: true,
        centerMode: true,
        focusOnSelect: true
    });
})(jQuery, Drupal);


