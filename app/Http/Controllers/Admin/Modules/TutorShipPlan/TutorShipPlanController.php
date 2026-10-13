<?php

namespace App\Http\Controllers\Admin\Modules\TutorShipPlan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TutorshipPlan;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\FieldOfStudy;

use App\Models\TutorRecognision;
use App\Models\University;
use App\Models\TutorExperience;
use App\Models\TutorAcademic;
use App\Models\State;
use App\Models\MyAvailability;
use App\Models\ExpToSubject;
use App\Models\Branch;
use Illuminate\Support\Facades\Validator;

class TutorShipPlanController extends Controller
{
    
    public function ajaxGetGradeSubjects(Request $request){
        try{
            $htmlResp = '';
            if(@$request->data['grade_id'] != 0){
                $data['notSubjects'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$request->data['teacher_id'],'grade_id'=>$request->data['grade_id']])->pluck('subject_id')->toArray();
            
                $data['subjects'] = Subject::where(['status'=>'A'])->where('branch_id',$request->data['branch_id'])->whereNotIn('id',$data['notSubjects']);

                $data['count'] = $data['subjects']->count();
                $data['subjects'] = $data['subjects']->orderBy('subject','asc')->get();
                $s2 = $data['subjects']->sortBy('subject', SORT_NATURAL);
                $s2 = $s2->values()->all();
                $data['subjects'] = $s2;
                foreach(@$data['subjects'] as $subject){
                    $htmlResp = $htmlResp.'<option value="'.$subject->id.'">'.$subject->subject.'</option>';
                }
                $data['html_response'] = $htmlResp;
                return response()->json($data,200);    
            }else{
                $data['notSubjects'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$request->data['teacher_id']])->pluck('subject_id')->toArray();
            
                $data['subjects'] = Subject::where(['status'=>'A'])->where('branch_id',$request->data['branch_id'])->whereNotIn('id',$data['notSubjects']);
                
                $data['count'] = $data['subjects']->count();
                $data['subjects'] = $data['subjects']->orderBy('subject','asc')->get();
                $s2 = $data['subjects']->sortBy('subject', SORT_NATURAL);
                $s2 = $s2->values()->all();
                $data['subjects'] = $s2;
                foreach(@$data['subjects'] as $subject){
                    $htmlResp = $htmlResp.'<option value="'.$subject->id.'">'.$subject->subject.'</option>';
                }
                $data['html_response'] = $htmlResp;
                return response()->json($data,200);
            }
            
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    public function tutorShipManagement($id,Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $tutorshipplan = TutorShipPlan::with(['getGrade','getBranch','getSubject'])->where(['teacher_id'=>$id,'status'=>'A']);
        
        $ps =  $tutorshipplan->count();
        $pp = $tutorshipplan;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $tutorshipplan = $tutorshipplan;
        $p =  $p->count();
        if($columnIndex == 0) {
            $tutorshipplan1 = $tutorshipplan->get();
            if($columnSortOrder == 'asc') {
                $tutorshipplan2 = $tutorshipplan1->sortBy(function($tutorshipplan, $key) {
                    return $tutorshipplan['getGrade']['grade_name'];
                });

                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            } else {
                $tutorshipplan2 = $tutorshipplan1->sortByDesc(function($tutorshipplan, $key) {
                    return $tutorshipplan['getGrade']['grade_name'];
                });
                
                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            }
        }
        if($columnIndex == 1) {
            $tutorshipplan1 = $tutorshipplan->get();
            if($columnSortOrder == 'asc') {
                $tutorshipplan2 = $tutorshipplan1->sortBy(function($tutorshipplan, $key) {
                    return $tutorshipplan['getBranch']['branch_name'];
                });

                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            } else {
                $tutorshipplan2 = $tutorshipplan1->sortByDesc(function($tutorshipplan, $key) {
                    return $tutorshipplan['getBranch']['branch_name'];
                });
                
                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            }
        }
        if($columnIndex == 2) {
            $tutorshipplan1 = $tutorshipplan->get();
            if($columnSortOrder == 'asc') {
                $tutorshipplan2 = $tutorshipplan1->sortBy(function($tutorshipplan, $key) {
                    return $tutorshipplan['getSubject']['subject'];
                });
                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            } else {
                $tutorshipplan2 = $tutorshipplan1->sortByDesc(function($tutorshipplan, $key) {
                    return $tutorshipplan['getSubject']['subject'];
                });
                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            }
        }
        // if($columnIndex == 1) {
        //     if($columnSortOrder == 'asc') {
        //         $tutorshipplan = $tutorshipplan->orderBy('id','asc');
        //     } else {
        //         $tutorshipplan = $tutorshipplan->orderBy('id','desc');
        //     }
        // }
        if($columnIndex == 3) {
            $tutorshipplan1 = $tutorshipplan->get();
            if($columnSortOrder == 'asc') {
                $tutorshipplan2 = $tutorshipplan1->sortBy(function($tutorshipplan, $key) {
                    return $tutorshipplan['hourly_rate'];
                });

                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            } else {
                $tutorshipplan2 = $tutorshipplan1->sortByDesc(function($tutorshipplan, $key) {
                    return $tutorshipplan['hourly_rate'];
                });

                $tutorshipplan = $tutorshipplan2->slice($request->start, $request->length)->values()->all();
            }
            // if($columnSortOrder == 'asc') {
            //     $tutorshipplan = $tutorshipplan->orderBy('hourly_rate','asc');
            // } else {
            //     $tutorshipplan = $tutorshipplan->orderBy('hourly_rate','desc');
            // }
            // $tutorshipplan = $tutorshipplan->skip($request->start)->take($request->length)->get();
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $tutorshipplan = $tutorshipplan->orderBy('id','asc');
            } else {
                $tutorshipplan = $tutorshipplan->orderBy('id','desc');
            }
            $tutorshipplan = $tutorshipplan->skip($request->start)->take($request->length)->get();
        }
        // $tutorshipplan = $tutorshipplan->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $tutorshipplan;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function ajaxDeleteTutorShipPlan(Request $request){
        try{
            $id = @$request->data['id'];
            $tutorshipplan = TutorShipPlan::where('id',$id)->first();
            if(@$tutorshipplan){
                TutorShipPlan::where('id',$id)->update(['status'=>'D']);
                $updateMin['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$tutorshipplan->teacher_id])->min('hourly_rate')?TutorshipPlan::where(['status'=>'A','teacher_id'=>$tutorshipplan->teacher_id])->min('hourly_rate'):0;
                            User::where('id',$tutorshipplan->teacher_id)->update($updateMin);  
                $data['status'] = 1;
                $data['message'] = "TutorShipPlan is deleted!";
                return response()->json($data,200);
            }else{
                $data['status'] = 0;
                $data['message'] = "TutorShipPlan is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    public function academicManagement($id,Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = TutorAcademic::with(['getFieldStudy','getUniversity'])->whereIn('status',['A','I'])->where('teacher_id',$id);
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
            $users = $users->skip($request->start)->take($request->length)->get();
        }
        if($columnIndex == 1) {
            $users1 = $users->get();
            if($columnSortOrder == 'asc') {
                $users2 = $users1->sortBy(function($users, $key) {
                    return $users['getFieldStudy']['field_of_study'];
                });

                $users = $users2->slice($request->start, $request->length)->values()->all();
            } else {
                $users2 = $users1->sortByDesc(function($users, $key) {
                    return $users['getFieldStudy']['field_of_study'];
                });

                $users = $users2->slice($request->start, $request->length)->values()->all();
            }
            // if($columnSortOrder == 'asc') {
            //     $users = $users->orderBy('id','asc');
            // } else {
            //     $users = $users->orderBy('id','desc');
            // }
            // $users = $users->skip($request->start)->take($request->length)->get();
        }
        if($columnIndex == 2) {
            $users1 = $users->get();
            if($columnSortOrder == 'asc') {
                $users2 = $users1->sortBy(function($users, $key) {
                    return $users['getUniversity']['university_name'];
                });

                $users = $users2->slice($request->start, $request->length)->values()->all();
            } else {
                $users2 = $users1->sortByDesc(function($users, $key) {
                    return $users['getUniversity']['university_name'];
                });

                $users = $users2->slice($request->start, $request->length)->values()->all();
            }
            // if($columnSortOrder == 'asc') {
            //     $users = $users->orderBy('id','asc');
            // } else {
            //     $users = $users->orderBy('id','desc');
            // }
            // $users = $users->skip($request->start)->take($request->length)->get();
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('located_in','asc');
            } else {
                $users = $users->orderBy('located_in','desc');
            }
            $users = $users->skip($request->start)->take($request->length)->get();
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('qualification_status','asc');
            } else {
                $users = $users->orderBy('qualification_status','desc');
            }
            $users = $users->skip($request->start)->take($request->length)->get();
        }
        if($columnIndex == 5) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('effective_date','asc');
            } else {
                $users = $users->orderBy('effective_date','desc');
            }
            $users = $users->skip($request->start)->take($request->length)->get();
        }
        if($columnIndex == 6) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
            $users = $users->skip($request->start)->take($request->length)->get();
        }
        // $users = $users->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function ajaxDeleteAcademic(Request $request){
        try{
            $id = @$request->data['id'];
            $tutorshipplan = TutorAcademic::where('id',$id)->first();
            if(@$tutorshipplan){
                TutorAcademic::where('id',$id)->update(['status'=>'D']);
                $data['status'] = 1;
                $data['message'] = "Tutor academic is deleted!";
                return response()->json($data,200);
            }else{
                $data['status'] = 0;
                $data['message'] = "Tutor academic is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    public function expManagement($id,Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = TutorExperience::with(['getExpToSub.subjectName'])->where(['teacher_id'=>$id])->whereNotIn('status',['D']);
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('organization','asc');
            } else {
                $users = $users->orderBy('organization','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('institution_type','asc');
            } else {
                $users = $users->orderBy('institution_type','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('job_title','asc');
            } else {
                $users = $users->orderBy('job_title','desc');
            }
        }
        /* if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('year_of_exp','asc');
            } else {
                $users = $users->orderBy('year_of_exp','desc');
            }
        } */
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('from_year','asc');
            } else {
                $users = $users->orderBy('from_year','desc');
            }
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('to_year','asc');
            } else {
                $users = $users->orderBy('to_year','desc');
            }
        }
        /* if($columnIndex == 5) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('description','asc');
            } else {
                $users = $users->orderBy('description','desc');
            }
        } */
        if($columnIndex == 5) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 6) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 7) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        $users = $users->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function ajaxDeleteExperience(Request $request){
        try{
            $id = @$request->data['id'];
            $tutorExpDtls = TutorExperience::where('id',$id)->first();
            if(@$tutorExpDtls){
                TutorExperience::where('id',$id)->update(['status'=>'D']);
                $tutor = User::where(['user_type'=>'T','status'=>'A','id'=>$tutorExpDtls->teacher_id])->first();
                if(@$tutor){
                    $updateTotalExp['total_experience'] = TutorExperience::where(['status'=>'A','teacher_id'=>$tutorExpDtls->teacher_id])->sum('year_of_exp');
                    User::where(['user_type'=>'T','status'=>'A','id'=>$tutorExpDtls->teacher_id])->update($updateTotalExp);
                    $tutorExpToSubj = ExpToSubject::where(['teacher_id'=>$tutorExpDtls->teacher_id,'exp_id'=>$id])->first();

                    if(@$tutorExpToSubj){
                        ExpToSubject::where(['teacher_id'=>$tutorExpDtls->teacher_id,'exp_id'=>$id])->delete();
                    }
                }
                $data['status'] = 1;
                $data['message'] = "Tutor experience is deleted!";
                return response()->json($data,200);
            }else{
                $data['status'] = 0;
                $data['message'] = "Tutor experience is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    public function recManagement($id,Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = TutorRecognision::where(['teacher_id'=>$id])->whereNotIn('status',['D']);
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('organization','asc');
            } else {
                $users = $users->orderBy('organization','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('location','asc');
            } else {
                $users = $users->orderBy('location','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('recg_title','asc');
            } else {
                $users = $users->orderBy('recg_title','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('year_of_recg','asc');
            } else {
                $users = $users->orderBy('year_of_recg','desc');
            }
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        // if($columnIndex == 3) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('status','asc');
        //     } else {
        //         $users = $users->orderBy('status','desc');
        //     }
        // }
        // if($columnIndex == 4) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('id','asc');
        //     } else {
        //         $users = $users->orderBy('id','desc');
        //     }
        // }
        $users = $users->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function ajaxDeleteRecognision(Request $request){
        try{
            $id = @$request->data['id'];
            $tutorshipplan = TutorRecognision::where('id',$id)->first();
            if(@$tutorshipplan){
                TutorRecognision::where('id',$id)->update(['status'=>'D']);
                $data['status'] = 1;
                $data['message'] = "Tutor recognision is deleted!";
                return response()->json($data,200);
            }else{
                $data['status'] = 0;
                $data['message'] = "Tutor recognision is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    public function editTutorAvailability($id,Request $request){
        $data['user'] = User::where(['id'=>$id])->first();
        return view('admin.modules.tutor_management.edit_tutor_info')->with($data);
    }
}
