/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($, Drupal, settings) {

  $('.top-main-page-header').owlCarousel({
    items:4,
    loop:true,
    margin:0,
    nav:true,
    //slideBy: 1,
    dots:false,
    center:false,
    autoWidth: false,
    //singleItem:true,
    responsive:{
      0:{
        items:1
      },
      480:{
        items:2
      },
      800:{
        items:3
      },
      1699:{
        items:4
      }
    }
  })
  var widthItem = $(".owl-item .item .card").width();
  $(".owl-item .item").css("width", widthItem +1)
})(jQuery, Drupal);


