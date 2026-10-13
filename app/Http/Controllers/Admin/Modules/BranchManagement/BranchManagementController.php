<?php

namespace App\Http\Controllers\Admin\Modules\BranchManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\TutorshipPlan;
use App\Models\Branch;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BranchManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function ajaxDuplicateBranchCheck(Request $request){
        try{
            $branch = trim(@$request->branch_name);
            $branch = Branch::where('branch_name',@$request->branch_name)->whereIn('status',['I','A'])->whereNotIn('id',[@$request->branch_id])->first();
            if(@$branch){
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
            $capture_code = trim(@$request->capture_code);
            $branch = Branch::where('capture_code',@$request->capture_code)->whereIn('status',['I','A'])->whereNotIn('id',[@$request->branch_id])->first();
            if(@$branch){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function branchManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $branch = Branch::whereIn('status',['I','A']);
        if(@$request->columns['1']['search']['value']){
            $branch = $branch->where(function($query) use($request) {
                $query->Where('branch_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('capture_code','like','%'.$request->columns['1']['search']['value'].'%');
            });
        }
        $ps =  $branch->count();
        $pp = $branch;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $branch = $branch;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $branch = $branch->orderBy('branch_name','asc');
            } else {
                $branch = $branch->orderBy('branch_name','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $branch = $branch->orderBy('capture_code','asc');
            } else {
                $branch = $branch->orderBy('capture_code','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $branch = $branch->orderBy('display_order','asc');
            } else {
                $branch = $branch->orderBy('display_order','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $branch = $branch->orderBy('id','asc');
            } else {
                $branch = $branch->orderBy('id','desc');
            }
        }

        $branch = $branch->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $branch;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    /*
    * Method        : index
    * Description   : This method is used to manage subject!
    * Author        : Jayatri
    */
    public function index(Request $request){
        try{
            $data['branches'] = Branch::whereIn('status',['I','A']);
            if(@$request->all()) {
                if(@$request->keyword) {
                    $data['branches'] = $data['branches']->where(function($q1) use($request) {
                        $q1 = $q1->where('branch_name','like','%'.$request->keyword.'%');
                    });
                }
            }
            $data['branches']= $data['branches']->paginate(10);
            $data['key'] = @$request->all();
            return view('admin.modules.branch_management.manage_branch')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : viewBranch
    * Description   : This method is used to view branch!
    * Author        : Jayatri
    */
    public function viewBranch($id,Request $request){
        try{
            $branch = Branch::with(['getAllSubjects'])->where('id',$id)->first();
            if(@$branch){
                return view('admin.modules.subjects_management.view_subject')->with(['branch'=>$branch]);
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
    * Method        : addBranch
    * Description   : This method is used to add branch!
    * Author        : Jayatri
    */
    public function addBranch(Request $request){
        try{
            if(@$request->all()){
                $request->validate(['branch_name' => 'required']);
                @$branch = Branch::where('branch_name',@$request->branch_name)->whereNotIn('status',['D'])->first();

                if(!@$branch){
                    $addbranch['branch_name'] = @$request->branch_name;
                    $addbranch['capture_code'] = @$request->capture_code;
                    $addbranch['display_order'] = @$request->display_order;
                    $addbranch['slug'] = Str::slug(@$request->branch_name)."-".time();
                    $addbranch['status'] = 'A';
                    $branch = Branch::create($addbranch);
                    $updateSubject['slug'] = Str::slug(@$request->branch)."-".$branch->id;
                    Branch::where(['id'=>$branch->id])->update($updateSubject);
                    session()->flash("success","Branch added successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Branch exists!");
                    return redirect()->back();
                }

            }else{
                return view('admin.modules.branch_management.add_branch');
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
    public function editBranch($id,Request $request){
        try{
            $data['branch'] = Branch::where('id',$id)->first();
            if(@$request->all()){
                @$branch = Branch::where('branch_name',@$request->branch_name)->whereIn('status',['I','A'])->whereNotIn('id',[$id])->first();
                if(!@$branch){
                    $updatebranch['branch_name'] = @$request->branch_name;
                    $updatebranch['slug'] = Str::slug(@$request->branch_name)."-".$id;
                    $updatebranch['capture_code'] = @$request->capture_code;
                    $updatebranch['display_order'] = @$request->display_order;
                    Branch::where('id',$id)->update($updatebranch);
                    $data['branch'] = Branch::where('id',$id)->first();
                    session()->flash("success",$data['branch']->branch_name. " branch updated successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Branch already exists!");
                    return redirect()->route('manage.branches');
                }
            }else{
                return view('admin.modules.branch_management.edit_branch')->with($data);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function ajaxDeleteBranch(Request $request){
        try{
            $id = @$request->data['id'];
            $branch = Branch::where('id',$id)->first();
            if(@$branch){
                $tot = Subject::where(['branch_id'=>$branch->id])->whereIn('status',['I','A'])->count();
                if($tot<= 0){
                    Branch::where('id',$id)->update(['status'=>'D']);
                $data['status'] = 1;
                $data['message'] = $branch->branch_name." branch is deleted!";
                return response()->json($data,200);
                }else{

                $data['status'] = 0;
                $data['message'] = $branch->branch_name." branch associated with subjects!";
                return response()->json($data,200);
                }

            }else{

                $data['status'] = 0;
                $data['message'] = "Branch is not found associated with id!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            $data['status'] = 0;
            $data['message'] = "Branch is not found associated with id!";
            return response()->json($data,200);
        }
    }
    /*
    * Method        : deleteSubject
    * Description   : This method is used to delete subject!
    * Author        : Jayatri
    */
    public function deleteBranch($id,Request $request){

    }
    public function changeStatusBranch($id,Request $request){
        try{
            $branch = Branch::where('id',$id)->first();
            if(@$branch){
                if($branch->status == 'A'){
                    $updateStatus['status'] = 'I';
                    $status = "Inctive";
                    Branch::where('id',$id)->update($updateStatus);
                    session()->flash("success","Status updated successfully! ");
                }elseif($branch->status == 'I'){
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    Branch::where('id',$id)->update($updateStatus);
                    session()->flash("success","Status updated successfully! ");
                }
                return redirect()->back();
            }else{
                session()->flash("error","Branch is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function getBranchManagementList(Request $request){
        $data['branches'] = Branch::whereIn('status',['I','A']);
        if(@$request->branch_name){
            $data['branches'] = $data['branches']->where(function($query) use($request) {
                $query->where('branch_name','like','%'.$request->branch_name.'%')
                ->orWhere('capture_code','like','%'.$request->capture_code.'%');
            });
        }
        $data['branches'] = $data['branches']->orderBy('id','desc')->get();
        $t = '';
        $t .='<table>
            <tr>
                <th style="border:1px solid black;background-color
                :lime">Branch</th>
                <th style="border:1px solid black;background-color
                :lime">Branch Code</th>
                  <th style="border:1px solid black;background-color
                :lime">Status</th>
            </tr>
            ';
        if(@$data['branches']){
            foreach(@$data['branches'] as $value){
                $t .= '
                <tr>
                    <td style="border:1px solid black;">'.@$value->branch_name.'</td>
                    <td style="border:1px solid black;">'.@$value->capture_code.'</td>
                     <td style="border:1px solid black;">'.@$value->status.'</td>


                </tr>';
            }
        }
        $t .= '</table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=BranchManagement.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
    }
}
