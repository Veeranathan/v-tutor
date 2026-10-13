<!-- jQuery & jQuery Validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script src="{{ public_asset('assets/js/semantic.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ public_asset('assets/js/bootstrap.js') }}"></script>

<!-- Other Libraries -->
<script src="{{ public_asset('assets/js/carouselscript.js') }}"></script>
<script src="{{ public_asset('assets/js/moment.js') }}"></script>
<script src="{{ public_asset('assets/js/jquery-ui.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<!-- Flatpickr & Semantic UI -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Owl Carousel (Correct Version) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<!-- Custom Scripts -->
<script src="{{ public_asset('js/countrySelect.min.js')}}"></script>

<script src="{{ public_asset('assets/js/custom.js') }}"></script>

@if (Request::segment(2) != 'login')
    <script type="text/javascript">
        // $('#waitFor1').modal('show');
        document.addEventListener('readystatechange', event => {
            $('#waitFor1').show();
            // When HTML/DOM elements are ready:
            if (event.target.readyState ===
                "interactive") { //does same as:  ..addEventListener("DOMContentLoaded"..
                // $('#waitFor1').modal('show');
                // alert("hi 1");
            }

            // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
            if (event.target.readyState === "complete") {
                // alert("hi 2");
                $('#waitFor1').hide();
                // $('#waitFor1').modal('hide');
            }
        });
    </script>
@endif
<script>
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    // yes
    $('#radio6:radio').change(function() {

        $("#search").val("");
        $("#search_tutor_id").val("");
        $("#search_tutor_selected_name").val("");
        $("#search_tutor_slug").val("");

    });
    // no
    $('#radio7:radio').change(function() {
        // if($(this).is(":checked")) {

        // }
        $("#search").val("");
        $("#search_tutor_id").val("");
        $("#search_tutor_selected_name").val("");
        $("#search_tutor_slug").val("");

    });
    $("#search").blur(function() {
        if ($.trim($("#search_tutor_selected_name").val()) != $.trim($(this).val())) {
            $(this).val("");
        }
    });
</script>
<script>
    $(".toggle-password1").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
{{-- <script>
  $('#checkbox1').change(function(){
    if ($(this).prop('checked')==true){
      $('.disable-input').prop("disabled",false);
      $('.submit-login').removeClass('disable-input');
      $('.submit-social').removeClass('disable-input');
    }else{
      // $('.disable-input').Attr('disabled');
      // $('.submit-login').addClass('disable-input');
      $('.submit-login').addClass('disable-input');
      $('.disable-input').prop("disabled",true);
       $('.submit-social').addClass('disable-input');
    }
  });

</script> --}}

{{-- ............................. --}}
{{--   <script>
    $('.moreless-button4').click(function() {
        $('.moretext4').slideToggle();
        if($('.moreless-button4').text() == "Read More +") {
            $(this).text("Read Less -")
        } else {
            $(this).text("Read More +")
        }
    });
    </script> --}}
<script>
    $('.moreless-button5').click(function() {
        $('.more-text5').slideToggle();
        if ($('.moreless-button5').text() == "Load  More +") {
            $(this).text("Load Less -")
        } else {
            $(this).text("Load More +")
        }
    });
</script>
{{--     <script type="text/javascript">
    $(document).ready(function() {
        $(".click_open").click(function() {
            $(".open_menu").slideToggle("slow");
        });
    });
    </script> --}}
<script type="text/javascript">
    $(document).ready(function() {
        $(".showmeu").click(function() {
            $(".dasbordLeft").slideToggle("slow");
        });
    });
</script>

<script type="text/javascript">
    $('#example1').calendar();
    $('#example2').calendar({
        type: 'date'
    });
    $('#example3').calendar({
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
    $('#example4').calendar({
        startMode: 'year'
    });
    $('#example5').calendar();
    $('#example6').calendar({
        ampm: false,
        type: 'time'
    });
    $('#example7').calendar({
        type: 'month'
    });
    $('#example8').calendar({
        type: 'year'
    });
    $('#example9').calendar();
    $('#example10').calendar({
        on: 'hover'
    });
    var today = new Date();
    $('#example11').calendar({
        minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() - 5),
        maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 5)
    });
    $('#example12').calendar({
        monthFirst: false
    });
    $('#example13').calendar({
        monthFirst: false,
        formatter: {
            date: function(date, settings) {
                if (!date) return '';
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                return day + '/' + month + '/' + year;
            }
        }
    });
    $('#example14').calendar({
        inline: true
    });
    $('#example15').calendar();
