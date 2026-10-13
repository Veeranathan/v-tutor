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
use Illuminate\Support\Facades\DB;
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

class TutorApplicationFormController extends Controller
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
            return view('admin.modules.tutor_application_form.manage_tutor_application_form')->with($data);
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

  public function getList(Request $request)
{
    $taf_data = TutorApplicationFormsModel::select(
        'tutor_application_forms.id',
        'tutor_application_forms.taf_id',
        'tutor_application_forms.first_name',
        'tutor_application_forms.middle_name',
        'tutor_application_forms.last_name',
        'tutor_application_forms.primary_email',
        'tutor_application_forms.primary_phone',
        'tutor_application_forms.com_addr_state as state',
        'tutor_application_forms.status',
        'users.subscription', // ✅ Get subscription from users table
        'tutor_application_forms.created_at'
    )
    ->leftJoin('users', 'users.email', '=', 'tutor_application_forms.primary_email');

    $filters = $request->input('filters', []);

    // 🔍 Name / Email / Phone / Form ID search
    if (!empty($filters['name_email_phone'])) {
        $val = $filters['name_email_phone'];
        $taf_data->where(function($q) use ($val) {
            $q->where('first_name', 'like', "%{$val}%")
              ->orWhere('middle_name', 'like', "%{$val}%")
              ->orWhere('last_name', 'like', "%{$val}%")
              ->orWhere('taf_id', 'like', "%{$val}%")
              ->orWhere('primary_email', 'like', "%{$val}%")
              ->orWhere('primary_phone', 'like', "%{$val}%");
        });
    }

    // 🏙 State filter
    if (!empty($filters['state'])) {
        $taf_data->where('tutor_application_forms.com_addr_state', $filters['state']);
    }

    // 📄 Status filter
    if (!empty($filters['status'])) {
        $taf_data->where('tutor_application_forms.status', $filters['status']);
    }

    // 📅 Date range
    if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
        $from = $filters['date_from'] . " 00:00:00";
        $to   = $filters['date_to']   . " 23:59:59";
        $taf_data->whereBetween('tutor_application_forms.created_at', [$from, $to]);
    }

    // 💬 Subscription filter (Yes/No)
    if (!empty($filters['subscription'])) {
        if ($filters['subscription'] == 'Y') {
            $taf_data->where('users.subscription', 'S');
        } elseif ($filters['subscription'] == 'N') {
            $taf_data->where('users.subscription', 'U');
        }
    }

    // 🔢 Sorting + pagination
    $recordsTotal = $taf_data->count();

    $taf_data = $taf_data->orderBy('tutor_application_forms.id', 'desc')
                         ->skip($request->start)
                         ->take($request->length)
                         ->get();

    // 🌏 State Mapping
    $states = [
        1 => "New South Wales",
        2 => "Victoria",
        3 => "Queensland",
        4 => "South Australia",
        5 => "Western Australia",
        6 => "Tasmania",
        7 => "Australian Capital Territory",
        8 => "Northern Territory"
    ];

    foreach ($taf_data as $item) {
        $key = intval($item->state);
        $item->state = $states[$key] ?? "N/A";
        $item->subscription = ($item->subscription === 'S') ? 'Yes' : 'No';
    }

    return response()->json([
        "draw" => intval($request->draw),
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsTotal,
        "aaData" => $taf_data
    ]);
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
 public function exportTutorApplicationList(Request $request)
{
    try {
        $taf_data = TutorApplicationFormsModel::select(
            'tutor_application_forms.taf_id',
            DB::raw("CONCAT(tutor_application_forms.first_name, ' ', tutor_application_forms.middle_name, ' ', tutor_application_forms.last_name) as name"),
            'tutor_application_forms.primary_email',
            'tutor_application_forms.primary_phone',
            'tutor_application_forms.com_addr_state as state',
            'tutor_application_forms.status',
            'users.subscription',
            'tutor_application_forms.created_at'
        )
        ->leftJoin('users', 'users.email', '=', 'tutor_application_forms.primary_email');

        $filters = $request->all();

        // 🔍 Filters
        if (!empty($filters['col1_filter'])) {
            $val = $filters['col1_filter'];
            $taf_data->where(function($q) use ($val) {
                $q->where('first_name', 'like', "%{$val}%")
                  ->orWhere('middle_name', 'like', "%{$val}%")
                  ->orWhere('last_name', 'like', "%{$val}%")
                  ->orWhere('taf_id', 'like', "%{$val}%")
                  ->orWhere('primary_email', 'like', "%{$val}%")
                  ->orWhere('primary_phone', 'like', "%{$val}%");
            });
        }

        if (!empty($filters['col2_filter'])) {
            $taf_data->where('tutor_application_forms.com_addr_state', $filters['col2_filter']);
        }

        if (!empty($filters['col3_filter'])) {
            $taf_data->where('tutor_application_forms.status', $filters['col3_filter']);
        }

        if (!empty($filters['col4_filter']) && !empty($filters['col5_filter'])) {
            $from = $filters['col4_filter'] . " 00:00:00";
            $to   = $filters['col5_filter'] . " 23:59:59";
            $taf_data->whereBetween('tutor_application_forms.created_at', [$from, $to]);
        }

        if (!empty($filters['col6_filter'])) {
            if ($filters['col6_filter'] == 'Y') {
                $taf_data->where('users.subscription', 'S');
            } elseif ($filters['col6_filter'] == 'N') {
                $taf_data->where('users.subscription', 'U');
            }
        }

        $taf_data = $taf_data->orderBy('tutor_application_forms.id', 'desc')->get();

        // 🌏 State mapping
        $states = [
            1 => "New South Wales",
            2 => "Victoria",
            3 => "Queensland",
            4 => "South Australia",
            5 => "Western Australia",
            6 => "Tasmania",
            7 => "Australian Capital Territory",
            8 => "Northern Territory"
        ];

        $output = '
        <table border="1">
            <thead style="background-color:lime;">
                <tr>
                    <th>Form ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>State</th>
                    <th>Status</th>
                    <th>Subscribed</th>
                    <th>Applied On</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($taf_data as $row) {
            $state = $states[intval($row->state)] ?? 'N/A';
            $status = match ($row->status) {
                1 => 'Accepted',
                2 => 'Rejected',
                3 => 'Submitted',
                4 => 'Pending',
                default => 'N/A',
            };
            $subscribed = $row->subscription === 'S' ? 'Yes' : 'No';
            $appliedOn = $row->created_at ? date('d-m-Y', strtotime($row->created_at)) : '';

            $output .= "
                <tr>
                    <td>{$row->taf_id}</td>
                    <td>{$row->name}</td>
                    <td>{$row->primary_email}</td>
                    <td>{$row->primary_phone}</td>
                    <td>{$state}</td>
                    <td>{$status}</td>
                    <td>{$subscribed}</td>
                    <td>{$appliedOn}</td>
                </tr>
            ";
        }

        $output .= "</tbody></table>";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Tutor_Applications_" . date('Ymd_His') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $output;
        exit;
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        abort(500, 'Failed to export Excel');
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
                        $update_dta['status'] = "A";
                        // $update_dta['f_name'] = $taf_data->first_name;
                        // $update_dta['m_name'] = $taf_data->middle_name;
                        // $update_dta['l_name'] = $taf_data->last_name;
                        $update_dta['phone'] = $taf_data->primary_phone;
                        $update_dta['dob'] = $taf_data->dob;
                        $update_dta['mother_tongue'] = $taf_data->mother_tongue;
                        $update_dta['primary_communication_lang'] = $taf_data->primary_communication_language;
                        $update_dta['nationality'] = $taf_data->nationality;
                        $update_dta['country'] = 1;
                        $update_dta['state'] = $taf_data->com_addr_state;
                        $update_dta['timezone_id'] = $taf_data->com_addr_timezone;
                        $update_dta['city'] = $taf_data->com_addr_city;
                        $update_dta['zip'] = $taf_data->com_addr_zip;
                        $update_dta['street'] = $taf_data->com_addr_street;
                        $update_dta['address'] = $taf_data->com_addr_street;
                        if(User::where('id',$taf_data->tutor_id)->update($update_dta)) {}

                        $data['taf_data'] = $taf_data;
                        $data['subject'] = 'Tutor Application Accepted – Next Steps for Onboarding';
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
                        $update_dta['status'] = "D";
                        if(User::where('id',$taf_data->tutor_id)->update($update_dta)) {}

                        $data['taf_data'] = $taf_data;
                        $data['subject'] = 'Tutor Application Outcome';
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

    public function validateWWCC(Request $request){
        try {
            $succ = 3;
            if(isset($request->id) && $request->id) {
                $taf_data = TutorWWCCModel::Where('tutor_app_id', $request->id)->Where('is_valid', 3)->first();
                if($taf_data) {
                    $succ = 2;
                } else {
                    $succ = 1;
                }
            }

            return $succ;
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            return 3;
        }
    }
     public function view($id,Request $request){
        try {
            $data['taf_data'] = TutorApplicationFormsModel::with(['getTutor','getTutorWwcc'])->where('id',$id)->first();
            $data['next_id'] = TutorApplicationFormsModel::whereIn('status',['1','2','3','4'])->where('id','>',$id)->min('id');
            $data['previous_id'] = TutorApplicationFormsModel::whereIn('status',['1','2','3','4'])->where('id','<',$id)->max('id');

            if(@$data['taf_data']) {
                $data['taf_wwcc'] = TutorWWCCModel::Where('tutor_id', $data['taf_data']->tutor_id)->Where('tutor_app_id', $data['taf_data']->id)->get();
                return view('admin.modules.tutor_application_form.view_tutor_application_form')->with($data);
            } else {
                session()->flash("error","Tutor Application Form is not found associated with id : ".$id);
                return redirect()->back();
            }
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

    public function reOpen(Request $request){
        try {
            $succ = 3;
           // if(isset($request->data['id']) && $request->data['id']) {
           if ($request->id) {
              //  $taf_data = TutorApplicationFormsModel::Where('id', $request->data['id'])->first();
                $taf_data = TutorApplicationFormsModel::where('id', $request->id)->first();
                if($taf_data) {
                    $taf_data->status = 4;
                    // $taf_data->status_remark = (isset($request->status_remark) && $request->status_remark) ? $request->status_remark : null;
                    if($taf_data->save()) {
                        $succ = 1;
                    } else {
                        $succ = 2;
                    }
                }
            }

            return $succ;
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            return 3;
        }
    }
}
