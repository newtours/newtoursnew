/**
 * @file
 * Parsha dat output.
 */

(function ($, Drupal,drupalSettings) {
    var counter = 1;
    Drupal.behaviors.youngcalendarParsha = {
      attach: function (context, settings) {

          $('#weekly',context).once('parshaBehaviors').each(function () {
              //$("#parsha").addClass("parsha")
              console.log(drupalSettings.parsha);
              $.each(drupalSettings.parsha.he , function( key,value){
                  if (value instanceof Array) {
                      $.each(value, function (subKey, subValue) {
                          $("#weekly").append('<div id="halak-' + key + ':' + subKey + '" class="halak-section">' +
                          '<div class="parsha-halak-hebrew">' + subValue + '</div>' +
                          '<div class="parsha-halak-engl">' + drupalSettings.parsha.text[key][subKey] + '</div>' +
                          '</div>');
                          //console.log(subValue);
                      })
                  } else {
                      $("#weekly").append('<div id="halak-' + key + ':' +  '">' +
                      '<div class="parsha-halak-hebrew">' + value + '</div>' +
                      '<div class="parsha-halak-engl">' + drupalSettings.parsha.text[key] + '</div>' +
                      '</div>');
                  }
              })
              //console.log(drupalSettings.parsha.text);

          });



      }
    };
})(jQuery, Drupal,drupalSettings);
