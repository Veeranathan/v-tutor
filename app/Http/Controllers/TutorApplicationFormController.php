<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Validation\Rule;
use App\Mail\TutorAccountClose;
use App\Mail\zoomMeetingReminderBeforeOneHour;
use App\Mail\zoomMeetingReminderTutorBeforeOneHour;
use App\Mail\TafIncompleteReminder;
use App\Mail\TafWWCCExpired;
use App\Mail\TafWWCCExpireReminder;
use App\Mail\TeacherVerify;
use App\Mail\TafReceived;
use App\Mail\TafAdminReceivedNotification;
use App\Notifications\TutorResetPasswordNotification;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Grade;
use App\Models\TutorshipPlan;
use App\Models\TestimonialModel;
use App\Models\StudentClassBooking;
use App\Models\Banners;
use App\Models\Subject;
use App\Models\User;
use App\Models\ZoomUser;
use App\Models\TutorApplicationFormsModel;
use App\Models\TutorWWCCModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Helpers\FirebaseHelper;

class TutorApplicationFormController extends Controller
{
    public function comingSoonPage()
    {
        $data = [];
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
            $data['tutor_id'] = $tutor_id;
            $taf_data = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->orderby('id', 'desc')->first();
            $data['taf_data'] = $taf_data;
        }

