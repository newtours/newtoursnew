import 'popper.js';
import 'bootstrap';


(function ($) {

  'use strict';

  Drupal.behaviors.helloWorld = {
    attach: function (context) {
      
      var shown = false;
      $(window).scroll(function () {
          console.log($('.navbar').scrollTop());
        if ($(window).scrollTop() == 0) {
            $('.block--sitebranding-2').fadeOut(200);
            $('.block--sitebranding-2 image').animate({
                height: "60px"
            }, 300);
            shown = false;
        } else if ($(window).scrollTop() > 0 && !shown) {
            $('.block--sitebranding-2').fadeIn(200);
            $('.block--sitebranding-2 image').animate({
                height: "120px"
            }, 300);
            shown = true;
    }
});
      
      
    }
  };

})(jQuery, Drupal);
