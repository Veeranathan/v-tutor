<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Modules\SubjectManagement\SubjectManagementController;

use App\Http\Controllers\Admin\Modules\SubjectController\SubjectController;
use App\Http\Controllers\Admin\Modules\TopicController\TopicController;
use App\Http\Controllers\Admin\Modules\SubjectTopics\SubjectTopicsController;
use App\Http\Controllers\Admin\Modules\SubjectTopicsDetails\SubjectTopicsDetailsController;
use App\Http\Controllers\Admin\Modules\BranchManagement\BranchManagementController;
use App\Http\Controllers\Admin\Modules\GradeManagement\GradeManagementController;
use App\Http\Controllers\Admin\Modules\StudentManagement\StudentManagementController;
use App\Http\Controllers\Admin\Modules\TutorManagement\TutorManagementController;
use App\Http\Controllers\Admin\Modules\TutorManagement\TutorApplicationFormController;
use App\Http\Controllers\Admin\Modules\TutorManagement\WWCCManagementController;
use App\Http\Controllers\Admin\Modules\ReviewManagementList\ReviewManagementController;
use App\Http\Controllers\Admin\Modules\TutorPaymentList\TutorPaymentListController;
use App\Http\Controllers\Admin\Modules\TutorPayouts\AdminPayoutController;
use App\Http\Controllers\Admin\Modules\TutorAvailability\TutorAvailabilityController;
use App\Http\Controllers\Admin\Modules\StudentPaymentList\StudentPaymentListController;
use App\Http\Controllers\Admin\Modules\TutorShipPlan\TutorShipPlanController;
use App\Http\Controllers\Admin\Modules\BookingsManagement\BookingsManagementController;
use App\Http\Controllers\Admin\Modules\AdminCommission\AdminCommissionController;
use App\Http\Controllers\Admin\Modules\AdminDisableBookingSettings\AdminDisableBookingsSettingsController;
use App\Http\Controllers\Admin\Modules\AdminDisableBookingDates\AdminDisableBookingDatesController;
use App\Http\Controllers\Admin\Modules\Review\AdminReviewController;
use App\Http\Controllers\Admin\Modules\AdminClassEndAssesment\AdminClassEndAsseesmentController;
use App\Http\Controllers\Admin\Modules\Payment\PaymentController;
use App\Http\Controllers\Admin\Modules\Faq\FaqController;
use App\Http\Controllers\Admin\Modules\Help\HelpController;
use App\Http\Controllers\Admin\Modules\Testimonial\TestimonialController;
use App\Http\Controllers\Admin\Modules\PrivacyPolicy\PrivacyPolicyController;
use App\Http\Controllers\Admin\Modules\TermsConditions\TermsConditionsController;
use App\Http\Controllers\Admin\Modules\Banners\BannersController;
use App\Http\Controllers\Admin\Modules\FollowUsDetails\FollowUsDetailsController;
use App\Http\Controllers\Admin\Modules\ModifyCommission\ModifyCommissionController;
use App\Http\Controllers\Admin\Modules\SchoolImport\ExcelImportController;
use App\Http\Controllers\Admin\Modules\ImportAddressSuburbs\SuburbsImportController;
use App\Http\Controllers\Admin\Modules\Promotions\PromotionController;
use App\Http\Controllers\Admin\Modules\ProgrammeManagement\ProgrammeManagementController;
use App\Http\Controllers\Admin\Modules\ProgrammeManagement\LearningProgramAssessmentController;
use App\Http\Controllers\Admin\Modules\LearningProgramAssessmentQuestionController\LearningProgramAssessmentQuestionController;
use App\Http\Controllers\Admin\Modules\LearningProgramAssessmentFormController\LearningProgramAssessmentFormController;
use App\Http\Controllers\Admin\Modules\Blog\BlogController;
use App\Http\Controllers\Admin\Modules\AcademicProgram\AcademicProgramController;
use App\Http\Controllers\Admin\Modules\AcademicProgram\AcademicProgramAssignmentController;

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin.auth:admin'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin_dashboard');
        //         // Admin Profile
        Route::get('admin-my-profile', [HomeController::class, 'editProfile'])->name('edit.admin.profile');
        Route::post('update-admin-profile', [HomeController::class, 'editProfile'])->name('update.admin.profile');
        Route::get('change-password', [HomeController::class, 'changePassword'])->name('admin.change.password');
        Route::post('change-password', [HomeController::class, 'changePassword'])->name('change.password');
        Route::get('confirm-admin-password', [HomeController::class, 'confirmAdminPassword'])->name('confirm.admin.password');
        Route::post('ajax-confirm-admin-password', [HomeController::class, 'ajaxconfirmAdminPassword'])->name('ajax.confirm.admin.password');

        Route::group(['namespace' => 'Modules'], function () {

            /*******************SUBJECT****************************/

            #subject management
            Route::get('/manage-subjects', [SubjectManagementController::class,'index'])->name('manage.subjects');
            Route::post('/manage-subjects', [SubjectManagementController::class,'subjectManagement'])->name('subject.management');
            #edit subject
            Route::any('/add-subject', [SubjectManagementController::class,'addSubject'])->name('add.subject');
            Route::any('/edit-subject/{id}', [SubjectManagementController::class,'editSubject'])->name('edit.subject');
            #view subject
            Route::get('/view-subject/{id}', [SubjectManagementController::class,'viewSubject'])->name('view.subject');
            #delete subject
            Route::get('/delete-subject/{id}', [SubjectManagementController::class,'deleteSubject'])->name('delete.subject');
            Route::get('subject/change-status/{id}', [SubjectManagementController::class,'changeStatusSubject'])->name('change.status.subject');
            /********************Subject******************************/

            Route::any('/ajax-delete-subject', [SubjectManagementController::class,'ajaxDeleteSubject'])->name('ajax.delete.subject');
            Route::any('/ajax-change-status-subject', [SubjectManagementController::class,'ajaxChangeStatusSubject'])->name('ajax.change.status.subject');


            Route::any('/subject-management-list-tab', [SubjectManagementController::class,'getSubjectManagementList'])->name('subject.management.list.tab');
            /*********************topics********************************************/
                 #topics management
                Route::get('/manage-topics', [SubjectTopicsController::class,'index'])->name('manage.topics');
                Route::post('/manage-topics', [SubjectTopicsController::class,'topicsManagement'])->name('topics.management');
                #edit subject
                Route::any('/add-topics', [SubjectTopicsController::class,'addTopics'])->name('add.topics');
                Route::any('/edit-topics/{id}', [SubjectTopicsController::class,'editTopics'])->name('edit.topics');
                #view subject
                Route::get('/view-topics/{id}', [SubjectTopicsController::class,'viewTopics'])->name('view.topics');
                #delete subject
                Route::get('/delete-topics/{id}', [SubjectTopicsController::class,'deleteTopics'])->name('delete.topics');
                Route::get('/change-status-topic/{id}', [SubjectTopicsController::class,'changeStatusTopics'])->name('change.status.topics');
                /********************topics******************************/ 
                
                Route::any('/ajax-delete-topics', [SubjectTopicsController::class,'ajaxDeleteTopics'])->name('ajax.delete.topics');
                Route::any('/ajax-change-status-topics', [SubjectTopicsController::class,'ajaxChangeStatusTopics'])->name('ajax.change.status.topics');
               Route::get('/get-subjects/{branch_id}/{grade_id}', [SubjectController::class, 'getSubjects'])->name('branch.get.subject');

                Route::post('/check-topic-code', [SubjectTopicsDetailsController::class, 'checkTopicCode'])
    ->name('check.topic.code');
                Route::any('/topics-management-list-tab', [SubjectTopicsController::class,'getTopicsManagementList'])->name('topics.management.list.tab');
    /*********************topics********************************************/
                 #topics Details management
                Route::get('/manage-topics-details', [SubjectTopicsDetailsController::class,'index'])->name('manage.topics.details');
                Route::post('/manage-topics-details', [SubjectTopicsDetailsController::class,'topicsDetailsManagement'])->name('topics.management.details');
                #edit subject
                Route::any('/add-topics-details', [SubjectTopicsDetailsController::class,'addTopicsDetails'])->name('add.topics.details');
                Route::any('/edit-topics-details/{id}', [SubjectTopicsDetailsController::class,'editTopicsDetails'])->name('edit.topic.details');
                #view subject
                Route::get('/view-topics-details/{id}', [SubjectTopicsDetailsController::class,'viewTopicsDetails'])->name('view.topics.details');
                #delete subject
                Route::get('/delete-topics-details/{id}', [SubjectTopicsDetailsController::class,'deleteTopicsDetails'])->name('delete.topics.details');
                Route::get('/change-status-topic-details/{id}', [SubjectTopicsDetailsController::class,'changeStatusTopicsDetails'])->name('change.status.topics.details');
                /********************topics******************************/ 

                Route::prefix('promotion')->group(function () {

    // LIST ALL PROMOTIONS
    Route::get('/', [PromotionController::class,'index'])->name('promotion.index');

    // CREATE PROMOTION FORM
    Route::get('/create', [PromotionController::class,'create'])->name('promotion.create');

    // STORE PROMOTION
    Route::post('/store', [PromotionController::class,'store'])->name('promotion.store');

    // EDIT PROMOTION FORM
    Route::get('/edit/{id}', [PromotionController::class,'edit'])->name('promotion.edit');

    // UPDATE PROMOTION
    Route::post('/update/{id}', [PromotionController::class,'update'])->name('promotion.update');

    // ACTIVATE / DEACTIVATE PROMOTION
    Route::get('/status/{id}', [PromotionController::class,'changeStatus'])->name('promotion.status');

});

                Route::any('/ajax-delete-topics-details', [SubjectTopicsDetailsController::class,'ajaxDeleteTopicsDetails'])->name('ajax.delete.topics.details');
                Route::any('/ajax-change-status-topics-details', [SubjectTopicsDetailsController::class,'ajaxChangeStatusTopicsDetails'])->name('ajax.change.status.topics.details');
               Route::get('/get-topics/{grade_id}/{subject_id}', [TopicController::class, 'getTopics'])->name('subject.get.topics');
Route::get('/admin/topics-export', [SubjectTopicsController::class, 'exportTopics'])
    ->name('topics.export');

                Route::any('/topics-management-list-tab-details', [SubjectTopicsDetailsController::class,'getTopicsDetailsManagementList'])->name('topics.management.list.tab.details');
            /***********************BRANCH******************************************/
            Route::any('/ajax-delete-branch', [BranchManagementController::class,'ajaxDeleteBranch'])->name('ajax.delete.branch');
            Route::get('/manage-branches', [BranchManagementController::class,'index'])->name('manage.branches');
            Route::post('/manage-branches', [BranchManagementController::class,'branchManagement'])->name('branch.management');
            Route::any('/add-branch', [BranchManagementController::class,'addBranch'])->name('add.branch');
            Route::any('/edit-branch/{id}', [BranchManagementController::class,'editBranch'])->name('edit.branch');
            #view branch
            Route::get('/view-branch/{id}', [BranchManagementController::class,'viewBranch'])->name('view.branch');
            #delete branch
            Route::get('/delete-branch/{id}', [BranchManagementController::class,'deleteBranch'])->name('delete.branch');
            Route::get('/status-branch/{id}', [BranchManagementController::class,'changeStatusBranch'])->name('change.status.branch');


            Route::any('/branch-management-list-tab', [BranchManagementController::class,'getBranchManagementList'])->name('branch.management.list.tab');
            Route::post('/ajax-duplicate-branch-check', [BranchManagementController::class,'ajaxDuplicateBranchCheck'])->name('ajax.branch.duplicate.check');
            Route::post('/ajax-duplicate-capture-branch-check', [BranchManagementController::class,'ajaxDuplicateCaptureCodeCheck'])->name('ajax.branch.capture.duplicate.check');
           
            /***********************Programme Management******************************************/
            Route::get('/manage-Programmes', [ProgrammeManagementController::class,'index'])->name('manage.programmes');
            Route::get('/view-Programme/{id}', [ProgrammeManagementController::class,'viewProgramme'])->name('view.programme');
            Route::get('/delete-Programme/{id}', [ProgrammeManagementController::class,'deleteProgramme'])->name('delete.programme');
            Route::post('/programme-management/list', [ProgrammeManagementController::class, 'list'])->name('programme.management');
            Route::get('/programme-management-download', [ProgrammeManagementController::class,'getProgrammeList'])->name('programme.management.download');

            /*********************** Learning Program Assessment *******************************/
            Route::get('/manage-learning-assessments',[LearningProgramAssessmentController::class, 'index'])->name('manage.learning.assessments');
            Route::get('/view-learning-assessment/{id}',[LearningProgramAssessmentController::class, 'view'])->name('view.learning.assessment');
            Route::get('/delete-learning-assessment/{id}',[LearningProgramAssessmentController::class, 'delete'])->name('delete.learning.assessment');
            Route::post('/learning-assessment/list',[LearningProgramAssessmentController::class, 'list'])->name('learning.assessment.list');
            Route::get('/learning-assessment-download',[LearningProgramAssessmentController::class, 'download'])->name('learning.assessment.download');
            Route::get('/action-learning-program/{id}',[LearningProgramAssessmentController::class, 'action'])->name('action.learning.assessment');
            Route::post('/action-learning-program/send-email',[LearningProgramAssessmentController::class, 'sendEmail'])->name('action.learning.assessment.send');
            Route::get('learning-assessment/{id}/download-result',[LearningProgramAssessmentController::class, 'downloadAssessmentResult'])->name('learning.assessment.download.result');
            Route::post('/learning-assessment/save-suggestion', [LearningProgramAssessmentController::class, 'saveSuggestion'])->name('learning.assessment.save.suggestion');
            Route::post('/learning-assessments/send-report', [LearningProgramAssessmentController::class, 'sendReport'])->name('learning.assessment.send.report');
            Route::get('/action-learning-program/view-report/{id}', [LearningProgramAssessmentController::class, 'viewReport'])->name('learning.assessment.view.report');

            /*********************** Learning Program Assessment Questions Management ************************/
            // Page
            Route::get('/manage-learning-assessment-questions',[LearningProgramAssessmentQuestionController::class, 'index'])->name('learning.assessment.questions.list');
            // DataTables AJAX
            Route::post('/manage-learning-assessment-questions/data',   [LearningProgramAssessmentQuestionController::class, 'list'])->name('learning.assessment.questions.list.ajax');
            // CRUD
            Route::get('/manage-learning-assessment-questions/add',[LearningProgramAssessmentQuestionController::class, 'create'])->name('learning.assessment.questions.add.page');
            Route::post('/manage-learning-assessment-questions/added',[LearningProgramAssessmentQuestionController::class, 'store'])->name('learning.assessment.questions.added');
            Route::get('/manage-learning-assessment-questions/view/{id}',[LearningProgramAssessmentQuestionController::class, 'show'])->name('learning.assessment.questions.view');
            Route::post('/manage-learning-assessment-questions/update',[LearningProgramAssessmentQuestionController::class, 'update'])->name('learning.assessment.questions.update');
            // Status toggle
            Route::get('/manage-learning-assessment-questions/active/{id}', [LearningProgramAssessmentQuestionController::class, 'active'])->name('learning.assessment.questions.active');
            Route::get('/manage-learning-assessment-questions/inactive/{id}',   [LearningProgramAssessmentQuestionController::class, 'inactive'])->name('learning.assessment.questions.inactive');
            // Delete
            Route::get('/manage-learning-assessment-questions/del/{id}', [LearningProgramAssessmentQuestionController::class, 'destroy'])->name('learning.assessment.questions.delete');

            /***********************  Assessment Forms Management ************************/
            /* PAGE */
            Route::get('/manage-learning-assessment-forms',[LearningProgramAssessmentFormController::class, 'index'])->name('learning.assessment.forms.list');
            /*  DATATABLES AJAX */
            Route::post('/manage-learning-assessment-forms/data',[LearningProgramAssessmentFormController::class, 'list'])->name('learning.assessment.forms.list.ajax');
            /* CREATE    */
            Route::get('/manage-learning-assessment-forms/add',[LearningProgramAssessmentFormController::class, 'create'])->name('learning.assessment.forms.add.page');
            Route::post('/manage-learning-assessment-forms/added', [LearningProgramAssessmentFormController::class, 'store'])->name('learning.assessment.forms.added');
            /* VIEW / EDIT  */
            Route::get('/manage-learning-assessment-forms/view/{id}',[LearningProgramAssessmentFormController::class, 'show'])->name('learning.assessment.forms.view');
            Route::post('/manage-learning-assessment-forms/update',[LearningProgramAssessmentFormController::class, 'update'])->name('learning.assessment.forms.update');
            /* STATUS TOGGLE*/
            Route::get('/manage-learning-assessment-forms/active/{id}',[LearningProgramAssessmentFormController::class, 'active'])->name('learning.assessment.forms.active');
            Route::get('/manage-learning-assessment-forms/inactive/{id}',[LearningProgramAssessmentFormController::class, 'inactive'])->name('learning.assessment.forms.inactive');
            /*DELETE*/
            Route::get('/manage-learning-assessment-forms/del/{id}',    [LearningProgramAssessmentFormController::class, 'destroy'])->name('learning.assessment.forms.delete');

            /*******************GRADE*******************************/ 

            #grade management
            Route::get('/grades-management', [GradeManagementController::class,'index'])->name('manage.grades');
            Route::post('/manage-grades', [GradeManagementController::class,'gradeManagement'])->name('grade.management');
            Route::post('/datatable-tutorship-management/{id}', [TutorManagementController::class,'tutorshipManagement'])->name('datatable.tutorship.management');
            #edit subject
            Route::any('/add-grade', [GradeManagementController::class,'addGrade'])->name('add.grade');
            Route::any('/edit-grade/{id}', [GradeManagementController::class,'editGrade'])->name('edit.grade');
            #view subject
            Route::get('/view-grade/{id}', [GradeManagementController::class,'viewGrade'])->name('view.grade');
            #delete subject
            Route::get('/delete-grade/{id}', [GradeManagementController::class,'deleteGrade'])->name('delete.grade');
            Route::any('/ajax-delete-grade', [GradeManagementController::class,'ajaxdeleteGrade'])->name('ajax.delete.grade');
            Route::any('/grade-management-list-tab', [GradeManagementController::class,'getGradeManagementList'])->name('grade.management.list.tab');

        /***************************School Import ********************************** */
   

       Route::get('/import-excel', [ExcelImportController::class, 'showImportForm'])->name('import.form');
       Route::post('/import-excel', [ExcelImportController::class, 'import'])->name('import.process');

        /***************************Suburbs Import ********************************** */
   

       Route::get('/import-suburbs', [SuburbsImportController::class, 'showImportSuburbs'])->name('import.formsuburbs');
       Route::post('/import-suburbs', [SuburbsImportController::class, 'importSuburbs'])->name('import.suburbs');
            /********************STUDENT******************************/
            Route::any('/ajax-delete-user', [StudentManagementController::class,'ajaxDeleteUser'])->name('ajax.delete.user');
            Route::any('/ajax-close-user', [StudentManagementController::class,'ajaxCloseUser'])->name('ajax.close.user');
            Route::any('/update-student-avatar', [StudentManagementController::class,'updateStudentAvatar'])->name('update.student.avatar');
            Route::any('/update-tutor-avatar', [TutorManagementController::class,'updateTutorAvatar'])->name('update.tutor.avatar');
            Route::any('/ajax-status-change-user-new', [StudentManagementController::class,'ajaxStatusChangeUserNew'])->name('ajax.status.change.user.new');
            Route::any('/ajax-status-change-user', [StudentManagementController::class,'ajaxStatusChangeUser'])->name('ajax.status.change.user');
            Route::any('/inactive-ajax-status-change-user', [StudentManagementController::class,'ajaxStatusChangeUserInactive'])->name('ajax.status.change.user.inactive');
            Route::any('/approved-ajax-status-change-user', [StudentManagementController::class,'ajaxStatusChangeUserApproved'])->name('ajax.status.change.user.approved');
            Route::any('/rejected-ajax-status-change-user', [StudentManagementController::class,'ajaxStatusChangeUserRejected'])->name('ajax.status.change.user.rejected');
            Route::any('/suspended-ajax-status-change-user', [StudentManagementController::class,'ajaxStatusChangeUserSuspended'])->name('ajax.status.change.user.suspended');
            Route::any('/ajax-resend-verification-link', [StudentManagementController::class,'resendVerificationLink'])->name('ajax.resend.verification.link');


            Route::any('/student-management-list-tab', [StudentManagementController::class,'getStudentManagementList'])->name('student.management.list.tab');

            #student management
            Route::get('/student-management', [StudentManagementController::class,'index'])->name('manage.students');
            #edit student information
            Route::any('/edit-student-personal-info/{id}', [StudentManagementController::class,'editStudentPersonalInfo'])->name('edit.student.personal.info.step.1');

            #datatable student management
            Route::any('/data-student-management', [StudentManagementController::class,'studentManagement'])->name('list.manage.students');
            #view student
            Route::get('/view-student/{id}', [StudentManagementController::class,'viewStudent'])->name('view.student');
            #change status of student
            Route::get('/change-status-student/{id}', [StudentManagementController::class,'changeStatus'])->name('change.status.user');
            #delete student information
            Route::get('/delete-student/{id}', [StudentManagementController::class,'deleteStudent'])->name('delete.user');

            /**************Review List*****************/
            Route::get('/review-list', [ReviewManagementController::class,'index'])->name('review.list');
            Route::post('/ajax-datatable-review-list', [ReviewManagementController::class,'getAjaxReviewManagement'])->name('review.list.datatable');
            /**************Payments Management List*****************/
            Route::get('/tutor-payment-list', [TutorPaymentListController::class,'index'])->name('tutor.payment.list');
            Route::post('/ajax-datatable-tutor-payment-list', [TutorPaymentListController::class,'tutorManagement'])->name('tutor.payment.list.datatable');
            
            /**************Payouts Management List*****************/
          
            Route::get('/payouts', [AdminPayoutController::class, 'index'])->name('admin.payouts');
            Route::post('/payouts/disburse', [AdminPayoutController::class, 'disburse'])->name('admin.payouts.disburse');
            Route::get('/payouts/details', [AdminPayoutController::class, 'detailsPage'])->name('admin.payouts.detailsPage');
            /**************Student Payments List*****************/
            Route::get('/student-payment-list', [StudentPaymentListController::class,'index'])->name('student.payment.list');
            Route::post('/ajax-datatable-student-payment-list', [StudentPaymentListController::class,'studentManagement'])->name('student.payment.list.datatable');
            /**************TUTOR*****************/


            Route::get('/tutor-management', [TutorManagementController::class,'index'])->name('manage.tutors');

            Route::any('/tutor-management-list-tab', [TutorManagementController::class,'getTutorManagementList'])->name('tutor.management.list.tab');
            #datatable tutor management
            Route::any('/admin-tutor-management', [TutorManagementController::class,'tutorManagement'])->name('list.tutors');
            Route::any('/admin-tutor-management-tutor-payment', [TutorManagementController::class,'getDuetutorManagement'])->name('list.tutors.tutor.payment');

            Route::any('/edit-tutor-personal-info/{id}', [TutorManagementController::class,'editTutorPersonalInfo'])->name('edit.tutor.personal.info.step.1');

            Route::any('/edit-tutor-advance-page/{id}', [TutorManagementController::class,'editTutorAdvancePage'])->name('edit.tutor.advance.page');
            Route::any('/view-tutor-personal-info/{id}', [TutorManagementController::class,'viewTutorPersonalInfo'])->name('view.tutor.personal.info.step.1');

            Route::any('/view-tutor-advance-page/{id}', [TutorManagementController::class,'viewTutorAdvancePage'])->name('view.tutor.advance.page');
            Route::get('/view-tutorship-plans/{id}', [TutorManagementController::class,'viewTutorshipPlans'])->name('view.tutor.tutorship.plans');
             Route::post('/update-featured-status', [TutorManagementController::class,'updateFeaturedStatus'])->name('update.featured.status');
             Route::post('/admin/update-free-trail-status', [TutorManagementController::class, 'updateFreeTrailStatus'])->name('update.free.trail.status');

            Route::get('/view-tutor-academic/{id}', [TutorManagementController::class,'viewTutorAcademic'])->name('view.tutor.academics');
            Route::get('/view-tutor-experience/{id}', [TutorManagementController::class,'viewTutorExperience'])->name('view.tutor.experience');
            Route::get('/view-tutor-recognitions/{id}', [TutorManagementController::class,'viewTutorRecognitions'])->name('view.tutor.recognitions');
            Route::get('/view-tutor-right-to-work/{id}', [TutorManagementController::class,'viewTutorRighttoWork'])->name('view.tutor.right.to.work');

            Route::any('/check-password/{id}', [TutorManagementController::class,'editTutorPersonalInfo'])->name('check.password');
            // Route::any('/edit-student-personal-info/{id}', [StudentManagementController::class,'editStudentPersonalInfo')->name('edit.student.personal.info.step.1');
            Route::get('/edit-tutor-tutorship-plans/{id}', [TutorManagementController::class,'editTutorShipPlans'])->name('edit.tutor.tutorship.plans');
            Route::any('/update-tutorship-plan/{tutorshipplanid}', [TutorManagementController::class,'updateTutorShipPlans'])->name('update.tutorship.plans');
            Route::any('/edit-tutor-add-plan/{id}', [TutorManagementController::class,'editTutorAddPlan'])->name('edit.tutor.add.plan');
            Route::get('/delete-tutor-add-plan/{id}', [TutorManagementController::class,'deleteTutorshipPlan'])->name('delete.tutor.plan');
            Route::get('/delete-tutor-exp/{id}', [TutorManagementController::class,'deleteTutorExp'])->name('delete.tutor.exp');
            Route::get('/delete-tutor-rec/{id}', [TutorManagementController::class,'deleteTutorRec'])->name('delete.tutor.rec');
            Route::get('/delete-tutor-academic/{id}', [TutorManagementController::class,'deleteTutorAcademic'])->name('delete.tutor.academic');
            Route::get('/edit-tutor-academics/{id}', [TutorManagementController::class,'editTutorAcademics'])->name('edit.tutor.academics');
            Route::any('/update-tutor-academics/{id}', [TutorManagementController::class,'updateTutorAcademic'])->name('update.tutor.academics');
            Route::any('/add-tutor-academics/{id}', [TutorManagementController::class,'addTutorAcademics'])->name('add.tutor.academics');
            Route::any('/Add-Tutor-Experience/{id}', [TutorManagementController::class,'addTutorExp'])->name('add.tutor.exp');
            Route::any('/add-tutor-rec/{id}', [TutorManagementController::class,'addTutorRec'])->name('add.tutor.rec');
            Route::get('/tutorprofile-experience/{id}', [TutorManagementController::class,'editTutorExp'])->name('edit.tutor.experience');

            Route::any('/update-tutor-experience/{id}', [TutorManagementController::class,'updateTutorExp'])->name('update.tutor.experience');
            Route::get('/tutorprofile-recognitions/{id}', [TutorManagementController::class,'editTutorRec'])->name('edit.tutor.rec');
            Route::any('/update-My-Recognitions/{id}', [TutorManagementController::class,'updateTutorRec'])->name('update.tutor.rec');

            Route::get('/tutorprofile-tutorship-plans/{id}', [TutorManagementController::class,'manageTutorShipPlans'])->name('manage.tutorship.plans');

            #datatable manage datatable tutorship plans
            Route::any('/datatable-tutorship-plans/{id}', [TutorShipPlanController::class,'tutorShipManagement'])->name('manage.tutorship.plans.data');
            #delete tutorship plan
            Route::any('/ajax-delete-tutorship-plan', [TutorShipPlanController::class,'ajaxDeleteTutorShipPlan'])->name('ajax.delete.tutorship.plan');
            Route::any('/ajax-grade-subject', [TutorShipPlanController::class,'ajaxGetGradeSubjects'])->name('ajax.grade.subject');
            Route::any('/ajax-delete-academic', [TutorShipPlanController::class,'ajaxDeleteAcademic'])->name('ajax.delete.academic');
            Route::any('/ajax-delete-experience', [TutorShipPlanController::class,'ajaxDeleteExperience'])->name('ajax.delete.experience');
            Route::any('/ajax-delete-experience', [TutorShipPlanController::class,'ajaxDeleteExperience'])->name('ajax.delete.experience');
            Route::any('/ajax-delete-recognision', [TutorShipPlanController::class,'ajaxDeleteRecognision'])->name('ajax.delete.recognision');

            #datatable manage datatable academic plans
            Route::any('/datatable-academic-plans/{id}', [TutorShipPlanController::class,'academicManagement'])->name('manage.academic.data');
            #datatable manage datatable experience plans
            Route::any('/datatable-exp-plans/{id}', [TutorShipPlanController::class,'expManagement'])->name('manage.exp.data');
            #datatable manage datatable recognisition plans
            Route::any('/datatable-rec-plans/{id}', [TutorShipPlanController::class,'recManagement'])->name('manage.rec.data');

            Route::any('/tutor-experience/{id}', [TutorManagementController::class,'manageTutorExperience'])->name('manage.tutor.experience');
            Route::any('/tutor-recognization/{id}', [TutorManagementController::class,'manageTutorRecognization'])->name('manage.tutor.recognization');

            Route::any('/tutor-academic/{id}', [TutorManagementController::class,'manageTutorAcademic'])->name('manage.tutor.academic');
            // Route::get('/view-tutor/{id}', [TutorManagementController::class,'viewTutor')->name('view.tutor');
            Route::get('/view-tutor/{id}', [TutorManagementController::class,'viewTutor'])->name('view.tutor');
            Route::get('/change-status-tutor/{id}', [TutorManagementController::class,'changeStatus'])->name('change.status.tutor');
            Route::get('/delete-tutor/{id}', [TutorManagementController::class,'deleteTutor'])->name('delete.tutor');

            /******************************AVAILABILITY*******************************/

            Route::any('/add-tutor-availability/{id}/{key}', [TutorAvailabilityController::class,'addTutorAvailability'])->name('add.tutor.availability');

            Route::any('/delete-tutor-availability/{id}', [TutorAvailabilityController::class,'deleteTutorAvailability'])->name('delete.tutor.availability');
            Route::get('/edit-tutor-availability/{id}', [TutorAvailabilityController::class,'editTutorAvailability'])->name('edit.tutor.availablity');
            // Route::get('/t-t-availability/{id}', [TutorAvailabilityController::class,'testingPurpose')->name('edit.tutor.availablity');
            /**************/
            Route::post('/ajax-duplicate-grade-check', [GradeManagementController::class,'ajaxDuplicateGradeCheck'])->name('ajax.grade.duplicate.check');
            Route::post('/ajax-duplicate-capture-code-grade-check', [GradeManagementController::class,'ajaxDuplicateCaptureCodeCheck'])->name('ajax.capture.code.grade.duplicate.check');

            Route::post('/ajax-duplicate-subject-check', [SubjectManagementController::class,'ajaxDuplicateSubjectCheck'])->name('ajax.subject.duplicate.check');
            Route::post('/ajax-duplicate-capture-subject-check', [SubjectManagementController::class,'ajaxDuplicateCaptureCodeCheck'])->name('ajax.subject.capture.duplicate.check');

            Route::post('/ajax-duplicate-tutor-email-check', [TutorManagementController::class,'ajaxTutorDuplicateEmailCheck'])->name('ajax.tutor.duplicate.email.check');
            Route::post('/ajax-duplicate-tutor-phone-check', [TutorManagementController::class,'ajaxTutorDuplicatePhoneCheck'])->name('ajax.tutor.duplicate.phone.check');

            Route::post('/ajax-duplicate-student-email-check', [TutorManagementController::class,'ajaxStudentDuplicateEmailCheck'])->name('ajax.student.duplicate.email.check');
            Route::post('/ajax-duplicate-student-phone-check', [StudentManagementController::class,'ajaxStudentDuplicatePhoneCheck'])->name('ajax.student.duplicate.phone.check');


            // booking mail
            Route::get('/booking-management', [BookingsManagementController::class,'index'])->name('booking.management');

            // Route::get('/manage-bookings', [BookingsManagementController::class,'index')->name('admin.booking.management');

            Route::get('/view-booking-details/{bookingNo}', [BookingsManagementController::class,'viewDetails'])->name('view.booking.details');

            Route::post('/booking-management-datatable.ajax', [BookingsManagementController::class,'bookingManagement'])->name('booking.management.datatable.ajax');

            Route::any('/booking-management-list-tab', [BookingsManagementController::class,'getBookingManagementList'])->name('booking.management.list.tab');

            Route::any('/cancel-booking', [BookingsManagementController::class,'cancelBooking'])->name('ajax.cancel.booking');

            Route::any('/update-cancel-booking-by-admin', [BookingsManagementController::class,'bookingCancel'])->name('booking.cancel.by.admin');

            /****************Admin Commission Management *************************/
            // admin disable booking
            Route::get('/admin-commission-management', [AdminCommissionController::class,'adminUpdateCommission'])->name('admin.set.commission');
            Route::post('/admin-commission-management', [AdminCommissionController::class,'adminUpdateCommission'])->name('admin.set.commission');

            /****************Enable Disable booking *******************************************************/
            // admin disable booking
            Route::get('/disable-booking-settings', [AdminDisableBookingsSettingsController::class,'adminDisableBookingsSettings'])->name('admin.disable.bookings');
            Route::post('/disable-booking-settings', [AdminDisableBookingsSettingsController::class,'adminDisableBookingsSettings'])->name('admin.disable.bookings');
            /********************Manage Disable booking dates list add edit status change******/
            // AdminDisableBookingDatesController
            # list
            Route::get('/manage-admin-disable-dates', [AdminDisableBookingDatesController::class,'index'])->name('manage.admin.disable.dates');
            Route::post('/manage-admin-disable-dates-datatable', [AdminDisableBookingDatesController::class,'adminDisableDatesManagement'])->name('manage.admin.disable.dates.datatable');
            #add
            Route::any('/add-disable-date', [AdminDisableBookingDatesController::class,'addAdminDisableBookingDates'])->name('add.disable.date');
            #edit
            Route::any('/edit-disable-date/{id}', [AdminDisableBookingDatesController::class,'ediAdminDisableBookingDates'])->name('edit.disable.date');

            #delete
            Route::any('/delete-ajax-disable-booking-dates', [AdminDisableBookingDatesController::class,'ajaxDeleteDisableBookingDates'])->name('ajax.delete.disable.dates');
            Route::any('/duplicate-ajax-blocked-date-check', [AdminDisableBookingDatesController::class,'ajaxDuplicateDateCheck'])->name('ajax.duplicate.ajax.blocked.date.check');

            /************************************************************************/

            //review
            Route::get('/manage-reviews', [AdminReviewController::class,'review_list'])->name('manage.admin.review.list');
            Route::post('/manage-reviews', [AdminReviewController::class,'review_list'])->name('manage.admin.review.list');
            Route::post('/manage-reviews/del', [AdminReviewController::class,'review_del'])->name('review.dlt');
            Route::get('/manage-reviews/all', [AdminReviewController::class,'review_list_all'])->name('get.all.review');

            /******************************Class End Assesment******************************************/

            Route::get('/view-class-end-assesment/{id}', [AdminClassEndAsseesmentController::class,'viewDetailsClassEndAssesment'])->name('view.admin.class.end.assesment');
            Route::get('/manage-class-end-assesment', [AdminClassEndAsseesmentController::class,'manageClassEndAssesment'])->name('manage.admin.class.end.assesment');
            Route::post('/class-end-assesment-management', [AdminClassEndAsseesmentController::class,'classEndAssesmentManagement'])->name('admin.class.end.assesment.management');
            Route::get('/a-class-end-assesment-management', [AdminClassEndAsseesmentController::class,'classEndAssesmentDtls'])->name('admin.class.end.assesment.management.a');



            //tutor due payments..
            Route::get('/manage-due-payments', [PaymentController::class,'due_payments'])->name('due.payments');
            Route::post('/manage-due-payments', [PaymentController::class,'due_payments'])->name('due.payments');
            Route::post('/manage-due-payments/payment', [PaymentController::class,'tutor_payment'])->name('tutor.payment');
            Route::get('/manage-due-payments/all', [PaymentController::class,'due_payments_all'])->name('get.all.payment');

            Route::post('/manage-due-payments/inc', [PaymentController::class,'tutor_incentive'])->name('tutor.incentive');

            //tutor payment history
            Route::get('/payment-history/{id}', [PaymentController::class,'payment_his'])->name('payments.history');
            Route::post('/payment-history/{id}', [PaymentController::class,'payment_his_search'])->name('payments.history.search');
            Route::get('/payment-history-all/{id}', [PaymentController::class,'payment_his_search_ajax'])->name('get.all.history');



            //student payment
            Route::any('/student-payments', [PaymentController::class,'student_pay_list'])->name('student.pay.list');
            Route::get('/student-payments/all', [PaymentController::class,'student_pay_list_ajax'])->name('get.all.student.payment');

            //faq managment
            Route::any('/manage-faq', [FaqController::class,'faq_list'])->name('faq.list');
            Route::get('/manage-faq/add', [FaqController::class,'faq_add_page'])->name('add.faq.page');
            Route::post('/manage-faq/added', [FaqController::class,'faq_ins'])->name('faq.added');

            Route::get('/manage-faq/del/{id}', [FaqController::class,'faq_del'])->name('del.faq');
            Route::get('/manage-faq/active/{id}', [FaqController::class,'faq_active'])->name('active.faq');
            Route::get('/manage-faq/inactive/{id}', [FaqController::class,'faq_inactive'])->name('inactive.faq');
            Route::get('/manage-faq/view/{id}', [FaqController::class,'faq_view'])->name('view.faq');
            Route::get('/manage-faq/edit/{id}', [FaqController::class,'faq_edit_page'])->name('edit.faq');
            Route::post('/manage-faq/update', [FaqController::class,'faq_update'])->name('update.faq');
            Route::get('/manage-faq/all', [FaqController::class,'faq_get_all_ajax'])->name('get.all.faq');
            
            /* Blog Management */

            // Page
            Route::get('/manage-blog', [BlogController::class, 'index'])->name('blog.list');
            // DataTables AJAX
            Route::post('/manage-blog/data', [BlogController::class, 'blog_list'])->name('blog.list.ajax');
            // CRUD
            Route::get('/manage-blog/add', [BlogController::class, 'blog_add_page'])->name('add.blog.page');
            Route::post('/manage-blog/added', [BlogController::class, 'blog_ins'])->name('blog.added');

            Route::get('/manage-blog/view/{id}', [BlogController::class, 'blog_view'])->name('view.blog');
            Route::post('/manage-blog/update', [BlogController::class, 'blog_update'])->name('update.blog');

            Route::get('/manage-blog/del/{id}', [BlogController::class, 'blog_del'])->name('del.blog');
            Route::get('/manage-blog/active/{id}', [BlogController::class, 'blog_active'])->name('active.blog');
            Route::get('/manage-blog/inactive/{id}', [BlogController::class, 'blog_inactive'])->name('inactive.blog');

            /* Academic Program Management */
            // Page
            Route::get('/manage-academic-program', [AcademicProgramController::class, 'index'])->name('academic.program.list');
            // DataTables AJAX
            Route::post('/manage-academic-program/data', [AcademicProgramController::class, 'academic_program_list'])->name('academic.program.list.ajax');
            // CRUD
            Route::get('/manage-academic-program/add', [AcademicProgramController::class, 'academic_program_add_page'])->name('add.academic.program.page');
            Route::post('/manage-academic-program/added', [AcademicProgramController::class, 'academic_program_ins'])->name('academic.program.added');
            Route::get('/manage-academic-program/view/{id}', [AcademicProgramController::class, 'academic_program_view'])->name('view.academic.program');
            Route::post('/manage-academic-program/update', [AcademicProgramController::class, 'academic_program_update'])->name('update.academic.program');
            Route::get('/manage-academic-program/del/{id}', [AcademicProgramController::class, 'academic_program_del'])->name('del.academic.program');
            Route::get('/manage-academic-program/active/{id}', [AcademicProgramController::class, 'academic_program_active'])->name('active.academic.program');
            Route::get('/manage-academic-program/inactive/{id}', [AcademicProgramController::class, 'academic_program_inactive'])->name('inactive.academic.program');

            /* Academic Program Assignment Management */
            // List Page
            Route::get('/manage-academic-assignment', [AcademicProgramAssignmentController::class, 'index'])->name('academic.assignment.list');
            // DataTables AJAX
            Route::post('/manage-academic-assignment/data', [AcademicProgramAssignmentController::class, 'assignment_list'])->name('academic.assignment.list.ajax');
            // View Assignment / Details Page
            Route::get('/manage-academic-assignment/view/{id}', [AcademicProgramAssignmentController::class, 'assignment_view'])->name('view.academic.assignment');
            Route::get('/academic-program/session/{id}/history', [AcademicProgramAssignmentController::class, 'sessionHistory'])->name('academic.session.history');
            // Assign Tutor (POST AJAX)
            Route::post('/academic-program/assignment/store', [AcademicProgramAssignmentController::class, 'assignTutorStore'])->name('academic.assignment.store');
            // Manual Assignment
            Route::get('/academic-program/manual-assignment', [AcademicProgramAssignmentController::class, 'manualAssignmentCreate'])->name('academic.assignment.manual.create');
            Route::post('/academic-program/manual-assignment/store',[AcademicProgramAssignmentController::class, 'manualAssignmentStore'])->name('academic.assignment.manual.store');
            
            //help section management
            Route::any('/manage-help-section', [HelpController::class,'help_list'])->name('help.list');
            Route::get('/manage-help-section/del/{id}', [HelpController::class,'help_del'])->name('del.help');
            Route::get('/manage-help-section/active/{id}', [HelpController::class,'help_active'])->name('active.help');
            Route::get('/manage-help-section/inactive/{id}', [HelpController::class,'help_inactive'])->name('inactive.help');

            Route::get('/manage-help-section/add', [HelpController::class,'help_add_page'])->name('add.help.page');
            Route::post('/manage-help-section/added', [HelpController::class,'help_ins'])->name('help.added');

            Route::get('/manage-help-section/view/{id}', [HelpController::class,'help_view'])->name('view.help');
            Route::get('/manage-help-section/edit/{id}', [HelpController::class,'help_edit_page'])->name('edit.help');
            Route::post('/manage-help-section/update', [HelpController::class,'help_update'])->name('update.help');
            Route::get('/manage-help-section/all', [HelpController::class,'help_get_all_ajax'])->name('get.all.help');


            //testimonial section
            Route::any('/manage-testimonials', [TestimonialController::class,'test_list'])->name('test.list');
            Route::get('/manage-testimonials/add', [TestimonialController::class,'test_add_page'])->name('add.test.page');
            Route::post('/manage-testimonials/added', [TestimonialController::class,'test_ins'])->name('test.added');

            Route::get('/manage-testimonials/del/{id}', [TestimonialController::class,'test_del'])->name('del.test');

            Route::get('/manage-testimonials/active/{id}', [TestimonialController::class,'test_active'])->name('active.test');

            Route::get('/manage-testimonials/inactive/{id}', [TestimonialController::class,'test_inactive'])->name('inactive.test');

            Route::get('/manage-testimonials/view/{id}', [TestimonialController::class,'test_view'])->name('view.test');

            Route::get('/manage-testimonials/edit/{id}', [TestimonialController::class,'test_edit_page'])->name('edit.test');

            Route::post('/manage-testimonials/update', [TestimonialController::class,'test_update'])->name('update.test');
            Route::get('/manage-testimonials/all', [TestimonialController::class,'test_get_all_ajax'])->name('get.all.test');

            /*****************privacy policy and terms and conditions********************/

            Route::get('/privacy-policy', [PrivacyPolicyController::class,'privacyPolicy'])->name('privacy.policy');
            Route::post('/update-privacy-policy', [PrivacyPolicyController::class,'privacyPolicy'])->name('update.privacy.policy');
            Route::get('/terms-and-conditions', [TermsConditionsController::class,'termsConditions'])->name('terms.conditions');
            Route::post('/update-terms-and-conditions', [TermsConditionsController::class,'termsConditions'])->name('update.terms.conditions');
            /*****************************BANNERS*****************************************/
            Route::any('/add-banner', [BannersController::class,'addBanner'])->name('admin.add.banner');
            Route::any('/edit-banner/{id}', [BannersController::class,'editBanner'])->name('admin.edit.banner');
            Route::any('/list-banner', [BannersController::class,'manageBanner'])->name('admin.list.banner');
            Route::any('/delete-banner/{id}', [BannersController::class,'deleteBanner'])->name('admin.delete.banner');
            /***************admin update Follow us details****************/
            Route::any('/admin-update-follow-us', [FollowUsDetailsController::class,'updateFollowUsDetails'])->name('admin.update.follow.us');

            Route::any('/modify-commission/{id}', [ModifyCommissionController::class,'updateModifyCommission'])->name('admin.modify.commission');

            /*************** admin tutor application form route start ****************/
                Route::get('/tutor-application-form-list', [TutorApplicationFormController::class,'list'])->name('admin_tutor_application_form_list');
                Route::any('/tutor-application-form-get-list', [TutorApplicationFormController::class,'getList'])->name('admin_tutor_application_form_get_list');
                Route::get('/tutor-application-form-list-export', [TutorApplicationFormController::class, 'exportTutorApplicationList'])
    ->name('admin_tutor_application_form_list_export');
                Route::any('/tutor-application-form-view/{id}', [TutorApplicationFormController::class,'view'])->name('admin_tutor_application_form_view');
                Route::any('/tutor-application-form/change-wwcc-status/', [TutorApplicationFormController::class,'changeWWCCStatus'])->name('admin_tutor_application_form_change_wwcc_status');
                Route::any('/tutor-application-form/change-accept-status/{id}', [TutorApplicationFormController::class,'changeAcceptStatus'])->name('admin_tutor_application_form_change_accept_status');
                Route::any('/tutor-application-form/change-reject-status/', [TutorApplicationFormController::class,'changeRejectStatus'])->name('admin_tutor_application_form_change_reject_status');
                Route::any('/tutor-application-form/validate-wwcc/', [TutorApplicationFormController::class,'validateWWCC'])->name('admin_tutor_application_form_validate_wwcc');
                Route::any('/tutor-application-form/re-open/', [TutorApplicationFormController::class,'reOpen'])->name('admin_tutor_application_form_re_open');
            /*************** admin tutor application form route end ******************/
            
            /*************** admin wwcc management route start ****************/
                Route::get('/wwcc-management-list', [WWCCManagementController::class,'list'])->name('admin_wwcc_management_list');
                Route::any('/wwcc-management-get-list', [WWCCManagementController::class,'getList'])->name('admin_wwcc_management_get_list');
                Route::any('/wwcc-management-view/{id}', [WWCCManagementController::class,'view'])->name('admin_wwcc_management_view');
                Route::any('/wwcc-management-update', [WWCCManagementController::class,'update'])->name('admin_wwcc_management_update');
                Route::any('/wwcc-management/change-wwcc-status/', [WWCCManagementController::class,'changeWWCCStatus'])->name('admin_wwcc_management_change_wwcc_status');
                Route::any('/wwcc-management/change-accept-status/{id}', [WWCCManagementController::class,'changeAcceptStatus'])->name('admin_wwcc_management_change_accept_status');
                Route::any('/wwcc-management/change-reject-status/', [WWCCManagementController::class,'changeRejectStatus'])->name('admin_wwcc_management_change_reject_status');
                Route::any('/wwcc-management/get-state-wwcc/', [WWCCManagementController::class,'getStateWWCC'])->name('admin_wwcc_management_get_state_wwcc');
            /*************** admin wwcc management route end ******************/
        });
 });




// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
//     Route::post('login', [LoginController::class, 'login']);
//     Route::post('logout', [LoginController::class, 'logout'])->name('logout');

//     // Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//     // Route::post('register', [RegisterController::class, 'register']);

//     // Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
//     // Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
//     // Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
//     // Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
//     // Verify
//     // Route::get('email/resend', 'Auth\VerificationController@resend')->name('admin.verification.resend');
//     // Route::get('email/verify', 'Auth\VerificationController@show')->name('admin.verification.notice');
//     // Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('admin.verification.verify');

//     Route::middleware(['admin.auth:admin'])->group(function () {

//         Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
//         Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

//         // Admin Profile
//         // Route::get('admin-my-profile', [HomeController::class, 'editProfile'])->name('edit.admin.profile');
//         // Route::post('update-admin-profile', [HomeController::class, 'editProfile'])->name('update.admin.profile');
//         // Route::get('change-password', [HomeController::class, 'changePassword'])->name('admin.change.password');
//         // Route::post('change-password', [HomeController::class, 'changePassword'])->name('change.password');
//         // Route::get('confirm-admin-password', [HomeController::class, 'confirmAdminPassword'])->name('confirm.admin.password');
//         // Route::post('ajax-confirm-admin-password', [HomeController::class, 'ajaxconfirmAdminPassword'])->name('ajax.confirm.admin.password');

