/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

  'use strict';

  Drupal.behaviors.bootstrap_barrio_subtheme = {
    attach: function(context, settings) {
      var position = $(window).scrollTop();
      $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
          $('body').addClass("scrolled");
        }
        else {
          $('body').removeClass("scrolled");
        }
        var scroll = $(window).scrollTop();
        if (scroll > position) {
          $('body').addClass("scrolldown");
          $('body').removeClass("scrollup");
        } else {
          $('body').addClass("scrollup");
          $('body').removeClass("scrolldown");
        }
        position = scroll;
      });

        function theme_menu(){

            //Main menu
            $('#main-menu').smartmenus();

            //Mobile menu toggle
            $('.navbar-toggle').click(function(){
                $('.region-primary-menu').slideToggle();
            });

            //Mobile dropdown menu
            if ( $(window).width() < 767) {

                $(".region-primary-menu li a:not(.has-submenu)").click(function () {
                    $('.region-primary-menu').hide();
                });
            }

        }

        function theme_home(){

            //flexslider
            $('.flexslider').flexslider({
                animation: "slide"
            });

        }
        theme_menu();
        theme_home();


    }
  };

})(jQuery, Drupal);