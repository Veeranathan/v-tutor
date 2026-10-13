<?php
namespace App\Http\Controllers\Admin\Modules\TopicController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectTopics;

class TopicController extends Controller
{
    public function getTopics($grade_id,$subject_id)
    {
        $topic = SubjectTopics::where('subject_id', $subject_id)
            ->where('grade_id', $grade_id)
            ->where('status', 'A')
            ->orderBy('topics', 'asc')
            ->get();

        return response()->json($topic);
    }
}
