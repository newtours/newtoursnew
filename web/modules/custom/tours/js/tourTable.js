/**
 * Created by rbensman on 2/11/19.
 */
(function ($, Drupal) {
    Drupal.behaviors.tours = {
        attach: function (context, settings) {
            //alert("Here")
            console.log(drupalSettings.tourData)
            $('#tour-list-main').DataTable();
        }
    }
})(jQuery, Drupal);

