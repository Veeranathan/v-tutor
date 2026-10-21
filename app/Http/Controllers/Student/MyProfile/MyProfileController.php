<?php

namespace App\Http\Controllers\Student\MyProfile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\State;
use App\Models\School;

use App\Models\AddressSuburbs;
use App\Models\StudentClassBooking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Import Hash facade for checking passwords

class MyProfileController extends Controller
{
    /**
     * Display the user's profile for editing.
     *
     * @return \Illuminate\View\View
     */
    public function my_profile_show(){
        $user = Auth::user();

        // Set timezone in session if user's state has one
        if ($user && $user->state_id && !empty($user->state->time_zone)) {
            session(['timezone' => $user->state->time_zone]);
        }

        // Fetch user data with related school and state information
        $data['user'] = User::with('getSchool.getState')->where('id', Auth()->user()->id)->first();
        $data['state'] = State::orderBy('id', 'asc')->get();

        // Get timezone for display
        $data['timezone'] = $data['user']->state_id
            ? State::where('id', $data['user']->state_id)->value('time_zone')
            : 'Not Set';

        $data['schools'] = School::with(['getState'])->get();

        // Handle first-time login flag
        if (Auth::user()->is_login == 1) {
            session(['is_first' => 1]);
        } else {
            session(['is_first' => 0]);
            User::where('id', Auth()->user()->id)->update(['is_login' => "1"]);
        }

        $bookingDataInformation = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['student_id' => @Auth::user()->id])->first();
        $data['bookingDataInformation'] = $bookingDataInformation;

