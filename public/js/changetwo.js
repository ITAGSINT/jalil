$( function() {
  $( "#datepicker" ).datepicker({
    altField: "#alternate",
    altFormat: "DD, d MM, yy",
    defaultDate: null,
    minDate: 0, // Disable past dates
    onSelect: function(dateText, inst) {
      // This function runs when a date is selected
      console.log("Selected date: " + dateText);

      // Get the selected date
      let selectedDate = new Date(dateText);
      $('#date').val(dateText)
      $('#date2').val($("#alternate").val())
      
      $('#time').val('')
      $('#time2').val('')
      // Get the current date and time
      let currentDate = new Date();

      // Set current date to midnight to compare only the date part
      let currentDateMidnight = new Date(currentDate);
      currentDateMidnight.setHours(0, 0, 0, 0);

      // Clear the hours list
      $("#myUL").empty();

      // If the selected date is today
      if (selectedDate.getTime() === currentDateMidnight.getTime()) {
          // Get the current hour and minute
          let currentHour = currentDate.getHours();
          let currentMinutes = currentDate.getMinutes();

          // Calculate the start hour
          let startHour = currentHour + 1;
          

          // Display hours starting from the calculated start hour
          for (let i = startHour; i < 24; i++) {
            var temp=i;
            if(currentMinutes <10)
              $("#myUL").append(`<li class="my-1 text-center"><a  class="myli" data-time2="${i}:0${currentMinutes} - ${temp+1}:0${currentMinutes}" data-time="${i}:0${currentMinutes}">${i}:0${currentMinutes} - ${temp+1}:0${currentMinutes}</a></li>`);
            else 
            $("#myUL").append(`<li class="my-1 text-center"><a  class="myli" data-time2="${i}:${currentMinutes} - ${temp+1}:${currentMinutes}" data-time="${i}:${currentMinutes}">${i}:${currentMinutes} - ${temp+1}:${currentMinutes}</a></li>`);

          }
      } else {
          // Display all hours for other days
          for (let i = 0; i < 24; i++) {
            var temp=i;
              $("#myUL").append(`<li class="my-1 text-center"><a  class="myli" data-time2="${i}:00 - ${temp+1}:00" data-time="${i}:00">${i}:00 - ${temp+1}:00</a></li>`);
          }
      }
    }
  });
  $( "#datepicker" ).datepicker('setDate', null);
  $("#datepicker").val("");
  $('.ui-state-active').removeClass('ui-state-active');

} );

  
$(document).on('click','.myli',function () {
  $('#time').val($(this).data('time'))
  $('#time2').val($(this).data('time2'))
    if ($(this).hasClass('active')) {
      $(".myli").removeClass('active');
  }
  else {
  $(".myli").removeClass('active');
    $(this).addClass('active');
  }
  });

