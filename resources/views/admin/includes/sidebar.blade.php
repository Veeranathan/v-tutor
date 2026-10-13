<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left">
                @php $admin = Auth::guard('admin')->user(); @endphp

                @if($admin && $admin->image)
                    <img src="{{ env('STORAGE_URL') . 'admin/profileImage/' . $admin->image }}" alt="user-img" class="thumb-md img-circle">

                @else
                    <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" alt="user-img" class="thumb-md img-circle">
                @endif
                {{-- @if ($admin && $admin->image)
                    <img src="{{ asset('storage/admin/profileImage/' . $admin->image) }}" alt="user-img"
                        class="thumb-md img-circle">
                @else
                    <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" alt="user-img"
                        class="thumb-md img-circle">
                @endif --}}
                {{-- <img src="{{ public_asset('admin/assets/images/users/avatar-1.jpg') }}" alt="" class="thumb-md img-circle"> --}}
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">{{ @Auth::guard('admin')->user()->name }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            @if (@Auth::guard('admin')->user()->email == 'academics.admin@v-tutor.com.au')
                                <a href="{{ route('edit.admin.profile') }}" class="gj_adm_mnu_disabled"><i class="fas fa-user-circle"></i> Profile</a>
                            @elseif (@Auth::guard('admin')->user()->email == 'operations.admin@v-tutor.com.au')
                                <a href="{{ route('edit.admin.profile') }}" class="gj_adm_mnu_disabled"><i class="fas fa-user-circle"></i> Profile</a>
                            @else
                                <a href="{{ route('edit.admin.profile') }}"><i class="fas fa-user-circle"></i> Profile</a>
                            @endif
                        </li>

                        <li><a href="{{ route('admin.change.password') }}"><i class="fas fa-cog"></i> Change
                                Password</a></li>
                        <li>

                            <a href="javascript"
                                onclick="event.preventDefault(); document.getElementById('logout-form-two').submit();"
                                href="javascript::void(0);"><i class="fas fa-power-off"></i> Logout</a>

                        </li>
                    </ul>
                </div>

                <p class="text-muted m-0">
                    @if (@Auth::guard('admin')->user()->type == 'A')
                        Administrator
                    @endif
                </p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
            @if (@Auth::guard('admin')->user()->email == 'academics.admin@v-tutor.com.au')
                <ul>
                    <li><a href="{{ route('admin_dashboard') }}"
                            class="waves-effect @if (Route::is('admin_dashboard')) active @endif"><i class="fa fa-tachometer"
                                ria-hidden="true"></i><span>Dashboard</span></a></li>

                    <li><a href="{{ route('admin_tutor_application_form_list') }}"
                            class="waves-effect @if (Route::is('admin_tutor_application_form_list') || Route::is('admin_tutor_application_form_view')) active @endif"><i
                                class="fa fa-check-square-o"></i><span>Applications Management</span></a></li>

                    <li><a href="{{ route('admin_wwcc_management_list') }}"
                            class="waves-effect @if (Route::is('admin_wwcc_management_list') || Route::is('admin_wwcc_management_view')) active @endif"><i
                                class="fa fa-check-square-o"></i><span>WWCC Management</span></a></li>

                    <li><a href="{{ route('manage.tutors') }}"
                            class="waves-effect @if (Route::is('manage.tutors') ||
                                    Route::is('view.tutor') ||
                                    Route::is('edit.tutor.personal.info.step.1') ||
                                    Route::is('edit.tutor.experience') ||
                                    Route::is('edit.tutor.rec') ||
                                    Route::is('edit.tutor.academics') ||
                                    Route::is('edit.tutor.rec') ||
                                    Route::is('edit.tutor.tutorship.plans') ||
                                    Route::is('edit.tutor.add.plan') ||
                                    Route::is('edit.tutor.add.plan') ||
                                    Route::is('edit.tutor.experience') ||
                                    Route::is('edit.tutor.availablity')) active @endif"><i
                                class="fas fa-user-tie"></i><span>Tutor
                                Management</span></a></li>
                    
                    <li><a href="{{ route('manage.students') }}"
                            class="waves-effect @if (Route::is('manage.students') || Route::is('view.student') || Route::is('edit.student.personal.info.step.1')) active @endif"><i
                                class="far fa-user"></i><span>Student Management
                            </span></a></li>

                    <li><a href="{{ route('booking.management') }}"
                            class="waves-effect @if (Route::is('view.booking.details') || Route::is('booking.management')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Booking Management</span></a></li>

                    <li><a href="{{ route('manage.branches') }}"
                            class="waves-effect @if (Route::is('manage.branches') || Route::is('add.branch') || Route::is('edit.branch') || Route::is('view.subject')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span> Branch Management</span></a></li>

                    <li><a href="{{ route('manage.grades') }}"
                            class="waves-effect @if (Route::is('manage.grades') || Route::is('add.grade') || Route::is('edit.grade') || Route::is('view.grade')) active @endif"><i class="fa fa-book"
                                aria-hidden="true"></i><span> Grade Management</span></a></li>
                    
                    <li><a href="{{ route('manage.subjects') }}"
                            class="waves-effect @if (Route::is('manage.subjects') || Route::is('add.subject') || Route::is('edit.subject') || Route::is('view.subject')) active @endif"><i
                                class="fas fa-hand-holding-usd" aria-hidden="true"></i><span> Subjects Management</span></a>
                    </li>
                    
                    <li><a href="{{ route('manage.topics') }}"
                            class="waves-effect @if (Route::is('manage.topics') || Route::is('add.topics') || Route::is('edit.topics') || Route::is('view.topics')) active @endif"><i
                                class="fas fa-hand-holding-usd" aria-hidden="true"></i><span> Session Plan Management</span></a>
                    </li>
                    
                    <li><a href="{{ route('manage.topics.details') }}"
                            class="waves-effect @if (Route::is('manage.topics.details') || Route::is('add.topics.details') || Route::is('view.topics.details') || Route::is('view.subject')) active @endif"><i
                                class="fas fa-hand-holding-usd" aria-hidden="true"></i><span> Session Report Management</span></a>
                    </li>
                    <li><a href="{{ route('manage.programmes') }}"
                            class="waves-effect @if (Route::is('manage.programmes') || Route::is('view.programme')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span> Programme Management</span></a></li>
                    <li><a href="{{ route('blog.list') }}"
                            class="waves-effect @if (Route::is('blog.list') || Route::is('add.blog.page') || Route::is('view.blog')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span> Blog Management</span></a></li>
                    <li><a href="{{ route('learning.assessment.forms.list') }}"
                            class="waves-effect @if (Route::is('learning.assessment.forms.list') || Route::is('learning.assessment.forms.add.page') || Route::is('learning.assessment.forms.view')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Assessment Forms</span></a></li>
                    <li><a href="{{ route('learning.assessment.questions.list') }}"
                            class="waves-effect @if (Route::is('learning.assessment.questions.list') || Route::is('learning.assessment.questions.add.page') || Route::is('learning.assessment.questions.view')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Assessment Questions</span></a></li>
                    <li><a href="{{ route('manage.learning.assessments') }}"
                            class="waves-effect @if (Route::is('manage.learning.assessments') || Route::is('view.learning.assessment') || Route::is('action.learning.assessment')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Learning Program Management</span></a></li>
                    <li><a href="{{ route('academic.program.list') }}"
                            class="waves-effect @if (Route::is('academic.program.list') || Route::is('add.academic.program.page') || Route::is('view.academic.program')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Academic Program</span></a></li>
                    <li><a href="{{ route('academic.assignment.list') }}"
                            class="waves-effect @if (Route::is('academic.assignment.list') || Route::is('view.academic.assignment')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Academic Program Assignment</span></a></li>
                    
                    <li>
                        <a href="{{ route('manage.admin.class.end.assesment') }}"
                            class="waves-effect  @if (Route::is('manage.admin.class.end.assesment') || Route::is('manage.admin.class.end.assesment')) active @endif"><i
                                class="fas fa-desktop"></i><span>Feedback Management</span></a>
                    </li>

                    <li>
                        <a href="{{ route('review.list') }}"
                            class="waves-effect  @if (Route::is('review.dlt') || Route::is('review.list')) active @endif"><i class="fa fa-star"
                                aria-hidden="true"></i><span>Reviews Management</span></a>
                    </li>
                    
                    <li>
                        <a href="{{ route('manage.admin.class.end.assesment') }}"
                            class="waves-effect  @if (Route::is('manage.admin.class.end.assesment')) active @endif"><i class="fa fa-star"
                                aria-hidden="true"></i><span>Assessments Management</span></a>
                    </li>
                </ul>
            @elseif (@Auth::guard('admin')->user()->email == 'operations.admin@v-tutor.com.au')
                <ul>
                    <li><a href="{{ route('admin_dashboard') }}"
                            class="waves-effect @if (Route::is('admin_dashboard')) active @endif"><i class="fa fa-tachometer"
                                ria-hidden="true"></i><span>Dashboard</span></a></li>

                    <li><a href="{{ route('booking.management') }}"
                            class="waves-effect @if (Route::is('view.booking.details') || Route::is('booking.management')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Booking Management</span></a></li>            
                    
                    <li>
                        <a href="{{ route('manage.admin.class.end.assesment') }}"
                            class="waves-effect  @if (Route::is('manage.admin.class.end.assesment') || Route::is('manage.admin.class.end.assesment')) active @endif"><i
                                class="fas fa-desktop"></i><span>Feedback Management</span></a>
                    </li>

                    <li>
                        <a href="{{ route('review.list') }}"
                            class="waves-effect  @if (Route::is('review.dlt') || Route::is('review.list')) active @endif"><i class="fa fa-star"
                                aria-hidden="true"></i><span>Reviews Management</span></a>
                    </li>
                    
                    <li>
                        <a href="{{ route('tutor.payment.list') }}"
                            class="waves-effect  @if (Route::is('tutor.payment') ||
                                    Route::is('tutor.payment.list') ||
                                    Route::is('payments.history.search') ||
                                    Route::is('payments.history')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Payments Management</span></a>
                    </li>
                     <li>
                       <a href="{{ route('admin.payouts') }}"
   class="waves-effect @if(Route::is('admin.payouts') || Route::is('admin.payouts.view')) active @endif">
   <i class="fa fa-money" aria-hidden="true"></i>
   <span>Tutor Payouts</span>
