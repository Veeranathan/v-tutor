<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Laravel\Socialite\Two\FacebookProvider;
use Laravel\Socialite\Facades\Socialite;
// use Socialite;
use App\Models\User;
use App\Models\TutorApplicationFormsModel;
use App\Models\LearningProgramAssessment;
use App\Models\LearningProgramAssessmentQuestion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Two\GoogleProvider;
use SocialiteProviders\Microsoft\Provider as MicrosoftProvider;




use Cache;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function credentials(Request $request)
    {

        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => ['A', 'I', 'U', 'AA']];
    }





    protected function authenticated(Request $request, $user)
    {

        // return $user;
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(720);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
        }

        $actvUser = User::where(['email' => $user->email, 'password' => $user->password])->whereIn('status', ['A', 'AA', 'U'])->first();
        // dd($actvUser);
        if ($actvUser) {
            //dd($actvUser);

            if ($actvUser->status == 'AA') {
                if ($actvUser->user_type == 'T') {
                    Auth::login($actvUser);

                    if (Auth::check()) {
                        $expiresAt = Carbon::now()->addMinutes(720);
                        Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
                    }

                    $taf_data = TutorApplicationFormsModel::Where('tutor_id', $actvUser->id)->orderby('id', 'desc')->first();
                    // dd($taf_data);
                    if ($taf_data) {
                        if ($taf_data && $taf_data->status == 1) {
                            // return redirect()->route('teacher.profile');
                            return redirect()->route('tutor_landing')->with('error', 'Congrats! Your application is conditionally accepted. You may log into access your profile, with full access granted after approval.');
                        } else if ($taf_data && $taf_data->status == 2) {
                            return redirect()->route('tutor_landing')->with('error', 'We regret to inform you that your application does not meet our current selection criteria. You may reapply once you meet the requirements.');
                        } else if ($taf_data && $taf_data->status == 3) {
                            return redirect()->route('tutor_landing')->with('error', 'Your application has already been submitted. Please wait 24-48 hours to hear back from our team.');
                        } else if ($taf_data && $taf_data->status == 4) {
                            return redirect()->route('tutor_landing')->with('error', 'Your tutor application is currently in progress. Please proceed to complete and submit your application. Any issues, contact us at be-a-tutor@v-tutor.com.au’');
                        } else {
                            return redirect()->route('tutor_landing');
                            // ->with('error', 'Our records indicate that your tutor application is currently in progress. Please proceed to complete and submit your application. If you encounter any issues, contact us at be-a-tutor@v-tutor.com.au')
                        }
                    } else {
                        return redirect()->route('tutor_landing');
                    }

                    // return redirect()->route('teacher.profile');
                }
            }


            if ($actvUser->status == 'U') {
                if ($actvUser->user_type == 'T') {
                    $this->guard()->logout();
                    $request->session()->invalidate();
                    session(['userDtls' => $actvUser]);
                    // session()->flash('error', 'Teacher not active, contact Admin');
                    return redirect()->route('login')->with('error', 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.');
                } else {
                    $this->guard()->logout();
                    $request->session()->invalidate();
                    session(['userDtls' => $actvUser]);
                    // session()->flash('error', 'Teacher not active, contact Admin');
                    return redirect()->route('login')->with('error', 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.');
                }
            }



            if ($actvUser->status == 'A') {

                if ($actvUser->user_type == 'T') {

                    //session()->flash('success', 'login successfully');
                    if ($actvUser->is_login == 0) {
                        Auth::login($actvUser);
                        if (Auth::check()) {
                            $expiresAt = Carbon::now()->addMinutes(720);
                            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
                        }

                        return redirect()->route('teacher.profile')->with('success', "Congrats on your login! Now start building your profile by adding a tutorship plan, your academics, experience and recognitions to get maximum visibility. Don't forget to fill in availability to start your journey as V-Tutor. All the best! For additional support, go to help pages or access 'How to' guides.");
                    } else {
                        Auth::login($actvUser);
                        if (Auth::check()) {
                            $expiresAt = Carbon::now()->addMinutes(720);
                            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
                        }
                        return redirect()->route('teacher.profile');
                    }
                } else {
                    Auth::login($actvUser);
                    if (Auth::check()) {
                        $expiresAt = Carbon::now()->addMinutes(720);
                        Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
                    }
                    // //  Check if student has an assessment in progress
                    // $inProgressAssessment = LearningProgramAssessment::where('student_id', $actvUser->id)
                    // ->where('status', LearningProgramAssessment::STATUS_PROGRESS)
                    // ->latest('id')
                    // ->first();  
                    // if ($inProgressAssessment) {
                    // // Determine the subject for quantitative questions
                    // $subject = $inProgressAssessment->subject; // e.g., English, Maths, Science
                    // // Fetch qualitative questions
                    // $qualitativeQuestions = LearningProgramAssessmentQuestion::where('type', 'qualitative')
                    //      ->orderBy('order')
                    //      ->get();
                    // // Fetch quantitative questions
                    // $quantitativeQuestions = LearningProgramAssessmentQuestion::where('type', 'quantitative')
                    //     ->where('subject', $subject)
                    //     ->orderBy('order')
                    //     ->get();
                    // // Pass questions and subject to assessment route via session
                    // session([
                    //     'assessment' => $inProgressAssessment,
                    //     'qualitativeQuestions' => $qualitativeQuestions,
                    //     'quantitativeQuestions' => $quantitativeQuestions,
                    //     'subject' => $subject,
                    // ]);

                    // return redirect()->route('student.my.assessment');
                    // }
                    $cartItems = session('cart.items', []);
                    if (!empty($cartItems)) {
                        return redirect()->route('cart.index');
                    }
                    return redirect()->route('my.profile');
                }
            }
        } else {

            if ($user->status == 'I' || $user->status == 'D') {
                if ($user->user_type == 'T') {
                    $this->guard()->logout();
                    $request->session()->invalidate();
                    // session()->flash('error', 'Teacher not active, contact Admin');
                    return redirect()->route('login')->with('error', 'Your account is inactive. Please contact support.');
                } else {
                    $this->guard()->logout();
                    $request->session()->invalidate();
                    // session()->flash('error', 'Teacher not active, contact Admin');
                    // return redirect()->route('login')->with('error','User not active, contact Admin');;
                    return redirect()->route('login')->with('error', 'User not active, contact Admin');;
                }
            }
        }
    }


    public function removeFcmToken(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        $token = $request->input('fcm_token');

        if ($token) {
            // Assuming you store FCM tokens in a table related to the user
            $user->fcmTokens()->where('token', $token)->delete();
        }

        return response()->json(['message' => 'FCM token removed successfully']);
    }




    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $this->guard()->logout();
        }

        return redirect()->route('login');
        // }
    }




    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request, $user_type, $provider_type, $login_type = "signin")
    {
        //  Log::info("Redirect to Provider:", [$user_type]);
        if ($user_type == 'user') $user_type = 'student';

        if (isset($request->redirect) && $request->redirect) {
            //  Log::info("im here");
            session()->forget('login_redirect');
            session()->put('login_redirect', $request->redirect);
        }

        if ($provider_type == 'facebook') {
            $config = [
                'client_id' => env('FACEBOOK_CLIENT_ID'),
                'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'redirect' => route('login.social.callback', ['user_type' => $user_type, 'provider_type' => $provider_type]),
            ];

            $provider = Socialite::buildProvider(
                FacebookProvider::class,
                $config
            );
        } else if ($provider_type == 'google') {
            //  Log::info("in Google provider ");
            $config = [
                'client_id' => env('GOOGLE_CLIENT_ID') ? env('GOOGLE_CLIENT_ID') : '255282844224-v7vv3jmuirp52s3atldb1g7lpp0it3rj.apps.googleusercontent.com',
                'client_secret' => env('GOOGLE_CLIENT_SECRET') ? env('GOOGLE_CLIENT_SECRET') : '7gvZ5mD6QIpGCEOKepxf7Hu_',
                'redirect' => route('login.social.callback', ['user_type' => $user_type, 'provider_type' => $provider_type, 'login_type' => $login_type]),
            ];

            $provider = Socialite::buildProvider(
                GoogleProvider::class,
                $config
            );
            return $provider->with(['prompt' => 'select_account'])->redirect();
        } else if ($provider_type == 'microsoft') {
            $config = [
                'client_id'     => env('MICROSOFT_CLIENT_ID'),
                'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
                'redirect'      => env('MICROSOFT_REDIRECT_URI'),
                'tenant'        => env('MICROSOFT_TENANT_ID'), // optional: 'organizations', 'consumers', or your tenant ID
            ];

            $provider = \Laravel\Socialite\Facades\Socialite::buildProvider(MicrosoftProvider::class, $config);
            return $provider->with(['prompt' => 'select_account'])->redirect();
        }


        return $provider->redirect();
    }



    public function handleProviderCallback(Request $request, $user_type = 'student', $provider_type, $login_type = "signin")
    {
        // Log::info("Handle Provider User Type:", [$user_type]);
        $login_redirect = session('login_redirect');
        //Log::info("Handle login_redirect:", [$login_redirect]);

        // 1. Build provider
        if ($provider_type == 'facebook') {
            $config = [
                'client_id' => env('FACEBOOK_CLIENT_ID'),
                'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'redirect' => route('login.social.callback', [
                    'user_type' => $user_type,
                    'provider_type' => $provider_type
                ]),
            ];
            $provider = Socialite::buildProvider(FacebookProvider::class, $config);
        } elseif ($provider_type == 'google') {
            $config = [
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect' => route('login.social.callback', [
                    'user_type' => $user_type,
                    'provider_type' => $provider_type,
                    'login_type' => $login_type
                ]),
            ];
            $provider = Socialite::buildProvider(GoogleProvider::class, $config);
        } else if ($provider_type === 'microsoft') {
            $config = [
                'client_id'     => env('MICROSOFT_CLIENT_ID'),
                'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
                'redirect'      => env('MICROSOFT_REDIRECT_URI'),
                'tenant'        => env('MICROSOFT_TENANT_ID'), // optional: 'organizations', 'consumers', or your tenant ID
            ];

            $provider = \Laravel\Socialite\Facades\Socialite::buildProvider(MicrosoftProvider::class, $config);
        }

        // 2. Get user from provider
        $user = $provider->stateless()->user();
        $splitName = explode(' ', $user->name, 2);
        $first_name = $splitName[0];
        $last_name  = !empty($splitName[1]) ? $splitName[1] : '';

        // Log::info("Social User Email", [@$user->email]);
        // Log::info("Social User ID", [@$user->id]);

        // 3A. Before anything else, check if same email exists with opposite user_type
        if (!empty($user->email)) {
            $oppositeUser = User::where('email', $user->email)->first();
            //  Log::info("Logged in user type", [$oppositeUser->user_type]);

            if ($oppositeUser->user_type == 'T') {
                // stop and show message
                return redirect()->route('login')->with(
                    'error',
                    'This email is already registered as a Tutor. Please log in with the appropriate account.'
                );
            }
        }

        // 3B. Existing user of same type
        $existingUser = User::where(function ($q) use ($user, $user_type) {
            if (!empty($user->email)) {
                $q->where('email', $user->email)
                    ->where('user_type', $user_type == 'student' ? 'U' : 'T')
                    ->whereIn('status', ['AA', 'A', 'I', 'C', 'U']);
            }
        })->orWhere(function ($q) use ($user) {
            $q->where('platform_id', $user->id)
                ->whereIn('status', ['AA', 'A', 'I', 'C', 'U']);
        })->first();

        // 4. If user exists → login directly
        if ($existingUser) {
            Auth::login($existingUser);
            $request->session()->regenerate();

            return $user_type == 'student'
                ? redirect()->intended('/my-profile')
                : redirect()->intended('/tutor/dashboard');
        }

        // 5. Not found → register a new one
        $newUser = new User();
        $newUser->f_name = $first_name;
        $newUser->l_name = $last_name;
        $newUser->email = $user->email;
        $newUser->status = 'A';
        $newUser->user_type = $user_type == 'student' ? 'U' : 'T';
        $newUser->slug = Str::slug($first_name . " " . $last_name);
        $newUser->is_email_verify = "Y";
        $newUser->avatar = $user->avatar;
        $newUser->platform_id = $user->id;
        $newUser->platform_type = $provider_type;
        $newUser->save();

        // update slug & unique id
        $newUser->update([
            'slug' => Str::slug($first_name . " " . $last_name . " " . $newUser->id),
            'unique_id' => ($user_type == 'student' ? 'STU000' : 'TUT000') . $newUser->id,
        ]);

        // 6. Login the new user immediately
        Auth::login($newUser);
        $request->session()->regenerate();

        // 7. Redirect to registration step or dashboard
        if ($user_type == 'student') {
            return redirect()->route('reg.two.view', $newUser->id)
                ->with('success', 'Please fill up following information to complete the sign up process.');
        } else {
            return redirect()->intended('/tutor/dashboard')
                ->with('success', 'Welcome to the platform!');
        }
    }
}