</script>
<script type="text/javascript">
    $(document).ready(function() {

        /*max-height: 100% !important;
        display: block !important;
        opacity: 1 !important !important;
        visibility: visible !important;
        left: 100% !important;
        top: 83% !important;
        width: 100% !important;*/
        //     max-height: 100%;
        // display: block;
        // opacity: 1 !important;
        // visibility: visible !important;
        // left: 100%;
        // top: 83% !important;
        // width: 100% !important;
        // $(".dropdown-submenu").click(function(){
        // var obj = $(this).find(".dropdown-menu");
        // obj.addClass("show");
        // obj.parent().addClass("show");
        // $(".find_my_v_tutor_ul_li_grade_ul").addClass("show");
        // $(".find_my_v_tutor_ul_li_grade").addClass("show");
        // console.log();
        // alert("jsdkgs");
        // $(".dropdown").addClass("show");
        // });
        $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');


            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });


            return false;
        });
    });
</script>
<script type="text/javascript">
    function dataautocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            $.ajax({
                url: "{{ route('student.search.grade.tutors.book') }}",
                dataType: 'json',
                data: {
                    "book_grade": $.trim($("#book_grade").val()),
                    "c_state": $.trim($("#c_state").val()),
                    "book_subject": $.trim($("#book_subject").val()),
                    "search_u_name": val,
                },
                type: 'GET',
                success: function(resp) {
                    /*for each item in the array...*/
                    if (resp.grade_id != 0) {
                        for (i = 0; i < resp.grade_tutors.length; i++) {
                            /*check if the item starts with the same letters as the text field value:*/
                            if ((resp.grade_tutors[i].f_name + " " + resp.grade_tutors[i].l_name)
                                .substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                /*create a DIV element for each matching element:*/
                                b = document.createElement("DIV");
                                /*make the matching letters bold:*/
                                b.innerHTML = "<strong>" + (resp.grade_tutors[i].f_name + " " + resp
                                    .grade_tutors[i].l_name).substr(0, val.length) + "</strong>";
                                b.innerHTML += (resp.grade_tutors[i].f_name + " " + resp
                                    .grade_tutors[i].l_name).substr(val.length);
                                /*insert a input field that will hold the current array item's value:*/
                                b.innerHTML += "<input type='hidden' data-slug='" + resp
                                    .grade_tutors[i].slug + "' id='" + resp.grade_tutors[i].id +
                                    "' value='" + resp.grade_tutors[i].f_name + ' ' + resp
                                    .grade_tutors[i].l_name + "'>";
                                // b.innerHTML += "<input type='hidden' name='ttuor_hidden' value='" + resp.grade_tutors[i].f_name + "'>";
                                /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function(e) {
                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                    $("#search_tutor_id").val(this.getElementsByTagName(
                                        "input")[0].id);
                                    $("#search_tutor_selected_name").val(this
                                        .getElementsByTagName("input")[0].value);
                                    // console.log(this.getElementsByTagName("input")[0].data-slug);
                                    var slug = $("#" + this.getElementsByTagName("input")[0]
                                        .id).attr("data-slug");
                                    $("#search_tutor_slug").val(slug);
                                    // inp.id = this.getElementsByTagName("input")[0].id;

                                    /*close the list of autocompleted values,
                                    (or any other open lists of autocompleted values:*/
                                    closeAllLists();
                                });
                                a.appendChild(b);
                            }
                        }
                    }
                    // console.log(resp);
                },
                error: function() {}
            });

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
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }
    const searchInput = document.getElementById("search");
    if (searchInput) {
        dataautocomplete(searchInput, []);
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".save_popup_value_new").on("click", function() {
            var save_on_click_value = $(this).data("type"),
                obj = $(this),
                c_state = $.trim($("#c_state").val()),
                book_grade = $.trim($("#book_grade").val()),
                book_subject = $.trim($("#book_subject").val()),
                save_search_on_click_tutor_id = $("#search_tutor_id").val(),
                grade_slug = $.trim($("#book_grade").data("slug"));
            // yes_vtutor = $('#radio6:radio').val(),
            // no_vtutor = $('#radio7:radio').val();

            // if(save_search_on_click_tutor_id == ""){
            //   $(".error_search_tutor_id_i_y").html("Please search and select tutor name");
            // }

            if ($('#radio6:radio').is(':checked') == true) {
                if (save_search_on_click_tutor_id == "") {
                    $(".error_search_tutor_id_i_y").html("Please search and select tutor name");
                } else {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('save.search.on.click.value') }}',
                        data: {
                            save_on_click_value: save_on_click_value, //type for which page if b booking if pp public profile if pr post review page
                            save_search_on_click_tutor_id: save_search_on_click_tutor_id,
                            book_subject: book_subject,
                            c_state: c_state,
                            book_grade: book_grade
                        },
                        success: function(resp) {
                            $("#bookpopup").submit();
                        }
                    });
                }
            }
            if ($('#radio7:radio').is(':checked') == true) {

                var to_p = "{{ url('tutor-search-result?grade=') }}";
                to_p = to_p + grade_slug + '&subject_id%5B%5D=' + book_subject + 'state=' + c_state;
                // to_p = to_p;
                window.location.href = to_p;
            }
        });
        $("#checkPassword").validate();
        $("#nextValueShow").click(function() {
            $("#passwordForm").show();
            $("#warningTextDi").hide();
        });
        $("#nextBookDiv1").click(function() {
            $("#textDi2").show();
            $("#textDi3").hide();
            $("#textDi4").hide();
            $("#textDi1").hide();
        });
        $("#nextBookDiv2").click(function() {
            $("#textDi2").hide();
            $("#textDi3").show();
            $("#textDi4").hide();
            $("#textDi1").hide();
        });
        $("#nextBookDiv3").click(function() {
            $("#textDi2").hide();
            $("#textDi3").hide();
            $("#textDi4").show();
            $("#textDi1").hide();
        });
        $("#nextBookDiv4").click(function() {
            $(".without_login_branch_id").trigger("click");
            $("#textDi2").hide();
            $("#textDi3").hide();
            $("#textDi4").hide();
            $("#textDi5").show();
            $("#textDi1").hide();

        });
        $("#prev1").click(function() {
            $("#textDi2").hide();
            $("#textDi3").hide();
            $("#textDi4").hide();
            $("#textDi1").show();
        });
        $("#prev2").click(function() {
            $("#textDi2").hide();
            $("#textDi3").hide();
            $("#textDi4").hide();
            $("#textDi1").show();
        });
        $("#prev3").click(function() {
            $("#textDi2").show();
            $("#textDi3").hide();
            $("#textDi4").hide();
            $("#textDi1").hide();
        });
        $("#prev4").click(function() {
            $("#textDi2").hide();
            $("#textDi3").show();
            $("#textDi4").hide();
            $("#textDi1").hide();
        });
        $("#prev5").click(function() {
            $("#textDi2").hide();
            $("#textDi3").hide();
            $("#textDi4").show();
            $("#textDi1").hide();
            $("#textDi5").hide();
        });
        $(document).on("change", ".without_login_branch_id", function(e) {
            var without_login_branch_id = $.trim($('.without_login_branch_id option:selected').val())
            reqData = {
                'jsonrpc': '2.0',
                '_token': '{{ csrf_token() }}',
                'data': {
                    'without_login_branch_id': without_login_branch_id
                }
            };
            $.ajax({
                url: "{{ route('get.branch.subjects') }}",
                dataType: 'json',
                data: reqData,
                type: 'post',
                success: function(resp) {
                    if (resp.count <= 0) {
                        $(".without_login_book_subject").html("");
                    } else {
                        $(".without_login_book_subject").html(resp.html_response);
                    }
                    // $(".without_login_book_subject").val('');
                    // $(".slct").val('').trigger("chosen:updated");
                },
                error: function() {

                }
            });
        });
        // $("#yesClose").click(function(){
        // $('#CloseWarningModal').modal('toggle');
        // $("#CloseWarningModal").hide();
        // $("#myProfileClosePopup").show();
        // });
        // $("#closeBtnCLick").click(function(){
        // $(".close").trigger("click");
        // $('#myProfileClosePopup').modal('toggle');
        // });
        // $("#noClose").click(function(){
        // $('#CloseWarningModal').modal('toggle');
        // $("#CloseWarningModal").hide();
        // $("#myProfileClosePopup").hide();
        // });
    });
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-207843159-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-207843159-1');
</script>
{{-- <script src="//code.tidio.co/qvt3plqqnvqullzniycxnrjuis2qroqd.js" async></script> --}}
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/21497893.js"></script>
<!-- End of HubSpot Embed Code -->
<script>
    ! function(e, t, n, s, u, a) {
        e.twq || (s = e.twq = function() {
                s.exe ? s.exe.apply(s, arguments) : s.queue.push(arguments);
            }, s.version = '1.1', s.queue = [], u = t.createElement(n), u.async = !0, u.src =
            '//static.ads-twitter.com/uwt.js',
            a = t.getElementsByTagName(n)[0], a.parentNode.insertBefore(u, a))
    }(window, document, 'script');
    // Insert Twitter Pixel ID and Standard Event data below
    twq('init', 'o7uxl');
    twq('track', 'PageView');
</script>
<!-- Start cookieyes banner --><!--script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/189a2c373e82ad290df983eb/script.js"></script>  End cookieyes banner -->
<!-- MailerLite Universal -->
{{-- <script>
    (function(m, a, i, l, e, r) {
        m['MailerLiteObject'] = e;

        function f() {
            var c = {
                a: arguments,
                q: []
            };
            var r = this.push(c);
            return "number" != typeof r ? r : f.bind(c.q);
        }
        f.q = f.q || [];
        m[e] = m[e] || f.bind(f.q);
        m[e].q = m[e].q || f.q;
        r = a.createElement(i);
        var _ = a.getElementsByTagName(i)[0];
        r.async = 1;
        r.src = l + '?v' + (~~(new Date().getTime() / 1000000));
        _.parentNode.insertBefore(r, _);
    })(window, document, 'script', 'https://static.mailerlite.com/js/universal.js', 'ml');

    var ml_account = ml('accounts', '3864368', 'c8l2v0b1r7', 'load');
</script> --}}
<!-- End MailerLite Universal -->
