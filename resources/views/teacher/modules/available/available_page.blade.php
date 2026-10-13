@extends('layouts.app')

@section('title')
    <title>V-Tutor | Tutor | Availability</title>
@endsection

@section('left_part')
    @include('include.header_menu_part')
@endsection

@section('content')
<section class="makes_special_sec faq-sec">
    <div class="makes_special_inr">
        <div class="top_mar"></div>
        <section class="user-account">
            <div class="container">
                <div class="row">
                    <div class="zin">
                        @include('include.teacher_left_common')

                        <div
                            class="user-right-panel tutor-right @if (@Auth::user()->status == 'AA') addDisablePhone pointerEventsNone @endif">
                            <div class="turo-edit">
                                <div class="user-right-top">
                                    <h2 class="profile-heading">Schedule</h2>
                                    <button type="button"
                                        onclick="window.location.href='{{ route('tutor.date.exclusion.list') }}'" class="pg_btn"
                                        style="float: right;">
                                        Add Exclusions
                                    </button>
                                    {{-- <a href="{{ route('tutor.date.exclusion.list') }}"
                                    class="pg_btn @if (@$available->count() <= 0) addDisablePhone pointerEventsNone @endif"
                                    style="float: right;">Add Exclusions</a> --}}
                                    <p>You can find information or edit your availability in this section</p>
                                    <br>
                                    <div class="container">
                                        <div id="weekContainer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</section>
@endsection

