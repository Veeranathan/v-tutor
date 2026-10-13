<?php

namespace App\Http\Controllers\Admin\Modules\SubjectTopicsDetails;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\SubjectTopics;
use App\Models\ExpToSubject;
use App\Models\Branch;
use App\Models\TopicDetail;
use Illuminate\Support\Facades\Validator;
class SubjectTopicsDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

   
   public function topicsDetailsManagement(Request $request)
{
    $columnIndex = $request->order[0]['column'];
    $columnSortOrder = $request->order[0]['dir'];

    $topics = TopicDetail::with(['getSubject', 'getGrade', 'getBranch','getTopic'])->whereIn('status', ['I', 'A']);

    if (@$request->columns['1']['search']['value']) {
        $topics = $topics->where('grade_id', $request->columns['1']['search']['value']);
    }

    if (@$request->columns['2']['search']['value']) {
        $topics = $topics->where('branch_id', $request->columns['2']['search']['value']);
    }

    if (@$request->columns['3']['search']['value']) {
        $topics = $topics->where('subject_id', $request->columns['3']['search']['value']);
    }
    if (@$request->columns['3']['search']['value']) {
        $topics = $topics->where('topic_id', $request->columns['4']['search']['value']);
    }

    if (@$request->columns['5']['search']['value'] || @$request->columns['6']['search']['value'] || @$request->columns['7']['search']['value']) {
        $topics = $topics->where(function ($query) use ($request) {
            if (@$request->columns['5']['search']['value']) {
                $query->where('topic_det_code', 'like', '%' . $request->columns['5']['search']['value'] . '%');
            }
            if (@$request->columns['6']['search']['value']) {
                $query->orWhere('session_focus', 'like', '%' . $request->columns['6']['search']['value'] . '%');
            }
            if (@$request->columns['7']['search']['value']) {
                $query->orWhere('learning_outcome', 'like', '%' . $request->columns['7']['search']['value'] . '%');
            }
        });
    }
    

    if (@$request->columns['8']['search']['value']) {
        $topics = $topics->where('status', $request->columns['']['search']['value']);
    }

    $ps = $topics->count();
    $pp = $ps;

    // Ordering
    if ($columnIndex == 0) {
        $topics = $topics->orderBy('grade_id', $columnSortOrder);
    }
    if ($columnIndex == 1) {
        $topics = $topics->orderBy('branch_id', $columnSortOrder);
    }
    if ($columnIndex == 2) {
        $topics = $topics->orderBy('subject_id', $columnSortOrder);
    }
    if ($columnIndex == 4) {
        $topics = $topics->orderBy('topic_id', $columnSortOrder);
    }
    if ($columnIndex == 5) {
        $topics = $topics->orderBy('topic_det_code', $columnSortOrder);
    }
    if ($columnIndex == 6) {
        $topics = $topics->orderBy('session_focus', $columnSortOrder);
    }
    if ($columnIndex == 7) {
        $topics = $topics->orderBy('learning_outcome', $columnSortOrder);
    }
    if ($columnIndex == 8) {
        $topics = $topics->orderBy('status', $columnSortOrder);
    }
     if ($columnIndex == 9) {
        $topics = $topics->orderBy('id', $columnSortOrder);
    }
    // Pagination
    $topics = $topics->skip($request->start)->take($request->length)->get();

    $data['aaData'] = $topics;
    $data['draw'] = intval($request->draw);
    $data['iTotalRecords'] = $ps;
    $data['iTotalDisplayRecords'] = $pp;

    return response()->json($data);
}
 
 

