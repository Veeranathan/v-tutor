<?php

namespace App\Mail;

use App\Models\LearningProgramAssessment;
use App\Models\AssessmentSuggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssessmentSuggestionReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessment;
    public $suggestion;
    public $pdfPath;

    public function __construct(LearningProgramAssessment $assessment, AssessmentSuggestion $suggestion, string $pdfPath)
    {
        $this->assessment = $assessment;
        $this->suggestion = $suggestion;
        $this->pdfPath    = $pdfPath;
    }

    public function build()
    {
        $lastName = !empty($this->assessment->last_name)
            ? ucfirst(strtolower(trim($this->assessment->last_name)))
            : '';

        $fileName = $lastName 
            ? "{$lastName}_Assessment_Suggestion_Report.pdf" 
            : 'Assessment_Suggestion_Report.pdf';

        return $this
        ->from('support@v-tutor.com.au', 'V-Tutor Student Assessment')
        ->to($this->assessment->email)
        ->cc('support@v-tutor.com.au')
        ->subject("Your Child's Academic Feedback & Learning Recommendations Report is Ready")
        ->view('mail.assessment_suggestion_report', [
            'assessment' => $this->assessment,
            'suggestion' => $this->suggestion,
        ])
        ->attach($this->pdfPath, [
            'as'   => $fileName,
            'mime' => 'application/pdf',
        ]);
    }
}