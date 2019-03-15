/**
 * @file
 * Fullcalendar View plugin JavaScript file.
 */

(function ($, Drupal,drupalSettings) {
    Drupal.behaviors.tourcalendarView = {
      attach: function (context, settings) {
          console.log(drupalSettings.defaultView);
          $('#calendar').fullCalendar({        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        editable: false,
        fixedWeekCount: false,
        defaultView: drupalSettings.defaultView,
        //defaultView: 'basicWeek',
        // defaultView: 'agendaWeek',
        //defaultView: 'basicDay',
        timezone: false,
        eventSources: [
            //"https://www.hebcal.com/hebcal/?cfg=fc&v=1&i=off&maj=on&min=on&nx=on&mf=on&ss=on&mod=on&lg=s&s=on&&c=on&geo=zip&zip=11223&city=&geonameid=&b=18&m=50&o=on",
            [JSON.parse(drupalSettings.nodeEvents)],
            "/calendar-data",
            "/calendar-data/local"
     //"https://www.hebcal.com/hebcal/?v=1&maj=on&min=on&nx=on&mf=on&ss=on&mod=on&s=on&i=off&year=2018&month=x&yt=G&lg=s&d=on&c=on&geo=zip&zip=11223&city=&geonameid=&b=18&m=50&.s=Create+Calendar"
                  //cache: true
        ],
        eventClick: function(calEvent, jsEvent, view) {

                  var eventDate = new Date(calEvent.start);
                  var eventDateString = moment(eventDate).add(1, 'days').format('YYYY-MM-DD');
            var eventUrl = '/weekly-parsha-date/' + eventDateString;
            alert(moment(eventDate).add(1, 'days').format('YYYY-MM-DD'));
                  console.log(eventDate);
                  //alert('Event: ' + calEvent.title);
                  //alert('Url:' + calEvent.url);
                  //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                  //alert('View: ' + view.name);

                  // change the border color just for fun
                  //$(this).css('border-color', 'red');
                    if (calEvent.url) {

                        alert(calEvent.start)
                        window.open(eventUrl);
                        return false;
                    }

              },
        dayClick: function(date, jsEvent, view, resourceObj) {

                  //alert('Date: ' + date.format());
                  //alert('Resource ID: ' + resourceObj.id);

              }
          });

    $("body").keydown(function(e) {
        if (e.keyCode == 37) {
            $('#calendar').fullCalendar('prev');
        } else if (e.keyCode == 39) {
            $('#calendar').fullCalendar('next');
        }
    });
      }
    };
})(jQuery, Drupal,drupalSettings);
