<?php

namespace App\Services;

use App\Models\LearningProgramAssessment;
use App\Models\MyAssessment;
use App\Models\AssessmentSuggestion;
use App\Models\Grade;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class AssessmentPdfService
{
    /**
     * Load assessment and result data.
     */
    public function getAssessmentData($assessmentId)
    {
        $assessment = LearningProgramAssessment::findOrFail($assessmentId);

        // Generate grade_id from the assessment grade
        $gradeNumber = preg_replace('/[^0-9]/', '', $assessment->grade);
        $gradeRecord = Grade::where('grade_name', 'Year ' . $gradeNumber)->first();
        // Add grade_id to the assessment object
        $assessment->grade_id = $gradeRecord ? $gradeRecord->id : '';

        $myAssessment = MyAssessment::where(
            'learning_program_assessment_id',
            $assessmentId
        )->firstOrFail();

        $rawQuantitative = $myAssessment->quantitative_answers;
        if (!is_array($rawQuantitative)) {
            $rawQuantitative = json_decode(json_encode($rawQuantitative), true) ?? [];
        }

        $result = $rawQuantitative;

        if (!isset($result['sections']) || !is_array($result['sections'])) {
            $result['sections'] = [];
        }

        $rawQualitative = $myAssessment->qualitative_answers;
        if (!is_array($rawQualitative)) {
            $rawQualitative = json_decode(json_encode($rawQualitative), true) ?? [];
        }

        $result['qualitative'] = $rawQualitative;

        $total = (int) ($result['total_marks'] ?? 0);
        $obtained = (int) ($result['obtained_marks'] ?? 0);
        $overall = $total > 0 ? round(($obtained / $total) * 100) : 0;

        
    if ($overall >= 95) {
        $result['performance'] = 'Outstanding Performer';
        $result['performance_color'] = '#16784d'; 
    } elseif ($overall >= 80) {
        $result['performance'] = 'Excellent Performer';
        $result['performance_color'] = '#16784d'; 
    } elseif ($overall >= 60) {
        $result['performance'] = 'Good Performer';
        $result['performance_color'] = '#16784d'; 
    } elseif ($overall >= 40) {
        $result['performance'] = 'Developing Performer';
        $result['performance_color'] = '#e67e22'; 
    } else {
        $result['performance'] = 'Needs Attention';
        $result['performance_color'] = '#d9482e'; 
    }

        return [
            'assessment'   => $assessment,
            'myAssessment' => $myAssessment,
            'result'       => $result,
        ];
    }

    /**
     * Fetch all assessment data ALONG WITH the suggestion details.
     */
    public function getSuggestionData($assessmentId)
    {
        // Reuse base assessment data
        $baseData = $this->getAssessmentData($assessmentId);

        // Fetch relationship suggestion data
        $suggestion = AssessmentSuggestion::where(
            'learning_program_assessment_id',
            $assessmentId
        )->firstOrFail();

        $baseData['suggestion'] = $suggestion;

        return $baseData;
    }

    /**
     * Shared internal logic to construct the base mPDF compiler configuration.
     */
    protected function initMpdf()
    {
        return new Mpdf([
            'margin_left'   => 20,
            'margin_right'  => 20,
            'margin_top'    => 20,
            'margin_bottom' => 20,
            'format'        => 'A4',
            'tempDir'       => storage_path('app')
        ]);
    }

    /**
     * Generate HTML layout string from view parameters using clean server assets.
     */
    protected function compileHtml($assessment, $result, $myAssessment)
    {
        // Pass standard file system strings instead of massive base64 strings
        return view('pdf.assessment-report', [
            'assessment'   => $assessment,
            'myAssessment' => $myAssessment,
            'result'       => $result,
            'logoRed'      => public_path('assets/images/pdf/pdf-red-logo.png'),
            'starFilled'   => public_path('assets/images/pdf/star_filled.png'),
            'starEmpty'    => public_path('assets/images/pdf/star_empty.png'),
        ])->render();
    }

    /**
     * Generate HTML layout string for Suggestion Report.
     */
    protected function compileSuggestionHtml($assessment, $result, $myAssessment, $suggestion)
    {
        return view('pdf.assessment_suggestion_report', [
            'assessment'   => $assessment,
            'myAssessment' => $myAssessment,
            'result'       => $result,
            'suggestion'   => $suggestion,
            'logoRed'      => public_path('assets/images/pdf/pdf-red-logo.png'),
            'starFilled'   => public_path('assets/images/pdf/star_filled.png'),
            'starEmpty'    => public_path('assets/images/pdf/star_empty.png'),
            'assessmentStep'    => public_path('assets/images/pdf/assessment-suggestion-next-step.png'),
        ])->render();
    }

    /**
     * Save PDF to server disk
     */
    public function generateToFile($assessment, $result, $myAssessment, $savePath)
    {
        try {
            ini_set('memory_limit', '512M');
            set_time_limit(120);

            $html = $this->compileHtml($assessment, $result, $myAssessment);
            $mpdf = $this->initMpdf();

            $mpdf->WriteHTML($html);
            $mpdf->Output($savePath, \Mpdf\Output\Destination::FILE);

            return true;
        } catch (\Throwable $e) {
            Log::error('mPDF File Storage Execution Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Save Suggestion PDF to server disk (Used by AssessmentSuggestionReportJob).
     */
    public function generateSuggestionToFile($assessment, $result, $myAssessment, $suggestion, $savePath)
    {
        try {
            ini_set('memory_limit', '512M');
            set_time_limit(120);

            $html = $this->compileSuggestionHtml($assessment, $result, $myAssessment, $suggestion);
            $mpdf = $this->initMpdf();

            $mpdf->WriteHTML($html);
            $mpdf->Output($savePath, \Mpdf\Output\Destination::FILE);

            return true;
        } catch (\Throwable $e) {
            Log::error('mPDF Suggestion File Storage Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate raw PDF string (Used by browser download controllers).
     */
    public function generateInline($assessment, $result, $myAssessment)
    {
        try {
            ini_set('memory_limit', '512M');
            set_time_limit(120);

            $html = $this->compileHtml($assessment, $result, $myAssessment);
            $mpdf = $this->initMpdf();

            $mpdf->WriteHTML($html);
            
            return $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
        } catch (\Throwable $e) {
            Log::error('mPDF Inline Download Stream Failure: ' . $e->getMessage());
            throw $e;
        }
    }
}