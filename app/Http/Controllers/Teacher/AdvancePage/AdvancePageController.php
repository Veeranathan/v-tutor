<?php

namespace App\Http\Controllers\Teacher\AdvancePage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\State;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\TutorshipPlan;
use App\Models\TutorExperience;
use App\Models\TutorRecognision;
use App\Models\TutorAcademic;
use App\Models\University;
use App\Models\FieldOfStudy;
use App\Models\ExpToSubject;
use App\Models\LangToTutor;
use App\Models\Language;
use App\Models\TutorToRef;
use App\Models\TimezoneLists;
use App\Models\Branch;
use App\Models\Nationality;
use Validator;
use Mail;
use App\Mail\SendApprovalMail;

class AdvancePageController extends Controller
{
    //
    public function myAdvancePage(Request $request){
        $data['teacher']=User::where('id',Auth()->user()->id)->first();
        $data['tutor_to_ref']=TutorToRef::where('tutor_id',Auth()->user()->id)->first();
        $data['state'] = State::orderBy('state_name', 'desc')->get();

    // Timezone based on user's state
    $data['timezone'] = $data['teacher']->state_id
        ? State::where('id', $data['teacher']->state_id)->value('time_zone')
        : 'Not Set';
        $data['lan']=Language::orderBy('id')->get();
        $data['tutor_to_lan']=LangToTutor::where('tutor_id',Auth()->user()->id)->get();
        //$data['timezonesLists']=TimezoneLists::get();
        $data['nationalities']=Nationality::get();
        return view('teacher.modules.advance_page.advance_page')->with($data);
    }
     public function updatemyAdvancePage(Request $request) {
        //     dd([
        //     'hasFile' => $request->hasFile('testing'),
        //     'file' => $request->file('testing'),
        //     'all_files' => $request->file(),
        // ]);

        $user = Auth::user();

        // Validation rules
        $rules = [
            'nationality_id'          => 'required',
            'visa_type'               => 'required',
            'id_proof_type'           => 'required',
            'residence_id_proof_type' => 'required',
        ];

        if (!$user->id_proof) {
            $rules['id_proof'] = 'required|file';
        }

        if (!$user->residence_proof) {
            $rules['residence_proof'] = 'required|file';
        }

        $request->validate($rules);

        // Handle ID Proof upload
        if ($request->hasFile('id_proof')) {
            // Delete previous file if exists
            if ($user->id_proof && Storage::disk('public')->exists('id_proof/' . $user->id_proof)) {
                Storage::disk('public')->delete('id_proof/' . $user->id_proof);
            }

            $file = $request->file('id_proof');
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/id_proof'), $filename);
            $user->id_proof = $filename;
        }

        // Handle Residence Proof upload
        if ($request->hasFile('residence_proof')) {
            if ($user->residence_proof && Storage::disk('public')->exists('residence_proof/' . $user->residence_proof)) {
                Storage::disk('public')->delete('residence_proof/' . $user->residence_proof);
            }

            $file = $request->file('residence_proof');
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/residence_proof'), $filename);
            $user->residence_proof = $filename;
        }

        // Update document score
        $score = 0;
        if ($user->id_proof) $score += 60;
        if ($user->residence_proof) $score += 40;
        $user->document_score = $score;

        // Update other fields
        $user->nationality_id          = $request->nationality_id;
        $user->visa_type               = $request->visa_type;
        $user->other_visa_type         = $request->visa_type == 'O' ? $request->other_visa_type : null;
        $user->id_proof_type           = $request->id_proof_type;
        $user->residence_id_proof_type = $request->residence_id_proof_type;
        $user->visa_expiry             = $request->visa_expiry ?: null;
        $user->timezone_id             = $request->timezone_id;
        $user->country                 = $request->country;
        $user->state                   = $request->state;
        $user->city                    = $request->city;
        $user->zip                     = $request->zip;
        $user->address                 = $request->address;

        $user->save();

        // Check if it's a final submission
        if ($user->about_me && $user->draft == 'Y') {
            $user->draft = 'N';
            $user->save();

            try {
                $data['user'] = $user;
                $data['subject'] = '';
                Mail::send(new SendApprovalMail($data));

                return back()->with('success', 'Your profile is updated and application has been submitted');
            } catch (\Exception $e) {
                return back()->with('success', 'Your profile is updated and application has been submitted. Email error: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Profile updated. Please fill in all the required fields under Personal Info and submit.');
    }
    // public function updatemyAdvancePage(Request $request){


    //     $request->validate([
    //         'nationality_id'                => 'required',
    //         'visa_type'                     => 'required',
    //         'id_proof_type'                 => 'required',
    //         'residence_id_proof_type'       => 'required'
    //     ]);

    //     if(!@Auth::user()->id_proof){
    //         $request->validate([
    //             'nationality_id'                => 'required',
    //             'visa_type'                     => 'required',
    //             'id_proof_type'                 => 'required',
    //             'residence_id_proof_type'       => 'required',
    //             'residence_proof'       => 'required',
    //             'id_proof'                      => 'required'
    //         ]);
    //     }
    //     if(!@Auth::user()->residence_proof){
    //         $request->validate([
    //             'nationality_id'                => 'required',
    //             'visa_type'                     => 'required',
    //             'id_proof_type'                 => 'required',
    //             'id_proof'                 => 'required',
    //             'residence_id_proof_type'       => 'required',
    //             'residence_proof'               => 'required'

    //         ]);
    //     }
    //         if(@$request->id_proof){
    //             $unlnk=User::where('id',@Auth::user()->id)->first();
    //             if(@$unlnk->id_proof){
    //                 @$prev_img = $unlink->id_proof;

    //                 if(@$prev_img){
    //                     @unlink('storage/id_proof/'.$prev_img);
    //                 }
    //             }

    //             //this is for upload
    //             $image = $request->id_proof;
    //             $profile = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
    //             $image->move("storage/id_proof",$profile);
    //             $user_pic_update=User::where('id',Auth()->user()->id)->update(['id_proof'=>$profile]);
    //         }

    //         if(@$request->residence_proof){
    //             $unlnk=User::where('id',@Auth::user()->id)->first();
    //             if(@$unlnk->residence_proof){
    //                 @$prev_img = $unlink->residence_proof;
    //                 if(@$prev_img){
    //                     @unlink('storage/residence_proof/'.$prev_img);
    //                 }
    //             }

    //             //this is for upload
    //             $image = $request->residence_proof;
    //             $profile = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
    //             $image->move("storage/residence_proof",$profile);

    //             $user_pic_update=User::where('id',Auth()->user()->id)->update(['residence_proof'=>$profile]);
    //         }

    //         $curentUser = User::where(['id'=>@Auth()->user()->id])->first();
    //         if(@$curentUser){
    //             if(@$curentUser->residence_proof && @$curentUser->id_proof){
    //                 $updPoints['document_score'] = 100;
    //                 User::where(['id'=>@Auth()->user()->id])->update($updPoints);
    //             }
    //             if(@$curentUser->residence_proof && !@$curentUser->id_proof){
    //                 $updPoints['document_score'] = 40;
    //                 User::where(['id'=>@Auth()->user()->id])->update($updPoints);
    //             }
    //             if(!@$curentUser->residence_proof && @$curentUser->id_proof){
    //                 $updPoints['document_score'] = 60;
    //                 User::where(['id'=>@Auth()->user()->id])->update($updPoints);
    //             }
    //         }
    //         $upd['nationality_id'] = @$request->nationality_id;
    //         $upd['visa_type'] = @$request->visa_type;
    //         if(@$request->visa_type == 'O'){
    //             $upd['other_visa_type'] = @$request->other_visa_type;
    //         }else{
    //             $upd['other_visa_type'] = NULL;
    //         }
    //         $upd['id_proof_type'] = @$request->id_proof_type;
    //         $upd['residence_id_proof_type'] = @$request->residence_id_proof_type;
    //         if(@$request->visa_expiry){
    //             $upd['visa_expiry'] = $request->visa_expiry;
    //         }else{
    //             $upd['visa_expiry'] = NULL;
    //         }

    //         if(@$request->timezone_id){
    //             $upd['timezone_id'] = $request->timezone_id;
    //         }
    //         if(@$request->country){
    //             $upd['country'] = $request->country;
    //         }
    //         if(@$request->state){
    //             $upd['state'] = $request->state;
    //         }
    //         if(@$request->city){
    //             $upd['city'] = $request->city;
    //         }
    //         if(@$request->zip){
    //             $upd['zip'] = @$request->zip;
    //         }
    //         if(@$request->address){
    //             $upd['address'] = @$request->address;
    //         }
    //         User::where(['id'=>@Auth::user()->id])->update($upd);


    //     if(@Auth::user()->about_me && @Auth::user()->draft == 'Y'){
    //         $updDraft['draft'] = 'N';
    //         User::where(['id'=>@Auth::user()->id])->update($updDraft);
    //         try{
    //             $data['user'] = User::where('id',@Auth::user()->id)->first();
    //             $data['subject'] = "";
    //             Mail::send(new SendApprovalMail($data));
    //             return back()->with('success','Your profile is updated and application has been submitted');
    //         }catch(\Exception $e){
    //             return back()->with('success','Your profile is updated and application has been submitted'.$e->getMessage());
    //         }

    //     }else{
    //         return back()->with('success','Profile updated. Please fill in all the required fields under Personal Info and submit');
    //     }

    // }
}