@section('script')
    @include('include.script')
    <style>
        .day-row {
            border-bottom: solid rgb(227, 227, 227) 1px !important;
            box-shadow: none !important;
        }

        .day-row::after,
        .day-row::before {
            display: none !important;
        }

        .slots-list {
            border: none !important;
        }
    </style>


    <script>
        const existingSlots = {!! json_encode($available_json ?? []) !!};
        console.log("Existing Slots:", existingSlots);

        $(function() {
            const START_HOUR = parseInt(`{{ config('sessionsettings.min_start_time') }}`);
            const END_HOUR = parseInt(`{{ config('sessionsettings.max_end_time') }}`);

            const weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            const allSlots = {};

            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            weekdays.forEach(day => allSlots[day] = []);

            existingSlots.forEach(slot => {
                const dayIndex = parseInt(slot.day);
                if (dayIndex < 1 || dayIndex > 7) return;
                const dayName = weekdays[dayIndex - 1];
                allSlots[dayName].push({
                    start: slot.from,
                    end: slot.to
                });
            });

            weekdays.forEach(day => {
                $('#weekContainer').append(createDayRow(day));
                const $row = $(`.day-row[data-day="${day}"]`);
                populateSelects($row);
                renderSlots(day, $row);

                $row.find('.add-slot').off('click').on('click', function() {
                    const $currentRow = $(this).closest('.day-row');
                    const day = $currentRow.data('day');
                    const from = $currentRow.find('.fromTime').val();
                    const to = $currentRow.find('.toTime').val();

                    const fromHour = parseInt(from);
                    const toHour = parseInt(to);

                    if (toHour <= fromHour) {
                        toastr.warning('Invalid time range.');
                        return;
                    }

                    const newSlot = {
                        start: `${from}:00`,
                        end: `${to}:00`
                    };

                    if (isOverlapping(newSlot, allSlots[day])) {
                        toastr.warning('This slot overlaps with an existing one.');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('availability.save') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            slots: {
                                [day]: [newSlot]
                            }
                        },
                        success: function() {
                            allSlots[day].push(newSlot);
                            renderSlots(day, $currentRow);
                            toastr.success("Time slot added successfully!");
                            populateSelects($row);
                        },
                        error: function() {
                            toastr.error("Failed to save slot.");
                        }
                    });
                });

                $row.find('.fromTime').on('change', function() {
                    const fromVal = parseInt($(this).val());
                    $row.find('.toTime option').each(function() {
                        const toVal = parseInt($(this).val());
                        $(this).prop('disabled', toVal <= fromVal);
                    });
                });
            });

            function createDayRow(day) {
                return `
            <div class="day-row" data-day="${day}">
                <div class="day-label">${day}</div>
                <div class="time-controls flex-wrap">
                    <div class="d-flex align-items-center">
                    <label class="pr-2">From: </label>
                    <select class="fromTime"></select>
                    </div>
                    <div class="d-flex align-items-center">
                    <label class="pr-2">To: </label>
                    <select class="toTime"></select>
                    </div>
                    <button class="add-slot"><i class="fa fa-plus"></i> Add</button>
                </div>
                <div class="slots-list"></div>
            </div>`;
            }

            function populateSelects($row) {
                const $from = $row.find('.fromTime').empty();
                const $to = $row.find('.toTime').empty();
                for (let h = START_HOUR; h < END_HOUR; h++) {
                    $from.append(`<option value="${h}">${formatHour(h)}</option>`);
                }
                for (let h = START_HOUR + 1; h <= END_HOUR; h++) {
                    $to.append(`<option value="${h}">${formatHour(h)}</option>`);
                }
            }

            function renderSlots(day, $row) {
                const $list = $row.find('.slots-list').empty();
                (allSlots[day] || []).forEach((slot, index) => {
                    const tag = $(`
                <span class="slot-tag">
                    ${formatHour(slot.start)} – ${formatHour(slot.end)}
                    <i class="fa fa-times delete-slot" data-index="${index}" data-day="${day}" data-from="${slot.start}" data-to="${slot.end}"></i>
                </span>`);
                    $list.append(tag);
                });
            }

            function isOverlapping(newSlot, slots) {
                const newStart = parseInt(newSlot.start);
                const newEnd = parseInt(newSlot.end);
                return slots.some(s => {
                    const sStart = parseInt(s.start);
                    const sEnd = parseInt(s.end);
                    return !(newEnd <= sStart || newStart >= sEnd);
                });
            }

            function formatHour(input) {
                let hour = input;
                if (typeof hour === 'string') {
                    const parts = hour.split(':');
                    hour = parseInt(parts[0], 10);
                }

                if (isNaN(hour)) return "Invalid";

                const ampm = hour >= 12 ? 'PM' : 'AM';
                const hr = hour % 12 === 0 ? 12 : hour % 12;
                return `${hr}:00 ${ampm}`;
            }

            function normalizeTime(t) {
                if (typeof t === 'number') t = t.toString().padStart(2, '0') + ':00';
                else if (t.length === 2) t = t + ':00';
                else if (t.length === 5) t = t;
                return t;
            }

            $('#weekContainer').off('click', '.delete-slot').on('click', '.delete-slot', function(e) {
                e.preventDefault();

                const $icon = $(this);
                const data = $icon.data();

                console.log("Delete slot clicked");
                console.log("Slot data:", data);

                if ($icon.data('deleting')) return;
                $icon.data('deleting', true);

                const day = data.day;
                const from = data.from;
                const to = data.to;

                const fromWithSeconds = normalizeTime(from);
                const toWithSeconds = normalizeTime(to);
                console.log("Normalized from:", fromWithSeconds);
                console.log("Normalized to:", toWithSeconds);
                const dayIndex = weekdays.indexOf(day) + 1;
                const normalizedDay = weekdays[dayIndex - 1]; // Capitalized day name

                $.ajax({
                    url: "{{ route('availability.delete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        day: dayIndex,
                        from: fromWithSeconds,
                        to: toWithSeconds
                    },
                    success: function(res) {
                        console.log("AJAX success response:", res);

                        if (res.success) {
                            // Update internal slots list only if deletion was successful
                            if (!allSlots[normalizedDay]) {
                                allSlots[normalizedDay] = [];
                            }

                            allSlots[normalizedDay] = allSlots[normalizedDay].filter(slot => {
                                const sFrom = normalizeTime(slot.start);
                                const sTo = normalizeTime(slot.end);
                                return !(sFrom === fromWithSeconds && sTo ===
                                    toWithSeconds);
                            });
                            console.log("Updated slots:", allSlots[normalizedDay]);

                            const container = $(`.day-row[data-day="${normalizedDay}"]`);
                            renderSlots(normalizedDay, container);

                            toastr.success(res.message || "Slot removed successfully.");
                        } else {
                            // If backend returned success: false (e.g. slot not found)
                            toastr.error(res.message || "Failed to remove slot.");
                        }
                    },
                    error: function() {
                        toastr.error("Something went wrong. Please try again.");
                    },

                    complete: function() {
                        $icon.data('deleting', false);
                    }
                });
            });

        });
    </script>
@endsection

@section('footer')
    @include('include.footer')
@endsection