//         // Route::group(['namespace' => 'Modules'], function () {

//         //     /*******************SUBJECT****************************/

//         //     #subject management
//         //     Route::get('/manage-subjects', [SubjectManagementController::class,'index'])->name('manage.subjects');
//         //     Route::post('/manage-subjects', [SubjectManagementController::class,'subjectManagement'])->name('subject.management');
//         //     #edit subject
//         //     Route::any('/add-subject', [SubjectManagementController::class,'addSubject'])->name('add.subject');
//         //     Route::any('/edit-subject/{id}', [SubjectManagementController::class,'editSubject'])->name('edit.subject');
//         //     #view subject
//         //     Route::get('/view-subject/{id}', [SubjectManagementController::class,'viewSubject'])->name('view.subject');
//         //     #delete subject
//         //     Route::get('/delete-subject/{id}', [SubjectManagementController::class,'deleteSubject'])->name('delete.subject');
//         //     Route::get('/change-status/{id}', [SubjectManagementController::class,'changeStatusSubject'])->name('change.status.subject');
//         //     /********************Subject******************************/

//         //     Route::any('/ajax-delete-subject', [SubjectManagementController::class,'ajaxDeleteSubject'])->name('ajax.delete.subject');
//         //     Route::any('/ajax-change-status-subject', [SubjectManagementController::class,'ajaxChangeStatusSubject'])->name('ajax.change.status.subject');


