$(document).ready(function() {
  $(".click_open").click(function() {
    $(".open_menu").slideToggle();
  });
});

$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('.open_menu').length && !$target.closest('.click_open').length && $('.open_menu').is(":visible")) {
    $('.open_menu').slideUp();
  }
});




// $(document).ready(function() {
//   $("#action4").click(function() {
//     $("#show-action4").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action5").click(function() {
//     $("#show-action5").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action6").click(function() {
//     $("#show-action6").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action7").click(function() {
//     $("#show-action7").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action8").click(function() {
//     $("#show-action8").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action9").click(function() {
//     $("#show-action9").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action10").click(function() {
//     $("#show-action10").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action1").click(function() {
//     $("#show-action1").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action2").click(function() {
//     $("#show-action2").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action3").click(function() {
//     $("#show-action3").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action11").click(function() {
//     $("#show-action11").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action12").click(function() {
//     $("#show-action12").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action13").click(function() {
//     $("#show-action13").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action14").click(function() {
//     $("#show-action14").slideToggle();
//   });
// });
// $(document).ready(function() {
//   $("#action15").click(function() {
//     $("#show-action15").slideToggle();
//   });
// });




$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action1').length && !$target.closest('#action1').length && $('#show-action1 ').is(":visible")) {
    $('#show-action1 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action2').length && !$target.closest('#action2').length && $('#show-action2 ').is(":visible")) {
    $('#show-action2 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action3').length && !$target.closest('#action3').length && $('#show-action3 ').is(":visible")) {
    $('#show-action3 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action4').length && !$target.closest('#action4').length && $('#show-action4 ').is(":visible")) {
    $('#show-action4').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action5').length && !$target.closest('#action5').length && $('#show-action5 ').is(":visible")) {
    $('#show-action5 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action6').length && !$target.closest('#action6').length && $('#show-action6 ').is(":visible")) {
    $('#show-action6 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action7').length && !$target.closest('#action7').length && $('#show-action7 ').is(":visible")) {
    $('#show-action7 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action8').length && !$target.closest('#action8').length && $('#show-action8 ').is(":visible")) {
    $('#show-action8 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action9').length && !$target.closest('#action9').length && $('#show-action9 ').is(":visible")) {
    $('#show-action9 ').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action10').length && !$target.closest('#action10').length && $('#show-action10').is(":visible")) {
    $('#show-action10').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action11').length && !$target.closest('#action11').length && $('#show-action11').is(":visible")) {
    $('#show-action11').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action12').length && !$target.closest('#action12').length && $('#show-action12').is(":visible")) {
    $('#show-action12').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action13').length && !$target.closest('#action13').length && $('#show-action13').is(":visible")) {
    $('#show-action13').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action14').length && !$target.closest('#action14').length && $('#show-action14').is(":visible")) {
    $('#show-action14').slideUp();
  }
});
$(document).on('click', function() {
  var $target = $(event.target);
  if(!$target.closest('#show-action15').length && !$target.closest('#action15').length && $('#show-action15').is(":visible")) {
    $('#show-action15').slideUp();
  }
});

/*===================================*
  24. CHECKBOX CHECK THEN ADD CLASS JS
  *===================================*/
$('.new-diif').show();
$('#radio1:radio').on('change', function() {
  if($(this).is(":checked")) {
    $('.new-diif').slideUp();
  } else {
    $('.new-diif').slideDown();
  }
});
$('.new-diif').hide();
$('#radio2:radio').on('change', function() {
  if($(this).is(":checked")) {
    $('.new-diif').slideDown();
  } else {
    $('.new-diif').slideUp();
  }
});

$('.moreless-button1').click(function() {
  $('.moretext1').slideToggle();
  if ($('.moreless-button1').text() == "Read More +") {
    $(this).text("Read Less -")
  } else {
    $(this).text("Read More +")
  }
});
$('.moreless-button2').click(function() {
  $('.moretext2').slideToggle();
  if ($('.moreless-button2').text() == "Read More +") {
    $(this).text("Read Less -")
  } else {
    $(this).text("Read More +")
  }
});
$('.moreless-button3').click(function() {
  $('.moretext3').slideToggle();
  if ($('.moreless-button3').text() == "Read More +") {
    $(this).text("Read Less -")
  } else {
    $(this).text("Read More +")
  }
});
$('.moreless-button4').click(function() {
  $('.moretext4').slideToggle();
  if ($('.moreless-button4').text() == "Read More +") {
    $(this).text("Read Less -")
  } else {
    $(this).text("Read More +")
  }
});
$('.moreless-button9').click(function() {
  $('.moretext9').slideToggle();
  if ($('.moreless-button5').text() == "Read More +") {
    $(this).text("Read Less -")
  } else {
    $(this).text("Read More +")
  }
});
$('.moreless-button10').click(function() {
  $('.moretext10').slideToggle();
  if ($('.moreless-button10').text() == "Read More +") {
    $(this).text("Read Less -")
  } else {
    $(this).text("Read More +")
  }
});
$('.moreless-button11').click(function() {
  $('.moretext11').slideToggle();
  if ($('.moreless-button11').text() == "Read More +") {
    $(this).text("Read Less -")
  } else {
    $(this).text("Read More +")
  }
});

/*===================================*
  24. CHECKBOX CHECK THEN ADD CLASS JS
  *===================================*/