public function index(Request $request)
{
    $data['branches'] = Branch::where(['status'=>'A'])->get();
    $data['grades'] = Grade::whereIn('status',['A'])->select('id','grade_name','status')->orderBy('id','asc')->get();
    $data['subjects'] = Subject::whereIn('status',['A'])->select('id','subject','status')->orderBy('subject','asc')->get();
    $data['topicdetail'] = TopicDetail::whereIn('status',['A'])->select('id','topic_det_code','session_focus','learning_outcome','status')->orderBy('topic_id','asc')->get();
    $data['details'] = TopicDetail::with(['getBranch', 'getSubject', 'getGrade','getTopic'])
        ->where('status', '!=', 'D')
        ->orderBy('id', 'ASC')
        ->get();
   

    return view('admin.modules.topics_details.manage_topics_details',$data);
}
 
    public function viewTopicsDetails($id,Request $request){
        try{
            $topics = TopicDetail::with(['getBranch','getSubject', 'getGrade','getTopic'])->where('id',$id)->first();
            if(@$topics){
                return view('admin.modules.topics_details.view_topic_details')->with(['topics'=>$topics]);
            }else{
                session()->flash("error","Topics is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
  
  public function addTopicsDetails(Request $request) {
    try {
        $data['grades'] = Grade::where(['status' => 'A'])->get();
        $data['branches'] = Branch::where(['status' => 'A'])->get();
        $data['subjects'] = Subject::where(['status' => 'A'])->get();
        $data['topics'] = SubjectTopics::where(['status' => 'A'])->get();

        if ($request->isMethod('post')) {
            $request->validate([
                'topic_id' => 'required',
                'grade_id' => 'required|integer',
                'branch_id' => 'required|integer',
                'subject_id' => 'required|integer',
                'topic_det_code' => 'required|string|max:15',
                'session_focus' => 'required|string|max:255',
                'learning_outcome' => 'required|string|max:255'

            ]);

            $addtopicdetails = [
                'grade_id' => $request->grade_id,
                'branch_id' => $request->branch_id,
                'subject_id' => $request->subject_id,
                'topic_id' => $request->topic_id,
                'topic_det_code' => $request->topic_det_code,
                'session_focus' => $request->session_focus,
                'learning_outcome' => $request->learning_outcome,
                'status' => 'A',
            ];

            $topicDetail = TopicDetail::create($addtopicdetails);

            // Optional: update slug with ID for uniqueness
            $slugWithId = Str::slug($request->topicDetail) . "-" . $topicDetail->id;
            TopicDetail::where('id', $topicDetail->id)->update(['slug' => $slugWithId]);

            session()->flash("success", "Topic Details added successfully!");
            return redirect()->back();
        }

        return view('admin.modules.topics_details.topic_details')->with($data);

    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash("error", $e->getMessage());
        return redirect()->back();
    }
}
    /*
    * Method        : editTopics
    * Description   : This method is used to edit & update subject!
    * Author        : Iniya
    */
     public function checkTopicCode(Request $request)
{
    $query = TopicDetail::where('topic_det_code', $request->topic_code)
        ->where('branch_id', $request->branch_id)
        ->where('grade_id', $request->grade_id)
        ->where('subject_id', $request->subject_id);

    // if editing, exclude current detail row by its ID
    if ($request->filled('detail_id')) {
        $query->where('id', '!=', $request->detail_id);
    }

    $exists = $query->exists();

    return response()->json(['exists' => $exists]);
}
public function editTopicsDetails($id, Request $request)
{
    try {
        // Get the topic based on the ID and eager load the relationships
        $topic_details = TopicDetail::with(['getBranch', 'getGrade', 'getSubject','getTopic'])->findOrFail($id);

        // Get other required data
        $branches = Branch::where('status', 'A')->get();
        $grades = Grade::where('status', 'A')->get();
        $subjects = Subject::where('branch_id', $topic_details->branch_id)->where('status', 'A')->get();
        $topics = SubjectTopics::where('subject_id', $topic_details->subject_id)->where('status', 'A')->get();

        // If the request contains data (i.e. form submission), attempt to update the topic
        if ($request->all()) {
            $existingTopic = TopicDetail::where('topic_det_code', $request->topic_det_code)
    ->where('branch_id', $request->branch_id)
    ->where('grade_id', $request->grade_id)
    ->where('subject_id', $request->subject_id)
    ->where('topic_id', $request->topic_id)
    ->where('id', '!=', $id)
    ->exists();

if ($existingTopic) {
    session()->flash("error", "Topic Detail code already exists!");
    return redirect()->route('manage.topics.details');
}

            if (!$existingTopic) {
                // Prepare the update data
                $updateTopic = [
                    'branch_id' => $request->branch_id,
                    'grade_id' => $request->grade_id,
                    'subject_id' => $request->subject_id,
                    'topic_id' => $request->topic_id,
                    'topic_det_code' => $request->topic_det_code,
                     'session_focus' => $request->session_focus,
                'learning_outcome' => $request->learning_outcome,
                    'slug' => Str::slug($request->topics) . "-" . $id
                ];

                // Update the topic
                TopicDetail::where('id', $id)->update($updateTopic);

                // Reload the topic after update
                $topic_details = TopicDetail::where('id', $id)->first();

                session()->flash("success", $topic_details->session_focus . " topic details updated successfully!");
                return redirect()->back();
            } else {
                session()->flash("error", "Topic Detail already exists!");
                return redirect()->route('manage.topics.details');
            }
        }
       
        // If the form isn't submitted yet, return the view with the topic data
        return view('admin.modules.topics_details.edit_topic_details', compact('topic_details', 'branches', 'grades', 'subjects','topics'));

    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash("error", $e->getMessage());
        return redirect()->back();
    }
}


public function ajaxDeleteTopicsDetails(Request $request)
{
    try {
        $id = $request->data['id'] ?? null;
  
        if (!$id) {
            return response()->json([
                'status' => 0,
                'message' => "Invalid topic ID!"
            ], 200);
        }

        $topic = TopicDetail::find($id);

        if ($topic) {
            // No need to check tutorship plans or expToSubject because it's for Topics, not Subjects.
            TopicDetail::where('id', $id)->update(['status' => 'D']); // Soft delete by setting status to D

           return response()->json([
    'status' => 1,
    'message' => "Topic details deleted successfully!"
], 200);
        } else {
            return response()->json([
                'status' => 0,
                'message' => "Topic details not found!"
            ], 200);
        }
    } catch (\Exception $e) {
        \Log::error($e->getMessage());

        return response()->json([
            'status' => 0,
            'message' => "Something went wrong. Please try again!"
        ], 200);
    }
}


    
    
    public function deleteTopicsDetails($id, Request $request)
{
    try {
        $topic = TopicDetail::find($id);

        if ($topic) {
            // Soft delete by setting status to 'D'
            $topic->status = 'D';
            $topic->save();

            session()->flash('success', $topic->session_focus . "  is deleted successfully!");
        } else {
            session()->flash('error', "Topic Details not found with ID: " . $id);
        }

        return redirect()->back();
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash('error', "Something went wrong! " . $e->getMessage());
        return redirect()->back();
    }
}
public function changeStatusTopicsDetails($id, Request $request)
{
    try {
        $subject = TopicDetail::find($id);
        if ($subject) {
            if ($subject->status == 'A') {
                $subject->status = 'I';
                $status = "Inactive";
            } elseif ($subject->status == 'I') {
                $subject->status = 'A';
                $status = "Active";
            }
            $subject->save(); // <<<<<< You forgot this earlier

            session()->flash("success", "Status updated successfully!");
            return redirect()->back();
        } else {
            session()->flash("error", "Topic Details not found!");
            return redirect()->back();
        }
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash("error", $e->getMessage());
        return redirect()->back();
    }
}
 public function ajaxChangeStatusSubject(Request $request)
{
    try {
        $id = $request->input('id');  // Get ID from request
        
        $subject = TopicDetail::find($id);

        if (!$subject) {
            return response()->json([
                'status' => 'error',
                'message' => 'Topic not found!'
            ]);
        }

        if ($subject->status == 'A') {
            $subject->status = 'I';
            $newStatus = "Inactive";
        } else {
            $subject->status = 'A';
            $newStatus = "Active";
        }

        $subject->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!',
            'new_status' => $subject->status,
        ]);

    } catch (\Exception $e) {
        \Log::error($e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong: ' . $e->getMessage()
        ]);   
    }
}

    public function getTopicsDetailsManagementList(Request $request)
  {
  $topicdetails = TopicDetail::with(['getGrade', 'getBranch', 'getSubject','getTopic'])
        ->whereIn('status', ['I', 'A']);

    // Apply filters if present
    if ($request->session_focus || $request->topic_det_code || $request->learning_outcome) {
        $topicdetails = $topicdetails->where(function ($query) use ($request) {
            if ($request->session_focus) {
                $query->where('session_focus', 'like', '%' . $request->session_focus . '%');
            }
            if ($request->topic_det_code) {
                $query->orWhere('topic_det_code', 'like', '%' . $request->topic_det_code . '%');
            }
           if ($request->learning_outcome) {
                $query->orWhere('learning_outcome', 'like', '%' . $request->learning_outcome . '%');
            }
        });
    }

   
    if ($request->ajax()) {
        return DataTables::of($topicdetails)
            ->addColumn('grade_id', fn($row) => $row->getGrade->grade_name ?? '')
            ->addColumn('branch_id', fn($row) => $row->getBranch->branch_name ?? '')
            ->addColumn('subject_id', fn($row) => $row->getSubject->subject ?? '')
            ->addColumn('topic_id', fn($row) => $row->getTopic->topics ?? '')
            ->addColumn('status', fn($row) => $row->status === 'A' ? 'Active' : 'Inactive')
            ->addColumn('action', function ($row) {
                $id = $row->id;
                $statusLabel = $row->status === 'A' ? 'Hide' : 'Show';
                return '
                    <a href="javascript:void(0);" class="action-dots action" data-key="'.$id.'" id="action'.$id.'">
                        <img src="'.asset('public/admin/assets/images/action-dots.png').'" alt="">
                    </a>
                    <div class="show-actions" id="show-action'.$id.'" style="display: none;">
                        <span class="angle"><img src="'.asset('public/admin/assets/images/angle.png').'" alt=""></span>
                        <ul>
                            <li><a href="'.url('admin/edit-topics-details/'.$id).'">Edit</a></li>
                            <li><a href="'.url('admin/change-status-topic-details/'.$id).'">'.$statusLabel.'</a></li>
                            <li><a class="delete_subject" data-id="'.$id.'" href="javascript:void(0);">Delete</a></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    
    if ($request->has('export') && $request->export == 'excel') {
        $topicdetails = $topicdetails->orderBy('id', 'desc')->get();

        $t = '<table>
            <tr>
                <th style="border:1px solid black;background-color:lime">Grade</th>
                <th style="border:1px solid black;background-color:lime">Branch</th>
                <th style="border:1px solid black;background-color:lime">Subject</th>
                <th style="border:1px solid black;background-color:lime">Topics</th>
                <th style="border:1px solid black;background-color:lime">Details Code</th>
 <th style="border:1px solid black;background-color:lime">Session Focus</th>
<th style="border:1px solid black;background-color:lime">Learning Outcome</th>
                <th style="border:1px solid black;background-color:lime">Status</th>
                <th style="border:1px solid black;background-color:lime">Action</th>
            </tr>';

        foreach ($topicdetails as $value) {
            $CurStatus = $value->status == 'I' ? 'Inactive' : 'Active';
            $t .= '<tr>
                <td style="border:1px solid black;">' . ($value->getGrade->grade_name ?? '') . '</td>
                <td style="border:1px solid black;">' . ($value->getBranch->branch_name ?? '') . '</td>
                <td style="border:1px solid black;">' . ($value->getSubject->subject ?? '') . '</td>
<td style="border:1px solid black;">' . ($value->getTopic->topics ?? '') . '</td>
                <td style="border:1px solid black;">' . $value->topic_det_code . '</td>
                <td style="border:1px solid black;">' . $value->session_focus . '</td>
<td style="border:1px solid black;">' . $value->learning_outcome . '</td>
                <td style="border:1px solid black;">' . $CurStatus . '</td>
                <td style="border:1px solid black;">' . $value->id . '</td>
            </tr>';
        }

        $t .= '</table>';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=TopicsDetailsManagement.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
        exit;
    }

    return response()->json(['error' => 'Invalid request.'], 400);
}
}