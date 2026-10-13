

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
