<?php

namespace App\Http\Controllers\Admin\Modules\SubjectTopics;
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
class SubjectTopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

   public function exportTopics(Request $request)
{
    $topics = SubjectTopics::with(['getGrade','getBranch','getSubject'])
        ->whereIn('status', ['A','I'])
        ->orderBy('id','DESC')
        ->get();

    $filename = "topics_".date('Y-m-d_H-i-s').".xls";

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename=\"$filename\""
    ];

    $columns = [
        "ID", "Grade", "Branch", "Subject", "Topic", "Status"
    ];

    $callback = function() use ($topics, $columns) {
        $file = fopen('php://output', 'w');

        // Write headers
        fputcsv($file, $columns, "\t");

        // Write data
        foreach ($topics as $row) {
            fputcsv($file, [
                $row->id,
                $row->getGrade->grade_name ?? '',
                $row->getBranch->branch_name ?? '',
                $row->getSubject->subject ?? '',
                $row->topics,
                $row->status == 'A' ? 'Active' : 'Inactive'
            ], "\t");
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

  public function topicsManagement(Request $request)
{
    $columnIndex = $request->order[0]['column'];
    $columnSortOrder = $request->order[0]['dir'];
    $searchValue = $request->search['value'];

    // Base query
    $query = SubjectTopics::with(['getSubject', 'getGrade', 'getBranch'])
        ->whereIn('status', ['I', 'A']);

    // ============================
    //   INDIVIDUAL COLUMN FILTERS
    // ============================

    // Grade filter (Column 1)
    if (!empty($request->columns[1]['search']['value'])) {
        $query->where('grade_id', $request->columns[1]['search']['value']);
    }

    // Branch filter (Column 2)
    if (!empty($request->columns[2]['search']['value'])) {
        $query->where('branch_id', $request->columns[2]['search']['value']);
    }

    // Subject filter (Column 3)
    if (!empty($request->columns[3]['search']['value'])) {
        $query->where('subject_id', $request->columns[3]['search']['value']);
    }

    // Topic name search (Column 4)
    if (!empty($request->columns[4]['search']['value'])) {
        $query->where('topics', 'LIKE', '%' . $request->columns[4]['search']['value'] . '%');
    }

    // Status filter (Column 5)
    if (!empty($request->columns[5]['search']['value'])) {
        $query->where('status', $request->columns[5]['search']['value']); 
    }

    // ============================
    //     RECORD COUNTS
    // ============================

    $recordsTotal = $query->count();
    $recordsFiltered = $recordsTotal;

    // ============================
    //       COLUMN SORTING
    // ============================

    switch ($columnIndex) {
        case 0: $query->orderBy('grade_id', $columnSortOrder); break;
        case 1: $query->orderBy('branch_id', $columnSortOrder); break;
        case 2: $query->orderBy('subject_id', $columnSortOrder); break;
        case 3: $query->orderBy('topics', $columnSortOrder); break;
        case 4: $query->orderBy('status', $columnSortOrder); break;
        default:$query->orderBy('id', 'DESC');
    }

    // ============================
    //      PAGINATION + FETCH
    // ============================

    $topics = $query->skip($request->start)
                    ->take($request->length)
                    ->get();

    // ============================
    //         FORMAT ROWS
    // ============================

    $data = [];

    foreach ($topics as $row) {
        $data[] = [
            'grade'        => $row->getGrade->grade_name ?? '',
            'branch'       => $row->getBranch->branch_name ?? '',
            'subject'      => $row->getSubject->subject ?? '',
            'topics'       => $row->topics,
            'status_label' => $row->status == 'A' ? 'Active' : 'Inactive',

            'action' => '
                <a href="javascript:void(0);" class="action-dots action" data-key="'.$row->id.'">
                    <img src="'.asset('public/admin/assets/images/action-dots.png').'">
                </a>
                <div class="show-actions" id="show-action'.$row->id.'" style="display:none;">
                    <span class="angle"><img src="'.asset('public/admin/assets/images/angle.png').'"></span>
                    <ul>
                        <li><a href="'.url('admin/edit-topics/'.$row->id).'">Edit</a></li>
                        <li><a href="'.url('admin/change-status-topic/'.$row->id).'">'.($row->status=='A'?'Hide':'Show').'</a></li>
                        <li><a class="delete_topics" data-id="'.$row->id.'" href="javascript:void(0);">Delete</a></li>
                    </ul>
                </div>
            '
        ];
    }

    // ============================
    //     RETURN DATATABLE JSON
    // ============================

    return response()->json([
    'draw' => intval($request->draw),
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $data
]);
}

    /*
    * Method        : index
    * Description   : This method is used to manage subject!
    * Author        : Jayatri
    */ 
 

public function index(Request $request)
{
    $data['branches'] = Branch::where(['status'=>'A'])->get();
    $data['grades'] = Grade::whereIn('status',['A'])->select('id','grade_name','status')->orderBy('id','asc')->get();
    $data['subjects'] = Subject::whereIn('status',['A'])->select('id','subject','status')->orderBy('subject','asc')->get();
    $data['subTopics'] = SubjectTopics::whereIn('status',['A'])->select('id','topics','status')->orderBy('topics','asc')->get();
    $data['topics'] = SubjectTopics::with(['getBranch', 'getSubject', 'getGrade'])
        ->where('status', '!=', 'D')
        ->orderBy('id', 'DESC')
        ->get();

    return view('admin.modules.subject_topics.manage_topics',$data);
}
    /*
    * Method        : viewSubject
    * Description   : This method is used to view subject!
    * Author        : Jayatri
    */
    public function viewTopics($id,Request $request){
        try{
            $topics = SubjectTopics::with(['getBranch','getSubject', 'getGrade'])->where('id',$id)->first();
            if(@$topics){
                return view('admin.modules.subject_topics.view_topic')->with(['topics'=>$topics]);
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
    /*
    * Method        : addSubject
    * Description   : This method is used to add subject!
    * Author        : Jayatri
    */
  public function addTopics(Request $request)
{
    try {
        $data['grades'] = Grade::where(['status' => 'A'])->get();
        $data['branches'] = Branch::where(['status' => 'A'])->get();

        if ($request->isMethod('post')) {
            // ✅ Validation with unique topic_code check
            $request->validate([
                'topics' => 'required|string|max:255',
                'grade_id' => 'required|integer',
                'branch_id' => 'required|integer',
                'subject_id' => 'required|integer',

                'details.*.topic_code' => [
                    'required',
                    'string',
                    'max:15',
                    function ($attribute, $value, $fail) use ($request) {
                        $exists = TopicDetail::where('topic_det_code', $value)
                            ->where('branch_id', $request->branch_id)
                            ->where('grade_id', $request->grade_id)
                            ->where('subject_id', $request->subject_id)
                            ->exists();

                        if ($exists) {
                            $fail("The topic code '$value' already exists for this subject.");
                        }
                    },
                ],
                'details.*.session_focus' => 'nullable|string|max:100',
                'details.*.learning_outcome' => 'nullable|string|max:250',
            ]);

            // ✅ Save main topic
            $subjectTopics = SubjectTopics::create([
                'grade_id'   => $request->grade_id,
                'branch_id'  => $request->branch_id,
                'subject_id' => $request->subject_id,
                'topics'     => $request->topics,
                'status'     => 'A',
            ]);

            // ✅ Save topic details
            foreach ($request->details as $detail) {
                TopicDetail::create([
                    'branch_id'        => $request->branch_id,
                    'grade_id'         => $request->grade_id,
                    'subject_id'       => $request->subject_id,
                    'topic_id'         => $subjectTopics->id,
                    'topic_det_code'   => $detail['topic_code'],
                    'session_focus'    => $detail['session_focus'] ?? '',
                    'learning_outcome' => $detail['learning_outcome'] ?? '',
                    'status'           => 'A',
                ]);
            }

            session()->flash("success", "Topic and details added successfully!");
            return redirect()->route('manage.topics');
        }

        return view('admin.modules.subject_topics.topic')->with($data);

    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash("error", "Error: " . $e->getMessage());
        return redirect()->back()->withInput();
    }
}


    /*
    * Method        : editTopics
    * Description   : This method is used to edit & update subject!
    * Author        : Iniya
    */
public function editTopics(Request $request, $id)
{
    try {
        $data['grades']   = Grade::where(['status' => 'A'])->get();
        $data['branches'] = Branch::where(['status' => 'A'])->get();
        $data['subjects'] = Subject::where(['status' => 'A'])->get();

        $topic = SubjectTopics::with('details')->findOrFail($id);
        $data['topic'] = $topic;

        if ($request->isMethod('put') || $request->isMethod('post')) {
            // ✅ Validation
            $request->validate([
                'topics' => 'required|string|max:255',
                'grade_id' => 'required|integer',
                'branch_id' => 'required|integer',
                'subject_id' => 'required|integer',

                'details.*.topic_det_code' => [
                    'required', 'string', 'max:15',
                    function ($attribute, $value, $fail) use ($request, $topic) {
                        $exists = TopicDetail::where('topic_det_code', $value)
                            ->where('branch_id', $request->branch_id)
                            ->where('grade_id', $request->grade_id)
                            ->where('subject_id', $request->subject_id)
                            ->where('topic_id', '!=', $topic->id)
                            ->exists();

                        if ($exists) {
                            $fail("The detail code '{$value}' already exists for this subject.");
                        }
                    }
                ],
                'details.*.session_focus' => 'nullable|string|max:100',
                'details.*.learning_outcome' => 'nullable|string|max:250',
            ]);

            // ✅ Update main topic
            $topic->update([
                'grade_id'   => $request->grade_id,
                'branch_id'  => $request->branch_id,
                'subject_id' => $request->subject_id,
                'topics'     => $request->topics,
            ]);

            // ✅ Handle details
            $existingDetailIds = $topic->details->pluck('id')->toArray();
            $submittedDetailIds = [];

            if ($request->has('details')) {
                foreach ($request->details as $detail) {
                    if (!empty($detail['id'])) {
                        $topicDetail = TopicDetail::find($detail['id']);
                        if ($topicDetail) {
                            $topicDetail->update([
                                'topic_det_code'   => $detail['topic_det_code'],
                                'session_focus'    => $detail['session_focus'] ?? '',
                                'learning_outcome' => $detail['learning_outcome'] ?? '',
                            ]);
                            $submittedDetailIds[] = $topicDetail->id;
                        }
                    } else {
                        $newDetail = TopicDetail::create([
                            'branch_id'        => $request->branch_id,
                            'grade_id'         => $request->grade_id,
                            'subject_id'       => $request->subject_id,
                            'topic_id'         => $topic->id,
                            'topic_det_code'   => $detail['topic_det_code'],
                            'session_focus'    => $detail['session_focus'] ?? '',
                            'learning_outcome' => $detail['learning_outcome'] ?? '',
                            'status'           => 'A',
                        ]);
                        $submittedDetailIds[] = $newDetail->id;
                    }
                }
            }

            // ✅ Delete removed details
            $toDelete = array_diff($existingDetailIds, $submittedDetailIds);
            if (!empty($toDelete)) {
                TopicDetail::whereIn('id', $toDelete)->delete();
            }

            session()->flash("success", "Topic and details updated successfully!");
            return redirect()->route('manage.topics');
        }

        return view('admin.modules.subject_topics.edit_topic', $data);

    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash("error", "Error: " . $e->getMessage());
        return redirect()->back()->withInput();
    }
}

/**
 * AJAX function for checking duplicate topic_det_code
 */
public function checkTopicCode(Request $request)
{
    $exists = TopicDetail::where('topic_det_code', $request->topic_code)
        ->where('branch_id', $request->branch_id)
        ->where('grade_id', $request->grade_id)
        ->where('subject_id', $request->subject_id)
        ->when($request->topic_id, function ($query) use ($request) {
            // exclude current topic's details when editing
            $query->where('topic_id', '!=', $request->topic_id);
        })
        ->exists();

    return response()->json(['exists' => $exists]);
}

public function ajaxDeleteTopics(Request $request)
{
    try {
        $id = $request->data['id'] ?? null;

        if (!$id) {
            return response()->json([
                'status' => 0,
                'message' => "Invalid topic ID!"
            ], 200);
        }

        $topic = SubjectTopics::with('details')->find($id);

        if ($topic) {
            // Soft delete topic
            $topic->status = 'D';
            $topic->save();

            // Soft delete all related topic details
            if ($topic->details->count() > 0) {
                TopicDetail::where('topic_id', $id)->update(['status' => 'D']);
            }

            return response()->json([
                'status' => 1,
                'message' => "Topic deleted successfully!"
            ], 200);
        } else {
            return response()->json([
                'status' => 0,
                'message' => "Topic not found!"
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



    
    /*
    * Method        : deleteSubject
    * Description   : This method is used to delete subject!
    * Author        : Jayatri
    */
    public function deleteTopics($id, Request $request)
{
    try {
        $topic = SubjectTopics::with('details')->find($id);

        if ($topic) {
            // Soft delete topic
            $topic->status = 'D';
            $topic->save();

            // Soft delete related topic details
            if ($topic->details->count() > 0) {
                TopicDetail::where('topic_id', $id)->update(['status' => 'D']);
            }

            session()->flash('success', $topic->topics . " topic is deleted successfully!");
        } else {
            session()->flash('error', "Topic not found with ID: " . $id);
        }

        return redirect()->back();
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash('error', "Something went wrong! " . $e->getMessage());
        return redirect()->back();
    }
}
public function changeStatusTopics($id, Request $request)
{
    try {
        $topic = SubjectTopics::with('details')->find($id);

        if ($topic) {
            if ($topic->status == 'A') {
                $topic->status = 'I';
                $status = "Inactive";
            } elseif ($topic->status == 'I') {
                $topic->status = 'A';
                $status = "Active";
            }
            $topic->save();

            // Update status of all related topic details
            if ($topic->details->count() > 0) {
                TopicDetail::where('topic_id', $id)->update(['status' => $topic->status]);
            }

            session()->flash("success", "Status updated successfully!");
            return redirect()->back();
        } else {
            session()->flash("error", "Topic not found!");
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
        $topic = SubjectTopics::with('details')->find($id);

        if (!$topic) {
            return response()->json([
                'status' => 'error',
                'message' => 'Topic not found!'
            ]);
        }

        if ($topic->status == 'A') {
            $topic->status = 'I';
            $newStatus = "Inactive";
        } else {
            $topic->status = 'A';
            $newStatus = "Active";
        }

        $topic->save();

        // Update status of all related topic details
        if ($topic->details->count() > 0) {
            TopicDetail::where('topic_id', $id)->update(['status' => $topic->status]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!',
            'new_status' => $topic->status,
        ]);

    } catch (\Exception $e) {
        \Log::error($e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong: ' . $e->getMessage()
        ]);
    }
}


 public function getTopicsManagementList(Request $request)
{
    $topics = SubjectTopics::with(['getGrade', 'getBranch', 'getSubject'])
        ->whereIn('status', ['A', 'I']);

    // Filters
    if ($request->col1_filter) { 
        $topics->where('grade_id', $request->col1_filter);
    }
    if ($request->col2_filter) {
        $topics->where('branch_id', $request->col2_filter);
    }
    if ($request->col3_filter) {
        $topics->where('subject_id', $request->col3_filter);
    }
    if ($request->col4_filter) {
        $topics->where('id', $request->col4_filter);
    }
    if ($request->col5_filter) {
        $topics->where('status', $request->col5_filter);
    }

    // Sorting
    $topics->orderBy('id', 'DESC');

    // Fetch
    $list = $topics->get();

    // Format response (NO DATATABLES)
    $data = [];
    foreach ($list as $row) {
        $data[] = [
            'id'           => $row->id,
            'grade'        => $row->getGrade->grade_name ?? '',
            'branch'       => $row->getBranch->branch_name ?? '',
            'subject'      => $row->getSubject->subject ?? '',
            'topics'       => $row->topics,
            'status'       => $row->status,
            'status_label' => $row->status == 'A' ? 'Active' : 'Inactive',
            'action'       => '
                <a href="javascript:void(0);" class="action-dots action" data-key="'.$row->id.'">
                    <img src="'.asset('public/admin/assets/images/action-dots.png').'">
                </a>
                <div class="show-actions" id="show-action'.$row->id.'" style="display:none;">
                    <span class="angle"><img src="'.asset('public/admin/assets/images/angle.png').'"></span>
                    <ul>
                        <li><a href="'.url('admin/edit-topics/'.$row->id).'">Edit</a></li>
                        <li><a href="'.url('admin/change-status-topic/'.$row->id).'">'.($row->status=='A'?'Hide':'Show').'</a></li>
                        <li><a class="delete_topics" data-id="'.$row->id.'" href="javascript:void(0);">Delete</a></li>
                    </ul>
                </div>
            '
        ];
    }

    return response()->json([
        'data' => $data
    ]);
}
}