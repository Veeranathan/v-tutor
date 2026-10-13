<div class="modal res-modal newqusmo" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Book a session</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="bookpopup" action="{{ url('studentbook-class') }}" method="get">
                    @csrf
                    <div>
                        <!-- Step 1 -->
                        <div id="textDi1">
                            <label>Hey there, what are you planning to book today?</label>
                            <div class="checkBox new-cus b-block">
                                <ul class="submn">
                                    <li class="one_li_check">
                                        <input type="radio" id="radio41" name="subject_id_book" value="all" checked>
                                        <label for="radio41">Subjects</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="next-btn1">
                                <button type="button" class="btn btn-new btn-danger" id="nextBookDiv1">Next</button>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div id="textDi2" style="display: none;">
                            <label>Select your State</label>
                            <select id="c_state" name="c_state" class="form-control">
                                @php $states = \App\Models\State::orderBy('state_name','asc')->get(); @endphp
                                <option value="">Select your State</option>
                                @if(!empty($states) && is_iterable($states))
                                    @foreach($states as $state)
                                        <option value="{{ $state->slug }}" data-sid="{{ $state->id }}">
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            {{-- Branch Dropdown --}}
                            <label>Choose Branch of Study</label>
                            <select id="branch_id" name="branch_id[]" class="change_apply form-control">
                                <option value="">Select Branch of Study</option>
                                @if(!empty($branches) && is_iterable($branches))
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->slug }}"
                                            @if(!empty($branch_slugs) && in_array($branch->slug, (array) $branch_slugs)) selected @endif>
                                            {{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <div class="next-btn1">
                                <button type="button" class="btn btn-new btn-danger float-left" id="prev2">Back</button>
                                <button type="button" class="btn btn-new btn-danger" id="nextBookDiv2">Next</button>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div id="textDi3" style="display: none;">
                            <label>Choose Subject</label>
                            <select id="book_subject" name="book_subject" class="form-control without_login_book_subject">
                                <option value="">Select Subject</option>
                                @if(!empty($subjects) && is_iterable($subjects))
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->slug }}" data-sid="{{ $subject->id }}">
                                            {{ $subject->subject }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <div class="next-btn1">
                                <button type="button" class="btn btn-new btn-danger float-left" id="prev3">Back</button>
                                <button type="button" class="btn btn-new btn-danger" id="nextBookDiv3">Next</button>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div id="textDi4" style="display: none;">
                            <label>What grade are you in?</label>
                            <select id="book_grade" name="book_grade" class="form-control">
                                <option value="">Select Grade</option>
                                @if(!empty($grades) && is_iterable($grades))
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            @if(Auth::check() && Auth::user()->grade == $grade->id) selected @endif>
                                            {{ $grade->grade_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <div class="next-btn1">
                                <button type="button" class="btn btn-new btn-danger float-left" id="prev4">Back</button>
                                <button type="button" class="btn btn-new btn-danger" id="nextBookDiv4">Next</button>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div id="textDi5" style="display: none;">
                            <div class="checkBox new-cus tur-radio mb-2 b-block">
                                <span>
                                    Do you have a V-Tutor in mind? <br>
                                    <i>If not, no worries. You can always use custom filters to select</i>
                                </span>
                                <ul>
                                    <li class="one_li_check">
                                        <input type="radio" id="radio6" name="is_tutor_name" value="Y">
                                        <label for="radio6">Yes</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="radio7" name="is_tutor_name" value="N" checked>
                                        <label for="radio7">No</label>
                                    </li>
                                </ul>

                                <span class="tutor-c1" style="display: none !important;">
                                    <span class="form_box_area">
                                        <label>Name your V-Tutor</label>
                                        <span class="autocomplete">
                                            <input id="search" type="text" name="search_tutor_nm" placeholder="Start typing a name" autocomplete="off">
                                            <input type="hidden" name="search_tutor_id" id="search_tutor_id" value="{{ @$key['search_tutor_id'] }}">
                                            <input type="hidden" name="search_tutor_selected_name" id="search_tutor_selected_name" value="{{ @$key['search_tutor_selected_name'] }}">
                                            <input type="hidden" name="search_tutor_slug" id="search_tutor_slug" value="{{ @$key['search_tutor_slug'] }}">
                                        </span>
                                        <span class="error error_search_tutor_id_i_y"></span>
                                    </span>
                                </span>
                            </div>

                            <div class="next-btn1">
                                <button type="button" class="btn btn-new btn-danger float-left" id="prev5">Back</button>
                                <button type="button" class="btn btn-new btn-danger save_popup_value_new booking_popup"
                                        data-type="B" data-id="" id="save_book_data_on_click">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- /modal-body -->
        </div>
    </div>
</div>