</a>


                    </li>

                    <li>
                        <a href="{{ route('student.payment.list') }}"
                            class="waves-effect  @if (Route::is('student.payment.list') || Route::is('get.all.student.payment')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Student Payments</span></a>
                    </li>

                    <li><a href="{{ route('faq.list') }}"
                            class="waves-effect  @if (Route::is('faq.list') ||
                                    Route::is('add.faq.page') ||
                                    Route::is('faq.added') ||
                                    Route::is('view.faq') ||
                                    Route::is('edit.faq')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>FAQ Management</span></a></li>

                    <li><a href="{{ route('help.list') }}"
                            class="waves-effect  @if (Route::is('help.list') ||
                                    Route::is('add.help.page') ||
                                    Route::is('help.added') ||
                                    Route::is('view.help') ||
                                    Route::is('edit.help')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Help Centre Management</span></a>
                    </li>

                    <li><a href="{{ route('test.list') }}"
                            class="waves-effect  @if (Route::is('test.list') ||
                                    Route::is('add.test.page') ||
                                    Route::is('test.added') ||
                                    Route::is('view.test') ||
                                    Route::is('edit.test')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Testimonials Management</span></a>
                    </li>

                    <li><a href="{{ route('admin.list.banner') }}"
                            class="waves-effect  @if (Route::is('admin.list.banner')) active @endif"><i
                                class="fas fa-images"></i><span>Banner Management</span></a></li>

                    <li><a href="{{ route('privacy.policy') }}"
                            class="waves-effect  @if (Route::is('privacy.policy')) active @endif"><i
                                class="fas fa-sticky-note"></i><span>Privacy Policy</span></a></li>

                    <li><a href="{{ route('terms.conditions') }}"
                            class="waves-effect  @if (Route::is('terms.conditions')) active @endif"><i
                                class="fas fa-pen"></i><span>Terms & Conditions</span></a></li>
                </ul>
            @else
                <ul>
                    <li><a href="{{ route('admin_dashboard') }}"
                            class="waves-effect @if (Route::is('admin_dashboard')) active @endif"><i class="fa fa-tachometer"
                                ria-hidden="true"></i><span>Dashboard</span></a></li>
                                  <li><a href="{{ route('promotion.index') }}"
                            class="waves-effect @if (Route::is('promotion.index')) active @endif"><i class="fa fa-tachometer"
                                ria-hidden="true"></i><span>Campaigns Management </span></a></li>
                    
                    <li><a href="{{ route('admin_tutor_application_form_list') }}"
                            class="waves-effect @if (Route::is('admin_tutor_application_form_list') || Route::is('admin_tutor_application_form_view')) active @endif"><i
                                class="fa fa-check-square-o"></i><span>Applications Management</span></a></li>
                    
                    <li><a href="{{ route('manage.tutors') }}"
                            class="waves-effect @if (Route::is('manage.tutors') ||
                                    Route::is('view.tutor') ||
                                    Route::is('edit.tutor.personal.info.step.1') ||
                                    Route::is('edit.tutor.experience') ||
                                    Route::is('edit.tutor.rec') ||
                                    Route::is('edit.tutor.academics') ||
                                    Route::is('edit.tutor.rec') ||
                                    Route::is('edit.tutor.tutorship.plans') ||
                                    Route::is('edit.tutor.add.plan') ||
                                    Route::is('edit.tutor.add.plan') ||
                                    Route::is('edit.tutor.experience') ||
                                    Route::is('edit.tutor.availablity')) active @endif"><i
                                class="fas fa-user-tie"></i><span>Tutor
                                Management</span></a></li>

                    <li><a href="{{ route('admin_wwcc_management_list') }}"
                            class="waves-effect @if (Route::is('admin_wwcc_management_list') || Route::is('admin_wwcc_management_view')) active @endif"><i
                                class="fa fa-check-square-o"></i><span>WWCC Management</span></a></li>

                    <li><a href="{{ route('manage.students') }}"
                            class="waves-effect @if (Route::is('manage.students') || Route::is('view.student') || Route::is('edit.student.personal.info.step.1')) active @endif"><i
                                class="far fa-user"></i><span>Student Management
                            </span></a></li>
                    <li><a href="{{ route('manage.grades') }}"
                            class="waves-effect @if (Route::is('manage.grades') || Route::is('add.grade') || Route::is('edit.grade') || Route::is('view.grade')) active @endif"><i class="fa fa-book"
                                aria-hidden="true"></i><span> Grade Management</span></a></li>

                    <li><a href="{{ route('manage.branches') }}"
                            class="waves-effect @if (Route::is('manage.branches') || Route::is('add.branch') || Route::is('edit.branch') || Route::is('view.subject')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span> Branch Management</span></a></li>

                    <li><a href="{{ route('manage.subjects') }}"
                            class="waves-effect @if (Route::is('manage.subjects') || Route::is('add.subject') || Route::is('edit.subject') || Route::is('view.subject')) active @endif"><i
                                class="fas fa-hand-holding-usd" aria-hidden="true"></i><span> Subjects Management</span></a>
                    </li>
                    <li><a href="{{ route('manage.topics') }}"
                            class="waves-effect @if (Route::is('manage.topics') || Route::is('add.topics') || Route::is('edit.topics') || Route::is('view.topics')) active @endif"><i
                                class="fas fa-hand-holding-usd" aria-hidden="true"></i><span> Session Topics Management</span></a>
                    </li>
                    <li><a href="{{ route('manage.topics.details') }}"
                            class="waves-effect @if (Route::is('manage.topics.details') || Route::is('add.topics.details') || Route::is('edit.topic.details') || Route::is('view.topics.details')) active @endif"><i
                                class="fas fa-hand-holding-usd" aria-hidden="true"></i><span> View Session Topics</span></a>
                    </li>
                    <li><a href="{{ route('booking.management') }}"
                            class="waves-effect @if (Route::is('view.booking.details') || Route::is('booking.management')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Booking Management</span></a></li>
                    <li><a href="{{ route('manage.programmes') }}"
                            class="waves-effect @if (Route::is('manage.programmes') || Route::is('view.programme')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span> Program Management</span></a></li>
                    <li><a href="{{ route('blog.list') }}"
                            class="waves-effect @if (Route::is('blog.list') || Route::is('add.blog.page') || Route::is('view.blog')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span> Blog Management</span></a></li>
                    <li><a href="{{ route('learning.assessment.forms.list') }}"
                            class="waves-effect @if (Route::is('learning.assessment.forms.list') || Route::is('learning.assessment.forms.add.page') || Route::is('learning.assessment.forms.view')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Assessment Forms</span></a></li>
                    <li><a href="{{ route('learning.assessment.questions.list') }}"
                            class="waves-effect @if (Route::is('learning.assessment.questions.list') || Route::is('learning.assessment.questions.add.page') || Route::is('learning.assessment.questions.view')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Assessment Questions</span></a></li>
                    <li><a href="{{ route('manage.learning.assessments') }}"
                            class="waves-effect @if (Route::is('manage.learning.assessments') || Route::is('view.learning.assessment') || Route::is('action.learning.assessment')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Learning Program Management</span></a></li>           
                    <li><a href="{{ route('academic.program.list') }}"
                            class="waves-effect @if (Route::is('academic.program.list') || Route::is('add.academic.program.page') || Route::is('view.academic.program')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Academic Program</span></a></li>
                    <li><a href="{{ route('academic.assignment.list') }}"
                            class="waves-effect @if (Route::is('academic.assignment.list') || Route::is('view.academic.assignment')) active @endif"><i
                                class="fas fa-code-branch" aria-hidden="true"></i><span>Academic Program Assignment</span></a></li>
                    <li><a href="{{ route('manage.admin.disable.dates') }}"
                            class="waves-effect @if (Route::is('add.disable.date') || Route::is('manage.admin.disable.dates')) active @endif"><i class="fa fa-ban"
                                aria-hidden="true"></i><span>Block Booking</span></a></li>


                    <li>
                        <a href="{{ route('review.list') }}"
                            class="waves-effect  @if (Route::is('review.dlt') || Route::is('review.list')) active @endif"><i class="fa fa-star"
                                aria-hidden="true"></i><span>Review Management</span></a>
                    </li>
                    <li>
                        <a href="{{ route('manage.admin.class.end.assesment') }}"
                            class="waves-effect  @if (Route::is('manage.admin.class.end.assesment') || Route::is('manage.admin.class.end.assesment')) active @endif"><i
                                class="fas fa-desktop"></i><span>View Assessments</span></a>
                    </li>

                    {{--  <li>
                                <a href="{{ route('due.payments') }}" class="waves-effect  @if (Route::is('tutor.payment') || Route::is('due.payments') || Route::is('payments.history.search') || Route::is('payments.history')) active @endif"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Tutor Payments</span></a></li> --}}
                    <li>
                        <a href="{{ route('tutor.payment.list') }}"
                            class="waves-effect  @if (Route::is('tutor.payment') ||
                                    Route::is('tutor.payment.list') ||
                                    Route::is('payments.history.search') ||
                                    Route::is('payments.history')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Payments Management</span></a>
                    </li>
