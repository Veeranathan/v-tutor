@extends('layouts.app')

@section('title')
    <title>V-Tutor  | Tutor | Add Date / Time Exclusions</title>
@endsection

@section('left_part')
    @include('include.header_menu_part')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
 <div class="top_mar"></div>
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
                    @include('include.teacher_left_common')
                    <div class="user-right-panel tutor-right">
                        <div class="turo-edit">
                            <div class="user-right-top">
                                <h2 class="profile-heading">
                                    <span class="per-info"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    Add Date / Time Exclusions
                                </h2>
                                <p>You can find information or add your date/time exclusion in this section</p>

                                <div class="user-account-info newst-acctinfo">
                                    <form method="post" action="{{ route('tutor.update.date.exclusion.list') }}"
                                        id="updTutorDateExclusionList">
                                        @csrf
                                        <div class="row new_rows no-gutters">
                                            <div class="col-md-4 col-sm-6 from_time_value book_f_t_v">
                                                <label>Date</label>
                                                <input id="selected_date" name="selected_date"
                                                    class="flatpickr-date form-control">
                                                <span id="error_selected_date_txt" class="text-danger"></span>
                                            </div>
                                            <div class="col-md-3 col-sm-6 from_time_value book_f_t_vs">
                                                <label for="start1">From</label>
                                                <select id="start1" name="from_time"
                                                    class="fromTime form-control"></select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 from_time_value book_f_t_vs">
                                                <label for="end1">To</label>
                                                <select id="end1" name="to_time" class="toTime form-control"></select>
                                            </div>
                                            <div class="col-md-2 col-sm-4 mt-4">
                                                <button type="submit" class="add-slot"><i class="fa fa-plus"></i>
                                                    Exclusion</button>
                                            </div>

                                            <div class="col-12">
                                                <div class="custom-table mt-3">
                                                    <table id="example" class="cell-border table table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>From Time</th>
                                                                <th>To Time</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (@$getTutorCalDatesTimes)
                                                                @foreach ($getTutorCalDatesTimes as $t)
                                                                    <tr>
                                                                        <td>{{ $t->unavialable_date }}</td>
                                                                        <td>{{ $t->start_time ? date('h:i A', strtotime($t->start_time_local)) : '' }}
                                                                        </td>
                                                                        <td>{{ $t->end_time ? date('h:i A', strtotime($t->end_time_local)) : '' }}
                                                                        </td>
                                                                        <td>
                                                                            <a onclick="return confirm('Are you sure?')"
                                                                                href="{{ route('tutor.delete.tutor.non.availability', $t->id) }}">Delete</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('include.footer')
@endsection

@section('script')
    @include('include.script')


    <script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

    <script>
        let originalEndTimes = [];

        const allAvailableDates = @json($get_available_dates ?? []);
        const disabledDates = @json($all_disabled_booking_dates ?? []);
        console.log("All Available Dates:", allAvailableDates);
        console.log("Disabled Dates:", disabledDates);
        const finalDates = allAvailableDates.filter(dateStr => {
            const today = new Date().toISOString().split('T')[0];
            return !disabledDates.includes(dateStr) && dateStr >= today;
        });
        console.log("finalDates:", finalDates);




        flatpickr("#selected_date", {
            dateFormat: "Y-m-d",
            enable: finalDates,
            disable: [
                function(date) {
                    const ymd = date.toISOString().split('T')[0];
                    return !finalDates.includes(ymd);
                }
            ],
            onChange: function(selectedDates, dateStr, instance) {
                changeDatePickerFunction(dateStr);
            }
        });

        function parseTimeToMinutes(timeStr) {
            const [time, modifier] = timeStr.split(" ");
            let [hours, minutes] = time.split(":").map(Number);
            if (modifier === "PM" && hours !== 12) hours += 12;
            if (modifier === "AM" && hours === 12) hours = 0;
            return hours * 60 + minutes;
        }

        function changeDatePickerFunction() {
            const $start = $("#start1");
            const $end = $("#end1");

            $start.val("").empty().append(`<option value="">-- Select --</option>`);
            $end.val("").empty().append(`<option value="">-- Select --</option>`);

            const selected_date = $.trim($("#selected_date").val());
            const reqData = {
                '_token': '{{ csrf_token() }}',
                'data': {
                    'tutor_id': {{ Auth::user()->id }},
                    'selected_date': selected_date
                }
            };

            if (selected_date !== "") {
                $.ajax({
                    url: "{{ route('tutor.ajax.date.exclusion.list') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success: function(resp) {
                        if (Array.isArray(resp.get_available_start_times)) {
                            resp.get_available_start_times.forEach(time => {
                                $start.append(`<option value="${time}">${time}</option>`);
                            });

                            // Re-bind change handler
                            $start.off('change').on('change', function() {
                                const selectedStart = $(this).val();
                                if (!selectedStart) return;

                                const startMinutes = parseTimeToMinutes(selectedStart);

                                // Map and sort all "to" times
                                const allEndOptions = $end.find('option').map(function() {
                                    const val = $(this).val();
                                    return {
                                        el: this,
                                        value: val,
                                        minutes: val ? parseTimeToMinutes(val) : null
                                    };
                                }).get();

                                const sortedEnd = allEndOptions.filter(opt => opt.value).sort((a, b) =>
                                    a.minutes - b.minutes);

                                let validEndTimes = [];
                                for (let i = 0; i < sortedEnd.length; i++) {
                                    const end = sortedEnd[i];
                                    if (end.minutes > startMinutes) {
                                        if (validEndTimes.length === 0) {
                                            validEndTimes.push(end);
                                        } else {
                                            const prev = validEndTimes[validEndTimes.length - 1];
                                            if (end.minutes - prev.minutes === 60) {
                                                validEndTimes.push(end);
                                            } else {
                                                break;
                                            }
                                        }
                                    }
                                }

                                $end.find('option').prop('disabled', true);
                                $end.find('option[value=""]').prop('disabled', false);
                                validEndTimes.forEach(opt => {
                                    $(opt.el).prop('disabled', false);
                                });
                                $end.val('');
                            });
                        }

                        if (Array.isArray(resp.get_available_end_times)) {
                            resp.get_available_end_times.forEach(time => {
                                $end.append(`<option value="${time}">${time}</option>`);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }
        }
    </script>
@endsection