//         //     Route::any('/subject-management-list-tab', [SubjectManagementController::class,'getSubjectManagementList'])->name('subject.management.list.tab');

//         //     /***********************BRANCH******************************************/
//         //     Route::any('/ajax-delete-branch', [BranchManagementController::class,'ajaxDeleteBranch'])->name('ajax.delete.branch');
//         //     Route::get('/manage-branches', [BranchManagementController::class,'index'])->name('manage.branches');
//         //     Route::post('/manage-branches', [BranchManagementController::class,'branchManagement'])->name('branch.management');
//         //     Route::any('/add-branch', [BranchManagementController::class,'addBranch'])->name('add.branch');
//         //     Route::any('/edit-branch/{id}', [BranchManagementController::class,'editBranch'])->name('edit.branch');
//         //     #view branch
//         //     Route::get('/view-branch/{id}', [BranchManagementController::class,'viewBranch'])->name('view.branch');
//         //     #delete branch
//         //     Route::get('/delete-branch/{id}', [BranchManagementController::class,'deleteBranch'])->name('delete.branch');
//         //     Route::get('/change-status/{id}', [BranchManagementController::class,'changeStatusBranch'])->name('change.status.branch');


//         //     Route::any('/branch-management-list-tab', [BranchManagementController::class,'getBranchManagementList'])->name('branch.management.list.tab');
//         //     Route::post('/ajax-duplicate-branch-check', [BranchManagementController::class,'ajaxDuplicateBranchCheck'])->name('ajax.branch.duplicate.check');
//         //     Route::post('/ajax-duplicate-capture-branch-check', [BranchManagementController::class,'ajaxDuplicateCaptureCodeCheck'])->name('ajax.branch.capture.duplicate.check');
//         //     /*******************GRADE*******************************/

