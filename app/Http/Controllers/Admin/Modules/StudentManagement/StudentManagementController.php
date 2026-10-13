<?php

namespace App\Http\Controllers\Admin\Modules\studentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\State;
use App\Models\School;
use App\Models\TimezoneLists;
use Mail;
use Auth;
use App\Mail\AdminApproveMail;
use App\Mail\DeleteAccountMail;
use App\Mail\AdminCloseAccountMail;
use App\Mail\TeacherVerify;
use App\Mail\TutorOnboardApproved;
use App\Mail\TutorWelcomeOnboard;
use App\Mail\TutorOnboardRejected;
use App\Mail\TutorSuspend;
use App\Services\ZoomService;
use App\Models\ZoomUser;
use Illuminate\Support\Facades\Log;

class studentManagementController extends Controller
{
    protected $zoom;

    public function __construct(ZoomService $zoom)
    {
        $this->zoom = $zoom;
        $this->middleware('admin.auth:admin');
    }

    public function updateStudentAvatar(Request $request)
    {
        try {
            $profile_pic = @$request->data['profile_pic'];
            $id = @$request->data['id'];
            User::where(['id' => $id])->update(['profile_pic' => $profile_pic]);
            $data['message'] = 'Your avatar is uploaded successfully !' . $profile_pic;
            return response()->json($data, 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = 'avatar is not uploaded!' . $e->getMessage();
            return response()->json($data, 200);
        }
    }
    public function ajaxStudentDuplicateEmailCheck(Request $request)
    {
        try {
            $email = trim($request->email);
            $isExistEmail = User::where(['email' => @$request->email])->whereNotIn('id', [@$request->id])->whereIn('status', ['A', 'I', 'AA', 'U'])->first();
            if (@$isExistEmail) {
                return 'false';
            } else {
                return 'true';
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function ajaxStudentDuplicatePhoneCheck(Request $request)
    {
        try {
            $phone = trim($request->phone);
            $isExistPhone = User::where(['phone' => @$request->phone])->whereNotIn('id', [@$request->id])->whereIn('status', ['A', 'I', 'AA', 'U'])->first();
            if (@$isExistPhone) {
                return 'false';
            } else {
                return 'true';
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function ajaxDeleteUser(Request $request)
    {
        $id = @$request->data['id'];
        $user = User::whereId($id)->first();
        if (@$user) {
            User::whereId($id)->update(['status' => 'D']);
            $data['status'] = 1;
            if (@$user->user_type == 'T') {
                $data['message'] = "Tutor Deleted!Confirmation sent to " . $user->email;
            } else {
                $data['message'] = "Student Deleted! Confirmation sent to" . $user->email;
            }
            try {
                $this->sendDeleteAccount($id, 'deleted');
            } catch (\Exception $e) {
                $data['message'] = "Mail not sent!" . $e->getMessage();
                \Log::error($e->getMessage());
            }
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['message'] = "User is not deleted!Something went wrong!No data found!";
            return response()->json($data, 200);
        }
    }
    public function ajaxCloseUser(Request $request)
    {
        $id = @$request->data['id'];
        $user = User::whereId($id)->first();
        if (@$user) {
            User::whereId($id)->update(['status' => 'C']);
            $data['status'] = 1;
            if (@$user->user_type == 'T') {
                $data['message'] = "Tutor closed!Confirmation sent to " . $user->email;
            } else {
                $data['message'] = "Student closed! Confirmation sent to" . $user->email;
            }
            try {
                $this->sendCloseAccount($id);
            } catch (\Exception $e) {
                $data['message'] = "Mail not sent!" . $e->getMessage();
                \Log::error($e->getMessage());
            }
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['message'] = "User is not deleted!Something went wrong!No data found!";
            return response()->json($data, 200);
        }
    }

    public function studentManagement(Request $request)
    {
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = User::where(['user_type' => 'U'])->whereNotIn('status', ['D']);
        if (@$request->columns['1']['search']['value']) {
            $users = $users->where(function ($query) use ($request) {
                $query->Where('f_name', 'like', '%' . $request->columns['1']['search']['value'] . '%')
                    ->orWhere('l_name', 'like', '%' . $request->columns['1']['search']['value'] . '%')
                    ->orWhere('unique_id', 'like', '%' . $request->columns['1']['search']['value'] . '%')
                    ->orWhere('email', 'like', '%' . $request->columns['1']['search']['value'] . '%')
                    ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->columns['1']['search']['value'] . '%')
                    ->orWhere('phone', 'like', '%' . $request->columns['1']['search']['value'] . '%');
            });
        }
        if (@$request->columns['2']['search']['value']) {
            $users = $users->where(function ($query) use ($request) {
                $query->Where('status', $request->columns['2']['search']['value']);
            });
        }
        if (@$request->columns['5']['search']['value'] == 'google') {
            $users = $users->where(function ($query) use ($request) {
                $query->Where('platform_type', 'google');
            });
        }
        if (@$request->columns['5']['search']['value'] == 'facebook') {
            $users = $users->where(function ($query) use ($request) {
                $query->Where('platform_type', 'facebook');
            });
        }
        if (@$request->columns['5']['search']['value'] == 'web') {
            $users = $users->where(function ($query) use ($request) {
                $query->Where('platform_type', NULL);
            });
        }
        // if(@$request->columns['5']['search']['value'] != 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_type',$request->columns['5']['search']['value']);
        //     });
        // }
        // if(@$request->columns['5']['search']['value'] == 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->WhereIn('platform_type',['google','facebook',NULL,'',null]);
        //     });
        // }
        if (@$request->columns['3']['search']['value']) {
            $users = $users->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
        }
        if (@$request->columns['4']['search']['value']) {
            $users = $users->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
        }
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
        if ($columnIndex == 0) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('id', 'asc');
            } else {
                $users = $users->orderBy('id', 'desc');
            }
        }
        if ($columnIndex == 1) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('f_name', 'asc');
            } else {
                $users = $users->orderBy('f_name', 'desc');
            }
        }
        if ($columnIndex == 2) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('email', 'asc');
            } else {
                $users = $users->orderBy('email', 'desc');
            }
        }
        if ($columnIndex == 3) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('phone', 'asc');
            } else {
                $users = $users->orderBy('phone', 'desc');
            }
        }
        if ($columnIndex == 4) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('created_at', 'asc');
            } else {
                $users = $users->orderBy('created_at', 'desc');
            }
        }
        if ($columnIndex == 5) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('status', 'asc');
            } else {
                $users = $users->orderBy('status', 'desc');
            }
        }
        if ($columnIndex == 6) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('platform_type', 'asc');
            } else {
                $users = $users->orderBy('platform_type', 'desc');
            }
        }
        if ($columnIndex == 7) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('id', 'asc');
            } else {
                $users = $users->orderBy('id', 'desc');
            }
        }
        if ($columnIndex == 8) {
            if ($columnSortOrder == 'asc') {
                $users = $users->orderBy('id', 'asc');
            } else {
                $users = $users->orderBy('id', 'desc');
            }
        }
        $users = $users->orderBy('id', 'desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    /*
    * Method        : index
    * Description   : This method is used to manage students!
    * Author        : Jayatri
    */
    public function index(Request $request)
    {
        try {
            // $data['users'] = User::where(['user_type'=>'U','student_type'=>'S'])->whereNotIn('status',['D']);
            // if(@$request->all()) {
            //     if(@$request->keyword) {
            //         $data['users'] = $data['users']->where(function($q) use($request){
            //             $q->where(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->keyword . '%')
            //             ->orwhere('l_name', 'like', '%' . $request->keyword . '%')
            //             ->orwhere('f_name', 'like', '%' . $request->keyword . '%')
            //             ->orwhere('email', 'like', '%' . $request->keyword . '%')
            //             ->orwhere('phone', 'like', '%' . $request->keyword . '%');
            //         });
            //     }
            //     if(@$request->status) {
            //         $data['users'] = $data['users']->where('status', $request->status);
            //     }
            //     if(@$request->created_at) {
            //         $data['users'] = $data['users']->where(function($q8) use($request) {
            //             $q8 = $q8->whereBetween('created_at',[@$request->created_at." 00:00:00", @$request->to_date." 23:59:59"]);
            //         });
            //     }
            //     if(@$request->platform_type) {
            //         $data['users'] = $data['users']->where('platform_type', $request->platform_type);
            //     }
            //     if(@$request->gender) {
            //         $data['users'] = $data['users']->where('platform_type', $request->gender);
            //     }
            // }
            // $data['users']= $data['users']->paginate(10);
            // $data['key'] = @$request->all();
            return view('admin.modules.student_management.manage_students');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
    public function viewStudent($id, Request $request)
    {
        try {
            $user = User::with(['getState', 'getTutorShipPlan', 'getSchool.getState', 'getSchool.getSuburb', 'getTimezone'])->where('id', $id)->first();
            $grade = Grade::where(['id' => @$user->grade])->first();
            if (@$user) {
                return view('admin.modules.student_management.view_student')->with(['user' => $user, 'grade' => $grade]);
            } else {
                session()->flash("error", "Student is not found associated with id : " . $id);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
    public function sendAdminApproveMail($id, $type)
    {
        // try{
        $data['user'] = User::where('id', $id)->first();
        $data['subject'] = "";
        if ($data['user']->user_type == 'T') {
            $data['subject'] = "Admin " . $type . " your vtutor tutor account!Please login!";
        }
        if ($data['user']->user_type == 'U') {
            if ($data['user']->student_type == 'G') {
                $data['subject'] = "Admin " . $type . " your vtutor gurdain account!Please login!";
            }
            if ($data['user']->student_type == 'P') {
                $data['subject'] = "Admin " . $type . " your vtutor parent account!Please login!";
            }
            if ($data['user']->student_type == 'S') {
                $data['subject'] = "Admin " . $type . " your vtutor student account!Please login!";
            }
        }
        Mail::send(new AdminApproveMail($data));
        // }catch(\Exception $e){
        //     \Log::error($e->getMessage());
        // }
    }
    public function sendDeleteAccount($id, $type)
    {
        // try{
        $data['user'] = User::where('id', $id)->first();
        $data['subject'] = "Your account is deleted!";
        Mail::send(new DeleteAccountMail($data));
        // }catch(\Exception $e){
        // \Log::error($e->getMessage());
        // }
    }
    public function sendCloseAccount($id, $type)
    {
        // try{
        $data['user'] = User::where('id', $id)->first();
        $data['subject'] = "Your account is closed!";
        Mail::send(new AdminCloseAccountMail($data));
        // }catch(\Exception $e){
        // \Log::error($e->getMessage());
        // }
    }
    public function ajaxStatusChangeUser(Request $request)
    {
        try {
            $id = @$request->data['id'];
            $user = User::whereId($id)->first();
            if (@$user) {
                if (@$user->status == 'AA') {
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    $nameUser = "  " . @$user->f_name . " " . @$user->l_name;
                    if (@$user->user_type == 'T') {
                        $nameUser = "tutor";
                    }
                    if (@$user->user_type == 'U') {
                        if (@$user->student_type == 'G') {
                            $nameUser = " guardain " . @$user->f_name . " " . @$user->l_name;
                        }
                        if (@$user->student_type == 'P') {
                            $nameUser = " parent " . @$user->f_name . " " . @$user->l_name;;
                        }
                        if (@$user->student_type == 'S') {
                            $nameUser = " student " . @$user->f_name . " " . @$user->l_name;;
                        }
                    }
                    User::where('id', $id)->update($updateStatus);
                    $data['status'] = 1;
                    $data['message'] = "Tutor approved. Confirmation sent to " . @$user->email;
                    $data['user_status'] = $status;
                    $data['next_status'] = "Suspend";
                    try {
                        $this->sendAdminApproveMail($id, 'approved');
                        $data['message'] = "Tutor approved. Confirmation sent to " . @$user->email;
                    } catch (\Exception $e) {
                        $data['message'] = "Tutor approved. Confirmation not sent to " . @$user->email . " because " . $e->getMessage();
                    }
                    return response()->json($data, 200);
                } elseif ($user->status == 'A') {
                    $updateStatus['status'] = 'I';
                    $status = "Suspend";
                    User::where('id', $id)->update($updateStatus);
                    $data['status'] = 1;
                    if (@$user->user_type == 'T') {
                        $data['message'] = "Tutor Suspended";
                        if (@$user->subscription == 'S' && @$user->draft == 'N') {
                            if (isset($user->suspend_mail_count) && $user->suspend_mail_count == 0) {
                                $getuser = User::where('id', $id)->first();
                                $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
                                $data['email'] = $getuser->email;
                                $data['id'] = $getuser->id;
                                $data['email_subject'] = "Notice of Access Removal – Tutor Platform";
                                Mail::send(new TutorSuspend($data));
                            }
                        }
                    } else {
                        $data['message'] = "Student Suspended";
                    }
                    $data['user_status'] = $status;
                    $data['next_status'] = "active";
                    return response()->json($data, 200);
                } elseif ($user->status == 'I') {
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    User::where('id', $id)->update($updateStatus);
                    $data['status'] = 1;
                    if (@$user->user_type == 'T') {
                        $data['message'] = "Tutor Activated";
                    } else {
                        $data['message'] = "Student Activated";
                    }
                    // $data['message'] = "You have successfully updated the status!Status is active!";
                    $data['user_status'] = $status;
                    $data['next_status'] = "Suspend";

                    return response()->json($data, 200);
                } elseif ($user->status == 'U') {
                    if (@$user->user_type == 'T') {
                        $updateStatus['status'] = 'AA';
                        $status = "Awaiting Approval";
                        $data['message'] = "Tutor verified!Tutor status is awaiting approval!";
                    } else {
                        $updateStatus['status'] = 'A';
                        $status = "Active";
                        $data['message'] = "Student verified!Student status is activated!";
                    }
                    User::where('id', $id)->update($updateStatus);
                    $data['status'] = 1;
                    // $data['message'] = "Status is active!";
                    $data['user_status'] = $status;
                    $data['next_status'] = "Suspend";
                    return response()->json($data, 200);
                } elseif ($user->status == 'C') {
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    User::where('id', $id)->update($updateStatus);
                    $data['status'] = 1;
                    if (@$user->user_type == 'T') {
                        $data['message'] = "Tutor Activated";
                    } else {
                        $data['message'] = "Student Activated";
                    }
                    // $data['message'] = "You have successfully updated the status!Status is active!";
                    $data['user_status'] = $status;
                    $data['next_status'] = "Suspend";

                    return response()->json($data, 200);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            $data['user_status'] = "";
            $data['next_status'] = "";
            return response()->json($data, 200);
        }
    }

    public function ajaxStatusChangeUserNew(Request $request)
    {
        try {
            $id = @$request->data['id'];
            $user = User::whereId($id)->first();
            if (@$user) {
                if ($user->status == 'I') {
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    User::where('id', $id)->update($updateStatus);
                    $data['status'] = 1;
                    $data['message'] = "Student Activated";
                    $data['user_status'] = $status;
                    $data['next_status'] = "";

                    return response()->json($data, 200);
                } else {
                    $updateStatus['status'] = 'I';
                    $updateStatus['admin_rej_sus_reason'] = $request->data['reason'] ?? NULL;
                    $status = "Suspend";
                    User::where('id', $id)->update($updateStatus);
                    $data['status'] = 1;
                    $data['message'] = "Student Suspended";
                    $data['user_status'] = $status;
                    $data['next_status'] = "";

                    return response()->json($data, 200);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            $data['user_status'] = "";
            $data['next_status'] = "";
            return response()->json($data, 200);
        }
    }

    public function ajaxStatusChangeUserInactive(Request $request)
    {
        try {
            $id = @$request->data['id'];
            $user = User::whereId($id)->first();
            if (@$user) {

                $updateStatus['status'] = 'A';
                $status = "Active";
                $nameUser = "  " . @$user->f_name . " " . @$user->l_name;
                if (@$user->user_type == 'T') {
                    $nameUser = "Tutor";
                }

                $updateStatus['status'] = 'I';
                $status = "Suspend";
                User::where('id', $id)->update($updateStatus);
                $data['status'] = 1;
                if (@$user->user_type == 'T') {
                    $data['message'] = "Tutor Suspended";
                } else {
                    $data['message'] = "Student Suspended";
                }
                $data['user_status'] = $status;
                $data['next_status'] = "active";
                return response()->json($data, 200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            $data['user_status'] = "";
            $data['next_status'] = "";
            return response()->json($data, 200);
        }
    }

    public function ajaxStatusChangeUserApproved(Request $request)
    {
        try {
            $id = @$request->data['id'];
            $tutor = $user = User::find($id);
         //   Log::info("tutor details", [$tutor]);
            // if(isset($request->data['zoom_email']) && $request->data['zoom_email']) {
               if( $id) {
                //$zoom_email = $request->data['zoom_email'];
                if (@$user) {
                    $updateStatus['status'] = 'A';
                    $updateStatus['subscription'] = 'S';
                    $updateStatus['draft'] = 'N';
                    $updateStatus['status_change_user_id'] = @Auth::guard('admin')->user()->id;
                    $updateStatus['status_change_date'] = date('y-m-d h:i:s');
                    $status = "Approve";
                    $nameUser = "  " . @$user->f_name . " " . @$user->l_name;
                    if (@$user->user_type == 'T') {
                        $nameUser = "Tutor";
                        //Approve Tutor
                        $tutor->update($updateStatus);

                        $data['status'] = 1;
                        $data['message'] = "Tutor Approved";
                        $data['user_status'] = $status;
                        $data['next_status'] = "";

                        $data['name'] = $user->f_name . ' ' . $user->l_name;
                        $data['email'] = $user->email;

                        Mail::send(new TutorWelcomeOnboard($data));
                        
                        // $password="Tutor@*123";
                      //  $password = generateGJRandomPassword(8);
                      //  $zu = $this->zoom->createLicensedUser($zoom_email, $password, $tutor->f_name, $tutor->l_name);
                     //   Log::info("Zoom User Details", [$zu]);
                        // if($zu) {
                        //     $zuc = ZoomUser::updateOrCreate(
                        //         ['tutor_id' => $tutor->id],
                        //         [
                        //             'zoom_user_id' => $zu['id'],
                        //             'email'        => $zu['email'] ?? $tutor->email,
                        //             'password'     => $password,
                        //             'pmi'          => (string)($zu['pmi'] ?? ''),
                        //             'status'       => 'active',
                        //         ]
                        //     );
                        // }
                        // if ($zuc) {
                        //     $tutor = $tutor->update($updateStatus);
                        //     if (isset($user->approve_mail_count) && $user->approve_mail_count == 0) {
                        //         $getuser = User::where('id', $id)->first();
                        //         $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
                        //         $data['email'] = $getuser->email;
                        //         $data['zoomemail']= $zu['email'] ?? $tutor->email;
                        //         $data['zoompassword']= $password;
                        //         $data['id'] = $getuser->id;
                        //         $data['email_subject'] = "Welcome to Tutor – Your Application is Approved";
                        //         Mail::send(new TutorOnboardApproved($data));
                        //     }
                        // }
                    }

                    return response()->json($data, 200);
                }
            } else {
                $data['status'] = 0;
              //  $data['message'] = "Zoom Email ID required!";
                $data['user_status'] = "";
                $data['next_status'] = "";
                return response()->json($data, 200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            $data['user_status'] = "";
            $data['next_status'] = "";
            return response()->json($data, 200);
        }
    }

    public function ajaxStatusChangeUserRejected(Request $request)
    {
        try {
            $id = @$request->data['id'];
            $user = User::whereId($id)->first();
            if (@$user) {
                $updateStatus['status'] = 'R';
                $updateStatus['admin_rej_sus_reason'] = $request->data['reason'] ?? NULL;
                $updateStatus['status_change_user_id'] = @Auth::guard('admin')->user()->id;
                $updateStatus['status_change_date'] = date('y-m-d h:i:s');
                $status = "Reject";
                $nameUser = "  " . @$user->f_name . " " . @$user->l_name;
                if (@$user->user_type == 'T') {
                    $nameUser = "Tutor";
                    if (User::where('id', $id)->update($updateStatus)) {
                        $data['status'] = 1;
                        $data['message'] = "Tutor Rejected";
                        $data['user_status'] = $status;
                        $data['next_status'] = "";

                        if (isset($user->approve_mail_count) && $user->approve_mail_count == 0) {
                            $getuser = User::where('id', $id)->first();
                            $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
                            $data['email'] = $getuser->email;
                            $data['id'] = $getuser->id;
                            $data['email_subject'] = "Tutor Application Outcome";
                            Mail::send(new TutorOnboardRejected($data));
                        }
                    }
                }

                return response()->json($data, 200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            $data['user_status'] = "";
            $data['next_status'] = "";
            return response()->json($data, 200);
        }
    }

    public function ajaxStatusChangeUserSuspended(Request $request)
    {
        try {
            $id = @$request->data['id'];
            $tutor = $user = User::with('zoomUser')->find($id);
            if (@$user) {
                $updateStatus['status'] = 'I';
                $updateStatus['admin_rej_sus_reason'] = $request->data['reason'] ?? NULL;
                $updateStatus['status_change_user_id'] = @Auth::guard('admin')->user()->id;
                $updateStatus['status_change_date'] = date('y-m-d h:i:s');
                $status = "Suspend";
                $nameUser = "  " . @$user->f_name . " " . @$user->l_name;
                if (@$user->user_type == 'T') {
                    $nameUser = "Tutor";
                    if ($tutor->zoomUser) {
                        // Delete user in Zoom
                        $this->zoom->deleteUser($tutor->zoomUser->zoom_user_id);
                        // Remove from local DB
                        $tutor->zoomUser->delete();
                    }
                    $updatetutor = $tutor->update($updateStatus);
                    if ($updatetutor) {
                        $data['status'] = 1;
                        $data['message'] = "Tutor Suspended";
                        $data['user_status'] = $status;
                        $data['next_status'] = "";

                        if (isset($user->suspend_mail_count) && $user->suspend_mail_count == 0) {
                            $getuser = User::where('id', $id)->first();
                            $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
                            $data['email'] = $getuser->email;
                            $data['id'] = $getuser->id;
                            $data['email_subject'] = "Notice of Access Removal – Tutor Platform";
                            Mail::send(new TutorSuspend($data));
                        }
                    }
                }

                return response()->json($data, 200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            $data['user_status'] = "";
            $data['next_status'] = "";
            return response()->json($data, 200);
        }
    }

    public function resendVerificationLink(Request $request)
    {
        try {
            $id = @$request->data['id'];
            $user = User::whereId($id)->first();
            if (@$user) {
                if ($user->status == 'U') {
                    $this->reSendMail($id);
                    $status = "Unverified";

                    $data['status'] = 1;
                    if (@$user->user_type == 'T') {
                        $data['message'] = "Tutor verification link send";
                    } else {
                        $data['message'] = "Student verification link send";
                    }
                    $data['user_status'] = $status;
                    $data['next_status'] = "unverified";
                    return response()->json($data, 200);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            $data['user_status'] = "";
            $data['next_status'] = "";
            return response()->json($data, 200);
        }
    }
    public function reSendMail($id)
    {
        $getuser = User::where('id', $id)->first();
        $data['name'] = $getuser->parent_f_name . ' ' . $getuser->parent_l_name;
        $data['email'] = $getuser->email;
        $data['vcode'] = $getuser->email_vcode;
        $data['id'] = $getuser->id;
        $data['email_subject'] = "Verify your email address on V-Tutor";
        Mail::send(new TeacherVerify($data));
    }
    public function changeStatus($id, Request $request)
    {
        try {
            $user = User::where('id', $id)->first();
            if (@$user) {
                if ($user->status == 'AA') {
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    User::where('id', $id)->update($updateStatus);
                } elseif ($user->status == 'A') {
                    $updateStatus['status'] = 'I';
                    $status = "Inctive";
                    User::where('id', $id)->update($updateStatus);
                } elseif ($user->status == 'I') {
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    User::where('id', $id)->update($updateStatus);
                } elseif ($user->status == 'U') {
                    $updateStatus['status'] = 'A';
                    $status = "Active";
                    User::where('id', $id)->update($updateStatus);
                }
                session()->flash("success", $user->f_name . " " . $user->l_name . "'s status is !");
                return redirect()->back();
            } else {
                session()->flash("error", "Student is not found associated with id : " . $id);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
    public function deleteStudent($id, Request $request)
    {
        try {
            $user = User::where('id', $id)->first();
            if (@$user) {
                $updateStatus['status'] = 'D';
                $status = "Deleted";
                User::where('id', $id)->update($updateStatus);

                session()->flash("success", "Student deleted successfully!");
                return redirect()->back();
            } else {
                session()->flash("error", "Student is not found associated with id : " . $id);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
    public function editStudentPersonalInfo($id, Request $request)
    {
        try {
            $data['user'] = User::where('id', $id)->first();
            $data['grades'] = Grade::whereIn('status', ['I', 'A'])->get();
            $data['states'] = State::orderBy('id', 'asc')->get();
            $data['timezonesLists'] = TimezoneLists::get();
            $data['schoolList'] = School::with(['getState', 'getSuburb'])->get();
            if (@$request->all()) {
                // $isExistEmail = User::where(['email'=>@$request->email])->whereNotIn('id',[$id])->whereIn('status',['A','I','AA','U'])->first();
                // if(@$isExistEmail){
                //     session()->flash("error","Email-id already exist!");
                //     return redirect()->back();
                // }
                // $isExistPhone = User::where(['phone'=>@$request->phone])->whereNotIn('id',[$id])->whereIn('status',['A','I','AA','U'])->first();
                // if(@$isExistPhone){
                //     session()->flash("error","Phone no already exist!");
                //     return redirect()->back();
                // }
                // dd($request->all());
                $updateTutor['salutation'] = @$request->salutation;
                $updateTutor['qualification'] = @$request->qualification;
                // $updateTutor['f_name'] = @$request->f_name;
                // $updateTutor['l_name'] = @$request->l_name;
                // $updateTutor['parent_f_name'] = @$request->parent_f_name;
                // $updateTutor['parent_l_name'] = @$request->parent_l_name;

                // $updateTutor['email'] = @$request->email;
                // $updateTutor['phone'] = @$request->phone;
                $updateTutor['grade'] = @$request->grade;
                $updateTutor['gender'] = @$request->gender;
                $updateTutor['is_full_time'] = @$request->is_full_time;
                $updateTutor['private_or_home'] = @$request->private_or_home;
                // $updateTutor['dob'] = @$request->dob;

                $updateTutor['annual_income'] = @$request->annual_income;
                $updateTutor['about_me'] = nl2br(@$request->about_me);
                $updateTutor['school'] = @$request->school;
                $updateTutor['country'] = @$request->country;
                $updateTutor['state'] = @$request->state;
                $updateTutor['city'] = @$request->city;
                $updateTutor['address'] = @$request->address;
                $updateTutor['zip'] = @$request->zip;
                $updateTutor['suburb'] = @$request->suburb;
                $updateTutor['timezone_id'] = @$request->timezone_id;

                if (@$request->imgSelect) {
                    $updateTutor['profile_pic'] = @$request->imgSelect;
                }
                // if(@$request->img){
                //     $image = $request->img;
                //     $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
                //     $image->move('storage/student_profile_pic/', $filename);
                //     $updateTutor['profile_pic'] = $filename;
                // }
                User::where('id', $id)->update($updateTutor);
                // if(@$request->img){
                //     if(@$data['user']->profile_pic){
                //         $image_path = 'storage/student_profile_pic/'.@$data['user']->profile_pic;
                //         if(file_exists(@$image_path)){
                //            unlink(@$image_path);
                //         }
                //     }
                // }
                $data['user'] = User::where('id', $id)->first();
                session()->flash("success", "Student information updated");
                return redirect()->back();
            } else {
                if (@$data['user']) {
                    return view('admin.modules.student_management.edit_student_personal_info')->with($data);
                } else {
                    session()->flash("error", "Student is not found associated with id : " . $id);
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
    public function getStudentManagementList(Request $request)
    {
        $data['students'] = User::where(['user_type' => 'U'])->whereNotIn('status', ['D']);
        if (@$request->col1_filter) {
            $data['students'] = $data['students']->where(function ($query) use ($request) {
                $query->Where('f_name', 'like', '%' . $request->col1_filter . '%')
                    ->orWhere('l_name', 'like', '%' . $request->col1_filter . '%')
                    ->orWhere('email', 'like', '%' . $request->col1_filter . '%')
                    ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->col1_filter . '%')
                    ->orWhere('phone', 'like', '%' . $request->col1_filter . '%');
            });
        }
        if (@$request->col2_filter) {
            $data['students'] = $data['students']->where(function ($query) use ($request) {
                $query->Where('status', $request->col2_filter);
            });
        }


        if (@$request->col3_filter) {
            $data['students'] = $data['students']->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->col3_filter . " 00:00:00", @$request->col3_filter . " 23:59:59"]);
            });
        }
        if (@$request->col4_filter) {
            $data['students'] = $data['students']->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->col4_filter . " 00:00:00", @$request->col4_filter . " 23:59:59"]);
            });
        }

        $data['students'] = $data['students']->orderBy('id', 'desc')->get();
        $t = '';
        $t .= '<table>
            <tr>
                <th style="border:1px solid black;background-color
                  :lime">Name</th>
                <th style="border:1px solid black;background-color
                :lime">Email</th>
                <th style="border:1px solid black;background-color
                :lime">Phone</th>
                <th style="border:1px solid black;background-color
                :lime">Date Joined</th>
                <th style="border:1px solid black;background-color
                :lime">Sign Up</th>
                <th style="border:1px solid black;background-color
                :lime">Status</th>
            </tr>
            ';
        if (@$data['students']) {
            foreach (@$data['students'] as $value) {
                if ($value->status == "U") {
                    $status = "Unverified";
                } elseif ($value->status == "A") {
                    $status = "Active";
                } elseif ($value->status == "I") {
                    $status = "Inactive";
                } else {
                    $status = "";
                }
                if (@$value->platform_type != NULL) {
                    $platform_type = @$value->platform_type;
                } else {
                    $platform_type = "Web";
                }
                $payment_method = "Online";
                $t .= '
                <tr>
                    <td style="border:1px solid black;">' . @$value->f_name . ' ' . @$value->l_name . '</td>
                    <td style="border:1px solid black;">' . @$value->email . '</td>
                    <td style="border:1px solid black;">' . @$value->phone . '</td>
                    <td style="border:1px solid black;">' . @$value->created_at . '</td>
                    <td style="border:1px solid black;">' . $platform_type . '</td>

                    <td style="border:1px solid black;">' . $status . '</td>
                </tr>';
            }
        }
        $t .= '</table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=StudentManagement.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
    }
}
