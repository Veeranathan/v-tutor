<?php

namespace App\Http\Controllers\CategoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicProgram;
use App\Models\Grade;
use App\Models\Branch;
use Illuminate\Support\Facades\Validator;
use App\Models\Messages;
use Mail;
use App\Mail\ProductEnquiryMail;

class CategoryPageController extends Controller
{
    public function show($category, $slug)
    {
        $pageConfig = config("pages.$category.$slug");
        abort_if(!$pageConfig, 404);

        $academicPrograms = AcademicProgram::query()
            ->where('status', 1)
            ->whereJsonContains('display_for', 'website')
            // SUBJECT PAGE
            ->when($category === 'subject', function ($q) use ($slug) {
                $normalizedSlug = strtolower($slug);
                //NAPLAN PAGE
                if ($normalizedSlug === 'naplan') {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%naplan%']);
                }
                // OPPORTUNITY CLASS PAGE
                elseif ($normalizedSlug === 'opportunity-class') {
                    $q->whereRaw('LOWER(name) LIKE ?', ['% oc %']);
                }
                // ACADEMIC YEAR PAGE
                elseif ($normalizedSlug === 'learning-programs') {
                }
                // NORMAL SUBJECT PAGE
                else {
                    $q->whereHas('branch', function ($b) use ($normalizedSlug) {
                    $b->whereRaw('LOWER(branch_name) = ?', [$normalizedSlug]);
                    });
                }
            })

            // YEAR PAGE
            ->when($category === 'year', function ($q) use ($slug) {

                $yearNumber = (int) str_replace('year-', '', $slug);
                $gradeId = \App\Models\Grade::where('grade_name', 'LIKE', "%{$yearNumber}%")
                ->where('status', 'A')
                ->value('id');
                if ($gradeId) {
                    $q->where('grade_id', $gradeId);
                    } else {
                    $q->whereRaw('1 = 0');
                }
            })

            // CURRICULUM PAGE
            ->when($category === 'curriculum', function ($q) use ($slug) {
                $normalizedSlug = strtolower(str_replace('-', ' ', $slug));
                $q->whereRaw("LOWER(curriculum) = ?",[$normalizedSlug]);
            })

            // STATE PAGE
            ->when($category === 'state', function ($q) use ($slug) {
                $normalizedSlug = strtolower(str_replace('-', ' ', $slug));
                $q->whereRaw("LOWER(state) = ?",[$normalizedSlug]);
            })

            // CITY PAGE
            ->when($category === 'city', function ($q) use ($slug) {
                $q->where('city', $slug);
            })
            ->with(['grade:id,grade_name']) 
            ->orderBy('popular', 'desc')
            ->orderByRaw("FIELD(state,'New South Wales','Victoria','Queensland','South Australia','Western Australia','Tasmania','Australian Capital Territory','Northern Territory')")
            ->orderBy('grade_id')
            ->orderBy('display_order')
            // ->get([
            //     'id', 
            //     'name',
            //     'description',
            //     'price',
            //     'regular_price',
            //     'discount',
            //     'validity',
            //     'popular',
            //     'grade_id',
            //     'program_type'  
            // ]);
            ->get()
            ->groupBy('name'); 

        
        /**
         * HARD-CODED FEATURES (same for all programs)
         */
     

        $grades = Grade::where('status', 'A')
            ->select('id', 'slug', 'grade_name')
            ->get();

        $branches = Branch::where('status', 'A')
            ->select('id', 'slug', 'branch_name', 'capture_code')
            ->get();
        
        $cartItemIds = collect(session('cart.items', []))
            ->pluck('id')
            ->toArray();

        return view('pages.category', compact(
            'pageConfig',
            'academicPrograms',
            'grades',
            'branches',
            'cartItemIds'
        ))->with('pageType', $category);
    }


public function programDetail(Request $request, $slug)
{
    $programs = AcademicProgram::with(['grade','branch'])
        ->where('status',1)
        ->whereJsonContains('display_for','website')
        ->where('slug',$slug)
        ->get();

    if($programs->count() > 1 && !$request->year){
        return view('pages.program-variant-select', compact('programs','slug'));
    }
  
    if($programs->count() > 1 && !$request->state){

        return view('pages.program-variant-select', [
            'programs' => $programs,
            'slug' => $slug,
            'selectedYear' => $request->year,
            'filteredStates' => $request->states ? explode(',', $request->states) : []
        ]);
    }

    $query = AcademicProgram::where('slug',$slug)
        ->where('status',1)
        ->whereJsonContains('display_for','website');

    if($request->year){
        $query->where('grade_id',$request->year);
    }

    if($request->state){
        $state = str_replace('-', ' ', $request->state);
        $state = ucwords($state);
        $query->where('state',$state);
    }

    $program = $query->firstOrFail();

    /*
    FEATURES
    */

    $commonFeatures = [
        ['icon' => 'bi-clock', 'title' => '10-hours duration'],
        ['icon' => 'bi-clipboard-check', 'title' => 'Structured Session Plans'],
        ['icon' => 'bi-graph-up', 'title' => 'Micro-assessments every session'],
        ['icon' => 'bi-award', 'title' => 'Mid-program check-in for progress'],
        ['icon' => 'bi-mortarboard', 'title' => 'End of Program Assessment'],
        ['icon' => 'bi-clipboard-check', 'title' => 'Progress Tracking & Reporting'],
        ['icon' => 'bi-graph-up', 'title' => '30-Day Skill Progress Guarantee'],
    ];

    $intensiveFeatures = [
        ['icon' => 'bi-lightning-charge', 'title' => 'Intensive 5-Session Program'],
        ['icon' => 'bi-bullseye', 'title' => 'Targeted Skill Revision'],
        ['icon' => 'bi-journal-check', 'title' => 'Exam-Focused Practice'],
        ['icon' => 'bi-stopwatch', 'title' => 'Timed Mini Assessments'],
        ['icon' => 'bi-chat-dots', 'title' => 'Focused Feedback & Review'],
        ['icon' => 'bi-rocket', 'title' => 'Short-Term Performance Boost'],
    ];

    $mlpFeatures = [
        ['icon' => 'bi-bullseye', 'title' => 'Targeted Skill Development'],
        ['icon' => 'bi-clipboard-check', 'title' => 'Structured Session Plans'],
        ['icon' => 'bi-graph-up', 'title' => 'Micro-assessments Every Session'],
        ['icon' => 'bi-chat-dots', 'title' => 'Session Feedback & Progress Summary'],
        ['icon' => 'bi-mortarboard', 'title' => 'End-of-Program Assessment'],
        ['icon' => 'bi-rocket', 'title' => 'Progress Tracking & Reporting'],
    ];

    if ($program->program_type === 'Intensive Crash Program') {
        $features = $intensiveFeatures;
    } elseif ($program->program_type === 'Micro Learning Program') {
        $features = $mlpFeatures;
    } else {
        $features = $commonFeatures;
    }

    return view('pages.program-detail', compact('program','features'));
}

