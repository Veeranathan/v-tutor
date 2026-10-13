<?php

namespace App\Http\Controllers\Student\SearchResult;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\TutorshipPlan;
use App\Models\State;
use App\Models\Branch;
use App\Models\Tutor_calander_availability;
use Auth;
use App\Models\LangToTutor;
use App\Models\Language;
use App\Models\AdminDisableBookings;
use App\Models\AdminDisableBookingDates;
use App\Models\TimezoneLists;
use App\Models\StudentClassBooking;
use App\Models\TutorWWCCModel;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchResultController extends Controller
{


    public function searchResult(Request $request, $slug = null)
    {
        // Redirect tutors if they try to access this page
        if (Auth::check() && Auth::user()->user_type == 'T') {
            return redirect()->back();
        }

        $availability = $request->input('availability', []);
        $availability = is_array($availability) ? $availability : [$availability];
        $availability = array_values(array_filter($availability));

        $data['request'] = $request->all();
        // dd($availability);

        $branchSlugs = $request->input('branch_id', []);
        
        $branchSlugs = is_array($branchSlugs) ? $branchSlugs : [$branchSlugs];
        $branchSlugs = array_values(array_filter($branchSlugs)); // remove "", null
        $subjectSlugs = $request->subject_id
            ? (is_array($request->subject_id) ? $request->subject_id : [$request->subject_id])
            : [];
        $searchSubjectIds = $request->search_subject_id
            ? (is_array($request->search_subject_id) ? $request->search_subject_id : [$request->search_subject_id])
            : [];

        # Default data
        $data['timezonesLists'] = TimezoneLists::orderBy('time_zone_name', 'asc')->get();
        $data['getBookedTutors'] = [];

        if (Auth::check() && Auth::user()->user_type == 'S') {
            $data['getBookedTutors'] = StudentClassBooking::where(['student_id' => Auth::user()->id])
                ->whereIn('booking_status', ['B', 'CM'])
                ->pluck('tutor_id')
                ->groupBy('tutor_id')
                ->toArray();
        }

        $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
        $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')
            ->pluck('disable_booking_date')
            ->toArray();
        $data['states'] = State::orderBy('state_name', 'asc')->get();

        /**
         * Subjects (filter by branch if branch is selected)
         */
        if (!empty($branchSlugs)) {
            $branchIds = Branch::whereIn('slug', $branchSlugs)->pluck('id')->toArray();
            if (!empty($branchIds)) {
                $data['subjects'] = Subject::where(['status' => 'A'])
                    ->whereIn('branch_id', $branchIds)
                    ->orderBy('display_order', 'asc')
                    ->get();
            } else {
                $data['subjects'] = Subject::where('status', 'A')
                    ->select('id', 'slug', 'subject', 'capture_code', 'status')
                    ->orderBy('display_order', 'asc')
                    ->get();
            }
        } else {
            $data['subjects'] = Subject::where('status', 'A')
                ->select('id', 'slug', 'subject', 'capture_code', 'status')
                ->orderBy('subject', 'asc')
                ->get();
        }

        # Branch list (dropdown)
        $data['branches'] = !empty($branchSlugs)
            ? Branch::whereIn('slug', $branchSlugs)->get()
            : Branch::where('status', 'A')->orderBy('display_order', 'asc')->get();

        # Grades
        $data['grades'] = Grade::where('status', 'A')
            ->select('id', 'slug', 'grade_name', 'capture_code', 'status')
            ->orderBy('grade_name', 'asc')
            ->get();

        # Rates
        $data['min_hourly_rate_fetch'] = User::where(['user_type' => 'T', 'draft' => 'N'])
            ->whereIn('status', ['A', 'AA'])
            ->min('min_hourly_rate');
        $data['max_hourly_rate_fetch'] = User::where(['user_type' => 'T', 'draft' => 'N'])
            ->whereIn('status', ['A', 'AA'])
            ->max('min_hourly_rate');

        $userId = Auth::check() ? Auth::user()->id : null;
        $loggedInStudentStateId = Auth::check() ? Auth::user()->state : null;
        $loggedInStudentGradeId = Auth::check() ? Auth::user()->grade : null;

        /**
         * Tutor base query
         */
       $baseQuery = User::with([
        'getMyAvailability',
        'getMinTutorShipPlan',
        'getMaxTutorShipPlan',
        'getuserToFavourite' => function ($query) use ($userId) {
            if ($userId) {
                $query->where('user_id', $userId);
            }
        },
        'getTutorAcademic',
        'languguageToTuor:id,tutor_id,language_id',
        'languguageToTuor.languageName:id,language',
        'getTimezone',
        'getState:id,slug,state_name',
        'getTutorShipPlan.getBranch:id,slug,branch_name,capture_code,status',
        'getTutorShipPlan.getSubject:id,slug,subject,capture_code,status',
        'getTutorShipPlan.getGrade:id,slug,grade_name,capture_code,status',
        'getTutorShipPlan:id,teacher_id,grade_id,subject_id,branch_id,hourly_rate,status',
        'getTutorWWCC',
        'getCalendarAvailability'
    ])
    ->where(['user_type' => 'T', 'draft' => 'N'])
    ->whereIn('status', ['AA', 'A'])

    /**
     * ✅ NEW CONDITION #1:
     * Tutor must have at least ONE valid WWCC state.
     * (If no WWCC OR all invalid → tutor is removed)
     */
    ->whereHas('getTutorWWCC', function ($q) {
        $q->where('is_valid', 1);
    })

    /**
     * ✅ NEW CONDITION #2:
     * Tutor must have at least ONE availability row with status = 'A'.
     * (If tutor deleted all availability, they are removed)
     */
    ->whereHas('getMyAvailability', function ($q) {
        $q->where('status', 'A');
    })

    /**
     * EXISTING CONDITION – DO NOT TOUCH
     * Must have valid active tuition plan
     */
    ->whereHas('getTutorShipPlan', function ($q) use ($request, $loggedInStudentGradeId) {
        $q->where('status', 'A');

        if ($request->grade_id) {
            $q->where('grade_id', $request->grade_id);
        } elseif ($loggedInStudentGradeId) {
            $q->where('grade_id', $loggedInStudentGradeId);
        }
    })

    /**
     * EXISTING CONDITION – DO NOT TOUCH
     * Tutor must have unbooked calendar availability in the future
     */
    ->whereHas('getCalendarAvailability', function ($q) {
        $q->where('booking_status', 'NB')
          ->where('date', '>=', now()->toDateString());
    });

        if (Auth::check() && $loggedInStudentStateId) {
            $baseQuery->whereHas('getTutorWWCC', function ($query) use ($loggedInStudentStateId) {
                $query->where('states', $loggedInStudentStateId)
                    ->where('is_valid', 1);
            });
        }

        if (Auth::check() && $loggedInStudentGradeId) {
            $baseQuery->whereHas('getTutorShipPlan', function ($query) use ($loggedInStudentGradeId) {
                $query->where('grade_id', $loggedInStudentGradeId);
            });
        }

        $maxTotalExp = User::where(['status' => 'A', 'user_type' => 'T'])->max('total_experience');
        $data['maxTotalExp'] = $maxTotalExp;
        $data['experience_arr'] = ($maxTotalExp < 2) ? range(0, $maxTotalExp) : range(0, $maxTotalExp, 2);

        $data['subjectNames'] = [];
        $data['branchNames'] = [];
        if (!empty($branchSlugs)) {
    $data['branchNames'] = Branch::whereIn('slug', $branchSlugs)->pluck('branch_name')->toArray();
}

        /**
         * Apply filters safely
         */
        if ($request->all()) {
            if ($request->grade) {
                $baseQuery->whereHas('getTutorShipPlan.getGrade', function ($q) use ($request) {
                    $q->where('slug', $request->grade);
                });
            }

            if ($request->review) {
                $baseQuery->where('avg_review','>=', $request->review);
            }

            if (!empty($subjectSlugs)) {
                $subjectIds = Subject::whereIn('slug', $subjectSlugs)->pluck('id')->toArray();
                $data['subjectNames'] = Subject::whereIn('slug', $subjectSlugs)->pluck('subject')->toArray();

                $baseQuery->whereHas('getTutorShipPlan.getSubject', function ($q) use ($subjectSlugs) {
                    $q->whereIn('slug', $subjectSlugs);
                });
            }

            if (!empty($branchSlugs)) {
                $branchIds = Branch::whereIn('slug', $branchSlugs)->pluck('id')->toArray();
                $data['branches'] = Branch::whereIn('slug', $branchSlugs)->get();
                $subjectIdsForBranch = Subject::whereIn('branch_id', $branchIds)->where('status', 'A')->pluck('id')->toArray();

                $baseQuery->whereHas('getTutorShipPlan.getSubject', function ($q) use ($subjectIdsForBranch) {
                    $q->whereIn('id', $subjectIdsForBranch);
                });
            }

            if (!empty($searchSubjectIds)) {
                $data['subjectNames'] = Subject::whereIn('id', $searchSubjectIds)->pluck('subject')->toArray();
                $data['subjectDetails'] = Subject::whereIn('id', $searchSubjectIds)->first();

                $baseQuery->whereHas('getTutorShipPlan.getSubject', function ($q) use ($searchSubjectIds) {
                    $q->whereIn('id', $searchSubjectIds);
                });
            }

            if ($request->state) {
                $baseQuery->whereHas('getState', function ($q) use ($request) {
                    $q->where('slug', $request->state);
                });
            }

            if ($request->timezone_id) {
                $data['timezoneValue'] = TimezoneLists::find($request->timezone_id);
                $baseQuery->where('timezone_id', $request->timezone_id);
            }

            if ($request->experience) {
                $expSplit = explode("-", $request->experience);
                if (!empty($expSplit[0]) && !empty($expSplit[1])) {
                    $baseQuery->whereBetween('total_experience', [$expSplit[0], $expSplit[1]]);
                } else {
                    if (!empty($expSplit[0])) {
                        $baseQuery->where('total_experience', '>=', $expSplit[0]);
                    }
                    if (!empty($expSplit[1])) {
                        $baseQuery->where('total_experience', '<=', $expSplit[1]);
                    }
                }
            }

            if (!empty($availability)) {
                $baseQuery->whereHas('getMyAvailability', function ($q) use ($availability) {
                    $q->whereIn('day', $availability);
                });
            }

            $min = $request->input('min_hourly_rate', null);
            $max = $request->input('max_hourly_rate', null);

            $hasMin = $min !== null && $min !== '' && is_numeric($min);
            $hasMax = $max !== null && $max !== '' && is_numeric($max);

            if ($hasMin && $hasMax) {
                $baseQuery->whereBetween('min_hourly_rate', [(float)$min, (float)$max]);
            } elseif ($hasMin) {
                $baseQuery->where('min_hourly_rate', '>=', (float)$min);
            } elseif ($hasMax) {
                $baseQuery->where('min_hourly_rate', '<=', (float)$max);
            }

            $baseQuery->select('id', 'f_name', 'l_name', 'slug', 'user_type', 'student_type', 'status', 'avatar', 'profile_pic', 'about_me', 'profile_video', 'video_short_url', 'total_experience', 'total_no_of_reviews', 'avg_review', 'min_hourly_rate', 'created_at', 'state', 'timezone_id', 'city', 'free_trial');

            switch ($request->input('sort_type_value', 'R')) {
                case 'D':
                    $baseQuery->orderby('created_at', 'desc');
                    break;
                case 'R':
                    $baseQuery->orderby('avg_review', 'desc');
                    break;
                case 'E':
                    $baseQuery->orderby('total_experience', 'desc');
                    break;
                case 'H':
                    $baseQuery->orderby('min_hourly_rate', 'desc');
                    break;
                case 'L':
                    $baseQuery->orderby('min_hourly_rate', 'asc');
                    break;
                default:
                    $baseQuery->orderby('avg_review', 'desc');
                    break;
            }
        } else {
            $baseQuery->orderby('avg_review', 'desc');
        }

        # Final paginate
        $data['tutors'] = $baseQuery->paginate(10)->appends(request()->query());

        # Store applied filters
        $data['key'] = $request->all();
        $data['grade_obj'] = Grade::where('slug', $request->grade)->select('id', 'slug', 'grade_name', 'status', 'capture_code')->first();
        $data['grade_value'] = $request->grade;
        $data['subject_slugs'] = $subjectSlugs;
        $data['branch_slugs'] = $branchSlugs;
        $data['state_value'] = State::where('slug', $request->state)->select('id', 'slug', 'state_name')->first();
        $data['state_slug'] = $request->state;
        $data['review_value'] = $request->review ?? null;
        $data['sort_type_value'] = $request->input('sort_type_value', 'R');
        $data['experience_value'] = $request->experience;
        $expSplit = explode(" ", $request->experience);
        $data['min_experience_value'] = trim($expSplit[0] ?? '');
        $data['max_experience_value'] = trim($expSplit[1] ?? '');
        $data['hourly_rate_value'] = $request->hourly_rate;
        $data['request_min_hourly_rate'] = $request->min_hourly_rate;
        $data['request_max_hourly_rate'] = $request->max_hourly_rate;

        return view('student.modules.search_result.search_result')->with($data);
    }

    // public function searchResult(Request $request, $slug = null)
    // {
    //     // Redirect tutors if they try to access this page
    //     if (Auth::check() && Auth::user()->user_type == 'T') {
    //         return redirect()->back();
    //     }


    //     $branchSlugs = $request->input('branch_id', []);
    //     $branchSlugs = is_array($branchSlugs) ? $branchSlugs : [$branchSlugs];
    //     $branchSlugs = array_values(array_filter($branchSlugs)); // remove "", null
    //     $subjectSlugs = $request->subject_id
    //         ? (is_array($request->subject_id) ? $request->subject_id : [$request->subject_id])
    //         : [];
    //     $searchSubjectIds = $request->search_subject_id
    //         ? (is_array($request->search_subject_id) ? $request->search_subject_id : [$request->search_subject_id])
    //         : [];

    //     # Default data
    //     $data['timezonesLists'] = TimezoneLists::orderBy('time_zone_name', 'asc')->get();
    //     $data['getBookedTutors'] = [];

    //     if (Auth::check() && Auth::user()->user_type == 'S') {
    //         $data['getBookedTutors'] = StudentClassBooking::where(['student_id' => Auth::user()->id])
    //             ->whereIn('booking_status', ['B', 'CM'])
    //             ->pluck('tutor_id')
    //             ->groupBy('tutor_id')
    //             ->toArray();
    //     }

    //     $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
    //     $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')
    //         ->pluck('disable_booking_date')
    //         ->toArray();
    //     $data['states'] = State::orderBy('state_name', 'asc')->get();

    //     /**
    //      * Subjects (filter by branch if branch is selected)
    //      */
    //     if (!empty($branchSlugs)) {
    //         $branchIds = Branch::whereIn('slug', $branchSlugs)->pluck('id')->toArray();
    //         if (!empty($branchIds)) {
    //             $data['subjects'] = Subject::where(['status' => 'A'])
    //                 ->whereIn('branch_id', $branchIds)
    //                 ->orderBy('display_order', 'asc')
    //                 ->get();
    //         } else {
    //             $data['subjects'] = Subject::where('status', 'A')
    //                 ->select('id', 'slug', 'subject', 'capture_code', 'status')
    //                 ->orderBy('display_order', 'asc')
    //                 ->get();
    //         }
    //     } else {
    //         $data['subjects'] = Subject::where('status', 'A')
    //             ->select('id', 'slug', 'subject', 'capture_code', 'status')
    //             ->orderBy('subject', 'asc')
    //             ->get();
    //     }

    //     # Branch list (dropdown)
    //     $data['branches'] = !empty($branchSlugs)
    //         ? Branch::whereIn('slug', $branchSlugs)->get()
    //         : Branch::where('status', 'A')->orderBy('display_order', 'asc')->get();

    //     # Grades
    //     $data['grades'] = Grade::where('status', 'A')
    //         ->select('id', 'slug', 'grade_name', 'capture_code', 'status')
    //         ->orderBy('grade_name', 'asc')
    //         ->get();

    //     # Rates
    //     $data['min_hourly_rate_fetch'] = User::where(['user_type' => 'T', 'draft' => 'N'])
    //         ->whereIn('status', ['A', 'AA'])
    //         ->min('min_hourly_rate');
    //     $data['max_hourly_rate_fetch'] = User::where(['user_type' => 'T', 'draft' => 'N'])
    //         ->whereIn('status', ['A', 'AA'])
    //         ->max('min_hourly_rate');

    //     $userId = Auth::check() ? Auth::user()->id : null;
    //     $loggedInStudentStateId = Auth::check() ? Auth::user()->state : null;
    //     $loggedInStudentGradeId = Auth::check() ? Auth::user()->grade : null;

    //     /**
    //      * Tutor base query
    //      */
    //     $baseQuery = User::with([
    //         'getMyAvailability',
    //         'getMinTutorShipPlan',
    //         'getMaxTutorShipPlan',
    //         'getuserToFavourite' => function ($query) use ($userId) {
    //             if ($userId) {
    //                 $query->where('user_id', $userId);
    //             }
    //         },
    //         'getTutorAcademic',
    //         'languguageToTuor:id,tutor_id,language_id',
    //         'languguageToTuor.languageName:id,language',
    //         'getTimezone',
    //         'getState:id,slug,state_name',
    //         'getTutorShipPlan.getBranch:id,slug,branch_name,capture_code,status',
    //         'getTutorShipPlan.getSubject:id,slug,subject,capture_code,status',
    //         'getTutorShipPlan.getGrade:id,slug,grade_name,capture_code,status',
    //         'getTutorShipPlan:id,teacher_id,grade_id,subject_id,branch_id,hourly_rate,status',
    //         'getTutorWWCC',
    //         'getCalendarAvailability'
    //     ])
    //         ->where(['user_type' => 'T', 'draft' => 'N'])
    //         ->whereIn('status', ['AA', 'A'])
    //         ->whereHas('getTutorShipPlan', function ($q) use ($request, $loggedInStudentGradeId) {
    //             $q->where('status', 'A');
    //             if ($request->grade_id) {
    //                 $q->where('grade_id', $request->grade_id);
    //             } elseif ($loggedInStudentGradeId) {
    //                 $q->where('grade_id', $loggedInStudentGradeId);
    //             }
    //         })
    //         ->whereHas('getCalendarAvailability', function ($q) {
    //             $q->where('booking_status', 'NB')
    //                 ->where('date', '>=', now()->toDateString());
    //         });

    //     if (Auth::check() && $loggedInStudentStateId) {
    //         $baseQuery->whereHas('getTutorWWCC', function ($query) use ($loggedInStudentStateId) {
    //             $query->where('states', $loggedInStudentStateId)
    //                 ->where('is_valid', 1);
    //         });
    //     }

    //     if (Auth::check() && $loggedInStudentGradeId) {
    //         $baseQuery->whereHas('getTutorShipPlan', function ($query) use ($loggedInStudentGradeId) {
    //             $query->where('grade_id', $loggedInStudentGradeId);
    //         });
    //     }

    //     $maxTotalExp = User::where(['status' => 'A', 'user_type' => 'T'])->max('total_experience');
    //     $data['maxTotalExp'] = $maxTotalExp;
    //     $data['experience_arr'] = ($maxTotalExp < 2) ? range(0, $maxTotalExp) : range(0, $maxTotalExp, 2);

    //     $data['subjectNames'] = [];
    //     $data['branchNames'] = [];

    //     /**
    //      * Apply filters safely
    //      */
    //     if ($request->all()) {
    //         if ($request->grade) {
    //             $baseQuery->whereHas('getTutorShipPlan.getGrade', function ($q) use ($request) {
    //                 $q->where('slug', $request->grade);
    //             });
    //         }

    //         if (!empty($subjectSlugs)) {
    //             $subjectIds = Subject::whereIn('slug', $subjectSlugs)->pluck('id')->toArray();
    //             $data['subjectNames'] = Subject::whereIn('slug', $subjectSlugs)->pluck('subject')->toArray();

    //             $baseQuery->whereHas('getTutorShipPlan.getSubject', function ($q) use ($subjectSlugs) {
    //                 $q->whereIn('slug', $subjectSlugs);
    //             });
    //         }

    //         if (!empty($branchSlugs)) {
    //             $branchIds = Branch::whereIn('slug', $branchSlugs)->pluck('id')->toArray();
    //             $data['branches'] = Branch::whereIn('slug', $branchSlugs)->get();
    //             $subjectIdsForBranch = Subject::whereIn('branch_id', $branchIds)->where('status', 'A')->pluck('id')->toArray();

    //             $baseQuery->whereHas('getTutorShipPlan.getSubject', function ($q) use ($subjectIdsForBranch) {
    //                 $q->whereIn('id', $subjectIdsForBranch);
    //             });
    //         }

    //         if (!empty($searchSubjectIds)) {
    //             $data['subjectNames'] = Subject::whereIn('id', $searchSubjectIds)->pluck('subject')->toArray();
    //             $data['subjectDetails'] = Subject::whereIn('id', $searchSubjectIds)->first();

    //             $baseQuery->whereHas('getTutorShipPlan.getSubject', function ($q) use ($searchSubjectIds) {
    //                 $q->whereIn('id', $searchSubjectIds);
    //             });
    //         }

    //         if ($request->state) {
    //             $baseQuery->whereHas('getState', function ($q) use ($request) {
    //                 $q->where('slug', $request->state);
    //             });
    //         }

    //         if ($request->timezone_id) {
    //             $data['timezoneValue'] = TimezoneLists::find($request->timezone_id);
    //             $baseQuery->where('timezone_id', $request->timezone_id);
    //         }

    //         if ($request->experience) {
    //             $expSplit = explode(" ", $request->experience);
    //             if (!empty($expSplit[0]) && !empty($expSplit[1])) {
    //                 $baseQuery->whereBetween('total_experience', [$expSplit[0], $expSplit[1]]);
    //             } else {
    //                 if (!empty($expSplit[0])) {
    //                     $baseQuery->where('total_experience', '>=', $expSplit[0]);
    //                 }
    //                 if (!empty($expSplit[1])) {
    //                     $baseQuery->where('total_experience', '<=', $expSplit[1]);
    //                 }
    //             }
    //         }

    //         $min = $request->input('min_hourly_rate', null);
    //         $max = $request->input('max_hourly_rate', null);

    //         $hasMin = $min !== null && $min !== '' && is_numeric($min);
    //         $hasMax = $max !== null && $max !== '' && is_numeric($max);

    //         if ($hasMin && $hasMax) {
    //             $baseQuery->whereBetween('min_hourly_rate', [(float)$min, (float)$max]);
    //         } elseif ($hasMin) {
    //             $baseQuery->where('min_hourly_rate', '>=', (float)$min);
    //         } elseif ($hasMax) {
    //             $baseQuery->where('min_hourly_rate', '<=', (float)$max);
    //         }

    //         $baseQuery->select('id', 'f_name', 'l_name', 'slug', 'user_type', 'student_type', 'status', 'avatar', 'profile_pic', 'about_me', 'profile_video', 'video_short_url', 'total_experience', 'total_no_of_reviews', 'avg_review', 'min_hourly_rate', 'created_at', 'state', 'timezone_id', 'city');

    //         switch ($request->input('sort_type_value', 'R')) {
    //             case 'D':
    //                 $baseQuery->orderby('created_at', 'desc');
    //                 break;
    //             case 'R':
    //                 $baseQuery->orderby('avg_review', 'desc');
    //                 break;
    //             case 'E':
    //                 $baseQuery->orderby('total_experience', 'desc');
    //                 break;
    //             case 'H':
    //                 $baseQuery->orderby('min_hourly_rate', 'desc');
    //                 break;
    //             case 'L':
    //                 $baseQuery->orderby('min_hourly_rate', 'asc');
    //                 break;
    //             default:
    //                 $baseQuery->orderby('avg_review', 'desc');
    //                 break;
    //         }
    //     } else {
    //         $baseQuery->orderby('avg_review', 'desc');
    //     }

    //     # Final paginate
    //     $data['tutors'] = $baseQuery->paginate(10)->appends(request()->query());

    //     # Store applied filters
    //     $data['key'] = $request->all();
    //     $data['grade_obj'] = Grade::where('slug', $request->grade)->select('id', 'slug', 'grade_name', 'status', 'capture_code')->first();
    //     $data['grade_value'] = $request->grade;
    //     $data['subject_slugs'] = $subjectSlugs;
    //     $data['branch_slugs'] = $branchSlugs;
    //     $data['state_value'] = State::where('slug', $request->state)->select('id', 'slug', 'state_name')->first();
    //     $data['state_slug'] = $request->state;
    //     $data['review_value'] = $request->review ?? null;
    //     $data['sort_type_value'] = $request->input('sort_type_value', 'R');
    //     $data['experience_value'] = $request->experience;
    //     $expSplit = explode(" ", $request->experience);
    //     $data['min_experience_value'] = trim($expSplit[0] ?? '');
    //     $data['max_experience_value'] = trim($expSplit[1] ?? '');
    //     $data['hourly_rate_value'] = $request->hourly_rate;
    //     $data['request_min_hourly_rate'] = $request->min_hourly_rate;
    //     $data['request_max_hourly_rate'] = $request->max_hourly_rate;

    //     return view('student.modules.search_result.search_result')->with($data);
    // }

    public function applyFilter(Request $request) {}

    public function addToFavourite(Request $request) {}

    public function saveSearchOnClickValue(Request $request)
    {
        if ($request->save_on_click_value) {
            session(['save_on_click_value' => $request->save_on_click_value]);
        }
        if ($request->save_search_on_click_tutor_id) {
            session(['save_search_on_click_tutor_id' => $request->save_search_on_click_tutor_id]);
        }
        if ($request->book_subject) {
            session(['book_subject' => $request->book_subject]);
        }
        if ($request->book_grade) {
            session(['book_grade' => $request->book_grade]);
        }
        return 1;
    }

    public function getSearchSubjects(Request $request)
    {
        try {
            $subjects = Subject::where(['status' => 'A']);
            if ($request->subject) {
                $subjects->where('subject', 'like', '%' . $request->subject . '%');
            }
            $data['subjects'] = $subjects->get();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'tutors_count' => 0
            ], 200);
        }
    }
}