        return view('student.modules.my_profile.edit_profile')->with($data);
    }

    /**
     * Fetches suburbs and their postcodes based on the provided state ID.
     * This method is designed to be called via AJAX from the frontend.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

  public function getSuburbs(Request $request)
{
    try {
        $request->validate([
            'state_id' => 'required|integer',
            'query' => 'nullable|string', // NEW: Validate the search query
        ]);

        $stateId = $request->input('state_id');
        $query = $request->input('query'); // NEW: Get the search query

        $suburbs = AddressSuburbs::where('state_id', $stateId);

        // NEW: Add a search filter if a query is provided
        if ($query) {
            $suburbs->where('suburb_name', 'like', '%' . $query . '%');
        }

        // NEW: Limit the results to a reasonable number to prevent performance issues
        $suburbs = $suburbs->get(['suburb_name', 'pincode'])->take(20);

        if ($suburbs->isNotEmpty()) {
            return response()->json($suburbs);
        }

        return response()->json([], 200);

    } catch (\Exception $e) {
        \Log::error('Error in getSuburbs: ' . $e->getMessage());
        return response()->json(['error' => 'An internal server error occurred'], 500);
    }
}
    /**
     * Update the user's profile information.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
        public function update_profile(Request $request)
    {
        Log::info('Update Profile Request Received:', $request->all()); // <--- Add this line 1

        // Update session timezone if provided
        if ($request->has('timezone_id')) {
            session(['timezone' => $request->timezone_id]);
        }

        // Password validation for non-platform users (if applicable)
      


        try {
            // Validate incoming request data
            $request->validate([
                'f_name' => 'required|min:3',
                'l_name' => 'required|min:3',
                'dob' => 'required|date', // Ensure DOB is a valid date
                'gender' => 'required', // Validate gender options
               
                'timezone_id' => 'required',
                'income' => 'required', // Assuming income is numeric
                'state' => 'required|exists:state,id', // Make sure this is 'state' (singular) as discussed
               
                'city' => 'required|string|max:255', // The hidden field that stores the suburb name
                
                'street' => 'nullable|string|max:255', // The new street name field
                'zip' => 'required|string|min:3|max:4', // Postcode validation
            ]);
            Log::info('Validation PASSED for user ID: ' . Auth::user()->id); // <--- Add this line 5

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation FAILED for user ID: ' . Auth::user()->id, ['errors' => $e->errors()]); // <--- Add this line 6
            session()->flash("error", "Please correct the form errors: " . json_encode($e->errors())); // Provide more detailed error
            return redirect()->back()->withErrors($e->errors())->withInput(); // Redirect with errors and old input
        }


        // Set update flag based on initial grade
        $curG = Auth::user()->grade;
        session(['update_first' => $curG == 0 ? 0 : 1]);

        session()->flash("success", "Your profile is now updated.");

        // Prepare data for update
        $upd = [
            "f_name" => $request->f_name,
            "l_name" => $request->l_name,
            "salutation" => $request->salutation,
            "qualification" => $request->qualification,
            "slug" => Str::slug($request->f_name . " " . $request->l_name . " " . Auth()->user()->id),
            "grade" => $request->grade,
            "timezone_id" => $request->timezone_id,
            "is_login" => '1',
            "city" => $request->city, // This is the hidden field holding the suburb name
            "address" => $request->address,
            "street" => $request->street, // Save the new street field
            "zip" => $request->zip,
            "state" => $request->state,
            "dob" => $request->dob,
            "gender" => $request->gender,
            
            "private_or_home" => $request->private_or_home,
            "parent_f_name" => $request->parent_f_name,
            "parent_l_name" => $request->parent_l_name,
            "annual_income" => $request->income,
            "parent_dob" => $request->parent_dob,
            "about_me" => $request->about_me,
        ];

        // Update school if provided
        if ($request->school_id == 0 && $request->filled('other_school_name')) {

            $school = new School();

            $maxAcaraId = School::max('acara_id');

            $school->acara_id = ($maxAcaraId ?? 0) + 1;
            $school->school_name = $request->other_school_name;
            $school->is_other_school = 1;
            $school->state_id = $request->show_school_state;
            $school->suburb_id = $request->show_school_suburb;
            $school->postcode = $request->show_school_postcode;

            $school->save();

            $upd['school'] = $school->id;

        } elseif ($request->school_id != 0) {

            $upd['school'] = $request->school_id;
        }

        try {
            // Perform the user update
            User::where('id', Auth()->user()->id)->update($upd);
            Log::info('User profile updated successfully for user ID: ' . Auth::user()->id, $upd); // <--- Add this line 7

            // Update profile picture if a new one is selected
            if ($request->imgSelect) {
                User::where('id', Auth()->user()->id)->update(['profile_pic' => $request->imgSelect]);
                Log::info('Profile picture updated for user ID: ' . Auth::user()->id, ['profile_pic' => $request->imgSelect]); // <--- Add this line 8
            }

        } catch (\Exception $e) {
            Log::error('Database update FAILED for user ID: ' . Auth::user()->id, ['error' => $e->getMessage(), 'update_data' => $upd]); // <--- Add this line 9
            session()->flash("error", "An error occurred during profile update. Please try again.");
            return redirect()->back();
        }


        return redirect()->back();
    }

    /**
     * Display the reset password view.
     *
     * @return \Illuminate\View\View
     */
    public function reset_password_view(){
        return view('student.modules.my_profile.reset_password');
    }

    /**
     * Update the user's password.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_password(Request $request){
        $request->validate([
            'old_password' => 'required|string|min:8',
            'newPassword' => 'required|min:8|',
            'confirm' => 'required|min:8|same:newPassword',
        ]);

        $oldPassword = $request->input('old_password');
        if (!Hash::check($oldPassword, Auth()->user()->password)) {
            return redirect()->back()->with('error', 'Incorrect current password');
        } else {
            User::where('id', Auth()->user()->id)->update([
                'password' => Hash::make($request->input('newPassword'))
            ]);
            return redirect()->back()->with('success', 'Password updated successfully!');
        }
    }

    /**
     * Check if the provided old password is correct (for AJAX validation).
     *
     * @param Request $request
     * @return string "true" or "false"
     */
    public function checkOldPassword(Request $request){
        $old_password = trim($request->data['old_password']);

        if(!Hash::check($old_password, Auth()->user()->password)) {
            return "false";
        }else{
            return "true";
        }
    }
}