$('.tutor-c').show();
$('#radio4:radio').on('change', function() {
  if($(this).is(":checked")) {
    $('.tutor-c').slideUp();
  } else {
    $('.tutor-c').slideDown();
  }
});
$('.tutor-c').hide();
$('#radio3:radio').on('change', function() {
  if($(this).is(":checked")) {
    $('.tutor-c').slideDown();
  } else {
    $('.tutor-c').slideUp();
  }
});
// $('.tutor-c1').show();
$('#radio6:radio').on('change', function() {
  if($(this).is(":checked")) {
    $('.tutor-c1').slideDown();
  } else {
    $('.tutor-c1').slideUp();
  }
});
// $('.tutor-c1').hide();
$('#radio7:radio').on('change', function() {
  if($(this).is(":checked")) {
    $('.tutor-c1').slideUp();
  } else {
    $('.tutor-c1').slideDown();
  }
});


// $(function() {
//   $("#datepicker").datepicker();
// });
// $(function() {
//   $("#datepicker2").datepicker();
// });
// $(function() {
//   $("#datepicker3").datepicker();
// });


$('#example2').calendar({
  type: 'date'
});
$('#example1').calendar({
  type: 'date'
});
$('#example3').calendar({
  type: 'time'
});
$('#example4').calendar({
  type: 'time'
});
$('#example5').calendar({
  type: 'time'
});
$('#example6').calendar({
  type: 'time'
});
$('#example7').calendar({
  type: 'time'
});
$('#example8').calendar({
  type: 'time'
});
$('#example9').calendar({
  type: 'time'
});
$('#example10').calendar({
  type: 'time'
});
$('#example11').calendar({
  type: 'time'
});
$('#example12').calendar({
  type: 'time'
});
$('#example13').calendar({
  type: 'time'
});
$('#example15').calendar({
  type: 'time'
});
$('#example118').calendar({
  type: 'time'
});
$('#example119').calendar({
  type: 'time'
});

$('#rangestart').calendar({
  type: 'date',
  endCalendar: $('#rangeend')
});
$('#rangeend').calendar({
  type: 'date',
  startCalendar: $('#rangestart')
});
$('#example24').calendar({
  startMode: 'year'
});
$('#example25').calendar();
$('#example26').calendar({
  ampm: false,
  type: 'time'
});
$('#example17').calendar({
  type: 'month'
});
$('#example18').calendar({
  type: 'year'
});
$('#example19').calendar();
$('#example20').calendar({
  on: 'hover'
});
var today = new Date();
$('#example31').calendar({
  minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() - 5),
  maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 5)
});
$('#example32').calendar({
  monthFirst: false
});
$('#example33').calendar({
  monthFirst: false,
  formatter: {
    date: function (date, settings) {
      if (!date) return '';
      var day = date.getDate();
      var month = date.getMonth() + 1;
      var year = date.getFullYear();
      return day + '/' + month + '/' + year;
    }
  }
});
$('#example34').calendar({
  inline: true
});
$('#example35').calendar();







$(document).ready(function(){
    $(".divs div").each(function(e) {
        if (e != 0)
            $(this).hide();
    });

    $("#next").click(function(){
        if ($(".divs div:visible").next().length != 0)
            $(".divs div:visible").next().show().prev().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:first").show();
        }
        return false;
    });
    $("#next1").click(function(){
        if ($(".divs div:visible").next().length != 0)
            $(".divs div:visible").next().show().prev().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:first").show();
        }
        return false;
    });
    $("#next2").click(function(){
        if ($(".divs div:visible").next().length != 0)
            $(".divs div:visible").next().show().prev().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:first").show();
        }
        return false;
    });
     $("#prev").click(function(){
        if ($(".divs div:visible").prev().length != 0)
            $(".divs div:visible").prev().show().next().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:last").show();
        }
        return false;
    });
     $("#prev1").click(function(){
        if ($(".divs div:visible").prev().length != 0)
            $(".divs div:visible").prev().show().next().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:last").show();
        }
        return false;
    });
     $("#prev2").click(function(){
        if ($(".divs div:visible").prev().length != 0)
            $(".divs div:visible").prev().show().next().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:last").show();
        }
        return false;
    });
     $("#prev3").click(function(){
        if ($(".divs div:visible").prev().length != 0)
            $(".divs div:visible").prev().show().next().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:last").show();
        }
        return false;
    });
    $("#next3").click(function(){
        if ($(".divs div:visible").next().length != 0)
            $(".divs div:visible").next().show().prev().hide();
        else {
            $(".divs div:visible").hide();
            $(".divs div:first").show();
        }
        return false;
    });

});
chk=$('input[name="tutorrados"]:checked').val();
 if(chk=='Y'){
  $('.tutor-c1').show();
}
 if(chk=='N'){
   $('.tutor-c1').hide();
}
$('.change-new-link').click(function() {
    chk=$('input[name="tutorrados"]:checked').val();
      if(chk=='Y'){
         window.location.href="student-bookclass.html";
      }
       if(chk=='N'){
          window.location.href="tutor-search-result.html";
      }
  })





function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = ["Rabin Manna" , "Anisha R." , "Anisha T." , "Rahul Roy" , "Avishek Das" ,  "Sayanti Das"
 ,  "Chandan Das" ,  "Devin Prister" ,  "Binod Prister" ,  "Ericca Sami" ,  "Fred Prister" ,  "Gorge Mull" ,  "Iman Das"
  ,  "Ranik Das" , "Kalyan Bera" , "Swapan Bera" , "Prabin Das" , "Monalia Roy" , "Tanmoy Dey"  , "Yash Devil"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
const searchInput1 = document.getElementById("myInput");
    if (searchInput1) {
        autocomplete(searchInput1, countries);
    }