    public function enquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ]);
        }

        $data = [
            'name'         => $request->name,
            'email'        => $request->email,
            'number'       => $request->phone,
            'program_name' => $request->program_name,
            'program_type' => $request->program_type,
            'subject'      => 'Academic Product Detail Enquiry',
            'message'      => 'Enquiry for Program: ' . 
                           ($request->program_name ?? 'N/A') . 
                           ' - ' . 
                          ($request->program_type ?? 'N/A'),
           ];

        Messages::create($data);

         try {
            Mail::send(new ProductEnquiryMail($data));
        } catch (\Exception $e) {
            Log::error("Product Enquiry Mail Error: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Enquiry sent successfully!'
        ]);
    }

     public function products($type)
    {
        $grades = Grade::where('status', 'A')
            ->select('id', 'slug', 'grade_name')
            ->get();

        $branches = Branch::where('status', 'A')
            ->select('id', 'branch_name')
            ->get();

        $cartItemIds = collect(session('cart.items', []))
            ->pluck('id')
            ->toArray();

        $prePopulatedData = [];

        $subjects = ['Maths', 'English', 'Science'];

        foreach ($subjects as $subjectName) {

        $branch = Branch::where('branch_name', $subjectName)->first();

        if ($branch) {

            $query = AcademicProgram::where('branch_id', $branch->id)
                ->where('status', 1);

            /*
            PROGRAM TYPE FILTER
            */
            if ($type == 'mlp') {
                $query->where('program_type', 'Micro Learning Program');
            }

            if ($type == 'ctp') {
                $query->where('program_type', 'Core Training Program');
            }

            if ($type == 'oc') {
                $query->where('name', 'LIKE', '%OC%');
            }

            if ($type == 'icp') {
                $query->where('program_type', 'Intensive Crash Program');
            }

            $programs = $query
                ->orderByRaw("FIELD(state,'New South Wales','Victoria','Queensland','South Australia','Western Australia','Tasmania','Australian Capital Territory','Northern Territory')")
                ->orderBy('grade_id')
                ->get()
                ->groupBy('name');

            $prePopulatedData[$subjectName] = [
                'branch' => $branch,
                'programs' => $programs
            ];
        }
    }

    return view('pages.products', compact(
        'grades',
        'branches',
        'prePopulatedData',
        'cartItemIds',
        'type'
    ));
}
public function filterPrograms(Request $request)
{
    $type = $request->type;

    $query = AcademicProgram::with(['branch', 'grade'])
        ->where('status', 1);


    if ($type == 'oc') {
        $query->where('name', 'LIKE', '%OC%');
    } elseif ($type == 'naplan') {
        $query->where('program_type', 'Intensive Crash Program');
    }

 
    if ($request->subject) {
        $query->where('branch_id', $request->subject);
    }

    if ($request->curriculum) {
        $query->where('curriculum', $request->curriculum);
    }

    if ($request->state) {
        $query->where('state', $request->state);
    }

    if ($request->year) {
        $query->where('grade_id', $request->year);
    }

  
    $programs = $query
        ->orderByRaw("FIELD(state,
            'New South Wales','Victoria','Queensland','South Australia',
            'Western Australia','Tasmania','Australian Capital Territory','Northern Territory')")
        ->orderBy('grade_id')
        ->get();

    
    $mergedPrograms = [];

    foreach ($programs as $program) {

        $key = $program->slug;

        if (!isset($mergedPrograms[$key])) {

            $mergedPrograms[$key] = [
                'id' => $program->id,
                'name' => $program->name,
                'slug' => $program->slug,
                'description' => $program->description,
                'number_of_sessions' => $program->number_of_sessions,
                'branch' => $program->branch,
                'curriculum' => $program->curriculum,
                'city' => $program->city,
                'program_type' => $program->program_type,
                'grades' => [],
                'grade_ids' => [],
                'states' => [],
            ];
        }

        // UNIQUE GRADES
        if (!in_array($program->grade_id, $mergedPrograms[$key]['grade_ids'])) {
            $mergedPrograms[$key]['grade_ids'][] = $program->grade_id;
            $mergedPrograms[$key]['grades'][] = $program->grade;
        }

        //  UNIQUE STATES
        if (!in_array($program->state, $mergedPrograms[$key]['states'])) {
            $mergedPrograms[$key]['states'][] = $program->state;
        }
    }

    /*  BY SUBJECT */
    $groupedPrograms = [];

    foreach ($mergedPrograms as $item) {

        $subjectName = $item['branch']->branch_name ?? 'Other';

        $groupedPrograms[$subjectName][] = (object) array_merge($item, [
            'singleProgram' =>
                count($item['grades']) === 1 &&
                count($item['states']) === 1
        ]);
    }

    /* SUBJECT ORDER */
    $order = ['Maths', 'English', 'Science'];

    $sortedPrograms = [];

    foreach ($order as $subject) {
        if (isset($groupedPrograms[$subject])) {
            $sortedPrograms[$subject] = $groupedPrograms[$subject];
            unset($groupedPrograms[$subject]);
        }
    }

    // append remaining
    foreach ($groupedPrograms as $subject => $items) {
        $sortedPrograms[$subject] = $items;
    }

    /* CART DATA  */
    $cartItemIds = collect(session('cart.items', []))
        ->pluck('id')
        ->toArray();


    return response()->json([
        'status' => true,
        'count' => count($mergedPrograms),
        'html' => view('pages.partials_program_list', [
            'groupedPrograms' => $sortedPrograms,
            'cartItemIds' => $cartItemIds
        ])->render()
    ]);
}
}
