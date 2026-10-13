<?php

namespace App\Http\Controllers\SchoolList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\TestTable;
use App\Models\Subject;
use App\Models\Branch;

class SchoolListController extends Controller
{
    
    public function getAllSchools(Request $request){
        // dd($request->all());
        $data['schools']=School::with(['getState','getSuburb']);
        if(@$request->search_school_name){
            $data['schools'] = $data['schools']->where(function($query) use($request) {
                $query->where('school_name','like','%'.$request->search_school_name.'%');
            });
        }
        // ->when($search, function ($q) use ($search) {
        //     $q->where('school_name', 'like', '%' . $search . '%')
        //         ->orWhere('head_teacher', 'like', '%' . $search . '%')
        //         ->orWhereHas('teachers', function ($sub) use ($search) {
        //             $sub->where('teacher_name', 'like', '%' . $search . '%');
        //         });
        //     });
        $data['count_schools'] = $data['schools']->count();
        $data['schools'] = $data['schools']->get();
        
        // search_school_name
        return response()->json($data,200);
    }
    public function addDescription(){
        
        $adDesc['test_description']="This is a test description";
        $cradDesc = TestTable::create($adDesc);
        $getAll = TestTable::get();
        // dd($getAll);
        echo "successfull";
    }
    public function getBranchSubjects(Request $request){
        $b = Branch::where(['slug'=>$request->data['without_login_branch_id']])->first();
        if(@$b){
            $data['subjects'] = Subject::where(['status'=>'A'])->where('branch_id',$b->id);
            $data['count'] = $data['subjects']->count();
            $data['subjects'] = $data['subjects']->orderBy('subject','asc')->get();
            $s2 = $data['subjects']->sortBy('subject', SORT_NATURAL);
            $s2 = $s2->values()->all();
            $data['subjects'] = $s2;
            try{
                $htmlResp = '';
                foreach(@$data['subjects'] as $subject){
                    $htmlResp = $htmlResp.'<option value="'.$subject->id.'">'.$subject->subject.'</option>';
                }
                $data['html_response'] = $htmlResp;
                return response()->json($data,200);
            }catch(\Exception $e){
                \Log::error($e->getMessage());
                $data['status'] = 0;
                $data['message'] = $e->getMessage();
                return response()->json($data,200);
            }    
        }else{
            $htmlResp = '';
            $data['html_response'] = $htmlResp;
            return response()->json($data,200);
        }
        
        
    }
}
