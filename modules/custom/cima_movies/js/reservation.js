(function ($) {

    function editContent() {
      $('#listTable tr').click(function (e) {
        if (!$(e.target).is('button')) { // Make a difference between the click on the row and the button
            if ($(this).hasClass('selected')) { 
            $('#btn').remove();
            $('#res').remove();
            $(this).removeClass('selected');
            $(this).css('background', 'white');
    
            } else {
            $('#listTable tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('#firstRow').append("<th id='res'>Reservation</th>")
            $(this).append("<td ><button class='btn'>Reserve</button></td>");
            $(this).css('background', 'blue');
            }}
        });
    }

    function popup() {
        let days = [];
        let reservationData = {};
        $("#listTable,.modal").on('click', '.btn', function click(e) {
          let currentRow = $(this).closest("tr");
          let availableDays = currentRow.find("td:eq(4)").text().trim().replace(/ /g, '').split("\n"); // Remove spaces and Split the text to an array of days
          let genre = currentRow.find("td:eq(3)").text().trim().replace(/\n/g, '');   // Remove spaces and '\n' from the string
          let movieName = currentRow.find("td:eq(0)").text();
          $('.days').empty();
          $('#movieName').text(movieName);
          $('.modal').toggleClass('is-visible');
          $.each(availableDays, function (i, item) {
            $('.days').append("<button class='available'>" + item + "</button>")
          });
          $(".available").click(function () {
            let customerName = $('.customer').val();
            $('.confirm').html("<button>Confirm your movie reservation</button>");
            reservationData = {
                day_of_reservation: $(this).text(),
                reserved_movie_name : movieName,
                reserved_movie_genre : genre,
                customer_name : customerName
              };
          });
          $('#confirm').click(function () {
            $.ajax({
              type: "POST",
              url: '/movie-reservation',
              data: {'reservation': JSON.stringify(reservationData) },
              success: function () {
                $('.confirmed').html("<h2>Reservation confirmed</h2>")
              },
              error: function (req, err) {
                alert('Error : Failed to retrieve data - Error details :' + err);
              }
            });
          });
        });
      }
  
    let json = {};
    editContent();
    popup();
    const select = $('select');
    select.change(function () {
      $.ajax({
        url: '/movie-reservation?genreSelected=' + select.val(),
        type: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
          json = response;
          $('#listTable').find('tr').eq(0).nextAll().empty(); // Table  emptied from the second row after changing response
          $.each(json, function (i, item) {
            $('#listTable').append("<tr><td>" + item.name + "</td>" +
              "<td>" + item.description + "</td>" +
              "<td><img src=' " + item.poster + "'></td><td>"
              + item.genre + "</td><td>" + item.days + "</td></tr>");
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
  