<?php
namespace App\Http\Controllers\Admin\Modules\SubjectController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function getSubjects($branch_id, $grade_id)
    {
        $subjects = Subject::where('branch_id', $branch_id)
            ->where('grade_id', $grade_id)
            ->where('status', 'A')
            ->orderBy('display_order', 'asc')
            ->get();

        return response()->json($subjects);
    }
}
