<?php

namespace App\Http\Controllers\Admin\Modules\GradeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\TutorshipPlan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class GradeManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function ajaxDuplicateGradeCheck(Request $request){
        try{
            $grade_name = trim($request->grade_name);
            $grade = Grade::where('grade_name',@$request->grade_name)->whereIn('status',['I','A'])->whereNotIn('id',[$request->grade_id])->first();
            if(@$grade){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function ajaxDuplicateCaptureCodeCheck(Request $request){
        try{
            $capture_code = trim($request->capture_code);
            $grade = Grade::where('capture_code',@$request->capture_code)->whereIn('status',['I','A'])->whereNotIn('id',[$request->grade_id])->first();
            if(@$grade){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function ajaxdeleteGrade(Request $request){
        try{
            $id = @$request->data['id'];
            $grade = Grade::where('id',$id)->first();
            if(@$grade){
                $tutorshipplan = TutorshipPlan::with(['getUser'])->where(['grade_id'=>$id]);
                $tutorshipplan = $tutorshipplan->whereHas('getUser',function($q1) {
                    $q1 = $q1->whereNotIn('status',['D']);
                });
                $tutorshipplan = $tutorshipplan->whereIn('status',['A','I'])->first();
                if(@$tutorshipplan){
                    $data['status'] = 0;
                    $data['message'] = "Grade is not deleted!Grade is associated with teacher!";
                    return response()->json($data,200);
                }else{
                    $isGradeExist = User::whereNotIn('status',['D'])->where(['grade'=>$id])->first();
                    if(@$isGradeExist){
                        $data['status'] = 0;
                        $data['message'] = "Grade is not deleted!Grade is associated with student!";
                        return response()->json($data,200);
                    }else{
                        Grade::where('id',$id)->update(['status'=>'D']);
                        $data['status'] = 1;
                        $data['message'] = $grade->grade_name." grade is deleted!";
                        return response()->json($data,200);
                    }
                }
                return redirect()->back();
            }else{
                $data['status'] = 0;
                $data['message'] = "Grade is not deleted!Grade is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    public function gradeManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $grades = Grade::whereIn('status',['I','A']);
        if(@$request->columns['1']['search']['value']){
            $grades = $grades->where(function($query) use($request) {
                $query->where('grade_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('capture_code','like','%'.$request->columns['1']['search']['value'].'%');
            });
        }
        $ps =  $grades->count();
        $pp = $grades;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $grades = $grades;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $grades = $grades->orderBy('grade_name','asc');
            } else {
                $grades = $grades->orderBy('grade_name','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $grades = $grades->orderBy('capture_code','asc');
            } else {
                $grades = $grades->orderBy('capture_code','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $grades = $grades->orderBy('id','asc');
            } else {
                $grades = $grades->orderBy('id','desc');
            }
        }
        $grades = $grades->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $grades;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    /*
    * Method        : index
    * Description   : This method is used to manage grades!
    * Author        : Jayatri
    */
    public function index(Request $request){
        try{
            return view('admin.modules.grades_management.manage_grade');
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : viewGrade
    * Description   : This method is used to view grade!
    * Author        : Jayatri
    */
    public function viewGrade($id,Request $request){
        try{
            $grade = Grade::where('id',$id)->first();
            if(@$grade){
                return view('admin.modules.grades_management.view_grade')->with(['grade'=>$grade]);
            }else{
                session()->flash("error","Grade is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : addGrade
    * Description   : This method is used to add grade!
    * Author        : Jayatri
    */
    public function addGrade(Request $request){
        try{
            if(@$request->all()){
                $request->validate(['grade_name' => 'required']);
                $grade = Grade::where('grade_name',@$request->grade_name)->whereNotIn('status',['D'])->first();
                if(!@$grade){
                    $addgrade['grade_name'] = @$request->grade_name;
                    $addgrade['slug'] = Str::slug(@$request->grade_name)."-".time();
                    $addgrade['capture_code'] = @$request->capture_code;
                    $grade = Grade::create($addgrade);
                    $updateGrade['slug'] = Str::slug(@$request->grade_name)."-".$grade->id;
                    Grade::where(['id'=>$grade->id])->update($updateGrade);
                    session()->flash("success","Grade added successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Grade is already taken!");
                    return redirect()->back();
                }
            }else{
                return view('admin.modules.grades_management.add_grade');
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : editGrade
    * Description   : This method is used to edit & update grade!
    * Author        : Jayatri
    */

    public function editGrade($id,Request $request){
        try{
            $data['grade'] = Grade::where('id',$id)->first();
            if(@$request->all()){
                @$grade = Grade::where('grade_name',@$request->grade_name)->whereIn('status',['I','A'])->whereNotIn('id',[$id])->first();
                if(!@$grade){
                    $updategrade['grade_name'] = @$request->grade_name;
                    $updategrade['slug'] = Str::slug(@$request->grade_name)."-".$id;
                    $updategrade['capture_code'] = @$request->capture_code;
                    Grade::where('id',$id)->update($updategrade);
                    $data['grade'] = Grade::where('id',$id)->first();
                    // dd($data);
                    session()->flash("success",$data['grade']->grade_name. " grade updated successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Grade already exists!");
                    return redirect()->route('manage.subjects');
                }
            }else{
                return view('admin.modules.grades_management.edit_grade')->with($data);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Description   : Not in use
    */
    public function deleteGrade($id){
        // try{
        //     $grade = Grade::where('id',$id)->first();
        //     if(@$grade){

        //         $tutorshipplan = TutorshipPlan::with(['getUser'])->where(['grade_id'=>$id]);
        //         $tutorshipplan = $tutorshipplan->whereHas('getUser',function($q1) {
        //             $q1 = $q1->whereNotIn('status',['D']);
        //         });
        //         $tutorshipplan = $tutorshipplan->whereIn('status',['A','I'])->first();
        //         if(@$tutorshipplan){
        //             session()->flash("error","Grade is not deleted!Grade is associated with user!");
        //         }else{
        //             Grade::where('id',$id)->update(['status'=>'D']);
        //             session()->flash("success",$grade->grade_name." grade is deleted!");
        //         }

        //         return redirect()->back();
        //     }else{
        //         Grade::where('id',$id)->delete();
        //         session()->flash("error","Grade is not deleted!Grade is not found associated with id : ".$id);
        //         return redirect()->back();
        //     }
        // }catch(\Exception $e){
        //     \Log::error($e->getMessage());
        //     session()->flash("error",$e->getMessage());
        //     return redirect()->back();
        // }
    }

    public function getGradeManagementList(Request $request){
        $data['grades'] = Grade::whereIn('status',['I','A']);
        if(@$request->grade_name){
            $data['grades'] = $data['grades']->where(function($query) use($request) {
                $query->where('grade_name','like','%'.$request->grade_name.'%')
                ->orWhere('capture_code','like','%'.$request->grade_name.'%');
            });
        }
        $data['grades'] = $data['grades']->orderBy('id','desc')->get();
        $t = '';
        $t .='<table>
            <tr>
                <th style="border:1px solid black;background-color
                :lime">Grade</th>
                <th style="border:1px solid black;background-color
                :lime">Grade Code</th>
            </tr>
            ';
        if(@$data['grades']){
            foreach(@$data['grades'] as $value){
                $t .= '
                <tr>
                    <td style="border:1px solid black;">'.@$value->grade_name.'</td>
                    <td style="border:1px solid black;">'.@$value->capture_code.'</td>

                </tr>';
            }
        }
        $t .= '</table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=GradeManagement.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
    }
}