<li>
    <a href="{{ route('admin.payouts') }}"
       class="waves-effect {{ Route::is('admin.payouts') || Route::is('admin.payouts.detailsPage') ? 'active' : '' }}">
        <i class="fa fa-money" aria-hidden="true"></i>
        <span>Tutor Payout</span>
    </a>
</li> {{--                               <li>
                                <a href="{{ route('student.pay.list') }}" class="waves-effect  @if (Route::is('student.pay.list') || Route::is('get.all.student.payment')) active @endif"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Student Payments</span></a></li> --}}
                    <li>
                        <a href="{{ route('student.payment.list') }}"
                            class="waves-effect  @if (Route::is('student.payment.list') || Route::is('get.all.student.payment')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Student Payments</span></a>
                    </li>
                    {{-- <li><a href="{{ route('admin.set.commission') }}" class="waves-effect  @if (Route::is('admin.set.commission')) active @endif"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Admin Commission</span></a></li> --}}


                    <li><a href="{{ route('faq.list') }}"
                            class="waves-effect  @if (Route::is('faq.list') ||
                                    Route::is('add.faq.page') ||
                                    Route::is('faq.added') ||
                                    Route::is('view.faq') ||
                                    Route::is('edit.faq')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>FAQ Management</span></a></li>

                    <li><a href="{{ route('help.list') }}"
                            class="waves-effect  @if (Route::is('help.list') ||
                                    Route::is('add.help.page') ||
                                    Route::is('help.added') ||
                                    Route::is('view.help') ||
                                    Route::is('edit.help')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Help Guide Management</span></a>
                    </li>


                    <li><a href="{{ route('test.list') }}"
                            class="waves-effect  @if (Route::is('test.list') ||
                                    Route::is('add.test.page') ||
                                    Route::is('test.added') ||
                                    Route::is('view.test') ||
                                    Route::is('edit.test')) active @endif"><i
                                class="fa fa-check-square-o" aria-hidden="true"></i><span>Testimony Management</span></a>
                    </li>
                    <li><a href="{{ route('privacy.policy') }}"
                            class="waves-effect  @if (Route::is('privacy.policy')) active @endif"><i
                                class="fas fa-sticky-note"></i><span>Privacy Policy</span></a></li>
                    <li><a href="{{ route('terms.conditions') }}"
                            class="waves-effect  @if (Route::is('terms.conditions')) active @endif"><i
                                class="fas fa-pen"></i><span>Terms & Conditions</span></a></li>
                    <li><a href="{{ route('admin.list.banner') }}"
                            class="waves-effect  @if (Route::is('admin.list.banner')) active @endif"><i
                                class="fas fa-images"></i><span>Banner Management</span></a></li>
                    <li><a href="{{ route('import.form') }}"
                            class="waves-effect  @if (Route::is('import.form')) active @endif"><i
                                class="fas fa-import"></i><span>Import Schools</span></a></li>
                    <li><a href="{{ route('import.formsuburbs') }}"
                            class="waves-effect  @if (Route::is('import.formsuburbs')) active @endif"><i
                                class="fas fa-import"></i><span>Import Suburbs</span></a></li>
                    {{-- <li><a href="{{ route('admin.update.follow.us') }}" class="waves-effect  @if (Route::is('admin.update.follow.us')) active @endif"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Follow Us</span></a></li> --}}
                    {{-- <li>
                                <a href="{{ route('payments.history') }}" class="waves-effect  @if (Route::is('payments.history')) active @endif"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Payment History</span></a></li> --}}
                    {{-- <li><a href="javascript:void(0);" class="waves-effect"><i class="fas fa-user"></i><span> Profile Manage</span></a></li> --}}
                    {{-- <li><a href="javascript:void(0);" class="waves-effect"><i class="fas fa-clock"></i><span>Manage
                                Availabiliti</span></a></li>
                            <li><a href="javascript:void(0);" class="waves-effect"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Booking Management</span></a></li>
                            <li><a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star" aria-hidden="true"></i><span>Rating Management
                            System</span></a></li>
                            <li><a href="javascript:void(0);" class="waves-effect"><i class="far fa-credit-card" aria-hidden="true"></i><span>Process Payment to Tutor</span></a></li> --}}
                </ul>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