//         //     #grade management
//         //     Route::get('/grades-management', [GradeManagementController::class,'index'])->name('manage.grades');
//         //     Route::post('/manage-grades', [GradeManagementController::class,'gradeManagement'])->name('grade.management');
//         //     Route::post('/datatable-tutorship-management/{id}', [TutorManagementController::class,'tutorshipManagement'])->name('datatable.tutorship.management');
//         //     #edit subject
//         //     Route::any('/add-grade', [GradeManagementController::class,'addGrade'])->name('add.grade');
//         //     Route::any('/edit-grade/{id}', [GradeManagementController::class,'editGrade'])->name('edit.grade');
//         //     #view subject
//         //     Route::get('/view-grade/{id}', [GradeManagementController::class,'viewGrade'])->name('view.grade');
//         //     #delete subject
//         //     Route::get('/delete-grade/{id}', [GradeManagementController::class,'deleteGrade'])->name('delete.grade');
//         //     Route::any('/ajax-delete-grade', [GradeManagementController::class,'ajaxdeleteGrade'])->name('ajax.delete.grade');
//         //     Route::any('/grade-management-list-tab', [GradeManagementController::class,'getGradeManagementList'])->name('grade.management.list.tab');



//         //     /********************STUDENT******************************/
//         //     Route::any('/ajax-delete-user', [StudentManagementController::class,'ajaxDeleteUser'])->name('ajax.delete.user');
//         //     Route::any('/ajax-close-user', [StudentManagementController::class,'ajaxCloseUser'])->name('ajax.close.user');
//         //     Route::any('/update-student-avatar', [StudentManagementController::class,'updateStudentAvatar'])->name('update.student.avatar');
//         //     Route::any('/update-tutor-avatar', [TutorManagementController::class,'updateTutorAvatar'])->name('update.tutor.avatar');
//         //     Route::any('/ajax-status-change-user', [StudentManagementController::class,'ajaxStatusChangeUser'])->name('ajax.status.change.user');
//         //     Route::any('/inactive-ajax-status-change-user', [StudentManagementController::class,'ajaxStatusChangeUserInactive'])->name('ajax.status.change.user.inactive');
//         //     Route::any('/ajax-resend-verification-link', [StudentManagementController::class,'resendVerificationLink'])->name('ajax.resend.verification.link');


