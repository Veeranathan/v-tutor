<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\SessionApiController;
use App\Http\Controllers\TutorApplicationFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ZohoAuthController;
use App\Http\Controllers\LandingPage\LandingPageController;
use App\Http\Controllers\ResendVerifyLink\ResendVerifyLinkController;
use App\Http\Controllers\StaticPages\Modules\StaticController;
use App\Http\Controllers\Teacher\CronUpdate\CronController;
use App\Http\Controllers\CChecking\CCheckingController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Teacher\Auth\RegController as TeacherRegController;
use App\Http\Controllers\Teacher\Dashboard\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\AdvancePage\AdvancePageController;
use App\Http\Controllers\Teacher\TeacherAvatarUpdate\TeacherAvatarUpdateController;
use App\Http\Controllers\Teacher\MyAvailability\MyAvailabilityController;
use App\Http\Controllers\Teacher\MyAvailability\MyAvailabilityController as TeacherMyAvailabilityController;
use App\Http\Controllers\Teacher\AwaitingApprovalTutorPersonalInfo\AwaitingApprovalTutorPersonalInfoController as AwaitingApprovalTutorProfileController;
use App\Http\Controllers\Teacher\DateExclusionList\DateExclusionListController;
use App\Http\Controllers\Teacher\ClassEndAssesment\ClassEndAssesmentController as TeacherClassEndAssesmentController;
use App\Http\Controllers\Teacher\TeacherMyPayments\TeacherMyPaymentsController;
use App\Http\Controllers\Teacher\MyClass\MyclassController;
use App\Http\controllers\Teacher\CloseMyAccount\CloseMyAccountController as TeacherCloseMyAccountController;
use App\Http\Controllers\Teacher\Review\TeacherReviewController;
use App\Http\Controllers\Teacher\ViewBookingDetails\ViewBookingDetailsController as TeacherViewBookingDetailsController;

use App\Http\Controllers\Teacher\RescheduleBooking\RescheduleBookingController as TeacherRescheduleBookingController;
use App\Http\Controllers\Teacher\MyProfile\MyProfileController as AwaitingApprovalTutorMyProfileController;
use App\Http\Controllers\Teacher\MyProfile\MyProfileController as TeacherProfileController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Student\Auth\RegController;
use App\Http\Controllers\Student\Auth\GuestRegisterController;
use App\Http\Controllers\Student\SearchResult\SearchResultController;
use App\Http\Controllers\Student\UserToFavourite\UserToFavouriteController;
use App\Http\Controllers\SchoolList\SchoolListController;
use App\Http\Controllers\Student\BookClass\BookClassController;
use App\Http\Controllers\Student\GetAllVTutors\GetAllVTutorsController;
use App\Http\Controllers\Student\StudentMyPayments\StudentMyPaymentsController;
use App\Http\Controllers\Student\MyClasses\MyClassesController;
use App\Http\Controllers\Student\Review\ReviewController;
use App\Http\Controllers\Student\Assessment\MyAssessmentController;
use App\Http\Controllers\Student\MyAcademicProgram\MyAcademicProgramControler;
use App\Http\Controllers\Student\ViewBookingDetails\ViewBookingDetailsController;
use App\Http\Controllers\Student\MyProfile\MyProfileController;
use App\Http\Controllers\Student\CloseMyAccount\CloseMyAccountController;
use App\Http\Controllers\Student\StudentAvatarUpdate\StudentAvatarUpdateController;
use App\Http\Controllers\Student\ClassEndAssesment\ClassEndAssesmentController;
use App\Http\Controllers\Student\Notification\NotificationController;
use App\Http\Controllers\Student\Alert\SessionController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ZoomWebhookController;
use App\Http\Controllers\Auth\PushNotificationController;
use App\Http\Controllers\Programme\ProgrammeController;
use App\Http\Controllers\CategoryController\CategoryPageController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Payment\ProgramPaymentController;

use App\Http\Controllers\Admin\Auth\ResetPasswordController;



Route::get('/zoom/join/{meetingId}', [ZoomWebhookController::class, 'joinMeeting']);
// https://your-app.com/zoom/join/{meetingId}?name=Parent+One&email=parent@example.com


Auth::routes();

Route::get('/coming-soon', [TutorApplicationFormController::class, 'comingSoonPage'])->name('coming_soon_page');

Route::get('/s/{code}', [TutorApplicationFormController::class, 'redirectZoomMeeting'])->name('zoom_short_redirect');

Route::post('/remove-fcm-token', [LoginController::class, 'removeFcmToken'])->name('remove-fcm-token');


