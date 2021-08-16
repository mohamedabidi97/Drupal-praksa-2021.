(function ($) {

    function editContent() {
      $('#listTable tr').click(function () {
        if ($(this).hasClass('selected')) {
          $('#btn').remove();
          $('#res').remove();
          $(this).removeClass('selected');
          $(this).css('background', 'white');
  
        } else {
          $('#listTable tr.selected').removeClass('selected');
          $(this).addClass('selected');
          $('#firstRow').append("<th id='res'>Reservation</th>")
          $(this).append("<td id='btn'><button>Reserve</button></td>");
          $(this).css('background', 'blue');
        }
      });
    }
  
    var json = {};
    editContent();
    let select = $('select');
    select.change(function () {
      $.ajax({
        url: '/movie-reservation?genreSelected=' + select.val(),
        type: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
          json = response;
          $('#listTable').find('tr').eq(0).nextAll().empty(); // Table  emptied from the second row after changing response
          console.log(json);
          $.each(json, function (i, item) {
            $('#listTable').append("<tr><td>" + item.name + "</td><td>" + item.description + "</td><td><img src=' " + item.poster + "'></td><td>" + item.genre + "</td><td>" + item.days + "</td></tr>");
          });
        },
        complete: function () {
          editContent();
        },
        error: function (req, err) {
          alert('Error : Failed to retrieve data - Error details :' + err);
        }
      })
    })
  }(jQuery));
  