//         //     Route::any('/student-management-list-tab', [StudentManagementController::class,'getStudentManagementList'])->name('student.management.list.tab');

//         //     #student management
//         //     Route::get('/student-management', [StudentManagementController::class,'index'])->name('manage.students');
//         //     #edit student information
//         //     Route::any('/edit-student-personal-info/{id}', [StudentManagementController::class,'editStudentPersonalInfo'])->name('edit.student.personal.info.step.1');

//         //     #datatable student management
//         //     Route::any('/data-student-management', [StudentManagementController::class,'studentManagement'])->name('list.manage.students');
//         //     #view student
//         //     Route::get('/view-student/{id}', [StudentManagementController::class,'viewStudent'])->name('view.student');
//         //     #change status of student
//         //     Route::get('/change-status-student/{id}', [StudentManagementController::class,'changeStatus'])->name('change.status.user');
//         //     #delete student information
//         //     Route::get('/delete-student/{id}', [StudentManagementController::class,'deleteStudent'])->name('delete.user');

//         //     /**************Review List*****************/
//         //     Route::get('/review-list', [ReviewManagementController::class,'index'])->name('review.list');
//         //     Route::post('/ajax-datatable-review-list', [ReviewManagementController::class,'getAjaxReviewManagement'])->name('review.list.datatable');
//         //     /**************TUTOR Payments List*****************/
//         //     Route::get('/tutor-payment-list', [TutorPaymentListController::class,'index'])->name('tutor.payment.list');
//         //     Route::post('/ajax-datatable-tutor-payment-list', [TutorPaymentListController::class,'tutorManagement'])->name('tutor.payment.list.datatable');
//         //     /**************Student Payments List*****************/
//         //     Route::get('/student-payment-list', [StudentPaymentListController::class,'index'])->name('student.payment.list');
//         //     Route::post('/ajax-datatable-student-payment-list', [StudentPaymentListController::class,'studentManagement'])->name('student.payment.list.datatable');
//         //     /**************TUTOR*****************/


//         //     Route::get('/tutor-management', [TutorManagementController::class,'index'])->name('manage.tutors');

//         //     Route::any('/tutor-management-list-tab', [TutorManagementController::class,'getTutorManagementList'])->name('tutor.management.list.tab');
//         //     #datatable tutor management
//         //     Route::any('/admin-tutor-management', [TutorManagementController::class,'tutorManagement'])->name('list.tutors');
//         //     Route::any('/admin-tutor-management-tutor-payment', [TutorManagementController::class,'getDuetutorManagement'])->name('list.tutors.tutor.payment');

//         //     Route::any('/edit-tutor-personal-info/{id}', [TutorManagementController::class,'editTutorPersonalInfo'])->name('edit.tutor.personal.info.step.1');

