<?php

namespace App\Http\Controllers\Admin\Modules\AdminClassEndAssesment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentClassBooking;
use App\Models\ClassEndAssesment;
use App\Models\BookingToReviews;
use App\Models\User;

class AdminClassEndAsseesmentController extends Controller
{
    public function manageClassEndAssesment(Request $request){
        $data['posted_by'] = User::whereIn('status',['A','I','U'])->select('id','status','f_name','l_name')->get();
        $data['tutors'] = User::whereIn('status',['A','I','U'])->where('user_type',['T'])->select('id','status','f_name','l_name')->get();
        $data['students'] = User::whereIn('status',['A','I','U'])->where('user_type',['U'])->select('id','status','f_name','l_name')->get();
        return view('admin.modules.admin_class_end_assesment.admin_class_end_assesment')->with($data);
    }
    public function classEndAssesmentManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];

        $classEndAssesment = BookingToReviews::with(['bookingInfo.getStudent','bookingInfo.getTutor','getUser']);
        if(@$request->columns['1']['search']['value']){
            $classEndAssesment = $classEndAssesment->whereHas('bookingInfo',function($query) use($request) {
                $query->where('booking_no','like','%'.$request->columns['1']['search']['value'].'%');
            });
        }
        if(@$request->columns['2']['search']['value']){
            $classEndAssesment = $classEndAssesment->where(function($query) use($request) {
                $query->where('rating','>=',$request->columns['2']['search']['value']);
            });
        }
        if(@$request->columns['3']['search']['value'] && @$request->columns['4']['search']['value']){
            $classEndAssesment = $classEndAssesment->where(function($query) use($request) {
                $query->whereBetween('created_at',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }
        if(@$request->columns['5']['search']['value']){
            $classEndAssesment = $classEndAssesment->where(function($query) use($request) {
                $query->Where('user_id',$request->columns['5']['search']['value']);
            });
        }
        if(@$request->columns['6']['search']['value']){
            $classEndAssesment = $classEndAssesment->where(function($query) use($request) {
                $query->Where('user_id',$request->columns['6']['search']['value']);
            });
        }
        if(@$request->columns['7']['search']['value']){
            $classEndAssesment = $classEndAssesment->where(function($query) use($request) {
                $query->Where('user_id',$request->columns['7']['search']['value']);
            });
        }
        
        $ps =  $classEndAssesment->count();
        $pp = $classEndAssesment;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $classEndAssesment = $classEndAssesment;
        $p =  $p->count();
        if($columnIndex == 0) {

            if($columnSortOrder == 'asc') {
                $classEndAssesment = $classEndAssesment->orderBy('booking_id','asc');
            } else {
                $classEndAssesment = $classEndAssesment->orderBy('booking_id','desc');
            }
            // $classEndAssesment = $classEndAssesment->slice($request->start, $request->length)->values()->all();
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $classEndAssesment = $classEndAssesment->orderBy('user_id','asc');
            } else {
                $classEndAssesment = $classEndAssesment->orderBy('user_id','desc');
            }
            // $classEndAssesment = $classEndAssesment->slice($request->start, $request->length)->values()->all();
        }
        if($columnIndex == 2) {
            // $classEndAssesment1 = $classEndAssesment->get();
            // if($columnSortOrder == 'asc') {
            //     $classEndAssesment2 = $classEndAssesment1->sortBy(function($classEndAssesment, $key) {
            //         return $classEndAssesment['getUser']['f_name'];
            //     });

            //     $classEndAssesment = $classEndAssesment2->slice($request->start, $request->length)->values()->all();
            // }
            // else
            // {
            //     $classEndAssesment2 = $classEndAssesment1->sortByDesc(function($classEndAssesment, $key) {
            //         return $classEndAssesment['getUser']['f_name'];
            //     });

            //     $classEndAssesment = $classEndAssesment2->slice($request->start, $request->length)->values()->all();
            // }
            if($columnSortOrder == 'asc') {
                $classEndAssesment = $classEndAssesment->orderBy('user_id','asc');
            } else {
                $classEndAssesment = $classEndAssesment->orderBy('user_id','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $classEndAssesment = $classEndAssesment->orderBy('user_id','asc');
            } else {
                $classEndAssesment = $classEndAssesment->orderBy('user_id','desc');
            }
            // $classEndAssesment = $classEndAssesment->slice($request->start, $request->length)->values()->all();
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $classEndAssesment = $classEndAssesment->orderBy('rating','asc');
            } else {
                $classEndAssesment = $classEndAssesment->orderBy('rating','desc');
            }
            // $classEndAssesment = $classEndAssesment->slice($request->start, $request->length)->values()->all();
        }
        if($columnIndex == 5) {
            if($columnSortOrder == 'asc') {
                $classEndAssesment = $classEndAssesment->orderBy('created_at','asc');
            } else {
                $classEndAssesment = $classEndAssesment->orderBy('created_at','desc');
            }
            // $classEndAssesment = $classEndAssesment->slice($request->start, $request->length)->values()->all();
        }
        if($columnIndex == 6) {
            if($columnSortOrder == 'asc') {
                $classEndAssesment = $classEndAssesment->orderBy('created_at','asc');
            } else {
                $classEndAssesment = $classEndAssesment->orderBy('created_at','desc');
            }
            // $classEndAssesment = $classEndAssesment->slice($request->start, $request->length)->values()->all();
        }
        
        
        $classEndAssesment = $classEndAssesment->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $classEndAssesment;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
        
    }
    public function viewDetailsClassEndAssesment($id){
        $data['booking_to_review'] =BookingToReviews::with(['bookingInfo','getUser'])->where('id',$id)->first();
        $data['assesmentDetails'] = ClassEndAssesment::with(['bookingInfo','getUser','getQuestion','getAnswer'])->where('user_id',@$data['booking_to_review']->user_id)->first();
        $data['assesmentQA'] = ClassEndAssesment::with(['bookingInfo','getUser','getQuestion','getAnswer'])->where(['user_id'=>$data['assesmentDetails']->user_id,'booking_id'=>$data['assesmentDetails']->booking_id])->get();
        return view('admin.modules.admin_class_end_assesment.view_class_end_assesment_details')->with($data);
    }
    public function classEndAssesmentDtls(Request $request){

        $classEndAssesment = BookingToReviews::with(['bookingInfo','getUser']);
        if(@$request->booking_search){
            $classEndAssesment = $classEndAssesment->whereHas('bookingInfo',function($query) use($request) {
                $query->where('booking_no','like','%'.$request->booking_search.'%');
            });
        }
        $classEndAssesment = $classEndAssesment->orderBy('id','desc')->get();
        $t = '';
        $t .='<table>
            <tr>
                <th style="border:1px solid black;background-color
                :lime">Booking No</th>
                <th style="border:1px solid black;background-color
                :lime">Student/Tutor</th>
                <th style="border:1px solid black;background-color
                :lime">Posted By</th>
                <th style="border:1px solid black;background-color
                :lime">Rating</th>
                <th style="border:1px solid black;background-color
                :lime">Date</th>
            </tr>
            ';
        if(@$classEndAssesment){
            foreach(@$classEndAssesment as $value){
                $sT = '';
                if(@$value->getUser->user_type == 'T'){
                    $sT = 'Tutor';
                }else{
                    $sT = 'Student';
                }
                $t .= '
                <tr>
                    <td style="border:1px solid black;">'.@$value->bookingInfo->booking_no.'</td>
                    <td style="border:1px solid black;">'.$sT.'</td>
                    <td style="border:1px solid black;">'.@$value->getUser->f_name." ".@$value->getUser->l_name.'</td>
                    <td style="border:1px solid black;">'.@$value->rating.'</td>
                    <td style="border:1px solid black;">'.date('Y-m-d',strtotime($value->created_at)).'</td>
                </tr>';
            }
        }
        $t .= '</table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");    
        header("Content-Disposition: attachment; filename=AdminClassEndAssesment.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        echo $t;
        // return view('admin.modules.admin_class_end_assesment.admin_class_end_assesment');
    }
}