// Tutor Application Form Start
    /* ——— Sign‑up ——— */
    Route::get ('/tutor-application-form-signup', [TutorApplicationFormController::class, 'showTutorRegisterForm'])
        ->name('tutor_application_form_signup');
    Route::post('/tutor-application-form-signup', [TutorApplicationFormController::class, 'saveTutorRegisterForm'])
        ->name('tutor_application_form_signup_save');
    /* ——— Login ——— */
    Route::get('/tutor-application-form-login', [TutorApplicationFormController::class, 'tutorApplicationFormLogin'])->name('tutor_application_form_login');
    Route::post('/tutor-application-form-check-login', [TutorApplicationFormController::class, 'tutorApplicationFormCheckLogin'])->name('tutor_application_form_check_login');
    /* ——— Forgot Password ——— */
    Route::get('/tutor-forget-password', [TutorApplicationFormController::class, 'tutorForgotPassword'])->name('tutor_application_form_fp');
    Route::post('/tutor-forget-password', [TutorApplicationFormController::class, 'tutorCheckForgotPassword'])->name('tutor_application_form_chk_fp');
    /* ——— Reset Password ——— */
    Route::get('/tutor-reset-password/{token}', [TutorApplicationFormController::class, 'tutorResetPassword'])->name('tutor_application_form_pw_reset');
    Route::post('/tutor-reset-password', [TutorApplicationFormController::class, 'tutorCheckResetPassword'])->name('tutor_application_form_chk_pw_reset');
    /* ——— Application form ——— */
    Route::get('/tutor-landing', [TutorApplicationFormController::class, 'tutorLandingPage'])->name('tutor_landing');
    Route::get('/tutor-application-form', [TutorApplicationFormController::class, 'getTutorApplicationForm'])->name('tutor_application_form');
    Route::post('/tutor-application-form-save-tab1', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab1'])->name('tutor_application_form_save_tab1');
    Route::post('/tutor-application-form-save-tab2', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab2'])->name('tutor_application_form_save_tab2');
    Route::post('/tutor-application-form-save-tab3', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab3'])->name('tutor_application_form_save_tab3');
    Route::post('/tutor-application-form-save-tab4', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab4'])->name('tutor_application_form_save_tab4');
    Route::post('/tutor-application-form-save-tab5', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab5'])->name('tutor_application_form_save_tab5');
    Route::post('/tutor-application-form-save-tab6', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab6'])->name('tutor_application_form_save_tab6');
    Route::post('/tutor-application-form-save-tab7', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab7'])->name('tutor_application_form_save_tab7');
    Route::post('/tutor-application-form-save-tab8', [TutorApplicationFormController::class, 'SaveTutorApplicationFormTab8'])->name('tutor_application_form_save_tab8');
    // Tutor - Close my Account
    Route::any('/tutor-close-account', [TutorApplicationFormController::class, 'tutorCloseMyAccount'])->name('tutor_close_account');
    // Cron Reminder Application Form Incomplete
    Route::get('/tutor-application-form/in-complete/cron', [TutorApplicationFormController::class, 'tafIncompleteCron'])->name('tutor_application_form_incomplete_cron');
    Route::get('/tutor-application-form/wwcc-expired/cron', [TutorApplicationFormController::class, 'tafWWCCExpiredCron'])->name('tutor_application_form_wwcc_expired_cron');
    Route::get('/tutor-application-form/reminder-wwcc-expire/cron', [TutorApplicationFormController::class, 'tafReminderWWCCExpireCron'])->name('tutor_application_form_reminder_wwcc_expire_cron');
    // Cron Zoom Meeting Notification
    Route::get('/zoom-meeting-notification/cron', [TutorApplicationFormController::class, 'zoomMeetingNotificationCron'])->name('zoom_meeting_notification_cron');
    // Check Student Zoom Meeting Befor 5min
    Route::get('/check-zoom-meeting-student', [TutorApplicationFormController::class, 'checkStudentZoomMeeting'])->name('check_student_zoom_meeting');
    Route::get('/check-zoom-meeting-tutor', [TutorApplicationFormController::class, 'checkTutorZoomMeeting'])->name('check_tutor_zoom_meeting');
// Tutor Application Form End

Route::get('/', [LandingPageController::class, 'viewLandingPage'])->name('landing.page');

Route::any('/resend-verification-link/{id}', [ResendVerifyLinkController::class, 'resendVerifyLink'])->name('resend.verification.link');
// Route::any('/update-end-meetings/{id}', [StaticController::class, 'updateEndMeetings'])->name('update.end.meetings');
// Route::any('/update-meetings', [StaticController::class, 'updateMeeting'])->name('update.meetings');
// Route::any('/end-meetings', [StaticController::class, 'endMeetings'])->name('end.meetings');
Route::any('/session/{userid}/{id}', [StaticController::class, 'classSessionLink'])->name('class.session.link');
Route::any('/tutor-session/{userid}/{id}', [StaticController::class, 'tutorclassSessionLink'])->name('tutor.class.session.link');
Route::any('data-deletion', [StaticController::class, 'facebookDataDeletion'])->name('data.deletion');
Route::get('faq', [StaticController::class, 'faq'])->name('faq');
Route::get('help', [StaticController::class, 'help'])->name('help');
Route::get('privacy-policy', [StaticController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('terms-service', [StaticController::class, 'termsservice'])->name('terms.service');

/* ——— Subject ——— */
Route::get('subject', [StaticController::class, 'subject'])->name('subject');

/* ——— Blog ——— */
Route::get('/blog', [StaticController::class, 'blog'])->name('home.blog');
Route::get('/blog/{slug}', [StaticController::class, 'blog_detail'])->name('blog.detail');

/* ——— Cart ——— */
Route::get('/cart/buy-now/{program}', [CartController::class, 'buyNow'])->name('cart.buyNow');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/toggle', [CartController::class, 'toggle'])->name('cart.toggle');
Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');


/* ——— Program  Payment ——— */
Route::post('/stripe/program/session',  [ProgramPaymentController::class, 'createCheckoutSession'])->name('stripe.program.session');
Route::get('/program/payment/success',[ProgramPaymentController::class, 'success'])->name('cart.payment.success');
Route::get('/program/payment/cancel',[ProgramPaymentController::class, 'cancel'])->name('cart.payment.cancel');
  

/* ——— Programme Form & Landing Page ——— */
Route::get('/summer-holiday-program-2025-old', [ProgrammeController::class, 'holidayProgramme'])->name('holiday.programme');
Route::get('/summer-holiday-program-2025', [ProgrammeController::class, 'programmeSignup'])->name('programme.signup');
Route::post('/programme-signup', [ProgrammeController::class, 'store'])->name('programme.signup.store');
Route::post('/programme-signup-check-email', [ProgrammeController::class, 'checkEmail'])->name('programme.signup.email.check');
Route::get('/learning-program-assessment', [ProgrammeController::class, 'learningProgramAssessment'])->name('program.assessment');
Route::post('/learning-program-assessment/store',[ProgrammeController::class, 'storeProgramLearningAssessment'])->name('learning.program.assessment.store');
// Email entry
Route::get('/learning-program-assessment/link/{token}',[ProgrammeController::class, 'assessmentEmailRedirect'])->middleware('assessment.otp')->name('program.assessment.email.link');
// OTP
Route::get('/learning-program-assessment/otp/{token}',[ProgrammeController::class, 'showOtpForm'])->name('program.assessment.otp');
Route::post('/learning-program-assessment/otp/verify',[ProgrammeController::class, 'verifyOtp'])->name('program.assessment.otp.verify');
Route::post('/learning-program-assessment/otp/resend', [ProgrammeController::class, 'resendOtp'])->name('program.assessment.otp.resend');
// Main assessment
Route::get('/learning-program-assessment/start/{token}',[ProgrammeController::class, 'startMainAssessment'])->middleware('assessment.start')->name('program.assessment.start');
Route::post('/learning-program-assessment/submit',[ProgrammeController::class, 'submitMainAssessment'])->name('program.assessment.submit');
Route::post('/learning-program-assessment/save-draft', [ProgrammeController::class, 'saveAssessmentDraft'])->middleware('assessment.start')->name('program.assessment.save_draft');

Route::get('/assessment/{slug}', [ProgrammeController::class, 'startAssessment'])->name('assessment.form.start');
//Fetch/Start Assessment Draft
Route::post('/assessment/{type}/fetch-draft', [ProgrammeController::class, 'fetchDirectAssessmentDraft'])->name('assessment.fetch_draft');
Route::get('/assessment/resume/{slug}', [ProgrammeController::class, 'showResumeForm'])->name('program.assessment.resume.form');
Route::post('/assessment/check-existing', [ProgrammeController::class, 'checkExistingAssessment'])->name('program.assessment.check_existing');

//Book Assessment
Route::get('/bookassessment', [ProgrammeController::class, 'bookassessment'])->name('bookassessment');
Route::post('/bookassessment/submit', [ProgrammeController::class, 'submitBookFreeAssessment'])->name('program.book.free.assessment.submit');

Route::get('/assessment-availability', [ProgrammeController::class, 'assessmentAvailability'])->name('assessment.availability');

Route::get('terms-conditions', [StaticController::class, 'termsConditions'])->name('terms.conditions');
Route::get('contact-us', [StaticController::class, 'contact_us'])->name('contact.us');
Route::post('send-contact-us', [StaticController::class, 'sendcontact_us'])->name('send.contact.us');
Route::get('about-us', [StaticController::class, 'about_us'])->name('about.us');
Route::get('message', [StaticController::class, 'message'])->name('msg');

Route::get('/update-earning', [CronController::class, 'update_earning'])->name('update.earning');
Route::get('/update-cm', [CronController::class, 'updateToCm'])->name('update.cm');
Route::get('/update-no', [CronController::class, 'no_add'])->name('update.no');
Route::get('add-t-desc', [CCheckingController::class, 'addDescription'])->name('cc.cc');
Route::get('test-cron', [CCheckingController::class, 'addDescription'])->name('test.cc.cc');

Route::get('/update-availability', [CronController::class, 'update_availability'])->name('update.availability');

Route::get('checkemail', [StaticController::class, 'emailcheck'])->name('check.email');
Route::get('checkmobile', [StaticController::class, 'emailmobile'])->name('check.mobile');
Route::get('checkmobile/two', [StaticController::class, 'emailmobiletwo'])->name('check.mobile.two');

Route::get('forget-password', [ForgotPasswordController::class, 'forget_pass_view'])->name('fgp.view');
Route::post('forget-password/send-mail', [ForgotPasswordController::class, 'sendMail'])->name('user.forget.password');
Route::get('reset-password/{email_vcode}', [ForgotPasswordController::class, 'resetpassword'])->name('password.confirm');
Route::post('reset-password/new-password', [ForgotPasswordController::class, 'newPassword'])->name('user.new.password');

Route::get('tutor-public-profile/{slug}', [TeacherDashboardController::class, 'public_profile'])->name('tutor.public.profile');
Route::get('getdata', [TeacherDashboardController::class, 'getdata'])->name('tutor.public.getdata');
Route::post('/contact-us', [MessageController::class, 'store'])->name('contact.us');
Route::get('/zoho/connect', [ZohoAuthController::class, 'redirect']);
Route::get('/zoho/callback', [ZohoAuthController::class, 'callback']);

Route::get('/api/student/next-session', [SessionApiController::class, 'getNextSession'])
    ->middleware('auth:web') // Assuming 'web' guard for students; adjust if different
    ->name('api.student.next-session');



//-------------------------------STUDENT ROUTE PART------------------------------------------//

// student auth
Route::get('sign-up', [RegisterController::class, 'showRegistrationForm'])->name('register'); /*26/10*/
Route::post('register/user', [RegController::class, 'student_custom_reg'])->name('user.reg');
Route::get('sign-up/user/step-2/{id}', [RegController::class, 'step_two_view'])->name('reg.two.view');
Route::post('register/user/two', [RegController::class, 'student_custom_reg_two'])->name('user.reg.two');

// guest  register
Route::post('/student/guest-register', [GuestRegisterController::class, 'guestRegister'])->name('student.guest.register');
Route::post('/student/guest/check-exists',[GuestRegisterController::class, 'checkGuestExists'])->name('student.guest.checkExists');


/***************Search*************/
// jayatri tutor search result
Route::get('/tutor-search-result/{slug?}', [SearchResultController::class, 'searchResult'])->name('search.result.j');
Route::post('/apply-filter-search-result', [SearchResultController::class, 'applyFilter'])->name('search.result.apply.filter');
Route::get('/save-search-on-click-value', [SearchResultController::class, 'saveSearchOnClickValue'])->name('save.search.on.click.value');
Route::any('get-all-search-subjects', [SearchResultController::class, 'getSearchSubjects'])->name('get.all.search.subjects');

Route::post('/save-user-favourite', [UserToFavouriteController::class, 'saveUserTofavourite'])->name('save.user.to.favourite');
Route::get('/student-mytutors', [UserToFavouriteController::class, 'getAllUserToFavourites'])->name('list.of.favourite');

/************End Search***********************************/

// jayatri get tutor data
Route::get('get-tutor-data', [BookClassController::class, 'getStudentGradeTutorData'])->name('student.search.grade.tutors.book');
Route::get('get-all-schools', [SchoolListController::class, 'getAllSchools'])->name('get.all.schools');
Route::post('get-branch-subjects', [SchoolListController::class, 'getBranchSubjects'])->name('get.branch.subjects');
Route::any('ajax-get-subject-date-amount', [BookClassController::class, 'ajaxGetGradeSubjectTimeDateAmount'])->name('ajax.get.date.time.subject.amount');
Route::get('get-subject-topics/{subject_id}', [BookClassController::class, 'getTopicsBySubject'])->name('get-subject-topics');
Route::post('/save-fcm-token', [PushNotificationController::class, 'saveToken'])->middleware('auth');
Route::get('/notifications/unread-count', [PushNotificationController::class, 'unreadCount'])->name('notifications_unread_count')->middleware('auth');
Route::get('/notifications/unread-list', [PushNotificationController::class, 'unreadList'])->name('notifications_unread_list')->middleware('auth');
Route::post('/notifications/mark-read', [PushNotificationController::class, 'markRead'])->name('notifications_mark_read')->middleware('auth');
Route::get('studentbook-class', [BookClassController::class, 'studentBookClass'])->name('student.book.class');

//ALL STUDENT AUTHENTICATED ROUTE
Route::group(['middleware' => ['auth', 'user']], function () {
    


    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/my-profile', [MyProfileController::class, 'my_profile_show'])->name('my.profile');

    // Cancel incomplete booking 25-11-2021
    Route::get('cancel-incomplete-booking/{id}', [BookClassController::class, 'cancelIncompleteBooking'])->name('cancel.booking.incomplete');

    // Change password
    Route::get('my-profile/reset-password', [MyProfileController::class, 'reset_password_view'])->name('student.reset.password.view');
    Route::post('my-profile/update-password', [MyProfileController::class, 'update_password'])->name('student.update.password');

    /************************BOOK CLASS********************/
    Route::any('get-all-v-tutors', [GetAllVTutorsController::class, 'getAllTutors'])->name('get.all.v.tutors');
    Route::any('booking-class/{slug?}/{id?}', [BookClassController::class, 'bookAClass'])->name('student.booking');
    Route::get('student-bookingconfirmation/{bookingId}', [BookClassController::class, 'studentBookingConfirmation'])->name('student.booking.confirmation');
    Route::get('cancel-student-booking/{bookingNo}', [BookClassController::class, 'cancelBooking'])->name('student.cancel.booking');
    Route::get('canceled-booking/{bookingNo}', [BookClassController::class, 'studentCancelBooking'])->name('student.canceled.booking');
    Route::post('ajax-checking-booking-slot', [BookClassController::class, 'ajaxCheckingBookingSlot'])->name('ajax.checking.booking.slot');
    Route::post('ajax-dt-time-checking-booking-slot', [BookClassController::class, 'ajaxDtTimeCheckingBookingSlot'])->name('ajax.dt.time.checking.booking.slot');
    Route::post('ajax-check-time-slot', [BookClassController::class, 'ajaxCheckTimeSlot'])->name('ajax.check.time.slot');
    Route::post('ajax-check-booking-date', [BookClassController::class, 'ajaxCheckBookingDate'])->name('ajax.check.booking.date');
    Route::get('/ajax/search-tutors', [BookClassController::class, 'searchTutors'])->name('ajax.search.tutors');
    Route::post('/ajax/get-day-slots', [BookClassController::class, 'ajaxGetDaySlots'])->name('ajax.get.day.slots');
    Route::get('/academic-booking/{purchaseId}', [BookClassController::class, 'academicBookingView'])->name('academic.booking.view');
    Route::any('booking-academic-session/{slug?}/{id?}', [BookClassController::class, 'bookAcademicSession'])->name('academic.booking');
    Route::get('student-academicBookingconfirmation/{bookingId}', [BookClassController::class, 'studentAcademicBookingConfirmation'])->name('student.academic.booking.confirmation');
    /************************ END BOOK CLASS********************/

    /*****************MY PAYMENTS************************/
    Route::get('student-my-payments', [StudentMyPaymentsController::class, 'studentMyPayments'])->name('student.my.payments');
    Route::any('g-student-my-payments', [StudentMyPaymentsController::class, 'studentGMyPayments'])->name('student.g.my.payments');
    Route::any('a-student-my-payments', [StudentMyPaymentsController::class, 'studentAMyPayments'])->name('student.a.my.payments');
    Route::any('ga-student-my-payments', [StudentMyPaymentsController::class, 'studentGAMyPayments'])->name('student.ga.my.payments');

    /************Student MY CLASSES*************************/
    Route::get('my-class', [MyClassesController::class, 'studentMyClasses'])->name('student.my.classes');
    Route::post('my-class', [MyClassesController::class, 'studentMyClasses'])->name('student.my.classes');
    Route::get('my-class/upcoming', [MyClassesController::class, 'studentMyClassesUpcoming'])->name('student.my.classes.upcoming');
    Route::post('my-class/upcoming', [MyClassesController::class, 'studentMyClassesUpcoming'])->name('student.my.classes.upcoming');
    Route::get('my-class/past', [MyClassesController::class, 'studentMyClassesPast'])->name('student.my.classes.past');
    Route::post('my-class/past', [MyClassesController::class, 'studentMyClassesPast'])->name('student.my.classes.past');
    Route::post('my-class/export', [MyClassesController::class, 'studentClassExport'])->name('student.class.export');

    /* Review part start */
    Route::get('my-review/{slug}', [ReviewController::class, 'review_page'])->name('student.my.review');
    Route::get('my-review', [ReviewController::class, 'review_page_without_slug'])->name('student.my.review.no.slug');
    Route::post('my-review/ins', [ReviewController::class, 'review_insert'])->name('student.my.review.ins');
    Route::get('my-review/del/{id}', [ReviewController::class, 'review_del'])->name('student.del.review');
    /* Review part end */

     /* My academic-program */
    Route::get('my-academic-program', [MyAcademicProgramControler::class, 'myMyAcademicProgram'])->name('student.my.academic.program');
    Route::get('student-academic-program-list',[MyAcademicProgramControler::class, 'student_academic_program_list'])->name('student.academic.program.list.ajax');
    Route::get('my-academic-program-view/{purchaseId}',[MyAcademicProgramControler::class, 'myMyAcademicProgramView'])->name('student.my.academic.program.view');

    /* My assessment */
    Route::get('my-assessment', [MyAssessmentController::class, 'myAssessment'])->name('student.my.assessment');
    Route::post('student/my-assessment/store', [MyAssessmentController::class, 'store'])->name('student.my.assessment.store');

    // View details - jayatri
    Route::get('/{bookingNo}', [ViewBookingDetailsController::class, 'viewDetails'])->name('student.view.details.class.booking');
    Route::get('student-view-payment-information/{bookingNo}', [ViewBookingDetailsController::class, 'viewDetailsPaymentInfo'])->name('student.view.payment.information');
    Route::get('student-cancel-class-booking/{bookingNo}', [ViewBookingDetailsController::class, 'cancelBookedClass'])->name('student.cancel.class.booking');

    // Profile part
    Route::any('/check-old-password', [MyProfileController::class, 'checkOldPassword'])->name('check.old.password');

    Route::post('/my-profile/update', [MyProfileController::class, 'update_profile'])->name('update.profile');
    Route::get('/my-profile/fetchAddress', [MyProfileController::class, 'fetchAddressSuggestions'])->name('fetch.address');
   Route::get('/autocomplete-school', [MyProfileController::class, 'autocompleteSchool'])->name('autocomplete.school');
   Route::get('/get-suburbs', [MyProfileController::class, 'getSuburbs'])->name('get.suburbs');
   Route::get('/get-schools', [MyProfileController::class, 'getSchools'])->name('get.schools');
// The existing route for the notification bell dropdown
// Route for the notification bell dropdown (fetches upcoming bookings)
Route::get('/upcoming-bookings-for-notification', [NotificationController::class, 'getUpcomingBookingsForNotification'])->name('get.notification');

// NEW ROUTE for today's upcoming bookings for the banner alert
Route::get('/todays-upcoming-bookings-for-banner', [NotificationController::class, 'getTodaysUpcomingBookingsForBanner'])->name('todays-upcoming-bookings-for-banner');

// Route to get the complete details for a single booking (when clicking a notification item)
// The 'booking_id' should be passed as a query parameter in the request.
Route::get('view-class-notification-details', [NotificationController::class,'getNotificationDetails'])->name('get.notificationdetails');
//Session counter


    // Student close account option
    Route::any('/student-close-account', [CloseMyAccountController::class, 'studentCloseMyAccount'])->name('student.close.account');

    /***********Avatar update*******************/
    Route::post('/student-update-avatar', [StudentAvatarUpdateController::class, 'updateStudentAvatar'])->name('student.avatar.update');

    // Student class end assessment jayatri 08-11-2021
    Route::get('/student-class-end-assesment/{id}', [ClassEndAssesmentController::class, 'viewStudentClassEndAssesment'])->name('student.class.end.assesment');
    Route::post('/save-student-class-end-assesment/{id}', [ClassEndAssesmentController::class, 'saveStudentClassEndAssesment'])->name('student.class.end.assesment.save');

    Route::get('/charge-pay', [PaymentController::class, 'initPaymentCreateObject'])->name('checking');

    // Payment
    Route::get('payment/init', [PaymentController::class, 'init'])->name('payment.init');
    Route::any('check/promocode', [PaymentController::class, 'checkPromocode'])->name('check_promo');
    Route::post('/free-booking', [PaymentController::class, 'freeBooking'])->name('free.booking');
    Route::get('pay', [PaymentController::class, 'init'])->name('view.payment.page');
    Route::get('proceed-pay', [PaymentController::class, 'viewPaymentPage'])->name('view.payment.page');
    Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
    Route::post('/stripe/session', [PaymentController::class, 'createCheckoutSession'])->name('stripe.create.session');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

});






//------SOCIAL LOGIN ROUTE-------------//
Route::get('login/{user_type}/{provider_type}/{login_type?}', [LoginController::class,'redirectToProvider'])->name('login.social');
Route::get('login/{user_type}/{provider_type}/{login_type?}/callback', [LoginController::class,'handleProviderCallback'])->name('login.social.callback');







//-------------------------------TEACHER ROUTE PART------------------------------------------//

//teacher auth
Route::group(['prefix'=>'tutor'],function(){

    Route::get('/sign-up', [TeacherRegController::class,'teacher_reg_view'])->name('reg.home');
    Route::post('register', [TeacherRegController::class,'teacher_custom_reg'])->name('teacher.custom.register');
    Route::get('email/verify/{id}/{vcode}', [TeacherRegController::class,'verify'])->name('teacher.verification.notice');
    Route::any('logout', [LoginController::class,'logout']);

    /*28/10*/Route::get('sign-up/step-2/{id}', [TeacherRegController::class,'step_two_view'])->name('tutor.reg.two.view');
    Route::post('register/user/two', [TeacherRegController::class,'tutor_custom_reg_two'])->name('teacher.custom.register.two');

    /******************************************************/
     // not approved tutors
    Route::get('tutor-awaiting-approval-my-profile', [AwaitingApprovalTutorProfileController::class,'my_profile'])->name('tutor.awaiting.approval.profile');
    Route::post('tutor-awaiting-approval-my-profile/update', [AwaitingApprovalTutorProfileController::class,'teacher_profile_update'])->name('tutor.awaiting.approval.profile.update');

    /******** tutor update avatar ***********/
    Route::post('/tutor-update-avatar', [TeacherAvatarUpdateController::class,'updateTutorAvatar'])->name('tutor.avatar.update');
    /******************************************************/



    //ALL TEACHER AUTHENTICATED ROUTE
    Route::group(['middleware'=>['auth','teacher']],function(){

        Route::get('home', [TeacherDashboardController::class,'teacher_dashboard'])->name('teacher.home');
        //profile related 9/9
        Route::get('my-profile', [TeacherProfileController::class,'my_profile'])->name('teacher.profile');
        Route::get('advance-page', [AdvancePageController::class,'myAdvancePage'])->name('teacher.advance.page');
        Route::post('update-advance-page', [AdvancePageController::class,'updatemyAdvancePage'])->name('teacher.update.advance.page');
        Route::any('/tutor-check-old-password', [TeacherProfileController::class,'checkOldPassword'])->name('tutor.check.old.password');
        Route::post('my-profile/update', [TeacherProfileController::class,'teacher_profile_update'])->name('teacher.profile.update');
        // student close account option
        Route::any('/tutor-close-account', [TeacherCloseMyAccountController::class,'tutorCloseMyAccount'])->name('teacher.close.account');


        //change password
        //30
        Route::get('my-profile/reset-password', [TeacherDashboardController::class,'reset_password_view'])->name('teacher.reset.password.view');
        Route::post('my-profile/update-password', [TeacherDashboardController::class,'update_password'])->name('tutor.update.password');


        //tutorship related
        Route::get('my-profile/tutorship-plan', [TeacherProfileController::class,'tutorship_plan_view'])->name('tutorship.plan');
        Route::post('my-profile/tutorship-plan/insert', [TeacherProfileController::class,'tutorship_plan_ins'])->name('tutorship.plan.ins');
        Route::get('my-profile/tutorship-plan/delete/{id}', [TeacherProfileController::class,'tutorship_plan_dlt'])->name('tutorship.plan.dlt');
        Route::get('my-profile/tutorship-plan/edit/{id}', [TeacherProfileController::class,'tutorship_edit_page'])->name('tutorship.plan.edit.page');
        Route::post('my-profile/tutorship-plan/update', [TeacherProfileController::class,'tutorship_update'])->name('tutorship.plan.update');
        Route::post('my-profile/get-sub', [TeacherProfileController::class,'get_sub'])->name('get.sub');
        Route::get('my-profile/academic-program', [TeacherProfileController::class,'tutorship_academic_program'])->name('tutorship.academic.program');
        Route::get('my-profile/academic-program/list',[TeacherProfileController::class, 'tutorship_academic_program_list'])->name('tutor.academic.program.list.ajax');



        //teacher experience
        Route::get('my-profile/experience', [TeacherProfileController::class,'experience_list'])->name('tutor.exp');
        Route::post('my-profile/experience/insert',[TeacherProfileController::class,'exp_ins'])->name('exp.ins');
        Route::get('my-profile/experience/delete/{id}', [TeacherProfileController::class,'exp_dlt'])->name('tutor.exp.dlt');
        Route::get('my-profile/experience/edit/{id}', [TeacherProfileController::class,'exp_edit_page'])->name('tutor.exp.edit.page');
        Route::post('my-profile/experience/update', [TeacherProfileController::class,'exp_update'])->name('tutor.exp.update');


        //teacher recognization
        Route::get('my-profile/right-to-work', [TeacherProfileController::class,'rightToWork'])->name('tutor.right_to_work');
        Route::get('my-profile/recognitions', [TeacherProfileController::class,'recognization_list'])->name('tutor.recognization');
        Route::post('my-profile/recognitions/insert', [TeacherProfileController::class,'rec_ins'])->name('tutor.rec.add');
        Route::get('my-profile/recognitions/delete/{id}', [TeacherProfileController::class,'rec_dlt'])->name('rec.delete');
        Route::get('my-profile/recognitions/edit/{id}', [TeacherProfileController::class,'rec_edit_page'])->name('rec.edit.page');
        Route::post('my-profile/recognitions/update', [TeacherProfileController::class,'rec_update'])->name('tutor.rec.update');

        //tutor academic
        Route::get('my-profile/acadamics', [TeacherProfileController::class,'acadamic_list'])->name('tutor.acadamic');
        Route::post('my-profile/acadamic/insert', [TeacherProfileController::class,'academic_ins'])->name('academic.ins');
        Route::get('my-profile/acadamic/delete/{id}', [TeacherProfileController::class,'aced_dlt'])->name('aced.dlt');
        Route::get('my-profile/acadamic/edit/{id}', [TeacherProfileController::class,'aced_edit_page'])->name('aced.edit.page');
        Route::post('my-profile/acadamic/update', [TeacherProfileController::class,'aced_update'])->name('academic.update');


        //teacher availibility
        Route::get('my-availablity', [TeacherMyAvailabilityController::class,'available_page'])->name('tutor.availability');
        Route::post('time/chk', [TeacherMyAvailabilityController::class,'time_chk'])->name('time.chk');
        Route::post('my-availablity/delete', [TeacherMyAvailabilityController::class, 'deleteSlot'])->name('availability.delete');
        Route::post('my-availablity/save', [TeacherMyAvailabilityController::class, 'saveSlots'])->name('availability.save');

        // Route::post('my-availablity/insert', [TeacherMyAvailabilityController::class,'aval_ins'])->name('aval.ins');
        // Route::post('my-availablity/delete', [TeacherMyAvailabilityController::class,'aval_dlt'])->name('aval.dlt');
        /*30*/Route::post('fromtime/fetch', [TeacherMyAvailabilityController::class,'fetch_from_time'])->name('from.time.fetch');

        /************************************************************/
        // jayatri 01-11-2021
        Route::get('my-date-exclusion-list', [DateExclusionListController::class,'viewMyDateExclusionList'])->name('tutor.date.exclusion.list');
        Route::post('update-date-exclusion-list', [DateExclusionListController::class,'updateMyDateExclusionList'])->name('tutor.update.date.exclusion.list');
        Route::post('ajax-date-exclusion-list', [DateExclusionListController::class,'ajaxCheckingDateExclusion'])->name('tutor.ajax.date.exclusion.list');
        Route::get('tutor-delete-non-availability/{id}', [DateExclusionListController::class,'deleteNonAvilability'])->name('tutor.delete.tutor.non.availability');
        /************************************************************/
        /****************MY PAYMENTS********/
        Route::get('tutor-my-payments', [TeacherMyPaymentsController::class,'teacherMyPayments'])->name('tutor.my.payments');
        Route::get('download-tutor-my-payments-list', [TeacherMyPaymentsController::class,'downloadTutorPayments'])->name('download.tutor.my.payments');
        Route::any('g-tutor-my-payments', [TeacherMyPaymentsController::class,'teacherGMyPayments'])->name('tutor.g.my.payments');
        Route::any('a-tutor-my-payments', [TeacherMyPaymentsController::class,'teacherAMyPayments'])->name('tutor.a.my.payments');
        Route::any('ga-tutor-my-payments', [TeacherMyPaymentsController::class,'teacherGAMyPayments'])->name('tutor.ga.my.payments');
        Route::any('tutor-my-payments/transaction-history', [TeacherMyPaymentsController::class,'transaction_his'])->name('transaction.history');
        /********************/

        //My class
        Route::get('my-class', [MyclassController::class,'my_class_list'])->name('tutor.myclass');
        Route::post('my-class', [MyclassController::class,'my_class_list'])->name('tutor.myclass');

        Route::get('my-class/upcoming', [MyclassController::class,'my_class_upcoming_list'])->name('tutor.myclass.upcoming');
        Route::post('my-class/upcoming', [MyclassController::class,'my_class_upcoming_list'])->name('tutor.myclass.upcoming');

        Route::get('my-class/past', [MyclassController::class,'my_class_past_list'])->name('tutor.myclass.past');
        Route::post('my-class/past', [MyclassController::class,'my_class_past_list'])->name('tutor.myclass.past');
        Route::get('view-feedback-history/{booking_no}', [MyclassController::class,'viewFeedbackHistory'])->name('tutor_view_feedback_history');

        //23/10
        Route::post('my-class/export', [MyclassController::class,'tutorClassExport'])->name('tutor.class.export');


        /*************************View Booking Details************************/
        //view details
        // jayatri
        Route::get('teacher-view-class-booking/{bookingNo}', [TeacherViewBookingDetailsController::class,'viewDetails'])->name('teacher.view.details.class.booking');
        Route::post('teacher-session-feedback-save', [TeacherViewBookingDetailsController::class,'teacherSessionFeedbackSave'])->name('teacher_session_feedback_save');
        // jayatri
        Route::get('teacher-cancel-class-booking/{bookingNo}', [TeacherViewBookingDetailsController::class,'cancelBookedClass'])->name('teacher.cancel.class.booking');
        /****************************************END VIEW BOOKING DETAILS*********************/

        /*************************RESCHEDULE BOOKING************************/
        // 25-10-2021 jayatri reschedule
        Route::get('teacher-reschedule-booking/{bookingNo}', [TeacherRescheduleBookingController::class,'viewRescheduleBooking'])->name('teacher.view.reschedule.booking');
        Route::any('teacher-update-reschedule-booking/{bookingNo}', [TeacherRescheduleBookingController::class,'updateRescheduleBooking'])->name('teacher.update.reschedule.booking');
        // checking
        Route::post('teacher-ajax-reschedule-booking-date-check', [TeacherRescheduleBookingController::class,'ajaxCheckingTeacherRescheduleBooking'])->name('teacher.ajax.check.reschedule.booking');
        /*************************END RESCHEDULE BOOKING************************/
        /***********tutor Class End Assesment***************************/
        Route::get('/tutor-class-end-assesment/{id}', [TeacherClassEndAssesmentController::class,'viewTutorClassEndAssesment'])->name('tutor.class.end.assesment');
        Route::post('/save-tutor-class-end-assesment/{id}', [TeacherClassEndAssesmentController::class,'saveTutorClassEndAssesment'])->name('tutor.class.end.assesment.save');
        /***********tutor Class End Assesment***************************/

        //teacher payment
        Route::get('payment-history', [TeacherMyPaymentsController::class,'my_payment_list'])->name('tutor.payment');



        //tutor review start
        Route::get('my-review', [TeacherReviewController::class,'review_page'])->name('tutor.my.review');
        Route::get('my-review/details/{id}', [TeacherReviewController::class,'review_details'])->name('review.details');


        //end

    });



});




Route::get('/config-clear', function() {
    $status = Artisan::call('config:clear');
    return '<h1>Configurations cleared</h1>';
});

// //Clear cache:
Route::get('/cache-clear', function() {
    $status = Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});

// //Clear configuration cache:
Route::get('/config-cache', function() {
    $status = Artisan::call('config:cache');
    return '<h1>Configurations cache cleared</h1>';
});

//fallback
Route::fallback(function(){
     return view('errors.404');
 });


Route::get('/callback', [StaticController::class,'callBack'])->name('call.back');
//Route::get('/create-meeting', [StaticController::class,'createMeeting'])->name('create.meeting');

/* ——— Category Pages ——— */
Route::get('/program/{slug}', [CategoryPageController::class, 'programDetail'])->name('program.detail');
Route::post('/program-enquiry', [CategoryPageController::class, 'enquiry'])->name('program.enquiry');
Route::get('/{type}/{slug}', [CategoryPageController::class, 'show'])
    ->where([
        'type' => '^(subject|year|curriculum|state|city)$',
        'slug' => '[a-z0-9-]+',
    ]);
Route::get('programs/{type}', [CategoryPageController::class, 'products'])->name('products');
Route::post('/programs/filter', [CategoryPageController::class, 'filterPrograms'])->name('programs.filter');