//         //     Route::any('/edit-tutor-advance-page/{id}', [TutorManagementController::class,'editTutorAdvancePage'])->name('edit.tutor.advance.page');
//         //     Route::any('/view-tutor-personal-info/{id}', [TutorManagementController::class,'viewTutorPersonalInfo'])->name('view.tutor.personal.info.step.1');

//         //     Route::any('/view-tutor-advance-page/{id}', [TutorManagementController::class,'viewTutorAdvancePage'])->name('view.tutor.advance.page');
//         //     Route::get('/view-tutorship-plans/{id}', [TutorManagementController::class,'viewTutorshipPlans'])->name('view.tutor.tutorship.plans');
//         //     Route::get('/view-tutor-academic/{id}', [TutorManagementController::class,'viewTutorAcademic'])->name('view.tutor.academics');
//         //     Route::get('/view-tutor-experience/{id}', [TutorManagementController::class,'viewTutorExperience'])->name('view.tutor.experience');
//         //     Route::get('/view-tutor-recognitions/{id}', [TutorManagementController::class,'viewTutorRecognitions'])->name('view.tutor.recognitions');

//         //     Route::any('/check-password/{id}', [TutorManagementController::class,'editTutorPersonalInfo'])->name('check.password');
//         //     // Route::any('/edit-student-personal-info/{id}', [StudentManagementController::class,'editStudentPersonalInfo')->name('edit.student.personal.info.step.1');
//         //     Route::get('/edit-tutor-tutorship-plans/{id}', [TutorManagementController::class,'editTutorShipPlans'])->name('edit.tutor.tutorship.plans');
//         //     Route::any('/update-tutorship-plan/{tutorshipplanid}', [TutorManagementController::class,'updateTutorShipPlans'])->name('update.tutorship.plans');
//         //     Route::any('/edit-tutor-add-plan/{id}', [TutorManagementController::class,'editTutorAddPlan'])->name('edit.tutor.add.plan');
//         //     Route::get('/delete-tutor-add-plan/{id}', [TutorManagementController::class,'deleteTutorshipPlan'])->name('delete.tutor.plan');
//         //     Route::get('/delete-tutor-exp/{id}', [TutorManagementController::class,'deleteTutorExp'])->name('delete.tutor.exp');
//         //     Route::get('/delete-tutor-rec/{id}', [TutorManagementController::class,'deleteTutorRec'])->name('delete.tutor.rec');
//         //     Route::get('/delete-tutor-academic/{id}', [TutorManagementController::class,'deleteTutorAcademic'])->name('delete.tutor.academic');
//         //     Route::get('/edit-tutor-academics/{id}', [TutorManagementController::class,'editTutorAcademics'])->name('edit.tutor.academics');
//         //     Route::any('/update-tutor-academics/{id}', [TutorManagementController::class,'updateTutorAcademic'])->name('update.tutor.academics');
//         //     Route::any('/add-tutor-academics/{id}', [TutorManagementController::class,'addTutorAcademics'])->name('add.tutor.academics');
//         //     Route::any('/Add-Tutor-Experience/{id}', [TutorManagementController::class,'addTutorExp'])->name('add.tutor.exp');
//         //     Route::any('/add-tutor-rec/{id}', [TutorManagementController::class,'addTutorRec'])->name('add.tutor.rec');
//         //     Route::get('/tutorprofile-experience/{id}', [TutorManagementController::class,'editTutorExp'])->name('edit.tutor.experience');

//         //     Route::any('/update-tutor-experience/{id}', [TutorManagementController::class,'updateTutorExp'])->name('update.tutor.experience');
//         //     Route::get('/tutorprofile-recognitions/{id}', [TutorManagementController::class,'editTutorRec'])->name('edit.tutor.rec');
//         //     Route::any('/update-My-Recognitions/{id}', [TutorManagementController::class,'updateTutorRec'])->name('update.tutor.rec');

//         //     Route::get('/tutorprofile-tutorship-plans/{id}', [TutorManagementController::class,'manageTutorShipPlans'])->name('manage.tutorship.plans');

//         //     #datatable manage datatable tutorship plans
//         //     Route::any('/datatable-tutorship-plans/{id}', [TutorShipPlanController::class,'tutorShipManagement'])->name('manage.tutorship.plans.data');
//         //     #delete tutorship plan
//         //     Route::any('/ajax-delete-tutorship-plan', [TutorShipPlanController::class,'ajaxDeleteTutorShipPlan'])->name('ajax.delete.tutorship.plan');
//         //     Route::any('/ajax-grade-subject', [TutorShipPlanController::class,'ajaxGetGradeSubjects'])->name('ajax.grade.subject');
//         //     Route::any('/ajax-delete-academic', [TutorShipPlanController::class,'ajaxDeleteAcademic'])->name('ajax.delete.academic');
//         //     Route::any('/ajax-delete-experience', [TutorShipPlanController::class,'ajaxDeleteExperience'])->name('ajax.delete.experience');
//         //     Route::any('/ajax-delete-experience', [TutorShipPlanController::class,'ajaxDeleteExperience'])->name('ajax.delete.experience');
//         //     Route::any('/ajax-delete-recognision', [TutorShipPlanController::class,'ajaxDeleteRecognision'])->name('ajax.delete.recognision');

//         //     #datatable manage datatable academic plans
//         //     Route::any('/datatable-academic-plans/{id}', [TutorShipPlanController::class,'academicManagement'])->name('manage.academic.data');
//         //     #datatable manage datatable experience plans
//         //     Route::any('/datatable-exp-plans/{id}', [TutorShipPlanController::class,'expManagement'])->name('manage.exp.data');
//         //     #datatable manage datatable recognisition plans
//         //     Route::any('/datatable-rec-plans/{id}', [TutorShipPlanController::class,'recManagement'])->name('manage.rec.data');

//         //     Route::any('/tutor-experience/{id}', [TutorManagementController::class,'manageTutorExperience'])->name('manage.tutor.experience');
//         //     Route::any('/tutor-recognization/{id}', [TutorManagementController::class,'manageTutorRecognization'])->name('manage.tutor.recognization');

//         //     Route::any('/tutor-academic/{id}', [TutorManagementController::class,'manageTutorAcademic'])->name('manage.tutor.academic');
//         //     // Route::get('/view-tutor/{id}', [TutorManagementController::class,'viewTutor')->name('view.tutor');
//         //     Route::get('/view-tutor/{id}', [TutorManagementController::class,'viewTutor'])->name('view.tutor');
//         //     Route::get('/change-status-tutor/{id}', [TutorManagementController::class,'changeStatus'])->name('change.status.tutor');
//         //     Route::get('/delete-tutor/{id}', [TutorManagementController::class,'deleteTutor'])->name('delete.tutor');

//         //     /******************************AVAILABILITY*******************************/

//         //     Route::any('/add-tutor-availability/{id}/{key}', [TutorAvailabilityController::class,'addTutorAvailability'])->name('add.tutor.availability');

//         //     Route::any('/delete-tutor-availability/{id}', [TutorAvailabilityController::class,'deleteTutorAvailability'])->name('delete.tutor.availability');
//         //     Route::get('/edit-tutor-availability/{id}', [TutorAvailabilityController::class,'editTutorAvailability'])->name('edit.tutor.availablity');
//         //     // Route::get('/t-t-availability/{id}', [TutorAvailabilityController::class,'testingPurpose')->name('edit.tutor.availablity');
//         //     /**************/
//         //     Route::post('/ajax-duplicate-grade-check', [GradeManagementController::class,'ajaxDuplicateGradeCheck'])->name('ajax.grade.duplicate.check');
//         //     Route::post('/ajax-duplicate-capture-code-grade-check', [GradeManagementController::class,'ajaxDuplicateCaptureCodeCheck'])->name('ajax.capture.code.grade.duplicate.check');

//         //     Route::post('/ajax-duplicate-subject-check', [SubjectManagementController::class,'ajaxDuplicateSubjectCheck'])->name('ajax.subject.duplicate.check');
//         //     Route::post('/ajax-duplicate-capture-subject-check', [SubjectManagementController::class,'ajaxDuplicateCaptureCodeCheck'])->name('ajax.subject.capture.duplicate.check');

//         //     Route::post('/ajax-duplicate-tutor-email-check', [TutorManagementController::class,'ajaxTutorDuplicateEmailCheck'])->name('ajax.tutor.duplicate.email.check');
//         //     Route::post('/ajax-duplicate-tutor-phone-check', [TutorManagementController::class,'ajaxTutorDuplicatePhoneCheck'])->name('ajax.tutor.duplicate.phone.check');

//         //     Route::post('/ajax-duplicate-student-email-check', [TutorManagementController::class,'ajaxStudentDuplicateEmailCheck'])->name('ajax.student.duplicate.email.check');
//         //     Route::post('/ajax-duplicate-student-phone-check', [StudentManagementController::class,'ajaxStudentDuplicatePhoneCheck'])->name('ajax.student.duplicate.phone.check');


//         //     // booking mail
//         //     Route::get('/booking-management', [BookingsManagementController::class,'index'])->name('booking.management');

//         //     // Route::get('/manage-bookings', [BookingsManagementController::class,'index')->name('admin.booking.management');

//         //     Route::get('/view-booking-details/{bookingNo}', [BookingsManagementController::class,'viewDetails'])->name('view.booking.details');

//         //     Route::post('/booking-management-datatable.ajax', [BookingsManagementController::class,'bookingManagement'])->name('booking.management.datatable.ajax');

//         //     Route::any('/booking-management-list-tab', [BookingsManagementController::class,'getBookingManagementList'])->name('booking.management.list.tab');

//         //     Route::any('/cancel-booking', [BookingsManagementController::class,'cancelBooking'])->name('ajax.cancel.booking');

