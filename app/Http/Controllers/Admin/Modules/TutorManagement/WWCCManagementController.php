<?php

namespace App\Http\Controllers\Admin\Modules\TutorManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TutorshipPlan;
use App\Models\ExpToSubject;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\FieldOfStudy;
use App\Models\MyAvailability;

use App\Models\TutorRecognision;
use App\Models\University;
use App\Models\TutorExperience;
use App\Models\TutorAcademic;
use App\Models\State;

use App\Models\LangToTutor;
use App\Models\Language;
use App\Models\TutorToRef;
use App\Models\TimezoneLists;
use App\Models\Branch;
use App\Models\Nationality;
use App\Models\TutorApplicationFormsModel;
use App\Models\TutorWWCCModel;
// use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\AdminAcceptTAFMail;
use App\Mail\AdminRejectTAFMail;
use Validator;

class WWCCManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    
    /*
    * Method        : index
    * Description   : This method is used to manage tutors applications!
    * Author        : GJ
    */
    public function list(Request $request){
        try {
            $data = [];
            return view('admin.modules.wwcc_manage.wwcc_management_list')->with($data);
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

    public function getList(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $exist_wwcc = [];
        $exist_taf = TutorApplicationFormsModel::selectRaw('MIN(id) as id')
            // ->Where('status', '!=', 2)
            // ->Where('status', 3)
            ->whereHas('getTutor', function ($q) {
                $q->where('status', 'A');
            })
            ->groupBy('tutor_id')
            ->pluck('id')
            ->toArray();
        if(count($exist_taf) != 0){
            $exist_wwcc = TutorWWCCModel::selectRaw('MIN(id) as id')
                ->WhereIn('tutor_app_id', $exist_taf)
                ->groupBy('tutor_app_id');
            if(@$request->columns['2']['search']['value']){
                $exist_wwcc = $exist_wwcc->where(function($query) use($request) {
                    $query->Where('tutor_wwcc.states',$request->columns['2']['search']['value']);
                });
            }

            if(@$request->columns['3']['search']['value']){
                $exist_wwcc = $exist_wwcc->where(function($query) use($request) {
                    $query->whereBetween('tutor_wwcc.expiry_date',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
                });
            }

            if(@$request->columns['4']['search']['value']){
                $exist_wwcc = $exist_wwcc->where(function($query) use($request) {
                    $query->whereBetween('tutor_wwcc.expiry_date',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
                });
            }

            if(@$request->columns['5']['search']['value']){
                $exist_wwcc = $exist_wwcc->where(function($query) use($request) {
                    if($request->columns['5']['search']['value'] == 1) {
                        $query->Where('tutor_wwcc.is_valid',$request->columns['5']['search']['value']);
                    } else {
                        $query->Where('tutor_wwcc.is_valid','!=',1);
                    }
                });
            }
            $exist_wwcc = $exist_wwcc->pluck('id')->toArray();
            // dd($exist_wwcc);
        }

        // $taf_data = TutorWWCCModel::with('getTutorForm', 'getTutor')->WhereIn('id', $exist_wwcc);
        $taf_data = TutorWWCCModel::query()
            ->with('getTutorForm', 'getTutor')
            ->join('tutor_application_forms', 'tutor_wwcc.tutor_app_id', '=', 'tutor_application_forms.id')
            ->join('users', 'tutor_wwcc.tutor_id', '=', 'users.id')
            ->WhereIn('tutor_wwcc.id', $exist_wwcc)
            ->select(
                'tutor_wwcc.*',
                'tutor_application_forms.taf_id',
                'tutor_application_forms.first_name',
                'tutor_application_forms.middle_name',
                'tutor_application_forms.last_name',
                'users.unique_id'
            );

        if(@$request->columns['1']['search']['value']){
            $taf_data = $taf_data->where(function($query) use($request) {
                $query->Where('tutor_application_forms.first_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('tutor_application_forms.middle_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('tutor_application_forms.last_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('tutor_application_forms.taf_id','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('users.unique_id','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhereRaw("CONCAT(tutor_application_forms.first_name, ' ', tutor_application_forms.last_name) LIKE ?", ['%' . $request->columns['1']['search']['value'] . '%'])
                ->orWhereRaw("CONCAT(tutor_application_forms.first_name, ' ', tutor_application_forms.middle_name, ' ', tutor_application_forms.last_name) LIKE ?", ['%' . $request->columns['1']['search']['value'] . '%']);

                // ->orWhere(\DB::raw("CONCAT(`tutor_application_forms.first_name`, ' ', `tutor_application_forms.last_name`)"), 'like', '%' . $request->columns['1']['search']['value'] . '%')
                // ->orWhere(\DB::raw("CONCAT(`tutor_application_forms.first_name`, ' ',`tutor_application_forms.middle_name`, ' ', `tutor_application_forms.last_name`)"), 'like', '%' . $request->columns['1']['search']['value'] . '%');
            });
        }

        if(@$request->columns['2']['search']['value']){
            $taf_data = $taf_data->where(function($query) use($request) {
                $query->Where('tutor_wwcc.states',$request->columns['2']['search']['value']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];
        }

        if(@$request->columns['3']['search']['value']){
            $taf_data = $taf_data->where(function($query) use($request) {
                $query->whereBetween('tutor_wwcc.expiry_date',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }

        if(@$request->columns['4']['search']['value']){
            $taf_data = $taf_data->where(function($query) use($request) {
                $query->whereBetween('tutor_wwcc.expiry_date',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }

        if(@$request->columns['5']['search']['value']){
            $taf_data = $taf_data->where(function($query) use($request) {
                if($request->columns['5']['search']['value'] == 1) {
                    $query->Where('tutor_wwcc.is_valid',$request->columns['5']['search']['value']);
                } else {
                    $query->Where('tutor_wwcc.is_valid','!=',1);
                }
            });
            $data["rre"] = @$request->columns['5']['search']['value'];
        }

        $ps =  $taf_data->count();
        $pp = $taf_data;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $taf_data = $taf_data;
        $p =  $p->count();

        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $taf_data = $taf_data->orderBy('tutor_application_forms.first_name','asc');
            } else {
                $taf_data = $taf_data->orderBy('tutor_application_forms.first_name','desc');
            }
        }

        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $taf_data = $taf_data->orderBy('users.unique_id','asc');
            } else {
                $taf_data = $taf_data->orderBy('users.unique_id','desc');
            }
        }

        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $taf_data = $taf_data->orderBy('tutor_application_forms.taf_id','asc');
            } else {
                $taf_data = $taf_data->orderBy('tutor_application_forms.taf_id','desc');
            }
        }

        $taf_data = $taf_data->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        // dd($taf_data);
        $data['aaData'] = $taf_data;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }

    public function view($id,Request $request){
        try {
            $data['taf_data'] = TutorWWCCModel::with(['getTutor','getTutorForm'])->where('id',$id)->first();
            $data['next_id'] = 0;
            $data['previous_id'] = 0;
            
            if(@$data['taf_data']) {
                $data['next_id'] = TutorWWCCModel::where('tutor_id','>',$data['taf_data']->tutor_id)->min('id');
                $data['previous_id'] = TutorWWCCModel::where('tutor_id','<',$data['taf_data']->tutor_id)->max('id');
                $data['taf_wwcc'] = TutorWWCCModel::Where('tutor_id', $data['taf_data']->tutor_id)->Where('tutor_app_id', $data['taf_data']->tutor_app_id)->get();
                /* echo "<pre>";
                print_r($data);
                die(); */
                return view('admin.modules.wwcc_manage.view_wwcc_management')->with($data);
            } else {
                session()->flash("error","WWCC is not found associated with id : ".$id);
                return redirect()->back();
            }
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request){
        try {
            if((isset($request->wwcc_tutor_id) && $request->wwcc_tutor_id) && (isset($request->wwcc_tutor_app_id) && $request->wwcc_tutor_app_id) && (isset($request->wwcc_states) && $request->wwcc_states)) {
                $wwcc_no = '';
                if(isset($request->wwcc_no) && $request->wwcc_no) {
                    $wwcc_no = $request->wwcc_no;
                } else {
                    return 4;
                }
                
                $wwcc_expiry_date = '';
                if(isset($request->wwcc_expiry_date) && $request->wwcc_expiry_date) {
                    $wwcc_expiry_date = date('Y-m-d', strtotime($request->wwcc_expiry_date));
                } else {
                    return 5;
                }
                
                $is_valid = 2;
                if(isset($request->is_valid) && $request->is_valid) {
                    $is_valid = $request->is_valid;
                }

                $generate_from = 2;
                
                $taf_wwcc = new TutorWWCCModel();
                if(isset($request->wwcc_id) && $request->wwcc_id) {
                    $taf_wwcc = TutorWWCCModel::Where('id', $request->wwcc_id)->first();

                    if(isset($taf_wwcc->generate_from) && $taf_wwcc->generate_from) {
                        $generate_from = $taf_wwcc->generate_from;
                    }
                } else {
                    $is_valid = 1;
                }

                if($taf_wwcc) {
                    $taf_wwcc->tutor_id = $request->wwcc_tutor_id;
                    $taf_wwcc->tutor_app_id = $request->wwcc_tutor_app_id;
                    $taf_wwcc->states = $request->wwcc_states;
                    $taf_wwcc->wwcc_no = $wwcc_no;
                    $taf_wwcc->expiry_date = $wwcc_expiry_date;
                    $taf_wwcc->is_valid = $is_valid;
                    $taf_wwcc->generate_from = $generate_from;
                    $taf_wwcc->status = 3;
                    if($taf_wwcc->save()) {
                        return 1;
                    } else {
                        return 2;
                    }
                } else {
                    return 3;
                }
            } else {
                return 3;
            }
        } catch(\Exception $e) {
            return 6;
        }
    }

    public function changeWWCCStatus(Request $request){
        try {
            $succ = 3;
            if(isset($request->wwcc_id) && $request->wwcc_id) {
                $taf_wwcc = TutorWWCCModel::Where('id', $request->wwcc_id)->first();
                if($taf_wwcc) {
                    $taf_wwcc->is_valid = (isset($request->is_valid) && $request->is_valid) ? $request->is_valid : 2;
                    if($taf_wwcc->save()) {
                        $succ = 1;
                    } else {
                        $succ = 2;
                    }
                }
            }

            return $succ;
        } catch(\Exception $e) {
            return 3;
        }
    }

    public function changeAcceptStatus($id, Request $request){
        try {
            $succ = 3;
            if(isset($id) && $id) {
                $taf_data = TutorApplicationFormsModel::Where('id', $id)->first();
                if($taf_data) {
                    $taf_data->status = 1;
                    if($taf_data->save()) {
                        $data['taf_data'] = $taf_data;
                        $data['subject'] = 'Your Application Accepted: V-Tutor';
                        Mail::send(new AdminAcceptTAFMail($data));

                        session()->flash("success", 'The application has been accepted. A notification email has been sent to the applicant');
                        return redirect()->back();
                    } else {
                        session()->flash("error", 'Application accept failed!');
                        return redirect()->back();
                    }
                }
            }

            session()->flash("error", 'Please try again later');
            return redirect()->back();
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

    public function changeRejectStatus(Request $request){
        try {
            $succ = 3;
            if(isset($request->form_id) && $request->form_id) {
                $taf_data = TutorApplicationFormsModel::Where('id', $request->form_id)->first();
                if($taf_data) {
                    $taf_data->status = 2;
                    $taf_data->status_remark = (isset($request->status_remark) && $request->status_remark) ? $request->status_remark : null;
                    if($taf_data->save()) {
                        $data['taf_data'] = $taf_data;
                        $data['subject'] = 'Your Application Rejected: V-Tutor';
                        Mail::send(new AdminRejectTAFMail($data));

                        session()->flash("success", 'The application has been rejected. A notification email has been sent to the applicant');
                        return redirect()->back();
                    } else {
                        session()->flash("error", 'Application rejection failed!');
                        return redirect()->back();
                    }
                }
            }

            session()->flash("error", 'Please try again later');
            return redirect()->back();
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

    public function getStateWWCC(Request $request){
        $succ = 'No';
        try {
            if((isset($request->tutor_id) && $request->tutor_id) && (isset($request->tutor_app_id) && $request->tutor_app_id) && (isset($request->state) && $request->state)) {
                $taf_data = TutorWWCCModel::Where('tutor_id', $request->tutor_id)->Where('tutor_app_id', $request->tutor_app_id)->Where('states', $request->state)->first();
                if($taf_data) {
                    if($taf_data->is_valid == 1) {
                        $succ = "Yes";
                    } else if($taf_data->is_valid == 2) {
                        $succ = "No";
                    } else if($taf_data->is_valid == 3) {
                        $succ = "No";
                    } else {
                        $succ = "No";
                    }
                }
            }

            return $succ;
        } catch(\Exception $e) {
            return $succ;
        }
    }
}
