<?php

namespace App\Http\Controllers\Admin\Modules\ProgrammeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programme;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProgrammeManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * AJAX: Check duplicate email (Admin)
     */
    public function ajaxDuplicateEmailCheck(Request $request)
    {
        try {
            $email = trim($request->email);

            $exists = Programme::where('email', $email)
                ->whereNotIn('id', [$request->programme_id ?? 0])
                ->first();

            return $exists ? 'false' : 'true';
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return 'true';
        }
    }

    /**
     * DataTable Server-Side List
     */
    public function list(Request $request)
    {
        try {
            $columnIndex = $request->order[0]['column'];
            $columnSortOrder = $request->order[0]['dir'];

            $query = Programme::select(
                'id',
                'parent_name',
                'email',
                'student_name',
                'student_grade',
                'programs',
                'subscribe',
                'terms_agreed',
                'ref_source'
            );

            // Keyword search
            if (!empty($request->keyword)) {
                $k = $request->keyword;
                $query->where(function ($q) use ($k) {
                    $q->where('parent_name', 'like', "%$k%")
                      ->orWhere('email', 'like', "%$k%")
                      ->orWhere('student_name', 'like', "%$k%")
                      ->orWhere('programs', 'like', "%$k%");
                });
            }

            // Sorting
            $columns = [
                0 => 'parent_name',
                1 => 'email',
                2 => 'student_name',
                3 => 'student_grade',
                4 => 'programs',
                5 => 'subscribe',
                6 => 'terms_agreed',
                7 => 'id'
            ];

            if (isset($columns[$columnIndex])) {
                $query->orderBy($columns[$columnIndex], $columnSortOrder);
            }

            // DataTable pagination
            $totalRecords = $query->count();

            $records = $query->skip($request->start)
                             ->take($request->length)
                             ->get();

            return response()->json([
                'draw' => intval($request->draw),
                'iTotalRecords' => $totalRecords,
                'iTotalDisplayRecords' => $totalRecords,
                'aaData' => $records
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Page load with pagination (non-AJAX)
     */
    public function index(Request $request)
    {
        try {
            $data['programmes'] = Programme::query();

            if ($request->keyword) {
                $k = $request->keyword;
                $data['programmes'] = $data['programmes']->where(function ($q) use ($k) {
                    $q->where('parent_name', 'like', "%$k%")
                      ->orWhere('email', 'like', "%$k%")
                      ->orWhere('student_name', 'like', "%$k%");
                });
            }

            $data['programmes'] = $data['programmes']->paginate(10);
            $data['key'] = $request->all();

            return view('admin.modules.programme_management.manage_programme')->with($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * View programme details
     */
  public function viewProgramme($id)
{
    try {
        $programme = Programme::find($id);
        if (!$programme) {
            session()->flash('error', "Programme not found for id: $id");
            return redirect()->back();
        }

        return view('admin.modules.programme_management.view_programme')
            ->with(['programme' => $programme]);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        session()->flash('error', $e->getMessage());
        return redirect()->back();
    }
}


    /**
     * Delete programme (AJAX)
     */
    public function deleteProgramme($id)
    {
        try {
            $programme = Programme::find($id);

            if (!$programme) {
                return response()->json([
                    'success' => false,
                    'message' => 'Programme not found'
                ]);
            }

            $programme->delete();

            return response()->json([
                'success' => true,
                'message' => 'Programme deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Download Excel
     */
    public function getProgrammeList(Request $request)
{
    $programmes = Programme::query();

    if ($request->keyword) {
        $k = $request->keyword;
        $programmes = $programmes->where(function ($q) use ($k) {
            $q->where('parent_name', 'like', "%$k%")
              ->orWhere('email', 'like', "%$k%")
              ->orWhere('student_name', 'like', "%$k%");
        });
    }

    $programmes = $programmes->orderBy('id', 'desc')->get();

    $t = '<table>
        <tr>
            <th style="border:1px solid black;background-color:lime">Parent</th>
            <th style="border:1px solid black;background-color:lime">Email</th>
            <th style="border:1px solid black;background-color:lime">Student</th>
            <th style="border:1px solid black;background-color:lime">Grade</th>
            <th style="border:1px solid black;background-color:lime">Programs</th>
            <th style="border:1px solid black;background-color:lime">Subscribed</th>
            <th style="border:1px solid black;background-color:lime">Terms</th>
        </tr>';

    foreach ($programmes as $p) {
        $programList = is_array($p->programs) ? implode(", ", $p->programs) : $p->programs;

        $t .= '<tr>
            <td style="border:1px solid black;">' . $p->parent_name . '</td>
            <td style="border:1px solid black;">' . $p->email . '</td>
            <td style="border:1px solid black;">' . $p->student_name . '</td>
            <td style="border:1px solid black;">' . $p->student_grade . '</td>
            <td style="border:1px solid black;">' . $programList . '</td>
            <td style="border:1px solid black;">' . ($p->subscribe ? "Yes" : "No") . '</td>
            <td style="border:1px solid black;">' . ($p->terms_agreed ? "Yes" : "No") . '</td>
        </tr>';
    }

    $t .= '</table>';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=ProgrammeManagement.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo $t;
    exit; // <-- Important, stops Laravel from appending HTML
}

}
