<?php

namespace App\Http\Controllers\Admin\Modules\SubjectManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\TutorshipPlan;
use App\Models\ExpToSubject;
use App\Models\SubjectTopics;
use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class SubjectManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function ajaxDuplicateSubjectCheck(Request $request){
        try{
            $subject = trim(@$request->subject);
            $branch_id = trim(@$request->branch_id);
            if(@$request->branch_id){
                $subject = Subject::where(['subject'=>@$request->subject,'branch_id'=>$request->branch_id])->whereIn('status',['I','A'])->whereNotIn('id',[@$request->subject_id])->first();
            }else{
                $subject = Subject::where('subject',@$request->subject)->whereIn('status',['I','A'])->whereNotIn('id',[@$request->subject_id])->first();
            }

            if(@$subject){
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
            $subject = trim(@$request->capture_code);
            $subject = Subject::where('capture_code',@$request->capture_code)->whereIn('status',['I','A'])->whereNotIn('id',[@$request->subject_id])->first();
            if(@$subject){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function subjectManagement(Request $request)
{
    $columnIndex = $request->order[0]['column'] ?? 0;
    $columnSortOrder = $request->order[0]['dir'] ?? 'asc';
    $start = $request->start ?? 0;
    $limit = $request->length ?? 10;

    // Build initial query with relationships
    $query = Subject::with(['getGrade', 'getBranch'])->whereIn('status', ['I', 'A']);

    // Filtering
    if (!empty($request->columns[2]['search']['value'])) {
        $query->where('grade_id', $request->columns[2]['search']['value']);
    }

    if (!empty($request->columns[3]['search']['value'])) {
        $query->where('branch_id', $request->columns[3]['search']['value']);
    }

    if (!empty($request->columns[1]['search']['value'])) {
        $search = $request->columns[1]['search']['value'];
        $query->where(function ($q) use ($search) {
            $q->where('subject', 'like', '%' . $search . '%')
              ->orWhere('capture_code', 'like', '%' . $search . '%');
        });
    }

    if (!empty($request->columns[4]['search']['value'])) {
        $query->where('status', $request->columns[4]['search']['value']);
    }

    $totalRecords = $query->count();

    // Dynamic ordering
    $columns = ['branch_id', 'subject', 'grade_id', 'capture_code', 'display_order', 'id'];
    $orderByColumn = $columns[$columnIndex] ?? 'id';
    $query->orderBy($orderByColumn, $columnSortOrder);

    // Pagination
    $subjects = $query->skip($start)->take($limit)->get();

    // Return response for DataTables
    return response()->json([
        'draw' => intval($request->draw),
        'iTotalRecords' => $totalRecords,
        'iTotalDisplayRecords' => $totalRecords,
        'data' => $subjects
    ]);
}

    /*
    * Method        : index
    * Description   : This method is used to manage subject!
    * Author        : Jayatri
    */
    public function index(Request $request){
        try{
            $data['grades'] = Grade::whereIn('status',['A'])->get();
            $data['branches'] = Branch::where(['status'=>'A'])->get();
            $data['subjects'] = Subject::whereIn('status',['I','A']);
            if(@$request->all()) {
                if(@$request->keyword) {
                    $data['subjects'] = $data['subjects']->where(function($q1) use($request) {
                        $q1 = $q1->where('subject','like','%'.$request->keyword.'%');
                    });
                }
            }
            $data['subjects']= $data['subjects']->paginate(10);
            $data['key'] = @$request->all();
            return view('admin.modules.subjects_management.manage_subjects')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : viewSubject
    * Description   : This method is used to view subject!
    * Author        : Jayatri
    */
    public function viewSubject($id,Request $request){
        try{
            $subject = Subject::with('getBranch','getGrade')->where('id',$id)->first();
            if(@$subject){
                return view('admin.modules.subjects_management.view_subject')->with(['subject'=>$subject]);
            }else{
                session()->flash("error","Subject is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : addSubject
    * Description   : This method is used to add subject!
    * Author        : Jayatri
    */
    public function addSubject(Request $request){
        try{
            $data['grades'] = Grade::whereIn('status',['A'])->select('id','grade_name','status')->orderBy('grade_name','asc')->get();
            $data['branches'] = Branch::where(['status'=>'A'])->get();
            if(@$request->all()){
                $request->validate(['subject' => 'required']);
                @$subject = Subject::where(['subject'=>@$request->subject,'branch_id'=>@$request->branch_id])->whereNotIn('status',['D'])->first();

                if(!@$subject){
                    $addsubject['grade_id'] = @$request->grade_id;
                    $addsubject['branch_id'] = @$request->branch_id;
                    $addsubject['subject'] = @$request->subject;
                    $addsubject['capture_code'] = @$request->capture_code;
                    $addsubject['display_order'] = @$request->display_order;
                    $addsubject['slug'] = Str::slug(@$request->subject)."-".time();
                    $addsubject['status'] = 'A';
                    $subject = Subject::create($addsubject);
                    $updateSubject['slug'] = Str::slug(@$request->subject)."-".$subject->id;
                    Subject::where(['id'=>$subject->id])->update($updateSubject);
                    session()->flash("success","Subject added successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Subject exists!");
                    return redirect()->back();
                }

            }else{
                return view('admin.modules.subjects_management.subject')->with($data);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : editSubject
    * Description   : This method is used to edit & update subject!
    * Author        : Jayatri
    */
    public function editSubject($id,Request $request){
        try{
            $data['grades'] = Grade::whereIn('status',['A'])->select('id','grade_name','status')->orderBy('grade_name','asc')->get();
            $data['branches'] = Branch::where(['status'=>'A'])->get();
            $data['subject'] = Subject::where('id',$id)->first();
            if(@$request->all()){
                @$subject = Subject::where(['subject'=>@$request->subject,'branch_id'=>@$request->branch_id])->whereIn('status',['I','A'])->whereNotIn('id',[$id])->first();
                if(!@$subject){
                    $updatesubject['grade_id'] = @$request->grade_id;
                    $updatesubject['branch_id'] = @$request->branch_id;
                    $updatesubject['subject'] = @$request->subject;
                    $updatesubject['slug'] = Str::slug(@$request->subject)."-".$id;
                    $updatesubject['capture_code'] = @$request->capture_code;
                    $updatesubject['display_order'] = @$request->display_order;
                    Subject::where('id',$id)->update($updatesubject);
                    $data['subject'] = Subject::where('id',$id)->first();
                    session()->flash("success",$data['subject']->subject. " subject updated successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Subject already exists!");
                    return redirect()->route('manage.subjects');
                }
            }else{
                return view('admin.modules.subjects_management.edit_subject')->with($data);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function ajaxDeleteSubject(Request $request){
        try{
            $id = @$request->data['id'];
            $subject = Subject::where('id',$id)->first();
            if(@$subject){
                $tutorshipplan = TutorshipPlan::with(['getUser'])->where(['subject_id'=>$id]);
                $isGradeExpToSubList = ExpToSubject::where(['subject_id'=>$id])->first();
                if(@$isGradeExpToSubList){
                    $data['status'] = 0;
                    $data['message'] = "Subject is not deleted!Subject is associated with user!";
                    return response()->json($data,200);
                }
                $tutorshipplan = $tutorshipplan->whereHas('getUser',function($q1) use($request) {
                    $q1 = $q1->whereNotIn('status',['D']);
                });
                $tutorshipplan = $tutorshipplan->whereIn('status',['A','I'])->first();
                if(@$tutorshipplan){
                    // session()->flash("error","Subject is not deleted!Subject is associated with user!");
                    $data['status'] = 0;
                    $data['message'] = "Subject is not deleted!Subject is associated with user!";
                    return response()->json($data,200);
                }else{
                    Subject::where('id',$id)->update(['status'=>'D']);
                    $data['status'] = 1;
                    $data['message'] = $subject->subject." subject is deleted!";
                    return response()->json($data,200);
                    // session()->flash("success",$subject->subject." subject is deleted!");
                }
            }else{

                $data['status'] = 0;
                $data['message'] = "Subject is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            $data['status'] = 0;
            $data['message'] = "Subject is not found associated with id!";
            return response()->json($data,200);
        }
        // $id = @$request->id;
        // $subject = Subject::whereId($id)->first();
        // if(@$subject){
        //     Subject::whereId($id)->update(['status'=>'D']);
        //     return 1;
        // }else{
        //     return 0;
        // }
    }
    public function ajaxChangeStatusSubject(Request $request){
        try{
            $id = @$request->data['id'];
            $subject = Subject::where('id',$id)->first();
            $changeStatus = @$subject->status;
            if(@$subject){
                $tutorshipplan = TutorshipPlan::with(['getUser'])->where(['subject_id'=>$id]);
                $isGradeExpToSubList = ExpToSubject::where(['subject_id'=>$id])->first();
                if(@$isGradeExpToSubList){
                    $data['status'] = 0;
                    $data['message'] = "You cannot hide the subject!Subject is associated with user!";
                    return response()->json($data,200);
                }
                $tutorshipplan = $tutorshipplan->whereHas('getUser',function($q1) use($request) {
                    $q1 = $q1->whereNotIn('status',['D']);
                });
                $tutorshipplan = $tutorshipplan->whereIn('status',['A','I'])->first();
                if(@$tutorshipplan){

                    $data['status'] = 0;
                    $data['message'] = "You cannot hide the subject!Subject is associated with user!";
                    return response()->json($data,200);
                }else{
                    if(@$subject->status == 'A'){
                        Subject::where('id',$id)->update(['status'=>'I']);
                        $changeStatus= "inactive";
                        $subject = Subject::where('id',$id)->first();
                        $data['status'] = 1;
                        $data['message'] = $subject->subject." subject is ".$changeStatus."! Subject will not be visible on the platform!";
                        return response()->json($data,200);
                    }else{
                        Subject::where('id',$id)->update(['status'=>'A']);
                        $changeStatus= "activated";
                        $subject = Subject::where('id',$id)->first();
                        $data['status'] = 1;
                        $data['message'] = $subject->subject." subject is ".$changeStatus."! ";
                        return response()->json($data,200);
                    }
                }
            }else{
                $data['status'] = 0;
                $data['message'] = "Subject is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            $data['status'] = 0;
            $data['message'] = "Subject is not found associated with id!";
            return response()->json($data,200);
        }
    }


    /*
    * Method        : deleteSubject
    * Description   : This method is used to delete subject!
    * Author        : Jayatri
    */
    public function deleteSubject($id,Request $request){
        // try{
        //     $subject = Subject::where('id',$id)->first();
        //     if(@$subject){
        //         $tutorshipplan = TutorshipPlan::with(['getUser'])->where(['subject_id'=>$id]);
        //         $tutorshipplan = $tutorshipplan->whereHas('getUser',function($q1) use($request) {
        //             $q1 = $q1->whereNotIn('status',['D']);
        //         });
        //         $tutorshipplan = $tutorshipplan->whereIn('status',['A','I'])->first();
        //         if(@$tutorshipplan){

        //             session()->flash("error","Subject is not deleted!Subject is associated with user!");
        //         }else{
        //             Subject::where('id',$id)->update(['status'=>'D']);
        //             session()->flash("success",$subject->subject." subject is deleted!");
        //         }

        //         return redirect()->back();
        //     }else{

        //         session()->flash("error","Subject is not found associated with id : ".$id);
        //         return redirect()->back();
        //     }
        // }catch(\Exception $e){
        //     \Log::error($e->getMessage());
        //     session()->flash("error",$e->getMessage());
        //     return redirect()->back();
        // }
    }
    public function changeStatusSubject($id,Request $request){
        try{
            $subject = Subject::where('id',$id)->first();
            if(@$subject){
                if($subject->status == 'A'){
                    $updateStatus['status'] = 'I';
                    $status = "Inctive";
                    User::where('id',$id)->update($updateStatus);
                    session()->flash("success","Status updated successfully! ");
                }elseif($subject->status == 'I'){
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    User::where('id',$id)->update($updateStatus);
                    session()->flash("success","Status updated successfully! ");
                }
                return redirect()->back();
            }else{
                session()->flash("error","Student is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function getSubjectManagementList(Request $request){
        $data['subjects'] = Subject::with('getBranch','getGrade')->whereIn('status',['I','A']);
        if(@$request->subject){
            $data['subjects'] = $data['subjects']->where(function($query) use($request) {
                $query->where('subject','like','%'.$request->subject.'%')
                ->orWhere('capture_code','like','%'.$request->capture_code.'%');
            });
        }
        $data['subjects'] = $data['subjects']->orderBy('id','desc')->get();
        $t = '';
        $t .='<table>
            <tr>
                <th style="border:1px solid black;background-color
                :lime">Subject</th>
                <th style="border:1px solid black;background-color
                :lime">Subject Code</th>
                <th style="border:1px solid black;background-color:lime">Status</th>
            </tr>
            ';
        if(@$data['subjects']){
            foreach(@$data['subjects'] as $value){
                if(@$value->status == 'I'){
                    $CurStatus = 'Inactive';
                }else{
                    $CurStatus = 'Active';
                }
                $t .= '
                <tr>
                    <td style="border:1px solid black;">'.@$value->subject.'</td>
                    <td style="border:1px solid black;">'.@$value->capture_code.'</td>
                    <td style="border:1px solid black;">'.@$CurStatus.'</td>

                </tr>';
            }
        }
        $t .= '</table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=SubjectManagement.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
    }
}
