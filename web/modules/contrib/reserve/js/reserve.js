(function ($, Drupal) {

  Drupal.behaviors.reserve = {
    attach: function (context, settings) {
      // set default Category tab if one is set in URL anchor
      var anchor = window.location.hash;
      if (anchor) {
        $('.room-tabs a.active').removeClass('active');
        $('.room-tabs li a[href=' + anchor + ']').addClass('active');
        $('.panel').hide();
        $(anchor).show();
      }

      // show the selected category panel
      $('.room-tabs a').click(function () {
        $this = $(this);
        $('.panel').hide();
        $('.room-tabs a.active').removeClass('active');
        $this.addClass('active').blur();
        var panel = $this.attr('href');
        $(panel).fadeIn(250);
        return false;
      });

      // change calendar date displayed
      $('#edit-date').change(function () {
        var datebits = $(this).val().split('-');
        var formatarr = drupalSettings.reserve.dateFormat.split('/');
        var dateobj = new Object();
        $.each(formatarr, function (index, value) {
          dateobj[value] = datebits[index];
        });
        var val = dateobj.m + '/' + dateobj.d;
        var newpath = '/reserve/' + drupalSettings.reserve.ebundle + '/calendar/' + val;
        window.location.href = newpath;
      });

      // show form fields for text message confirmation and reminder
      $('#edit-textmsg').each(function () {
        if ($(this).attr('checked')) {
          $('#txtmsg-fields').slideDown('fast');
        }
        else {
          $('#txtmsg-fields').slideUp('fast');
        }
      });
      $('#edit-textmsg').click(function () {
        if ($(this).attr('checked')) {
          $('#txtmsg-fields').slideDown('fast');
        }
        else {
          $('#txtmsg-fields').slideUp('fast');
        }
      });
			
      var isMouseDown = false, isHighlighted;
      var maxLength = drupalSettings.reserve.maxLength / 30;
      $("#rooms-calendar .panel li.reservable")

        .mousedown(function () {
          isMouseDown = true;
          // original code used toggleClass; but addClass works better
          $(this).addClass("highlighted");
          isHighlighted = $(this).hasClass("highlighted");
          return false; // prevent text selection
        })

        .mouseover(function () {
          if (isMouseDown) {
            $(this).addClass("highlighted", isHighlighted);
						
            // Limit the selection of cells equal to maxLength parameter
            var limitselect = document.querySelectorAll('.highlighted').length - 1;
            if (limitselect >= maxLength) {
                isMouseDown = false;
            }

			// Disable further selection when drag on lunch / booked time slot
		    $('.booked').mouseover(function () {
              isMouseDown = false;
            });
            $('.closed').mouseover(function () {
              isMouseDown = false;
            });

            // Restrict horizontal selection
            $('.grid-column').mouseleave(function () {
                isMouseDown = false;
            });
          }
        })
			
        .bind("selectstart", function () {
          return false;
        })
				
        .mouseup(function () {
          isMouseDown = false;
          var link = $('li.highlighted:first a');
          var count = $('li.highlighted').length;
          var href = $(link).attr('href');

          // not sure why the count == 0 case is required; but it occurs 2nd+ times modal is opened
          if (count == 0) return false;
          if (count == 1) {
            $('li.highlighted:first a').click();
          }
          else {
            var callback = 'reserve/ajax/reservation_add';
            $.ajax({
              async: false,
              url: Drupal.url(callback),
              data: {
                count: count,
                path: href
              },
              //dataType: 'json',
              success: function success(data) {
                if (data) {
                  var $myDialog = $('<div>' + data + '</div>').appendTo('body');
                  var options = {
                    title: 'Add Reservation',
                    width: 700,
                  };
                  Drupal.dialog($myDialog, options).showModal();
                }
              }
            });
          }

          $("#rooms-calendar .panel li.reservable").removeClass("highlighted");
        });
    }
  };
})(jQuery, Drupal);