//         //     Route::any('/update-cancel-booking-by-admin', [BookingsManagementController::class,'bookingCancel'])->name('booking.cancel.by.admin');

//         //     /****************Admin Commission Management *************************/
//         //     // admin disable booking
//         //     Route::get('/admin-commission-management', [AdminCommissionController::class,'adminUpdateCommission'])->name('admin.set.commission');
//         //     Route::post('/admin-commission-management', [AdminCommissionController::class,'adminUpdateCommission'])->name('admin.set.commission');

//         //     /****************Enable Disable booking *******************************************************/
//         //     // admin disable booking
//         //     Route::get('/disable-booking-settings', [AdminDisableBookingsSettingsController::class,'adminDisableBookingsSettings'])->name('admin.disable.bookings');
//         //     Route::post('/disable-booking-settings', [AdminDisableBookingsSettingsController::class,'adminDisableBookingsSettings'])->name('admin.disable.bookings');
//         //     /********************Manage Disable booking dates list add edit status change******/
//         //     // AdminDisableBookingDatesController
//         //     # list
//         //     Route::get('/manage-admin-disable-dates', [AdminDisableBookingDatesController::class,'index'])->name('manage.admin.disable.dates');
//         //     Route::post('/manage-admin-disable-dates-datatable', [AdminDisableBookingDatesController::class,'adminDisableDatesManagement'])->name('manage.admin.disable.dates.datatable');
//         //     #add
//         //     Route::any('/add-disable-date', [AdminDisableBookingDatesController::class,'addAdminDisableBookingDates'])->name('add.disable.date');
//         //     #edit
//         //     Route::any('/edit-disable-date/{id}', [AdminDisableBookingDatesController::class,'ediAdminDisableBookingDates'])->name('edit.disable.date');

//         //     #delete
//         //     Route::any('/delete-ajax-disable-booking-dates', [AdminDisableBookingDatesController::class,'ajaxDeleteDisableBookingDates'])->name('ajax.delete.disable.dates');
//         //     Route::any('/duplicate-ajax-blocked-date-check', [AdminDisableBookingDatesController::class,'ajaxDuplicateDateCheck'])->name('ajax.duplicate.ajax.blocked.date.check');

//         //     /************************************************************************/

//         //     //review
//         //     Route::get('/manage-reviews', [AdminReviewController::class,'review_list'])->name('manage.admin.review.list');
//         //     Route::post('/manage-reviews', [AdminReviewController::class,'review_list'])->name('manage.admin.review.list');
//         //     Route::post('/manage-reviews/del', [AdminReviewController::class,'review_del'])->name('review.dlt');
//         //     Route::get('/manage-reviews/all', [AdminReviewController::class,'review_list_all'])->name('get.all.review');

//         //     /******************************Class End Assesment******************************************/

//         //     Route::get('/view-class-end-assesment/{id}', [AdminClassEndAsseesmentController::class,'viewDetailsClassEndAssesment'])->name('view.admin.class.end.assesment');
//         //     Route::get('/manage-class-end-assesment', [AdminClassEndAsseesmentController::class,'manageClassEndAssesment'])->name('manage.admin.class.end.assesment');
//         //     Route::post('/class-end-assesment-management', [AdminClassEndAsseesmentController::class,'classEndAssesmentManagement'])->name('admin.class.end.assesment.management');
//         //     Route::get('/a-class-end-assesment-management', [AdminClassEndAsseesmentController::class,'classEndAssesmentDtls'])->name('admin.class.end.assesment.management.a');



//         //     //tutor due payments..
//         //     Route::get('/manage-due-payments', [PaymentController::class,'due_payments'])->name('due.payments');
//         //     Route::post('/manage-due-payments', [PaymentController::class,'due_payments'])->name('due.payments');
//         //     Route::post('/manage-due-payments/payment', [PaymentController::class,'tutor_payment'])->name('tutor.payment');
//         //     Route::get('/manage-due-payments/all', [PaymentController::class,'due_payments_all'])->name('get.all.payment');

//         //     Route::post('/manage-due-payments/inc', [PaymentController::class,'tutor_incentive'])->name('tutor.incentive');

//         //     //tutor payment history
//         //     Route::get('/payment-history/{id}', [PaymentController::class,'payment_his'])->name('payments.history');
//         //     Route::post('/payment-history/{id}', [PaymentController::class,'payment_his_search'])->name('payments.history.search');
//         //     Route::get('/payment-history-all/{id}', [PaymentController::class,'payment_his_search_ajax'])->name('get.all.history');



//         //     //student payment
//         //     Route::any('/student-payments', [PaymentController::class,'student_pay_list'])->name('student.pay.list');
//         //     Route::get('/student-payments/all', [PaymentController::class,'student_pay_list_ajax'])->name('get.all.student.payment');

//         //     //faq managment
//         //     Route::any('/manage-faq', [FaqController::class,'faq_list'])->name('faq.list');
//         //     Route::get('/manage-faq/add', [FaqController::class,'faq_add_page'])->name('add.faq.page');
//         //     Route::post('/manage-faq/added', [FaqController::class,'faq_ins'])->name('faq.added');

//         //     Route::get('/manage-faq/del/{id}', [FaqController::class,'faq_del'])->name('del.faq');
//         //     Route::get('/manage-faq/active/{id}', [FaqController::class,'faq_active'])->name('active.faq');
//         //     Route::get('/manage-faq/inactive/{id}', [FaqController::class,'faq_inactive'])->name('inactive.faq');
//         //     Route::get('/manage-faq/view/{id}', [FaqController::class,'faq_view'])->name('view.faq');
//         //     Route::get('/manage-faq/edit/{id}', [FaqController::class,'faq_edit_page'])->name('edit.faq');
//         //     Route::post('/manage-faq/update', [FaqController::class,'faq_update'])->name('update.faq');
//         //     Route::get('/manage-faq/all', [FaqController::class,'faq_get_all_ajax'])->name('get.all.faq');




//         //     //help section management
//         //     Route::any('/manage-help-section', [HelpController::class,'help_list'])->name('help.list');
//         //     Route::get('/manage-help-section/del/{id}', [HelpController::class,'help_del'])->name('del.help');
//         //     Route::get('/manage-help-section/active/{id}', [HelpController::class,'help_active'])->name('active.help');
//         //     Route::get('/manage-help-section/inactive/{id}', [HelpController::class,'help_inactive'])->name('inactive.help');

//         //     Route::get('/manage-help-section/add', [HelpController::class,'help_add_page'])->name('add.help.page');
//         //     Route::post('/manage-help-section/added', [HelpController::class,'help_ins'])->name('help.added');

//         //     Route::get('/manage-help-section/view/{id}', [HelpController::class,'help_view'])->name('view.help');
//         //     Route::get('/manage-help-section/edit/{id}', [HelpController::class,'help_edit_page'])->name('edit.help');
//         //     Route::post('/manage-help-section/update', [HelpController::class,'help_update'])->name('update.help');
//         //     Route::get('/manage-help-section/all', [HelpController::class,'help_get_all_ajax'])->name('get.all.help');


//         //     //testimonial section
//         //     Route::any('/manage-testimonials', [TestimonialController::class,'test_list'])->name('test.list');
//         //     Route::get('/manage-testimonials/add', [TestimonialController::class,'test_add_page'])->name('add.test.page');
//         //     Route::post('/manage-testimonials/added', [TestimonialController::class,'test_ins'])->name('test.added');

//         //     Route::get('/manage-testimonials/del/{id}', [TestimonialController::class,'test_del'])->name('del.test');

//         //     Route::get('/manage-testimonials/active/{id}', [TestimonialController::class,'test_active'])->name('active.test');

//         //     Route::get('/manage-testimonials/inactive/{id}', [TestimonialController::class,'test_inactive'])->name('inactive.test');

//         //     Route::get('/manage-testimonials/view/{id}', [TestimonialController::class,'test_view'])->name('view.test');

//         //     Route::get('/manage-testimonials/edit/{id}', [TestimonialController::class,'test_edit_page'])->name('edit.test');

//         //     Route::post('/manage-testimonials/update', [TestimonialController::class,'test_update'])->name('update.test');
//         //     Route::get('/manage-testimonials/all', [TestimonialController::class,'test_get_all_ajax'])->name('get.all.test');

//         //     /*****************privacy policy and terms and conditions********************/

//         //     Route::get('/privacy-policy', [PrivacyPolicyController::class,'privacyPolicy'])->name('privacy.policy');
//         //     Route::post('/update-privacy-policy', [PrivacyPolicyController::class,'privacyPolicy'])->name('update.privacy.policy');
//         //     Route::get('/terms-and-conditions', [TermsConditionsController::class,'termsConditions'])->name('terms.conditions');
//         //     Route::post('/update-terms-and-conditions', [TermsConditionsController::class,'termsConditions'])->name('update.terms.conditions');
//         //     /*****************************BANNERS*****************************************/
//         //     Route::any('/add-banner', [BannersController::class,'addBanner'])->name('admin.add.banner');
//         //     Route::any('/edit-banner/{id}', [BannersController::class,'editBanner'])->name('admin.edit.banner');
//         //     Route::any('/list-banner', [BannersController::class,'manageBanner'])->name('admin.list.banner');
//         //     Route::any('/delete-banner/{id}', [BannersController::class,'deleteBanner'])->name('admin.delete.banner');
//         //     /***************admin update Follow us details****************/
//         //     Route::any('/admin-update-follow-us', [FollowUsDetailsController::class,'updateFollowUsDetails'])->name('admin.update.follow.us');

//         //     Route::any('/modify-commission/{id}', [ModifyCommissionController::class,'updateModifyCommission'])->name('admin.modify.commission');
//         // });
//     });
// });