        return view('coming_soon_page')->with($data);
    }

    public function showTutorRegisterForm()
    {
        if (auth()->check()) {
            return redirect()->route('tutor_application_form');
        }

        return view('auth.new_register');
    }

    public function saveTutorRegisterForm(Request $request)
    {
        $data = $request->validate([
            'f_name'   => ['required', 'min:3', 'max:250'],
            'l_name'   => ['required', 'min:3', 'max:250'],
            'email'    => ['required', 'email', 'max:250', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'f_name.required' => 'The first name field is required.',
            'f_name.min' => 'The first name must be at least 3 characters.',
            'f_name.max' => 'The first name may not be greater than 250 characters.',
            'l_name.required' => 'The last name field is required.',
            'l_name.min' => 'The last name must be at least 3 characters.',
            'l_name.max' => 'The last name may not be greater than 250 characters.',
            'email.unique' => 'This email is already registered.',
        ]);

        $tutor = new User();
        $tutor->f_name = $request->f_name;
        $tutor->l_name = $request->l_name;
        $tutor->email = $request->email;
        $tutor->password = Hash::make($request->password);
        $tutor->user_type = 'T';
        $tutor->slug = Str::slug($request->f_name . " " . $request->l_name);
        $tutor->email_vcode = Str::random(60);
        if ($tutor->save()) {
            $updateSlug['slug'] = Str::slug($tutor->f_name . " " . $tutor->l_name . " " . $tutor->id);
            $updateSlug['unique_id'] = "TUT000" . $tutor->id;
            if (User::where('id', $tutor->id)->update($updateSlug)) {
            }

            $getuser = User::where('id', $tutor->id)->first();
            if ($getuser) {
                $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
                $data['email'] = $getuser->email;
                $data['vcode'] = $getuser->email_vcode;
                $data['id'] = $getuser->id;
                $data['email_subject'] = "Verify your email address on V-Tutor";
                $data['redirect'] = "tutor_application_form_login";

                Mail::to($getuser->email)->send(new TeacherVerify($data));
            }

            return redirect()->route('tutor_application_form_login')->with('success', 'A verification link has been sent to your email address, please check your email and click on the verification link to complete sign up. You will be able to login after your email address is verified');
        }

        return back()
            ->with('error', 'Some thing went wrong, please try again later or contact support team.');
    }

    public function tutorApplicationFormLogin()
    {
        if (auth()->check()) {
            return redirect()->route('tutor_application_form');
        }

        return view('auth.new_login');
    }

    public function tutorApplicationFormCheckLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('tutor_application_form'));
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function tutorForgotPassword()
    {
        return view('auth.new_login_forget_password');
    }

    public function tutorCheckForgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'We can’t find a tutor account with that email.');
        }


        $token = Password::broker()->createToken($user);

        $user->notify(new TutorResetPasswordNotification($token));

        return back()->with('success', 'Reset link sent! Check your inbox.');
        /*
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]); */
    }

    public function tutorResetPassword(Request $request, string $token)
    {
        return view('auth.new_login_reset_password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function tutorCheckResetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                Auth::login($user); // auto-login after reset
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('tutor_application_form')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function tutorLandingPage()
    {
        $data = [];
        $tutor_id = '';
        if (auth()->check()) {
            if (auth()->user()->user_type == "T") {
                $tutor_id = auth()->user()->id;
                $data['tutor_id'] = $tutor_id;
                $taf_data = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->orderby('id', 'desc')->first();
                $data['taf_data'] = $taf_data;
                return view('tutor_landing_page')->with($data);
            } else {
                return redirect()->route('landing.page')->with('error', 'You do not have access to this page with your current login');
            }
        }

        return view('tutor_landing_page')->with($data);
    }

    public function getTutorApplicationForm()
    {
        $data = [];
        $tutor_id = '';
        if (auth()->check()) {
            if (auth()->user()->user_type == "T") {
                $tutor_id = auth()->user()->id;
                $data['tutor_id'] = $tutor_id;
                $taf_data = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->orderby('id', 'desc')->first();
                // dd($taf_data);
                if ($taf_data && $taf_data->status == 1) {
                    return redirect()->route('tutor_landing')->with('success', 'Your application is conditionally accepted. Profile access is available for updates, with full functionality enabled upon approval.');
                } else if ($taf_data && $taf_data->status == 2) {
                    return view('tutor_application_form')->with($data);
                } else if ($taf_data && $taf_data->status == 3) {
                    return redirect()->route('tutor_landing')->with('error', 'We notice that your application has already been submitted. Please wait 24-48 hours to hear back from our team. Thanks for the patience.');
                } else if ($taf_data && $taf_data->status == 4) {
                    $data['taf_data'] = $taf_data;
                    $taf_wwcc = TutorWWCCModel::Where('tutor_id', $tutor_id)->Where('tutor_app_id', $taf_data->id)->get();
                    // dd($taf_wwcc);
                    $data['taf_wwcc'] = $taf_wwcc;
                    return view('tutor_application_form')->with($data);
                } else {
                    return view('tutor_application_form')->with($data);
                }
            }
        }

        return redirect()->route('tutor_landing');
    }

    public function SaveTutorApplicationFormTab1(Request $request)
    {
        // dd($request->all());
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:250',
            'middle_name' => 'nullable|string|max:250',
            'last_name' => 'required|string|max:250',
            'primary_email' => 'required|email',
            // 'primary_phone' => 'required|regex:/^[0-9]{10}$/',
            'primary_phone' => [
                'required',
                'regex:/^[0-9]{10}$/',
                Rule::unique('tutor_application_forms', 'primary_phone')->ignore($request->form_id, 'id'),
            ],
            'com_addr_country' => 'required',
            'com_addr_state' => 'required',
            'com_addr_city' => 'required',
            'com_addr_street' => 'required',
            'com_addr_zip' => 'required|regex:/^[0-9]{4}$/',
            'com_addr_timezone' => 'required',
            'pick_permanent_address' => 'nullable',
            'perm_addr_country' => 'nullable|required_if:pick_permanent_address,2',
            'perm_addr_state' => 'nullable|required_if:pick_permanent_address,2',
            'perm_addr_city' => 'nullable|required_if:pick_permanent_address,2',
            'perm_addr_street' => 'nullable|required_if:pick_permanent_address,2',
            'perm_addr_zip' => 'nullable|required_if:pick_permanent_address,2|regex:/^[0-9]{4}$/',
            'dob' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'nationality' => 'required',
            'current_residency_status' => 'required',
            'current_residency'      => 'nullable|required_if:current_residency_status,8',
            'disability_health' => 'required',
            'disability_health_details' => 'nullable|required_if:disability_health,1',
        ], [
            'first_name.required' => 'Please enter your first name.',
            'first_name.string' => 'First name must be valid text.',
            'first_name.max' => 'First name must be valid proper length.',
            'middle_name.string' => 'Middle name must be valid text.',
            'middle_name.max' => 'Middle name must be valid proper length.',
            'last_name.required' => 'Please enter your last name.',
            'last_name.string' => 'Last name must be valid text.',
            'last_name.max' => 'Last name must be valid proper length.',
            'primary_email.required' => 'Email is required.',
            'primary_email.email'    => 'Enter a valid email address.',
            'primary_phone.required' => 'Phone Number is required.',
            'primary_phone.regex'    => 'The phone number must be exactly 10 digits.',
            //'primary_phone.unique' => 'This phone number is already registered.',
            'com_addr_country.required' => 'This field is required.',
            'com_addr_state.required' => 'This field is required.',
            'com_addr_city.required' => 'This field is required.',
            'com_addr_street.required' => 'This field is required.',
            'com_addr_zip.required' => 'This field is required.',
            'com_addr_zip.regex'    => 'The postcode must be exactly 4 digits.',
            'com_addr_timezone.required' => 'This field is required.',
            'pick_permanent_address.required' => 'Permanent address is required.',
            // 'permanent_address.required_if' => 'Permanent address is required.',
            'perm_addr_country.required_if' => 'This field is required.',
            'perm_addr_state.required_if' => 'This field is required.',
            'perm_addr_city.required_if' => 'This field is required.',
            'perm_addr_street.required_if' => 'This field is required.',
            'perm_addr_zip.required_if' => 'This field is required.',
            'perm_addr_zip.regex'    => 'The postcode must be exactly 4 digits.',
            'dob.required' => 'Date of birth is required.',
            'dob.date'               => 'Please enter a valid date.',
            'dob.before_or_equal'    => 'You must be at least 18 years old.',
            'nationality.required' => 'Nationality is required.',
            'current_residency_status.required' => 'This field is required.',
            'current_residency.required_if' => 'This field is required.',
            'disability_health.required' => 'This field is required.',
            'disability_health_details.required_if' => 'Please provide additional details regarding your disability.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 200);
        }

        /* if(isset($request->form_action) && $request->form_action == 1) {
            return response()->json([
                'status' => true,
                'message' => '',
                'data'  => '',
                'complete'  => 1,
            ]);
        } */

        $taf_save = new TutorApplicationFormsModel();
        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }
        }
        // dd($taf_save);
        if ($taf_save) {
            $taf_save->tutor_id = $tutor_id;
            $taf_save->first_name = $request->first_name ?? '';
            $taf_save->middle_name = $request->middle_name ?? '';
            $taf_save->last_name = $request->last_name ?? '';
            $taf_save->primary_email = $request->primary_email ?? '';
            $taf_save->primary_phone = $request->primary_phone ?? '';
            $taf_save->com_addr_country = $request->com_addr_country ?? '';
            $taf_save->com_addr_state = $request->com_addr_state ?? '';
            $taf_save->com_addr_city = $request->com_addr_city ?? '';
            $taf_save->com_addr_street = $request->com_addr_street ?? '';
            $taf_save->com_addr_zip = $request->com_addr_zip ?? '';
            $taf_save->com_addr_timezone = $request->com_addr_timezone ?? '';
            $taf_save->pick_permanent_address = $request->pick_permanent_address ?? 1;
            $taf_save->perm_addr_country = $request->perm_addr_country ?? '';
            $taf_save->perm_addr_state = $request->perm_addr_state ?? '';
            $taf_save->perm_addr_city = $request->perm_addr_city ?? '';
            $taf_save->perm_addr_street = $request->perm_addr_street ?? '';
            $taf_save->perm_addr_zip = $request->perm_addr_zip ?? '';
            $taf_save->dob = $request->dob ?? '';
            $taf_save->nationality = $request->nationality ?? 0;
            $taf_save->current_residency_status = $request->current_residency_status ?? 0;
            $taf_save->current_residency = $request->current_residency ?? '';
            $taf_save->disability_health = $request->disability_health ?? 0;
            $taf_save->disability_health_details = $request->disability_health_details ?? '';
            $taf_save->status = 4;
            if ($taf_save->save()) {
                if (TutorApplicationFormsModel::Where('id', $taf_save->id)->update(['taf_id' => $taf_save->formatted_id])) {
                }

                return response()->json([
                    'status' => true,
                    'message' => 'The information has been saved successfully.',
                    'data'  => $taf_save,
                ]);
            }
        }


        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function SaveTutorApplicationFormTab2(Request $request)
    {
        // dd($request->all());
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'select_tutor_subjects' => 'nullable|array',
            'select_tutor_subjects.*' => 'integer',
            'tutor_subjects' => 'nullable',
            'select_assist' => 'nullable|array',
            'select_assist.*' => 'integer',
            'select_tutor_grade' => 'nullable|array',
            'select_tutor_grade.*' => 'integer',
            'select_tutor_status' => 'nullable',
            'select_merits' => 'nullable',
            'select_commit_per_week' => 'nullable',
            'select_online_class_experience' => 'nullable',
            'select_wwcc' => 'nullable',
            'select_building_activities' => 'nullable',
        ], [
            // 'select_tutor_subjects.required' => 'Please select at least one subject.',
            'select_tutor_subjects.array' => 'The selected subjects must be a valid list.',
            'select_tutor_subjects.*.integer' => 'Invalid subject selected.',
            // 'tutor_subjects.required' => 'Subject is required.',
            'select_assist.array' => 'The selected assist must be a valid list.',
            'select_assist.*.integer' => 'Invalid assist selected.',
            'select_tutor_grade.array' => 'The selected grade must be a valid list.',
            'select_tutor_grade.*.integer' => 'Invalid grade selected.',
            // 'select_tutor_status.required' => 'Tutor status is required.',
            // 'select_merits.required' => 'Qualifications and merits is required.',
            // 'select_commit_per_week.required' => 'Commit per week for online tutoring is required.',
            // 'select_online_class_experience.required' => 'Experience in conducting online classes is required.',
            // 'select_wwcc.required' => 'Status of WWCC is required.',
            // 'select_building_activities.required' => 'Building activities is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 200);
        }

        /* if(isset($request->form_action) && $request->form_action == 1) {
            return response()->json([
                'status' => true,
                'message' => '',
                'data'  => '',
                'complete'  => 1,
            ]);
        } */

        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }

            if ($taf_save) {
                // $taf_save->tutor_id = $tutor_id;
                $taf_save->select_tutor_subjects = isset($request->select_tutor_subjects) && $request->select_tutor_subjects ? json_encode($request->select_tutor_subjects) : null;
                $taf_save->tutor_subjects = $request->tutor_subjects ?? '';
                $taf_save->select_assist = isset($request->select_assist) && $request->select_assist ? json_encode($request->select_assist) : null;
                $taf_save->select_tutor_grade = isset($request->select_tutor_grade) && $request->select_tutor_grade ? json_encode($request->select_tutor_grade) : null;
                $taf_save->select_tutor_status = $request->select_tutor_status ?? 0;
                $taf_save->select_merits = $request->select_merits ?? 0;
                $taf_save->select_commit_per_week = $request->select_commit_per_week ?? 0;
                $taf_save->select_online_class_experience = $request->select_online_class_experience ?? 0;
                $taf_save->select_wwcc = $request->select_wwcc ?? 0;
                $taf_save->select_building_activities = $request->select_building_activities ?? 0;
                $taf_save->status = 4;
                if ($taf_save->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'The information has been saved successfully.',
                        'data'  => $taf_save,
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function SaveTutorApplicationFormTab3(Request $request)
    {
        // dd($request->all());
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'mother_tongue' => 'required',
            'primary_communication_language' => 'required',
            'tertiary_communication_language' => 'nullable',
            'select_english_language_proficiency' => 'required',
            'select_biological_parent' => 'required',
            'select_not_biological_parent' => 'required',
            'select_domestic_violence' => 'required',
            'select_addicted_to_drugs' => 'required',
            'select_addicted_to_drugs_details'      => 'nullable|required_if:select_addicted_to_drugs,1',
            'select_showing_your_face' => 'required',
            'select_showing_your_face_details'      => 'nullable|required_if:select_showing_your_face,1',
            'select_worked_children' => 'required',
            'worked_children'      => 'nullable|required_if:select_worked_children,1',
        ], [
            'mother_tongue.required' => 'Native language is required.',
            'primary_communication_language.required' => 'Primary communication language is required.',
            // 'tertiary_communication_language.required' => 'Tertiary communication language is required.',
            'select_english_language_proficiency.required' => 'This field is required',
            'select_biological_parent.required' => 'This field is required',
            'select_not_biological_parent.required' => 'This field is required',
            'select_domestic_violence.required' => 'This field is required',
            'select_addicted_to_drugs.required' => 'This field is required',
            'select_addicted_to_drugs_details.required_if' => 'This field is required',
            'select_showing_your_face.required' => 'This field is required',
            'select_showing_your_face_details.required_if' => 'This field is required',
            'select_worked_children.required' => 'This field is required',
            'worked_children.required_if' => 'This field is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 200);
        }

        /* if(isset($request->form_action) && $request->form_action == 1) {
            return response()->json([
                'status' => true,
                'message' => '',
                'data'  => '',
                'complete'  => 1,
            ]);
        } */

        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }

            if ($taf_save) {
                // $taf_save->tutor_id = $tutor_id;
                $taf_save->mother_tongue = $request->mother_tongue ?? '';
                $taf_save->primary_communication_language = $request->primary_communication_language ?? '';
                $taf_save->tertiary_communication_language = $request->tertiary_communication_language ?? '';
                $taf_save->select_english_language_proficiency = $request->select_english_language_proficiency ?? 0;
                $taf_save->select_biological_parent = $request->select_biological_parent ?? 0;
                $taf_save->select_not_biological_parent = $request->select_not_biological_parent ?? 0;
                $taf_save->select_domestic_violence = $request->select_domestic_violence ?? 0;
                $taf_save->select_addicted_to_drugs = $request->select_addicted_to_drugs ?? 0;
                $taf_save->select_addicted_to_drugs_details = $request->select_addicted_to_drugs_details ?? NULL;
                $taf_save->select_showing_your_face = $request->select_showing_your_face ?? 0;
                $taf_save->select_showing_your_face_details = $request->select_showing_your_face_details ?? NULL;
                $taf_save->select_worked_children = $request->select_worked_children ?? 0;
                $taf_save->worked_children = $request->worked_children ?? NULL;
                $taf_save->status = 4;
                if ($taf_save->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'The information has been saved successfully.',
                        'data'  => $taf_save,
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function SaveTutorApplicationFormTab4(Request $request)
    {
        // dd($request->all());
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'select_working_wwcc' => 'required',
            'select_australian_states_wwcc' => 'nullable|array',
            'select_australian_states_wwcc.*' => 'integer',
            'select_crime_in_any_country' => 'required',
            'crime_in_any_country'      => 'nullable|required_if:select_crime_in_any_country,1',
            'select_pending_criminal_cases' => 'required',
            'pending_criminal_cases'      => 'nullable|required_if:select_pending_criminal_cases,1',
            'select_children_related_offences' => 'required',
            'children_related_offences'      => 'nullable|required_if:select_children_related_offences,1',
        ], [
            'select_working_wwcc.required' => 'This field is required.',
            // 'select_australian_states_wwcc.required' => 'Please select at least one state.',
            'select_australian_states_wwcc.array' => 'The selected state must be a valid list.',
            'select_australian_states_wwcc.*.integer' => 'Invalid state selected.',
            'select_crime_in_any_country.required' => 'This field is required.',
            'crime_in_any_country.required_if' => 'This field is required.',
            'select_pending_criminal_cases.required' => 'This field is required.',
            'pending_criminal_cases.required_if' => 'This field is required.',
            'select_children_related_offences.required' => 'This field is required.',
            'children_related_offences.required_if' => 'This field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 200);
        }

        /* if(isset($request->form_action) && $request->form_action == 1) {
            return response()->json([
                'status' => true,
                'message' => '',
                'data'  => '',
                'complete'  => 1,
            ]);
        } */

        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }

            if ($taf_save) {
                // $taf_save->tutor_id = $tutor_id;
                $taf_save->select_working_wwcc = $request->select_working_wwcc ?? '';
                $taf_save->select_australian_states_wwcc = isset($request->select_australian_states_wwcc) && $request->select_australian_states_wwcc ? json_encode($request->select_australian_states_wwcc) : null;
                $taf_save->select_crime_in_any_country = $request->select_crime_in_any_country ?? 0;
                $taf_save->crime_in_any_country = $request->crime_in_any_country ?? '';
                $taf_save->select_pending_criminal_cases = $request->select_pending_criminal_cases ?? 0;
                $taf_save->pending_criminal_cases = $request->pending_criminal_cases ?? '';
                $taf_save->select_children_related_offences = $request->select_children_related_offences ?? 0;
                $taf_save->children_related_offences = $request->children_related_offences ?? '';
                $taf_save->status = 4;
                if ($taf_save->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'The information has been saved successfully.',
                        'data'  => $taf_save,
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function SaveTutorApplicationFormTab5(Request $request)
    {
        // dd($request->all());
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'motivated_tutor' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 150) {
                        $fail("Answers must not exceed 150 words.");
                    }
                },
            ],
            'belief_values' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 150) {
                        $fail("Answers must not exceed 150 words.");
                    }
                },
            ],
            'understood_topic' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 150) {
                        $fail("Answers must not exceed 150 words.");
                    }
                },
            ],
            'late_online_session' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 150) {
                        $fail("Answers must not exceed 150 words.");
                    }
                },
            ],
            'parent_watching' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 150) {
                        $fail("Answers must not exceed 150 words.");
                    }
                },
            ],
            'academic_achievements' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 150) {
                        $fail("Answers must not exceed 150 words.");
                    }
                },
            ],
            /* 'motivated_tutor' => 'nullable|max:150',
            'belief_values' => 'nullable|max:150',
            'understood_topic' => 'nullable|max:150',
            'late_online_session' => 'nullable|max:150',
            'parent_watching' => 'nullable|max:150',
            'academic_achievements' => 'nullable|max:150', */
        ], [
            // 'motivated_tutor.required' => 'Motivated is required.',
            // 'belief_values.required' => 'Belief values is required.',
            // 'understood_topic.required' => 'Understood topic is required.',
            // 'late_online_session.required' => 'Late online session is required.',
            // 'parent_watching.required' => 'Parent watching is required.',
            // 'academic_achievements.required' => 'Academic achievements is required.',
            /* 'motivated_tutor.max'          => 'Answers must not exceed 150 characters.',
            'belief_values.max'          => 'Answers must not exceed 150 characters.',
            'understood_topic.max'          => 'Answers must not exceed 150 characters.',
            'late_online_session.max'          => 'Answers must not exceed 150 characters.',
            'parent_watching.max'          => 'Answers must not exceed 150 characters.',
            'academic_achievements.max'          => 'Answers must not exceed 150 characters.', */]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 200);
        }

        /* if(isset($request->form_action) && $request->form_action == 1) {
            return response()->json([
                'status' => true,
                'message' => '',
                'data'  => '',
                'complete'  => 1,
            ]);
        } */

        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }

            if ($taf_save) {
                // $taf_save->tutor_id = $tutor_id;
                $taf_save->motivated_tutor = $request->motivated_tutor ?? '';
                $taf_save->belief_values = $request->belief_values ?? '';
                $taf_save->understood_topic = $request->understood_topic ?? '';
                $taf_save->late_online_session = $request->late_online_session ?? '';
                $taf_save->parent_watching = $request->parent_watching ?? '';
                $taf_save->academic_achievements = $request->academic_achievements ?? '';
                $taf_save->status = 4;
                if ($taf_save->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'The information has been saved successfully.',
                        'data'  => $taf_save,
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function SaveTutorApplicationFormTab6(Request $request)
    {
        // dd($request->all());
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        if (isset($request->form_action) && $request->form_action == 1) {
            /* if(isset($request->form_id) && $request->form_id) {
                $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
                if($taf_save && (isset($taf_save->video_interview) && $taf_save->video_interview)) {
                    return response()->json([
                        'status' => true,
                        'message' => '',
                        'data'  => '',
                        'complete'  => 1,
                    ]);
                }
            } */

            if (isset($request->video) && $request->video) {
            } else {
                return response()->json([
                    'status' => true,
                    'message' => '',
                    'data'  => '',
                    'complete'  => 1,
                ]);
            }
        }

        $validator = Validator::make($request->all(), [
            'video' => 'required',
        ], [
            'video.required' => 'Video not recorded, please try again later',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 200);
        }

        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }

            if ($taf_save) {
                $tutor_name = "tutor_" . $tutor_id;
                if ($taf_save->first_name) {
                    $tutor_name = $taf_save->first_name . '_' . $tutor_id;
                }

                // $taf_save->tutor_id = $tutor_id;
                $file = $request->file('video');
                // $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filename = $tutor_name . '_video_interview.mp4';
                $filename = str_replace(' ', '_', $filename);

                $path = $file->storeAs('public/admin/videos', $filename); // stored in storage/app/public/admin/videos

                $taf_save->video_interview = $filename;
                $taf_save->status = 4;
                if ($taf_save->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'The recording was completed and saved successfully.',
                        'data'  => $taf_save,
                    ]);
                }
            }
        } else {
            return response()->json([
                'status'  => 1,
                'message' => 'Please try again after refresh the page, or contact the administrator for support.',
                'errors'  => '',
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function SaveTutorApplicationFormTab7(Request $request)
    {
        // dd($request->all());

        /* $hasAtLeastOneWWCC = collect($request->wwcc_check)->contains(function ($item) {
            return !empty($item['wwcc_state']) && !empty($item['wwcc_no']) && !empty($item['wwcc_expiry']);
        }); */

        $hasAtLeastOneWWCC = collect($request->wwcc_check)->contains(function ($item) {
            return !empty($item['wwcc_state'])
                && !empty($item['wwcc_no'])
                && !empty($item['wwcc_expiry'])
                && (
                    // New upload
                    (!empty($item['wwcc_doc']) && $item['wwcc_doc'] instanceof \Illuminate\Http\UploadedFile)
                    // Or existing file from hidden field
                    || !empty($item['wwcc_doc_hdn'])
                );
        });


        if (!$hasAtLeastOneWWCC) {
            return response()->json([
                'status'  => false,
                'message' => 'Please fill at least one WWCC number, expiry date and doc.',
                'errors'  => '',
            ], 200);
        }

        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        $rules = [];
        $selected = request()->input('select_wwcc_check', []);

        /* if (!is_array($selected)) {
            $selected = [$selected];
        }

        foreach ($selected as $key) {
            $rules["wwcc_check.$key.wwcc_no"] = ['required', 'string'];
            $rules["wwcc_check.$key.wwcc_expiry"] = ['required', 'date', 'after_or_equal:today'];
        }

        $validator = Validator::make($request->all(), $rules, [
            'wwcc_check.*.wwcc_no.required' => 'The WWCC number is required.',
            'wwcc_check.*.wwcc_expiry.required' => 'The expiry date is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Please fill selected state WWCC number and expiry date.',
                'errors'  => '',
            ], 200);
        } */

        $vok = 2;
        $vnok = 2;
        if (isset($request->wwcc_check) && count($request->wwcc_check) != 0) {
            foreach ($request->wwcc_check as $key => $value) {
                if (isset($value['wwcc_state']) && $value['wwcc_state']) {
                    if ((isset($value['wwcc_no']) && $value['wwcc_no']) && (isset($value['wwcc_expiry']) && $value['wwcc_expiry']) && ((!empty($value['wwcc_doc']) && $value['wwcc_doc'] instanceof \Illuminate\Http\UploadedFile) || !empty($value['wwcc_doc_hdn']))) {
                        $vok = 1;
                    } else {
                        $vnok = 1;
                    }
                }
            }
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Please fill at least one WWCC number and expiry date.',
                'errors'  => '',
            ], 200);
        }

        // dd($vok, $vnok);
        if ($vnok == 1) {
            return response()->json([
                'status'  => false,
                'message' => 'Please enter the WWCC number for all selected options.',
                'errors'  => '',
            ], 200);
        }

        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();

            if (isset($request->form_action) && $request->form_action == 1 && $taf_save) {
                /* $twm = TutorWWCCModel::Where('tutor_id', $tutor_id)->Where('tutor_app_id', $taf_save->id)->first();
                if($twm) {
                    return response()->json([
                        'status' => true,
                        'message' => '',
                        'data'  => '',
                        'complete'  => 1,
                    ]);
                } else {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Please save the WWCC details, then continue next process',
                        'errors'  => '',
                    ], 200);
                } */
            }

            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }

            if ($taf_save) {
                if (TutorWWCCModel::where('tutor_id', $tutor_id)->where('tutor_app_id', $taf_save->id)->whereNotIn('states', collect($request->wwcc_check)->pluck('wwcc_state')->filter()->all())->delete()) {
                }

                foreach ($request->wwcc_check as $key => $value) {
                    $hasNoData = empty($value['wwcc_no']) && empty($value['wwcc_expiry']);

                    if ($hasNoData) {
                        if (TutorWWCCModel::Where('tutor_id', $tutor_id)->Where('tutor_app_id', $taf_save->id)->Where('states', $key)->delete()) {
                        }
                    }

                    if ((isset($value['wwcc_no']) && $value['wwcc_no']) && (isset($value['wwcc_expiry']) && $value['wwcc_expiry']) && ((!empty($value['wwcc_doc']) && $value['wwcc_doc'] instanceof \Illuminate\Http\UploadedFile) || !empty($value['wwcc_doc_hdn']))) {
                        $wwcc_chk = TutorWWCCModel::Where('tutor_id', $tutor_id)->Where('tutor_app_id', $taf_save->id)->Where('states', $key)->first();
                        if ($wwcc_chk) {
                            $wwcc_chk->wwcc_no = $value['wwcc_no'];
                            $wwcc_chk->expiry_date = $value['wwcc_expiry'];

                            $doc_path = NULL;

                            if (isset($value['wwcc_doc']) && $value['wwcc_doc'] instanceof \Illuminate\Http\UploadedFile) {
                                $file = $value['wwcc_doc'];
                                $extension = $file->getClientOriginalExtension();

                                $uniqueName = 'wwcc_' . $value['wwcc_no'] . '_' . now()->format('Ymd_His') . '_' . uniqid() . '.' . $extension;

                                // Store file in storage/app/public/wwcc_docs
                                $path = $file->storeAs('wwcc_docs', $uniqueName, 'public');
                                $doc_path = 'storage/' . $path;
                                $wwcc_chk->wwcc_doc = $doc_path;
                            }

                            if ($wwcc_chk->save()) {
                            }
                        } else {
                            $doc_path = NULL;

                            if (isset($value['wwcc_doc']) && $value['wwcc_doc'] instanceof \Illuminate\Http\UploadedFile) {
                                $file = $value['wwcc_doc'];
                                $extension = $file->getClientOriginalExtension();

                                $uniqueName = 'wwcc_' . $value['wwcc_no'] . '_' . now()->format('Ymd_His') . '_' . uniqid() . '.' . $extension;

                                // Store file in storage/app/public/wwcc_docs
                                $path = $file->storeAs('wwcc_docs', $uniqueName, 'public');
                                $doc_path = 'storage/' . $path;
                            }

                            $wwcc_chk = new TutorWWCCModel();
                            $wwcc_chk->tutor_id = $tutor_id;
                            $wwcc_chk->tutor_app_id = $taf_save->id;
                            $wwcc_chk->states = $key;
                            $wwcc_chk->wwcc_no = $value['wwcc_no'];
                            $wwcc_chk->expiry_date = $value['wwcc_expiry'];
                            $wwcc_chk->wwcc_doc = $doc_path;
                            $wwcc_chk->is_valid = 3;
                            $wwcc_chk->generate_from = 1;
                            $wwcc_chk->status = 3;
                            if ($wwcc_chk->save()) {
                            }
                        }
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => 'The information has been saved successfully.',
                    'data'  => $taf_save,
                ]);
            }
        }

        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function SaveTutorApplicationFormTab8(Request $request)
    {
        // dd($request->all());
        $tutor_id = '';
        if (auth()->check()) {
            $tutor_id = auth()->user()->id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Logged in & continue',
                'errors'  => '',
            ], 200);
        }

        if (isset($request->form_action) && $request->form_action == 1) {
            return response()->json([
                'status' => true,
                'message' => '',
                'data'  => '',
                'complete'  => 1,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'choose_auth_accept' => 'required',
            'choose_term_accept' => 'required',
        ], [
            'choose_auth_accept.required' => 'Kindly confirm by selecting the checkbox above.',
            'choose_term_accept.required' => 'Kindly confirm by selecting the checkbox above.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 200);
        }

        if (isset($request->form_id) && $request->form_id) {
            $taf_save = TutorApplicationFormsModel::Where('tutor_id', $tutor_id)->Where('id', $request->form_id)->first();
            if ($taf_save && $taf_save->status == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already approved',
                    'errors'  => '',
                ], 200);
            } else if ($taf_save && $taf_save->status == 2) {
                $taf_save = new TutorApplicationFormsModel();
            } else if ($taf_save && $taf_save->status == 3) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Application already submitted',
                    'errors'  => '',
                ], 200);
            }

            if ($taf_save) {
                // $taf_save->tutor_id = $tutor_id;
                $taf_save->choose_auth_accept = $request->choose_auth_accept ?? 1;
                $taf_save->choose_term_accept = $request->choose_term_accept ?? 1;
                $taf_save->status = 3;
                if ($taf_save->save()) {
                    $data['name'] = @$taf_save->first_name . ' ' . @$taf_save->middle_name . ' ' . @$taf_save->last_name;
                    $data['email'] = $taf_save->primary_email;
                    $data['email_subject'] = "V-Tutor – We have received your application!";

                    if (Mail::to($taf_save->primary_email)->send(new TafReceived($data))) {
                    }

                    $adm1_data['name'] = 'Admin';
                    $adm1_data['email'] = 'my.v-tutor@gmail.com';
                    $adm1_data['user_del'] = @$taf_save->first_name . ' ' . @$taf_save->middle_name . ' ' . @$taf_save->last_name;
                    $adm1_data['email_subject'] = "New Application Submitted";
                    if (Mail::to($adm1_data['email'])->send(new TafAdminReceivedNotification($adm1_data))) {
                    }

                    $adm2_data['name'] = 'Academics Admin';
                    $adm2_data['user_del'] = @$taf_save->first_name . ' ' . @$taf_save->middle_name . ' ' . @$taf_save->last_name;
                    $adm2_data['email'] = 'academics.admin@vtutor.zohodesk.com.au';
                    $adm2_data['email_subject'] = "New Application Submitted - " . @$taf_save->first_name . ' ' . @$taf_save->middle_name . ' ' . @$taf_save->last_name;
                    if (Mail::to($adm2_data['email'])->send(new TafAdminReceivedNotification($adm2_data))) {
                    }

                    return response()->json([
                        'status' => true,
                        'complete' => true,
                        'complete_msg' => '<p>Thank you for submitting the responses.</p> <p>Your application will now be assessed by our backend team. You would be notified of the outcome within the next 24-48 hours. Kindly be patient and await an email notification from us. Keep an eye on your email inbox and make sure to check the spam folders.</p> <p>Thanks again for your time and we truly appreciate your interest to apply as a tutor with V-Tutor.</p>',
                        'message' => 'The information has been saved successfully',
                        'data'  => $taf_save,
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => false,
            'message' => 'Please try again later, or contact the administrator for support.',
            'errors'  => '',
        ], 200);
    }

    public function tutorCloseMyAccount(Request $request)
    {
        $password = '';
        if (isset($request->close_acc_pw) && $request->close_acc_pw) {
            $password = @$request->close_acc_pw;
        } else {
            return 4;
        }

        if (Hash::check($password, @Auth()->user()->password)) {
            if (User::where(['id' => @Auth::user()->id])->update(['status' => 'I'])) {
                $get_user = User::Where('id', @Auth::user()->id)->first();
                if ($get_user) {
                    $data['name'] = @$get_user->f_name . ' ' . @$get_user->m_name . ' ' . @$get_user->l_name;
                    $data['email'] = $get_user->email;
                    $data['email_subject'] = "V-Tutor - Notice of Account Closure";

                    Mail::to($get_user->email)->send(new TutorAccountClose($data));
                }

                Auth::logout();

                return 1; // Your V-Tutor account is closed!
            } else {
                return 2; // failed!
            }
        } else {
            return 3; // Wrong Password!
        }
    }

    public function tafIncompleteCron()
    {
        $taf_data = TutorApplicationFormsModel::Where('status', 4)->Where('taf_reminder_count', '<', 2)->orderby('id', 'desc')->get();
        // dd($taf_data);
        if (count($taf_data) != 0) {
            // Log::info('In complete Application - Cron Start Time - ' . date('d-M-Y h:i A'));

            foreach ($taf_data as $key => $value) {
                $af_1_day = Carbon::parse($value->created_at)->addDay();
                // dd($value->created_at, date('Y-m-d'), $af_1_day, date('Y-m-d', strtotime($af_1_day)), $af_3_day);

                if ((date('Y-m-d', strtotime($af_1_day)) < date('Y-m-d')) && $value->taf_reminder_count == 0) {
                    // dd(date('Y-m-d', strtotime($end_date)), date('Y-m-d'));
                    $data['name'] = @$value->first_name . ' ' . @$value->middle_name . ' ' . @$value->last_name;
                    $data['email'] = $value->primary_email;
                    $data['email_subject'] = "Reminder: Complete Your Tutor Application";

                    if (Mail::to($value->primary_email)->send(new TafIncompleteReminder($data))) {
                        $update_cnt['taf_reminder_count'] = 1;
                        $update_cnt['taf_reminder_date'] = date('Y-m-d');
                        if (TutorApplicationFormsModel::where('id', $value->id)->update($update_cnt)) {
                        }
                    }
                }

                $srt_date = Carbon::parse(date('Y-m-d', strtotime($value->created_at)))->subDay();
                if ($value->taf_reminder_date) {
                    $srt_date = date('Y-m-d', strtotime($value->taf_reminder_date));
                }

                $end_date = Carbon::parse($srt_date)->addDays(2);

                $af_3_day = Carbon::parse($value->created_at)->addDays(3);

                if (date('Y-m-d', strtotime($af_3_day)) < date('Y-m-d')) {
                    // dd(date('Y-m-d', strtotime($end_date)), date('Y-m-d'));
                    $data['name'] = @$value->first_name . ' ' . @$value->middle_name . ' ' . @$value->last_name;
                    $data['email'] = $value->primary_email;
                    $data['email_subject'] = "Reminder: Complete Your Tutor Application";

                    if (Mail::to($value->primary_email)->send(new TafIncompleteReminder($data))) {
                        $update_cnt['taf_reminder_count'] = (int) $value->taf_reminder_count + 1;
                        $update_cnt['taf_reminder_date'] = date('Y-m-d');
                        if (TutorApplicationFormsModel::where('id', $value->id)->update($update_cnt)) {
                        }
                    }
                }
            }

            // Log::info('In complete Application - Cron End Time - ' . date('d-M-Y h:i A'));
        }
    }

    public function tafWWCCExpiredCron()
    {
        $exist_taf = TutorApplicationFormsModel::selectRaw('MIN(id) as id')
            ->Where('status', '!=', 2)
            ->groupBy('tutor_id')
            ->pluck('id')
            ->toArray();
        if (count($exist_taf) != 0) {
            $taf_wwcc_data = TutorWWCCModel::WhereIn('tutor_app_id', $exist_taf)->Where('expiry_date', '<', date('Y-m-d'))->orderby('id', 'desc')->get();
            // dd($taf_wwcc_data);
            if (count($taf_wwcc_data) != 0) {
                //  Log::info('WWCC Expired - Cron Start Time - ' . date('d-M-Y h:i A'));

                foreach ($taf_wwcc_data as $key => $value) {
                    if ($value->wwcc_expired_reminder_count > 0) {
                    } else {
                        $data['name'] = @$value->getTutorForm->first_name . ' ' . @$value->getTutorForm->middle_name . ' ' . @$value->getTutorForm->last_name;
                        $data['email'] = @$value->getTutorForm->primary_email;
                        $data['email_subject'] = "Reminder: Your WWCC Expired";
                        $data['state'] = @$value->states ? config('tutor_form.australian_states')[@$value->states] : 'Australian ';
                        $data['wwcc_no'] = @$value->wwcc_no;
                        $data['expiry_date'] = @$value->expiry_date;

                        if (Mail::to(@$value->getTutorForm->primary_email)->send(new TafWWCCExpired($data))) {
                            $update_cnt['wwcc_expired_reminder_count'] = (int) @$value->wwcc_expired_reminder_count + 1;
                            $update_cnt['wwcc_expired_reminder_date'] = date('Y-m-d');
                            $update_cnt['is_valid'] = 2;
                            if (TutorWWCCModel::where('id', $value->id)->update($update_cnt)) {
                                // $all_wwcc = TutorWWCCModel::Where('tutor_id', $value->tutor_id)->Where('tutor_app_id', $value->tutor_app_id)->get();
                                $chk_wwcc = TutorWWCCModel::Where('tutor_id', $value->tutor_id)->Where('tutor_app_id', $value->tutor_app_id)->Where('is_valid', 1)->first();
                                if (!$chk_wwcc) {
                                    $update_user['status'] = "I";
                                    if (User::where('id', $value->tutor_id)->update($update_user)) {
                                        // echo $value->id;
                                    }
                                }
                            }
                        }
                    }
                }

                //  Log::info('WWCC Expired - Cron End Time - ' . date('d-M-Y h:i A'));
            }
        }
    }

    public function tafReminderWWCCExpireCron()
    {
        $exist_taf = TutorApplicationFormsModel::selectRaw('MIN(id) as id')
            ->Where('status', '!=', 2)
            ->groupBy('tutor_id')
            ->pluck('id')
            ->toArray();
        if (count($exist_taf) != 0) {
            $taf_wwcc_data = TutorWWCCModel::WhereIn('tutor_app_id', $exist_taf)->Where('expiry_date', '>=', date('Y-m-d'))->orderby('id', 'desc')->get();
            // dd($taf_wwcc_data);
            if (count($taf_wwcc_data) != 0) {
                // Log::info('WWCC Expire Reminder - Cron Start Time - ' . date('d-M-Y h:i A'));

                foreach ($taf_wwcc_data as $key => $value) {
                    if (isset($value->expiry_date) && $value->expiry_date) {
                        $expiry_date = @$value->expiry_date;
                        $mn_exp = Carbon::parse($expiry_date)->subDays(30);
                        $wk_exp = Carbon::parse($expiry_date)->subDays(7);
                        $dy_exp = Carbon::parse($expiry_date)->subDay();

                        $data['name'] = @$value->getTutorForm->first_name . ' ' . @$value->getTutorForm->middle_name . ' ' . @$value->getTutorForm->last_name;
                        $data['email'] = @$value->getTutorForm->primary_email;
                        $data['email_subject'] = "Reminder: Your Working With Children Check (WWCC) is Expiring Soon";
                        $data['state'] = @$value->states ? config('tutor_form.australian_states')[@$value->states] : 'Australian ';
                        $data['wwcc_no'] = @$value->wwcc_no;
                        $data['expiry_date'] = @$value->expiry_date;

                        if (date('Y-m-d', strtotime($mn_exp)) < date('Y-m-d')) {
                            if ($value->wwcc_expiry_reminder_count > 0) {
                            } else {
                                if (Mail::to(@$value->getTutorForm->primary_email)->send(new TafWWCCExpireReminder($data))) {
                                    $update_cnt['wwcc_expiry_reminder_count'] = (int) @$value->wwcc_expiry_reminder_count + 1;
                                    $update_cnt['wwcc_expiry_reminder_date'] = date('Y-m-d');
                                    if (TutorWWCCModel::where('id', $value->id)->update($update_cnt)) {
                                    }
                                }
                            }
                        }

                        if (date('Y-m-d', strtotime($wk_exp)) < date('Y-m-d')) {
                            if ($value->wwcc_expiry_reminder_count > 1) {
                            } else {
                                if (Mail::to(@$value->getTutorForm->primary_email)->send(new TafWWCCExpireReminder($data))) {
                                    $update_cnt['wwcc_expiry_reminder_count'] = (int) @$value->wwcc_expiry_reminder_count + 1;
                                    $update_cnt['wwcc_expiry_reminder_date'] = date('Y-m-d');
                                    if (TutorWWCCModel::where('id', $value->id)->update($update_cnt)) {
                                    }
                                }
                            }
                        }

                        if (date('Y-m-d', strtotime($dy_exp)) < date('Y-m-d')) {
                            if ($value->wwcc_expiry_reminder_count > 2) {
                            } else {
                                if (Mail::to(@$value->getTutorForm->primary_email)->send(new TafWWCCExpireReminder($data))) {
                                    $update_cnt['wwcc_expiry_reminder_count'] = (int) @$value->wwcc_expiry_reminder_count + 1;
                                    $update_cnt['wwcc_expiry_reminder_date'] = date('Y-m-d');
                                    if (TutorWWCCModel::where('id', $value->id)->update($update_cnt)) {
                                    }
                                }
                            }
                        }
                    }
                }

                //  Log::info('WWCC Expire Reminder - Cron End Time - ' . date('d-M-Y h:i A'));
            }
        }
    }



    public function zoomMeetingNotificationCron()
    {
        $nowUtc = Carbon::now('UTC');
        Log::info("🚀 [ZoomCron] Started at {$nowUtc->toDateTimeString()} UTC");

        // 1️⃣ Mark as read after 2 days
        \App\Models\AppNotification::where('read', false)
            ->where('created_at', '<', now()->subDays(2)->startOfDay())
            ->update(['read' => true]);

        // 2️⃣ Delete after 30 days
        \App\Models\AppNotification::where('created_at', '<', now()->subDays(5))
            ->delete();

        // Fetch upcoming or current-day classes
        $bookings = StudentClassBooking::with(['getStudent', 'getTutor', 'getSubject', 'getTopicDetails.getTopic'])->where('booking_status', 'B')
            ->whereDate('booking_date', '>=', $nowUtc->toDateString())
            ->get();

        Log::info("📚 [ZoomCron] Found {$bookings->count()} bookings for today or later");

        foreach ($bookings as $booking) {
            try {
                $classStartUtc = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC');
                $minutesToClass = $nowUtc->diffInMinutes($classStartUtc, false);

                Log::info("🕒 [ZoomCron] Booking {$booking->booking_no}: {$minutesToClass} minutes until class");

                // Skip if class already started or passed
                // if ($minutesToClass <= 0) {
                if ($minutesToClass < 0) {
                    Log::info("⏭️ [ZoomCron] Skipped {$booking->booking_no} — class already started/past");
                    continue;
                }

                $testIntervals = range(780, 0, -2); // every 2 min from 10 hours before
                // $liveIntervals = [30, 15, 10, 5, 2];
                $liveIntervals = [60, 30, 15, 5, 0];

                $triggerIntervals = $liveIntervals;

                // ⏳ Only send notifications for defined intervals
                if (!in_array($minutesToClass, $triggerIntervals)) {
                    Log::info("⏭️ [ZoomCron] Skipped {$booking->booking_no} — not a trigger interval");
                    continue;
                }

                // Build remaining time text
                $hours = intdiv($minutesToClass, 60);
                $mins = $minutesToClass % 60;
                $remainingText = ($hours > 0 ? "{$hours} hr " : '') . ($mins > 0 ? "{$mins} min" : '');

                $zoom_user = ZoomUser::Where('tutor_id', $booking->tutor_id)->first();

                // ==========================
                // Notify Student
                // ==========================
                if ($booking->getStudent && $booking->getStudent->fcmTokens->count() > 0) {
                    $student = $booking->getStudent;
                    $studentTz = $student->timezone_id ?? 'UTC';
                    $localTime = $classStartUtc->copy()->setTimezone($studentTz)->format('h:i A');

                    $bookingNo   = $booking->booking_no ?? 'N/A';
                    $tutorName   = $booking->getTutor->f_name ?? 'Tutor';
                    $studentName = $student->f_name ?? 'Student';
                    $subject     = $booking->getSubject->subject ?? 'scheduled subject';
                    $topic = $booking->getTopicDetails?->getTopic?->topics ?? 'the selected topic';

                    // 🔹 Create student session link

                    $link = config('app.url') . "/session/{$student->unique_id}/{$booking->booking_no}";


                    // 🔹 Title
                    $title = "Upcoming Session - Booking #{$bookingNo} with {$tutorName}";

                    // 🔹 Body
                    $tremainingText = trim($remainingText);
                    if($tremainingText) {
                        $body = "Hi {$studentName}, your scheduled session on {$subject} - {$topic} will begin in {$remainingText} at {$localTime} ({$studentTz})";
                    } else {
                        $body = "Hi {$studentName}, your scheduled session on {$subject} - {$topic} will begin {$localTime} ({$studentTz})";
                    }

                    //  Add link only if 5 minutes before
                   // if ($minutesToClass <= 5) {
                        //$body .= " Join here: {$link}";
                   // }

                    $notification = \App\Models\AppNotification::create([
                        'user_id' => $student->id, // or $tutor->id
                        'type' => 'class_reminder',
                        'title' => $title,
                        'body' => $body,
                        
                    ]);
                    $extraData = [
                        'notification_id' => $notification->id,
                        'type' => 'class_reminder',
                        'booking_no' => $bookingNo,
                        'student_name' => $studentName,
                        'tutor_name' => $tutorName,
                        'subject' => $subject,
                        'topic' => $topic,
                        'link' => $link,
                    ];
                    if (!empty($student->email)) {
                        $mailData = [
                            'email' => $student->email,
                            'student_name' => $student->f_name,
                            'parent_name' => $student->parent_f_name,
                            'tutor_name' => $tutorName,
                            'subject' => $subject,
                            'topic' => $topic,
                            'booking_no' => $bookingNo,
                            'class_time' => $localTime . " ({$studentTz})",
                            'remaining_time' => $remainingText,
                            'join_link' => $link,
                            'pmi' => @$zoom_user->pmi,
                            // 'email_subject' => "Reminder: Your {$subject} class starts in {$remainingText}",
                            'email_subject' => "V-Tutor - Upcoming Session Reminder - {$bookingNo}",
                        ];

                        if ($minutesToClass === 60) {
                            Mail::send(new zoomMeetingReminderBeforeOneHour($mailData));
                            Log::info("📧 [ZoomCron] Email sent to student {$student->email} for booking {$bookingNo}");
                        }
                    }

                    foreach ($student->fcmTokens as $tokenRecord) {
                        FirebaseHelper::sendPushNotification(
                            $tokenRecord->fcm_token,
                            $title,
                            $body,
                            $link,
                            $student,
                            $tokenRecord,
                            $extraData
                        );
                    }

                    Log::info("🎓 [ZoomCron] Student {$studentName} notified — {$remainingText} left for booking {$bookingNo}");
                } else {
                    Log::warning("⚠️ [ZoomCron] Student missing or has no FCM tokens for booking {$booking->booking_no}");
                }

                // ==========================
                // Notify Tutor
                // ==========================
                if ($booking->getTutor && $booking->getTutor->fcmTokens->count() > 0) {
                    $tutor = $booking->getTutor;
                    $tutorTz = $tutor->timezone_id ?? 'UTC';
                    $localTime = $classStartUtc->copy()->setTimezone($tutorTz)->format('h:i A');

                    $bookingNo   = $booking->booking_no ?? 'N/A';
                    $tutorName   = $tutor->f_name ?? 'Tutor';
                    $studentName = $booking->getStudent->f_name ?? 'Student';
                    $subject     = $booking->getSubject->subject ?? 'the scheduled subject';
                    $topic = $booking->getTopicDetails?->getTopic?->topics ?? 'the selected topic';


                    // 🔹 Create tutor join link
                    $link = config('app.url') . "/tutor-session/{$tutor->unique_id}/{$booking->booking_no}";
                    // 🔹 Title
                    $title = "Upcoming Session - Booking #{$bookingNo} with {$studentName}";

                    // 🔹 Body
                    $body = "Hi {$tutorName}, your scheduled session on {$subject} - {$topic} will begin in {$remainingText} at {$localTime} ({$tutorTz})";


                    // 🔹 Add link only if 5 minutes before
                    //if ($minutesToClass <= 5 && $link) {
                        //$body .= " Join here: {$link}";
                    //}


                    $tutornotification = \App\Models\AppNotification::create([
                        'user_id' => $tutor->id, // or $tutor->id
                        'type' => 'class_reminder',
                        'title' => $title,
                        'body' => $body,
                        
                    ]);

                    $extraData = [
                        'notification_id' => $tutornotification->id,
                        'type' => 'class_reminder',
                        'booking_no' => $bookingNo,
                        'student_name' => $studentName,
                        'tutor_name' => $tutorName,
                        'subject' => $subject,
                        'topic' => $topic,
                        'link' => $link,
                    ];
                    if (!empty($tutor->email)) {
                        $mailData = [
                            'email' => $tutor->email,
                            'tutor_name' => $tutor->f_name,
                            'student_name' => $studentName,
                            'subject' => $subject,
                            'topic' => $topic,
                            'booking_no' => $bookingNo,
                            'class_time' => $localTime . " ({$tutorTz})",
                            'remaining_time' => $remainingText,
                            'join_link' => $link,
                            'pmi' => @$zoom_user->pmi,
                            // 'email_subject' => "Reminder: Your {$subject} class with {$studentName} starts in {$remainingText}",
                            'email_subject' => "Reminder: Upcoming Tutoring Session at {$mailData['class_time']}",
                        ];

                        if ($minutesToClass === 60) {
                            Mail::send(new zoomMeetingReminderTutorBeforeOneHour($mailData));
                            Log::info("📧 [ZoomCron] Email sent to tutor {$tutor->email} for booking {$bookingNo}");
                        }                        
                    }


                    foreach ($tutor->fcmTokens as $tokenRecord) {
                        FirebaseHelper::sendPushNotification(
                            $tokenRecord->fcm_token,
                            $title,
                            $body,
                            $tutor,
                            $tokenRecord,
                            $extraData
                        );
                    }

                    Log::info("👨‍🏫 [ZoomCron] Tutor {$tutorName} notified — {$remainingText} left for booking {$bookingNo}");
                } else {
                    Log::warning("⚠️ [ZoomCron] Tutor missing or has no FCM tokens for booking {$booking->booking_no}");
                }
            } catch (\Exception $e) {
                Log::error("💥 [ZoomCron] Error processing booking {$booking->booking_no}: " . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Log::info("✅ [ZoomCron] Completed at " . Carbon::now('UTC')->toDateTimeString());
    }




    // public function zoomMeetingNotificationCron() {
    //     $nowUtc = Carbon::now('UTC');

    //     $bookings = StudentClassBooking::with(['getStudent', 'getTutor'])
    //         ->whereDate('booking_date', '>=', $nowUtc->toDateString())
    //         ->get();
    //     // dd($bookings);

    //     if(count($bookings) != 0) {
    //       //  Log::info('zoom Meeting Notification Befor 1hr - Cron Start Time - ' . date('d-M-Y h:i A'));
    //         foreach ($bookings as $booking) {
    //             // Combine booking_date + from_time
    //             $classStartUtc = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC');
    //             $book_time = $classStartUtc->format('Y-m-d H:i');

    //             $bookTimeUtc   = Carbon::parse($book_time, 'UTC');
    //             $before1hrUtc  = $bookTimeUtc->copy()->subHour();
    //             $before_1hr_bt  = $before1hrUtc->format('Y-m-d H:i');

    //             $bookTime20Utc   = Carbon::parse($before_1hr_bt, 'UTC');
    //             $before1hr20Utc  = $bookTime20Utc->copy()->addMinute(20);
    //             $before_1hr_bt_af_20min  = $before1hr20Utc->format('Y-m-d H:i');
    //             $nowUtc = Carbon::now('UTC')->format('Y-m-d H:i');
    //             // dd($book_time, $before_1hr_bt, $before_1hr_bt_af_20min, $nowUtc);
    //             /* echo 'book_time: '.$book_time;
    //             echo '<br>';
    //             echo 'before_1hr_bt: '.$before_1hr_bt;
    //             echo '<br>';
    //             echo 'before_1hr_bt_af_20min: '.$before_1hr_bt_af_20min;
    //             echo '<br>';
    //             echo 'nowUtc: '.$nowUtc;
    //             echo '<br>'; */

    //             if ($before_1hr_bt <= $nowUtc && $before_1hr_bt_af_20min >= $nowUtc) {
    //                 // Notify Student
    //                 if ($booking->getStudent) {
    //                     $tz = $booking->getStudent->timezone_id ?? 'UTC';
    //                     $meetingTime = $classStartUtc->copy()->setTimezone($tz)->format('Y-m-d H:i');
    //                     $st_meetingTime = $meetingTime;

    //                     $st_bookTimeUtc   = Carbon::parse($st_meetingTime, $tz);
    //                     $st_before1hrUtc  = $st_bookTimeUtc->copy()->subHour();
    //                     $st_mt_before_1hr  = $st_before1hrUtc->format('Y-m-d H:i');

    //                     $st_bookTime20Utc   = Carbon::parse($st_mt_before_1hr, $tz);
    //                     $st_before1hr20Utc  = $st_bookTime20Utc->copy()->addMinute(20);
    //                     $st_mt_before_1hr_af_20min  = $st_before1hr20Utc->format('Y-m-d H:i');
    //                     $st_nowUtc = Carbon::now($tz)->format('Y-m-d H:i');

    //                     $message = "Your class will start at {$meetingTime} ({$tz})";

    //                     /* echo 'st_meetingTime: '.$st_meetingTime;
    //                     echo '<br>';
    //                     echo 'st_mt_before_1hr: '.$st_mt_before_1hr;
    //                     echo '<br>';
    //                     echo 'st_mt_before_1hr_af_20min: '.$st_mt_before_1hr_af_20min;
    //                     echo '<br>';
    //                     echo 'st_nowUtc: '.$st_nowUtc;
    //                     echo '<br>'; */
    //                     // dd($book_time, $before_1hr_bt, $before_1hr_bt_af_20min, $nowUtc, $message, $st_meetingTime, $st_mt_before_1hr, $st_mt_before_1hr_af_20min, $st_nowUtc);
    //                     $tutor_time  = date('h:i A', strtotime($st_meetingTime));
    //                     /* $tut_tz = $booking->getTutor->timezone_id ?? 'UTC';
    //                     $st_m_time_tz = Carbon::parse($book_time, $tut_tz);
    //                     $tutor_time  = $st_m_time_tz->format('h:i A'); */

    //                     $st_data['name'] = @$booking->getStudent->f_name.' '. @$booking->getStudent->m_name.' '. @$booking->getStudent->l_name;
    //                     $st_data['tutor_name'] = @$booking->getTutor->f_name.' '. @$booking->getTutor->m_name.' '. @$booking->getTutor->l_name;
    //                     $st_data['booking_date'] = @$booking->booking_date;
    //                     $st_data['tutor_time'] = @$tutor_time;
    //                     $st_data['tutor_tz'] = $tz;
    //                     $st_data['email'] = @$booking->getStudent->email;
    //                     $st_data['email_subject'] = "Reminder: Your session starts in 1 hour";
    //                     $st_data['zoom_link'] = @$booking->short_url;
    //                     // dd($st_data);

    //                     if ($st_mt_before_1hr <= $st_nowUtc && $st_mt_before_1hr_af_20min >= $st_nowUtc) {
    //                         if($booking->getStudent->zoom_meet_onehr_cnt == 0) {
    //                             if(Mail::to(@$booking->getStudent->email)->send(new zoomMeetingReminderBeforeOneHour($st_data))) {
    //                                 $update_cnt['zoom_meet_onehr_cnt'] = 1;
    //                                 $update_cnt['zoom_meet_onehr_time'] = date('Y-m-d h:i:s');
    //                                 if(User::where('id',$booking->getStudent->id)->update($update_cnt)) {}
    //                             }
    //                         }
    //                     }



    //                     if ($st_meetingTime < $st_nowUtc) {
    //                         $rp_update_cnt['zoom_meet_onehr_cnt'] = 0;
    //                         $rp_update_cnt['zoom_meet_five_min_cnt'] = 0;
    //                         $rp_update_cnt['zoom_meet_onehr_time'] = NULL;
    //                         if(User::where('id',$booking->getStudent->id)->update($rp_update_cnt)) {}
    //                     }
    //                 }

    //                 // Notify Tutor
    //                 if ($booking->getTutor) {
    //                     $tut_tz = $booking->getTutor->timezone_id ?? 'UTC';
    //                     $meetingTime = $classStartUtc->copy()->setTimezone($tut_tz)->format('Y-m-d H:i');
    //                     $tut_meetingTime = $meetingTime;

    //                     $tut_bookTimeUtc   = Carbon::parse($tut_meetingTime, $tut_tz);
    //                     $tut_before1hrUtc  = $tut_bookTimeUtc->copy()->subHour();
    //                     $tut_mt_before_1hr  = $tut_before1hrUtc->format('Y-m-d H:i');

    //                     $tut_bookTime20Utc   = Carbon::parse($tut_mt_before_1hr, $tut_tz);
    //                     $tut_before1hr20Utc  = $tut_bookTime20Utc->copy()->addMinute(20);
    //                     $tut_mt_before_1hr_af_20min  = $tut_before1hr20Utc->format('Y-m-d H:i');
    //                     $tut_nowUtc = Carbon::now($tut_tz)->format('Y-m-d H:i');

    //                     $message = "Your class will start at {$meetingTime} ({$tut_tz})";

    //                     /* echo 'tut_meetingTime: '.$tut_meetingTime;
    //                     echo '<br>';
    //                     echo 'tut_mt_before_1hr: '.$tut_mt_before_1hr;
    //                     echo '<br>';
    //                     echo 'tut_mt_before_1hr_af_20min: '.$tut_mt_before_1hr_af_20min;
    //                     echo '<br>';
    //                     echo 'tut_nowUtc: '.$tut_nowUtc;
    //                     echo '<br>'; */
    //                     // dd($book_time, $before_1hr_bt, $before_1hr_bt_af_20min, $nowUtc, $message, $tut_meetingTime, $tut_mt_before_1hr, $tut_mt_before_1hr_af_20min, $tut_nowUtc);
    //                     $st_time  = date('h:i A', strtotime($tut_meetingTime));
    //                     /* $st_tz = $booking->getStudent->timezone_id ?? 'UTC';
    //                     $st_m_time_tz = Carbon::parse($book_time, $st_tz);
    //                     $st_time  = $st_m_time_tz->format('h:i A'); */

    //                     $tut_data['name'] = @$booking->getTutor->f_name.' '. @$booking->getTutor->m_name.' '. @$booking->getTutor->l_name;
    //                     $tut_data['st_name'] = @$booking->getStudent->f_name.' '. @$booking->getStudent->m_name.' '. @$booking->getStudent->l_name;
    //                     $tut_data['booking_date'] = @$booking->booking_date;
    //                     $tut_data['st_time'] = @$st_time;
    //                     $tut_data['st_tz'] = $tut_tz;
    //                     $tut_data['email'] = @$booking->getTutor->email;
    //                     $tut_data['email_subject'] = "Reminder: Your session with ".@$tut_data['st_name']." starts in 1 hour";
    //                     $tut_data['zoom_link'] = @$booking->short_url;

    //                     if ($tut_mt_before_1hr <= $tut_nowUtc && $tut_mt_before_1hr_af_20min >= $tut_nowUtc) {
    //                         if($booking->getTutor->zoom_meet_onehr_cnt == 0) {
    //                             if(Mail::to(@$booking->getTutor->email)->send(new zoomMeetingReminderTutorBeforeOneHour($tut_data))) {
    //                                 $update_cnt['zoom_meet_onehr_cnt'] = 1;
    //                                 $update_cnt['zoom_meet_onehr_time'] = date('Y-m-d h:i:s');
    //                                 if(User::where('id',$booking->getTutor->id)->update($update_cnt)) {}
    //                             }
    //                         }
    //                     }

    //                     if ($tut_meetingTime < $tut_nowUtc) {
    //                         $rp_update_cnt['zoom_meet_onehr_cnt'] = 0;
    //                         $rp_update_cnt['zoom_meet_five_min_cnt'] = 0;
    //                         $rp_update_cnt['zoom_meet_onehr_time'] = NULL;
    //                         if(User::where('id',$booking->getTutor->id)->update($rp_update_cnt)) {}
    //                     }
    //                 }
    //             }
    //         }
    //      //   Log::info('zoom Meeting Notification Befor 1hr - Cron End Time - ' . date('d-M-Y h:i A'));
    //     }
    // }

    public function checkStudentZoomMeeting()
    {
        $nowtUtc = Carbon::now('UTC')->format('Y-m-d H:i');
        if (auth()->check()) {
            if (auth()->user()->user_type == "U") {
                $student_id = auth()->user()->id;
                $nowUtc = Carbon::now('UTC');

                $bookings = StudentClassBooking::with(['getStudent', 'getTutor'])
                    ->whereDate('booking_date', '>=', $nowUtc->toDateString())
                    ->where('student_id', $student_id)
                    ->get();
                // dd($bookings);

                if (count($bookings) != 0) {
                    foreach ($bookings as $booking) {
                        if ($booking->getStudent->zoom_meet_five_min_cnt == 0) {
                            $classStartUtc = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC');
                            $book_time = $classStartUtc->format('Y-m-d H:i');

                            $bookTimeUtc   = Carbon::parse($book_time, 'UTC');
                            $before5minUtc  = $bookTimeUtc->copy()->subMinutes(5);
                            $before_5min_bt  = $before5minUtc->format('Y-m-d H:i');
                            $nowUtc = Carbon::now('UTC')->format('Y-m-d H:i');
                            // dd($book_time, $before_5min_bt, $nowUtc);
                            if ($before_5min_bt <= $nowUtc && $book_time >= $nowUtc) {
                                // dd($book_time, $before_5min_bt, $nowUtc);
                                // Notify Student
                                if ($booking->getStudent) {
                                    $tz = $booking->getStudent->timezone_id ?? 'UTC';
                                    $meetingTime = $classStartUtc->copy()->setTimezone($tz)->format('Y-m-d H:i');
                                    $st_meetingTime = $meetingTime;

                                    $st_bookTimeUtc   = Carbon::parse($st_meetingTime, $tz);
                                    $st_before5minUtc  = $st_bookTimeUtc->copy()->subMinutes(5);
                                    $st_mt_before_5min  = $st_before5minUtc->format('Y-m-d H:i');
                                    $st_nowUtc = Carbon::now($tz)->format('Y-m-d H:i');

                                    $tut_tz = $booking->getTutor->timezone_id ?? 'UTC';
                                    $st_m_time_tz = Carbon::parse($st_meetingTime, $tut_tz);
                                    $st_m_time  = $st_m_time_tz->format('d M Y h:i A');
                                    // dd($st_meetingTime, $st_mt_before_5min, $st_nowUtc);
                                    if ($st_mt_before_5min <= $st_nowUtc && $st_meetingTime >= $st_nowUtc) {
                                        $update_cnt['zoom_meet_five_min_cnt'] = 1;
                                        if (User::where('id', $booking->getStudent->id)->update($update_cnt)) {
                                            $rlt = array(
                                                'name' => @$booking->getTutor->f_name . ' ' . @$booking->getTutor->m_name . ' ' . @$booking->getTutor->l_name,
                                                'time' => @$st_m_time,
                                                'timezone' => $tut_tz,
                                                'zoom_link' => @$booking->short_url,
                                            );
                                            return response()->json(['status' => true, 'data' => $booking, 'rlt' => $rlt]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json(['status' => false, 'nowUtc' => $nowtUtc]);
    }

    public function checkTutorZoomMeeting()
    {
        $nowtUtc = Carbon::now('UTC')->format('Y-m-d H:i');
        if (auth()->check()) {
            if (auth()->user()->user_type == "T") {
                $tutor_id = auth()->user()->id;
                $nowUtc = Carbon::now('UTC');

                $bookings = StudentClassBooking::with(['getStudent', 'getTutor'])
                    ->whereDate('booking_date', '>=', $nowUtc->toDateString())
                    ->where('tutor_id', $tutor_id)
                    ->get();
                // dd($bookings);

                if (count($bookings) != 0) {
                    foreach ($bookings as $booking) {
                        if ($booking->getTutor->zoom_meet_five_min_cnt == 0) {
                            $classStartUtc = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC');
                            $book_time = $classStartUtc->format('Y-m-d H:i');

                            $bookTimeUtc   = Carbon::parse($book_time, 'UTC');
                            $before5minUtc  = $bookTimeUtc->copy()->subMinutes(5);
                            $before_5min_bt  = $before5minUtc->format('Y-m-d H:i');
                            $nowUtc = Carbon::now('UTC')->format('Y-m-d H:i');

                            // dd($book_time, $before_5min_bt, $nowUtc);
                            if ($before_5min_bt <= $nowUtc && $book_time >= $nowUtc) {
                                // Notify Tutor
                                if ($booking->getTutor) {
                                    $tz = $booking->getTutor->timezone_id ?? 'UTC';
                                    $meetingTime = $classStartUtc->copy()->setTimezone($tz)->format('Y-m-d H:i');
                                    $st_meetingTime = $meetingTime;

                                    $st_bookTimeUtc   = Carbon::parse($st_meetingTime, $tz);
                                    $st_before5minUtc  = $st_bookTimeUtc->copy()->subMinutes(5);
                                    $st_mt_before_5min  = $st_before5minUtc->format('Y-m-d H:i');
                                    $st_nowUtc = Carbon::now($tz)->format('Y-m-d H:i');

                                    $st_tz = $booking->getStudent->timezone_id ?? 'UTC';
                                    $st_m_time_tz = Carbon::parse($st_meetingTime, $st_tz);
                                    $st_m_time  = $st_m_time_tz->format('d M Y h:i A');

                                    if ($st_mt_before_5min <= $st_nowUtc && $st_meetingTime >= $st_nowUtc) {
                                        $update_cnt['zoom_meet_five_min_cnt'] = 1;
                                        if (User::where('id', $booking->getTutor->id)->update($update_cnt)) {
                                            $rlt = array(
                                                'name' => @$booking->getStudent->f_name . ' ' . @$booking->getStudent->m_name . ' ' . @$booking->getStudent->l_name,
                                                'time' => @$st_m_time,
                                                'timezone' => $st_tz,
                                                'zoom_link' => @$booking->short_url,
                                            );
                                            return response()->json(['status' => true, 'data' => $booking, 'rlt' => $rlt]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json(['status' => false, 'nowUtc' => $nowtUtc]);
    }

    public function redirectZoomMeeting($code)
    {
        $id = base64_decode($code);

        $meeting = StudentClassBooking::findOrFail($id);

        return redirect()->away($meeting->join_url);
    }
}
